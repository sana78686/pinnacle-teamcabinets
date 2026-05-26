<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;

class CommissionReportService
{
    public function __construct(
        protected OrderWorkspaceCheckoutService $checkout,
    ) {}

    /**
     * CI admin_saving_report default: last Thursday → last Wednesday.
     *
     * @return array{from: string, to: string}
     */
    public function defaultWeeklyRange(): array
    {
        $wednesday = Carbon::now()->modify('last Wednesday');
        $lastThursday = (clone $wednesday)->subDays(6);

        return [
            'from' => $lastThursday->format('Y-m-d'),
            'to' => $wednesday->format('Y-m-d'),
        ];
    }

    /**
     * Mirror of CI commission_report_formatted_data().
     *
     * @param  array{rep_id?: int|string, parent_id?: int|string, from?: string, to?: string, state?: int}  $filters
     * @return array<int, array<string, mixed>>
     */
    public function formattedData(array $filters = []): array
    {
        $orders = $this->ordersForReport($filters);
        $result = [];

        foreach ($orders as $order) {
            $rooms = $order->rooms;
            if (! is_array($rooms) || $rooms === []) {
                continue;
            }

            $doorLines = $this->doorLinesForOrder($order);
            if ($doorLines === []) {
                continue;
            }

            $roomNames = $this->roomNamesFromStorage($rooms);
            $customer = $order->user;

            $result[] = [
                'order_id' => $order->id,
                'invoice_number' => (string) $order->id,
                'job_name' => is_array($order->job_name)
                    ? implode(', ', $order->job_name)
                    : (string) ($order->job_name ?? ''),
                'invoice_date' => $order->created_at?->format('m/d/Y') ?? '',
                'customer_name' => $customer?->name ?? '',
                'order_by' => $customer?->name ?? '',
                'room_name' => implode(', ', $roomNames),
                'rep_id' => $order->rep_id,
                'parent_id' => $order->commission_parent_id ?? $order->parent_id,
                'mfg_comm' => (float) ($order->mfg_comm ?? 0),
                'rep_comm' => (float) ($order->rep_comm ?? 0),
                'aff_comm' => (float) ($order->aff_comm ?? 0),
                'sub_aff_commission' => (float) ($order->sub_aff_commission ?? 0),
                'door_lines' => $doorLines,
            ];
        }

        return $result;
    }

    /**
     * CI user_commissins_list — gross_sales * point_factor (decimal factor, not /100).
     *
     * @return array<int, array<string, mixed>>
     */
    public function userTypeList(string $userType): array
    {
        $ciType = TenantRoleService::normalizeCiRoleName($userType);
        if ($ciType === '') {
            return [];
        }

        $users = User::query()
            ->where('status', 'approved')
            ->where(function ($q) use ($ciType) {
                $q->where('user_type', $ciType)
                    ->orWhereHas('roles', fn ($r) => $r->where('name', $ciType));
            })
            ->with('manageCommission')
            ->orderBy('name')
            ->get();

        return $users->map(fn (User $u) => [
            'name' => $u->name,
            'email' => $u->email,
            'point_factor' => $u->point_factor,
            'gross_sales' => (float) ($u->manageCommission?->gross_sales ?? 0),
            'commission_amount' => (float) ($u->manageCommission?->gross_sales ?? 0) * (float) ($u->point_factor ?? 0),
        ])->values()->all();
    }

    /**
     * @param  array<mixed>  $rooms
     * @return list<string>
     */
    protected function roomNamesFromStorage(array $rooms): array
    {
        if ($this->isCiRoomMap($rooms)) {
            return array_map('strval', array_keys($rooms));
        }

        $names = [];
        foreach ($this->checkout->normalizeRoomsFromStorage($rooms) as $room) {
            $names[] = (string) ($room['room_name'] ?? 'Room');
        }

        return $names;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    protected function doorLinesForOrder(Order $order): array
    {
        $rooms = $order->rooms;
        if (! is_array($rooms) || $rooms === []) {
            return [];
        }

        $products = $this->flattenCiRoomProducts($rooms);
        if ($products === []) {
            return [];
        }

        $byDoorStyle = [];
        foreach ($products as $product) {
            $doorStyle = (string) ($product['product_cabinets_color'] ?? 'N/A');
            if ($doorStyle === '') {
                $doorStyle = 'N/A';
            }

            if (! isset($byDoorStyle[$doorStyle])) {
                $byDoorStyle[$doorStyle] = [
                    'door_style' => $doorStyle,
                    'product_quantity' => 0,
                    'product_cost' => 0.0,
                    'product_assemble_cost' => 0.0,
                    'product_actual_price' => 0.0,
                    'list_price' => 0.0,
                    'user_door_price' => 0.0,
                    'parent_door_price' => 0.0,
                    'rep_door_price' => 0.0,
                    'user_door_factor' => 0.0,
                    'parent_door_factor' => 0.0,
                    'rep_door_factor' => 0.0,
                ];
            }

            $qty = max(1, (float) ($product['product_quantity'] ?? 1));
            $actual = (float) ($product['product_actual_price'] ?? 0);
            $userFactor = (float) ($product['user_door_factor'] ?? 0);
            $parentUnit = (float) ($product['parent_door_price'] ?? 0);
            $repUnit = (float) ($product['representative_door_price'] ?? 0);

            $byDoorStyle[$doorStyle]['product_quantity'] += $qty;
            $byDoorStyle[$doorStyle]['product_cost'] += (float) ($product['product_cost'] ?? 0) * $qty;
            $byDoorStyle[$doorStyle]['product_assemble_cost'] += (float) ($product['product_assemble_cost'] ?? 0) * $qty;
            $byDoorStyle[$doorStyle]['product_actual_price'] += $actual * $qty;
            $byDoorStyle[$doorStyle]['list_price'] += $actual * $qty;
            $byDoorStyle[$doorStyle]['parent_door_price'] += $parentUnit * $qty;
            $byDoorStyle[$doorStyle]['rep_door_price'] += $repUnit * $qty;
            // CI: user_door_price = product_actual_price * qty * user_door_factor (recomputed)
            $byDoorStyle[$doorStyle]['user_door_price'] += $actual * $qty * $userFactor;
            // Factors: last seen (not summed)
            $byDoorStyle[$doorStyle]['parent_door_factor'] = (float) ($product['parent_door_factor'] ?? 0);
            $byDoorStyle[$doorStyle]['rep_door_factor'] = (float) ($product['representative_door_factor'] ?? 0);
            $byDoorStyle[$doorStyle]['user_door_factor'] = $userFactor;
        }

        foreach ($byDoorStyle as &$line) {
            $line['aff_commission'] = $line['user_door_price'] - $line['parent_door_price'];
            $line['rep_commission'] = $line['parent_door_price'] - $line['rep_door_price'];

            if ($line['parent_door_price'] == 0.0 && $line['parent_door_factor'] == 0.0) {
                $line['aff_commission_display'] = 'N/A';
                $line['parent_cost_display'] = 'N/A';
            } else {
                $line['aff_commission_display'] = number_format($line['aff_commission'], 2);
                $line['parent_cost_display'] = number_format($line['parent_door_price'], 2);
            }

            if ($line['rep_door_price'] == 0.0 && $line['rep_door_factor'] == 0.0) {
                $line['rep_commission_display'] = 'N/A';
                $line['rep_cost_display'] = 'N/A';
            } else {
                $line['rep_commission_display'] = number_format($line['rep_commission'], 2);
                $line['rep_cost_display'] = number_format($line['rep_door_price'], 2);
            }
        }
        unset($line);

        return array_values($byDoorStyle);
    }

    /**
     * CI export_admin_saving_report — door-line commission total per order.
     */
    public function orderDoorCommissionTotal(Order $order): float
    {
        $doorLines = $this->doorLinesForOrder($order);
        if ($doorLines === []) {
            return 0.0;
        }

        $customer = $order->user;
        if (! $customer) {
            return 0.0;
        }

        $chain = $this->ciCommissionChain($customer);
        $colorCount = count($doorLines);
        $parentComm = 0.0;
        $repComm = 0.0;

        foreach ($doorLines as $line) {
            $aff = (float) ($line['aff_commission'] ?? 0);
            $rep = (float) ($line['rep_commission'] ?? 0);

            if ($chain['has_parent'] && $chain['has_representative']) {
                if ($colorCount > 1) {
                    $parentComm += $aff;
                    $repComm += $rep;
                } else {
                    $parentComm = $aff;
                    $repComm = $rep;
                }
            } elseif ($chain['has_parent']) {
                if ($colorCount > 1) {
                    $parentComm += $aff;
                } else {
                    $parentComm = $aff;
                }
                $repComm = 0.0;
            } else {
                $parentComm = 0.0;
                $repComm = 0.0;
            }
        }

        return round($parentComm + $repComm, 2);
    }

    /**
     * CI saving-report CSV rows (one row per order).
     *
     * @param  array{rep_id?: int|string, parent_id?: int|string, from?: string, to?: string, state?: int}  $filters
     * @return array<int, array<string, mixed>>
     */
    public function savingReportRows(array $filters = []): array
    {
        $rows = [];

        foreach ($this->ordersForReport($filters) as $order) {
            if ($this->doorLinesForOrder($order) === []) {
                continue;
            }

            $totalSale = (float) ($order->order_amount ?? $order->grand_total_cost ?? 0);
            $totalCommission = $this->orderDoorCommissionTotal($order);
            $salesTax = $this->orderSalesTaxAmount($order);
            $shipping = $this->orderShippingAmount($order);
            $assembly = $this->orderAssemblyAmount($order);
            $fuel = (float) ($order->fuel_charges ?? 0);
            $payment = $this->orderPaymentProcessingCharge($order);
            $netSale = round(
                $totalSale - $totalCommission - $salesTax - $shipping - $payment - $assembly - $fuel,
                2
            );

            $rows[] = [
                'invoice_number' => $order->id,
                'order_date' => $order->created_at?->format('m/d/Y') ?? '',
                'total_sale' => $totalSale,
                'total_commission' => $totalCommission,
                'sales_tax' => $salesTax,
                'shipping_charges' => $shipping,
                'assembly_charges' => $assembly,
                'fuel_charges' => $fuel,
                'payment_charges' => $payment,
                'net_sale' => $netSale,
            ];
        }

        return $rows;
    }

    public function orderSalesTaxAmount(Order $order): float
    {
        if (isset($order->tax) && is_numeric($order->tax)) {
            return round((float) $order->tax, 2);
        }

        $subTotal = (float) ($order->sub_total_cost ?? 0);
        $percent = (float) ($order->sales_tax ?? 0);

        return round($subTotal * ($percent / 100), 2);
    }

    public function orderShippingAmount(Order $order): float
    {
        $shipping = $order->shipping_cost ?? 0;

        return is_numeric($shipping) ? round((float) $shipping, 2) : 0.0;
    }

    public function orderAssemblyAmount(Order $order): float
    {
        if (isset($order->assemble_cabinetry_charged) && is_numeric($order->assemble_cabinetry_charged)) {
            return round((float) $order->assemble_cabinetry_charged, 2);
        }

        return round((float) ($order->sub_total_assemble_cost ?? 0), 2);
    }

    public function orderPaymentProcessingCharge(Order $order): float
    {
        $credit = (float) ($order->credit_card_charges ?? 0);
        if ($credit > 0) {
            return round($credit, 2);
        }

        $debit = (float) ($order->debit_card_charges ?? 0);
        if ($debit > 0) {
            return round($debit, 2);
        }

        $ach = (float) ($order->ach_charges ?? 0);
        if ($ach > 0) {
            return round($ach, 2);
        }

        return 0.0;
    }

    /**
     * CI getUserDetail chain: parent = customer's parent; representative = parent's parent when not admin.
     *
     * @return array{has_parent: bool, has_representative: bool}
     */
    protected function ciCommissionChain(User $customer): array
    {
        $directParent = $customer->parent_id
            ? User::query()->find((int) $customer->parent_id)
            : null;

        $hasParent = $directParent !== null && ! $this->isCiSkippedHierarchyUser($directParent);

        $grandParent = ($hasParent && $directParent->parent_id)
            ? User::query()->find((int) $directParent->parent_id)
            : null;

        $hasRepresentative = $grandParent !== null && ! $this->isCiSkippedHierarchyUser($grandParent);

        return [
            'has_parent' => $hasParent,
            'has_representative' => $hasRepresentative,
        ];
    }

    protected function isCiSkippedHierarchyUser(User $user): bool
    {
        if ($user->id === 4) {
            return true;
        }

        return $user->isAdmin();
    }

    /**
     * @param  array{rep_id?: int|string, parent_id?: int|string, from?: string, to?: string, state?: int}  $filters
     * @return \Illuminate\Support\Collection<int, Order>
     */
    protected function ordersForReport(array $filters)
    {
        $query = Order::query()
            ->with('user')
            ->where('state', $filters['state'] ?? 1);

        if (! empty($filters['rep_id']) && $filters['rep_id'] !== 'all') {
            $query->where('rep_id', $filters['rep_id']);
        }
        if (! empty($filters['parent_id'])) {
            $parentId = $filters['parent_id'];
            $query->where(function ($q) use ($parentId) {
                $q->where('commission_parent_id', $parentId)
                    ->orWhere('parent_id', $parentId);
            });
        }
        if (! empty($filters['from'])) {
            $query->whereDate('created_at', '>=', $filters['from']);
        }
        if (! empty($filters['to'])) {
            $query->whereDate('created_at', '<=', $filters['to']);
        }

        return $query->orderByDesc('id')->get();
    }

    /**
     * @param  array<mixed>  $rooms
     * @return array<int, array<string, mixed>>
     */
    protected function flattenCiRoomProducts(array $rooms): array
    {
        if ($this->isCiRoomMap($rooms)) {
            return $this->flattenCiRoomMap($rooms);
        }

        $modern = $this->checkout->normalizeRoomsFromStorage($rooms);
        $products = [];
        foreach ($modern as $room) {
            foreach ($room['products'] ?? [] as $line) {
                $qty = max(1, (int) ($line['quantity'] ?? 1));
                $actual = (float) ($line['cost1'] ?? $line['cost'] ?? 0);
                $products[] = [
                    'product_cabinets_color' => $line['product_color'] ?? '',
                    'product_quantity' => $qty,
                    'product_cost' => (float) ($line['cost'] ?? $actual),
                    'product_assemble_cost' => (float) ($line['assemble_cost'] ?? 0),
                    'product_actual_price' => $actual,
                    'user_door_factor' => $line['user_door_factor'] ?? 0,
                    'parent_door_factor' => $line['parent_door_factor'] ?? 0,
                    'representative_door_factor' => $line['representative_door_factor'] ?? 0,
                    'parent_door_price' => $line['parent_door_price'] ?? 0,
                    'representative_door_price' => $line['representative_door_price'] ?? 0,
                ];
            }
        }

        return $products;
    }

    /**
     * @param  array<string, array<string, mixed>>  $rooms
     * @return array<int, array<string, mixed>>
     */
    protected function flattenCiRoomMap(array $rooms): array
    {
        $products = [];

        foreach ($rooms as $roomData) {
            if (! is_array($roomData)) {
                continue;
            }

            $skus = $roomData['product_sku'] ?? [];
            if (! is_array($skus) || $skus === []) {
                continue;
            }

            $count = count($skus);
            for ($i = 0; $i < $count; $i++) {
                $products[] = [
                    'product_cabinets_color' => (string) ($roomData['product_cabinets_color'][$i] ?? ''),
                    'product_quantity' => max(1, (int) ($roomData['product_quantity'][$i] ?? 1)),
                    'product_cost' => (float) ($roomData['product_cost'][$i] ?? 0),
                    'product_assemble_cost' => (float) ($roomData['product_assemble_cost'][$i] ?? 0),
                    'product_actual_price' => (float) ($roomData['product_actual_price'][$i] ?? 0),
                    'user_door_factor' => $roomData['user_door_factor'][$i] ?? 0,
                    'parent_door_factor' => $roomData['parent_door_factor'][$i] ?? 0,
                    'representative_door_factor' => $roomData['representative_door_factor'][$i] ?? 0,
                    'parent_door_price' => (float) ($roomData['parent_door_price'][$i] ?? 0),
                    'representative_door_price' => (float) ($roomData['representative_door_price'][$i] ?? 0),
                ];
            }
        }

        return $products;
    }

    /**
     * @param  array<mixed>  $rooms
     */
    protected function isCiRoomMap(array $rooms): bool
    {
        if (array_is_list($rooms)) {
            return false;
        }

        foreach ($rooms as $val) {
            if (is_array($val) && isset($val['product_sku']) && is_array($val['product_sku'])) {
                return true;
            }
        }

        return false;
    }
}

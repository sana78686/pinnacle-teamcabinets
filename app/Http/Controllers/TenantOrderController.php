<?php

namespace App\Http\Controllers;

use App\Exports\OrderExport;
use App\Imports\OrderImport;
use App\Models\DoorColors;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCatalog;
use App\Models\ProductSection;
use App\Models\TaxValues;
use App\Services\AdminRecordViewService;
use App\Services\ClaimWorkspaceService;
use App\Services\QuoteWorkspaceService;
use App\Services\TenantNavBadgeService;
use App\Services\WarehousePickListService;
use App\Support\TenantListPaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TenantOrderController extends Controller
{
    public function __construct(
        protected QuoteWorkspaceService $recordWorkspace,
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, TenantNavBadgeService $navBadges)
    {
        $perPage = TenantListPaginator::perPage($request);
        $search = TenantListPaginator::search($request);
        $workspace = app(\App\Services\OrderWorkspaceService::class);
        $query = $workspace->listQuery(Order::class, Auth::user());

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('job_name', 'like', '%'.$search.'%')
                    ->orWhereHas('user', function ($u) use ($search) {
                        $u->where('name', 'like', '%'.$search.'%')
                            ->orWhere('email', 'like', '%'.$search.'%');
                    });
            });
        }

        $data = [
            'records' => $query->paginate($perPage)->withQueryString(),
            'perPage' => $perPage,
            'search' => $search,
            'exportCsvUrl' => route('tenant_order_export_csv', $request->only(['search', 'status', 'from', 'to'])),
        ];

        if (Auth::user()->hasRole('Admin')) {
            return view('tenants.orders.index', $data);
        }

        return view('tenants.representative_modals.orders.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [];
        $data['product_catalogs'] = ProductCatalog::where('status', 1)->get();
        $data['product_sections'] = ProductSection::with('products')->get();
        $data['door_colors'] = DoorColors::with('productCatalog')->get();
        if(Auth::user()->hasRole('Admin'))
        {
            return view('tenants.orders.step_1', $data);

        }
        else
        {
            return view('tenants.orders.step_1', $data);

        }
    }
    public function create_step_1()
    {
        $data = [];
        $data['product_catalogs'] = ProductCatalog::where('status', 1)->get();
        $data['product_sections'] = ProductSection::with('products')->get();
        $data['door_colors'] = DoorColors::with('productCatalog')->get();
        if(Auth::user()->hasRole('Admin'))
        {
            return view('tenants.orders.step_1', $data);

        }
        else
        {
            return view('tenants.representative_modals.orders.step_1', $data);

        }
    }
    public function create_step_2($id)
    {
        
        $data = [];
        // $data['product_catalogs'] = ProductCatalog::where('status', 1)->get();
        // $data['product_sections'] = ProductSection::with('products')->get();
        // $data['door_colors'] = DoorColors::where('product_catalog_id', $id)->with('productCatalog')->get();
        $data['door_colors'] = DoorColors::where('product_catalog_id', $id)->get();

        // dd($data['door_colors']);
        if(Auth::user()->hasRole('Admin'))
        {
            return view('tenants.orders.step_2', $data);

        }
        else
        {
            return view('tenants.representative_modals.orders.step_2', $data);

        }
    }

    public function create_step_3($catalog_id, $door_id)
    {

        // dd($catalog_id, $door_id);
        $data = [];

$data['cart'] = session()->get('cart', []);
$data['jobName'] = session()->get('job_name', ''); // Retrieve stored Job Name
$data['roomNames'] = session()->get('room_names', []);

$data['products'] = Product::with('doorColor')
->withTrashed()
    ->where('product_catalog_id', $catalog_id)
    ->where('door_color_id', $door_id)
    ->get(); // Use get() for multiple products

$data['product_catalogs'] = ProductCatalog::where('status', 1)->get();
$data['product_sections'] = ProductSection::with('products', 'products.doorColor')->get();
$data['door_colors'] = DoorColors::with('productCatalog')->get();

$data['catalog_id'] = $catalog_id;
$data['door_id'] = $door_id;

        // dd($data['products']);
        if(Auth::user()->hasRole('Admin'))
        {
            return view('tenants.orders.step_3', $data);
        }
        else
        {
            return view('tenants.representative_modals.orders.step_3', $data);

        }
    }

    public function search(Request $request) {
        if ($request->ajax()) {
            $products = Product::where('sku', 'LIKE', '%' . $request->search . '%')->get();
            return response()->json(['products' => $products]);
        }
        return response()->json(['products' => []]);
    }

    public function step_2($id)
    {
        $data = [];
        $data['product_catalogs'] = ProductCatalog::with('products')->where('status', 1)->get();
        $data['product_sections'] = ProductSection::with('products')->get();
        // dd($data['product_sections']);
        $data['products'] = Product::get();
        if(Auth::user()->hasRole('Admin'))
        {
            return view('tenants.profile.step_2', $data);
        }
        else
        {
            return view('tenants.orders.step_2', $data);
        }
    }

    /**
     * Store a newly created resource in storage.
     */

     public function store(Request $request)
     {

         Log::info("Received Data:", $request->all());
         $user = Auth::user();
         $validated_data = $request->validate([
             'job_name' => 'required|string',
             'rooms' => 'req|array|required',
             'assemble_cabinets_check' => 'required',
             'shipping_status' => 'required|in:yes,pending',
             'comment' => 'nullable|string'
         ]);

         Log::info($request->rooms);
         $countryName = $user->country_id ? $user->country->name : '';
         $stateName = $user->state_id ? $user->state->name : '';

         $user_address = implode(', ', array_filter([
             $user->address,
             $user->city_name,
             $user->county_name,
             $stateName,
             $countryName
         ]));
         $fuel_tax = TaxValues::where('option_key', 'fuel_charges_value')->first();

         $total_assemble_cost = 0;
         $sub_total_cost = 0;
         $sub_total_weight = 0;
         foreach ($request->rooms as $room) {
             foreach ($room['products'] as $product) {
                 // Fetch the assemble cost for the product from the database
                 $productData = Product::find($product['product_id']);
                 Log::info($productData);
                 $product_assemble_cost = $productData ? $productData->assemble_cost : 0;
                 $product_cost = $productData ? $productData->cost : 0;
                 $product_weight = $productData ? $productData->weight : 0;

                 // Multiply by quantity and add to total
                 $total_assemble_cost += ($product_assemble_cost * $product['quantity']);
                 $sub_total_cost += ($product_cost * $product['quantity']);
                 $sub_total_weight += ($product_weight * $product['quantity']);

             }
         }
         Log::info($total_assemble_cost);
         $stockCheckRequest = Order::create([
             'job_name' => $request->job_name,
             'rooms' => json_encode($request->rooms),
             'assemble_cabinets_check' => $request->assemble_cabinets_check,
             'shipping_status' => $request->shipping_status,
             'comment' => $request->comment,
             'user_id' => $user->id,
             'user_address' => $user_address,
             'user_email' => $user->email,
             'user_phone' => $user->phone,
             'sub_total_cost' => $sub_total_cost,
             'fuel_tax' => $fuel_tax->option_value,
         ]);
         if($request->assemble_cabinets_check == 1)
         {
             Log::info("assemble cabinet check");
             $stockCheckRequest->sub_total_assemble_cost = $total_assemble_cost;
             $stockCheckRequest->save();
         }
         /***  Sum grand total */
         $stockCheckRequest->grand_total_cost = $total_assemble_cost + $sub_total_cost;
         $stockCheckRequest->sub_total_weight = $sub_total_weight;
         $stockCheckRequest->save();


         // $admins = User::where('role', 'admin')->pluck('email')->toArray();
         // Mail::to($user->email)->send(new StockCheckUserMail());
         // if (!empty($admins)) {
         //     Mail::to($admins)->send(new StockCheckAdminMail());
         // }
         Log::info($stockCheckRequest);
         return response()->json(['message' => 'Order Created successfully'], 200);
     }

    /**
     * Display the specified resource.
     */
    public function show(string $id, AdminRecordViewService $adminView, ClaimWorkspaceService $claims): View
    {
        $order = Order::query()->with('user')->findOrFail($id);

        if (! $this->recordWorkspace->userMayAccess($order, Auth::user())) {
            abort(403);
        }

        $adminView->markViewed($order, Auth::user());
        $canClaim = $claims->orderEligibleForClaim($order);

        $data = [
            'record' => $order,
            'recordLabel' => 'Order',
            'nameRowLabel' => 'Job name',
            'recordName' => $order->job_name ?? '—',
            'catalogLabel' => $this->recordWorkspace->catalogLabel($order),
            'doorLabel' => $order->product_img_name ?? '—',
            'billName' => $this->recordWorkspace->billName($order),
            'shipName' => $order->user_address ?? $this->recordWorkspace->shipName($order),
            'rooms' => $order->rooms ?? [],
            'listRoute' => 'tenant_order_list',
            'editRoute' => null,
            'canClaim' => $canClaim,
            'showClaimDisabled' => ! $canClaim,
            'claimLines' => $canClaim ? $claims->buildClaimLineOptions($order) : [],
        ];

        $view = Auth::user()->hasRole('Admin')
            ? 'tenants.orders.show'
            : 'tenants.representative_modals.orders.show';

        return view($view, $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function deletedorderList()
    {
        return view('tenants.orders.deleted_order_list');
        // $data['order'] = Order::onlyTrashed()->get();
        // session()->flash('success', "Please deleted_products_list add user's Point Factor immediately after the Approval. Otherwise it will affect the Commission Report.You can only change the product type of the product until product is not approved.");
        // return view('tenants.orders.deleted_order_list', $data);
    }

    public function restoreDeletedorder($id)
    {
        $order = Order::onlyTrashed()->findOrFail($id);
        if (!$order) {
            session()->flash('error', 'Product cannot found.');
            return redirect()->back();
        }
        $order->restore(); // Restore the user
        return redirect()->route('tenant_deleted_product_catalog_list')
            ->with('success', 'product_catalog.'.$order->name.'. Restored successfully');
    }




    public function warehousePickList(string $orderId, WarehousePickListService $pickList): View
    {
        $order = Order::query()->with('user')->findOrFail($orderId);

        return view('tenants.orders.warehouse_pick_list', [
            'order' => $order,
            'pickRooms' => $pickList->roomsForOrder($order),
        ]);
    }

    public function warehousePickListPrint(Request $request, string $orderId, WarehousePickListService $pickList): View
    {
        $order = Order::query()->with('user')->findOrFail($orderId);

        if ($request->isMethod('post')) {
            $order->update([
                'is_picked' => true,
                'picked_at' => now(),
            ]);
        }

        return view('tenants.orders.warehouse_pick_list_print', [
            'order' => $order->fresh(),
            'pickRooms' => $pickList->roomsForOrder($order),
        ]);
    }

    public function exportCsv(Request $request): StreamedResponse
    {
        $workspace = app(\App\Services\OrderWorkspaceService::class);
        $query = $workspace->listQuery(Order::class, Auth::user());

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->input('from'));
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->input('to'));
        }
        $search = TenantListPaginator::search($request);
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('job_name', 'like', '%'.$search.'%')
                    ->orWhereHas('user', function ($u) use ($search) {
                        $u->where('name', 'like', '%'.$search.'%')
                            ->orWhere('email', 'like', '%'.$search.'%');
                    });
            });
        }

        $filename = 'Orders_'.now()->format('Ymd').'.csv';

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'Order ID', 'Customer Name', 'Email', 'Invoice #', 'Job Name',
                'Order Amount', 'Status', 'Date',
            ]);

            $query->orderByDesc('id')->chunk(200, function ($orders) use ($handle) {
                foreach ($orders as $order) {
                    $jobName = is_array($order->job_name)
                        ? implode(', ', $order->job_name)
                        : (string) ($order->job_name ?? '');
                    fputcsv($handle, [
                        $order->id,
                        $order->user?->name ?? '',
                        $order->user?->email ?? $order->user_email ?? '',
                        (string) $order->id,
                        $jobName,
                        number_format((float) ($order->order_amount ?? $order->grand_total_cost ?? 0), 2, '.', ''),
                        $order->status ?? '',
                        $order->created_at?->format('Y-m-d') ?? '',
                    ]);
                }
            });

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    public function order_export()
    {
        return Excel::download(new OrderExport, 'order.xlsx');
    }

    public function order_import(Request $request)
{
    // Validate the file
    $request->validate([
        'orderFile' => 'required|file|mimes:xlsx,xls,csv'  // Accept Excel and CSV files
    ]);

    // Import the file using Excel::import
    Excel::import(new OrderImport, $request->file('orderFile'));

    // Redirect back after import
    return redirect()->back();
}
}

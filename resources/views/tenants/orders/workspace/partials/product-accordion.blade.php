@foreach ($sections as $section)
    <details class="ow-accordion__item" @if ($loop->first) open @endif>
        <summary>{{ $section->cabinets_name }}</summary>
        <div class="table-responsive ow-picker-table-wrap">
            <table class="table table-sm table-bordered table-striped ow-picker-table tc-settings-table mb-0" data-category-name="{{ $section->cabinets_name }}">
                <thead>
                    <tr>
                        <th>Cabinet Label</th>
                        <th>SKU</th>
                        <th>Description</th>
                        <th>Weight (lbs)</th>
                        <th>Price</th>
                        <th>Qty</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($section->products as $product)
                        @php
                            $pricing = $product->pricing ?? [];
                            $rawCost = $pricing['raw_cost'] ?? (float) preg_replace('/[^\d.]/', '', (string) $product->cost);
                            $rawWeight = $pricing['weight'] ?? (float) preg_replace('/[^\d.]/', '', (string) $product->weight);
                            $listDesc = $door->product_label.' - '.$product->sku.' - '.$product->label;
                            $details = $pricing['details'] ?? ($product->value_1 ?: ($product->description ?: ''));
                            $diagram = $pricing['product_img'] ?? ($product->image ? asset($product->image) : '');
                        @endphp
                        <tr class="cabinet-row ow-product-row"
                            data-product-id="{{ $product->id }}"
                            data-sku="{{ $product->sku }}"
                            data-label="{{ $product->label }}"
                            data-description="{{ $listDesc }}"
                            data-details="{{ $details }}"
                            data-weight="{{ $rawWeight }}"
                            data-cost="{{ $rawCost }}"
                            data-cost1="{{ $rawCost }}"
                            data-cabinet="{{ $section->id }}"
                            data-cabinetid="{{ $product->id }}"
                            data-qty="{{ $product->qty }}"
                            data-ass-cost="{{ $pricing['assemble_cost'] ?? preg_replace('/[^\d.]/', '', (string) $product->assemble_cost) }}"
                            data-door-point="{{ is_string($pricing['user_door_point'] ?? '') ? $pricing['user_door_point'] : json_encode($pricing['user_door_point'] ?? []) }}"
                            data-parent-point="{{ is_string($pricing['parent_door_point'] ?? '') ? $pricing['parent_door_point'] : json_encode($pricing['parent_door_point'] ?? []) }}"
                            data-representative-point="{{ is_string($pricing['representative_door_point'] ?? '') ? $pricing['representative_door_point'] : json_encode($pricing['representative_door_point'] ?? []) }}"
                            data-product-img="{{ $diagram }}">
                            <td class="cabinet-label-cell ow-product-label">{{ $product->label }}</td>
                            <td>{{ $product->sku }}</td>
                            <td>{{ $listDesc }}</td>
                            <td>{{ \App\Support\ProductFieldFormat::formatWeight($rawWeight ?: $product->weight) }}</td>
                            <td>${{ number_format($rawCost, 2) }}</td>
                            <td>{{ $product->qty }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </details>
@endforeach

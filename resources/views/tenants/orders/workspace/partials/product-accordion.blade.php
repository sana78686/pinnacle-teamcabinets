@foreach ($sections as $section)
    <details class="ow-accordion__item" open>
        <summary>{{ $section->cabinets_name }}</summary>
        <div class="table-responsive ow-picker-table-wrap">
            <table class="table table-sm table-bordered ow-picker-table mb-0">
                <thead>
                    <tr>
                        <th>Cabinet Label</th>
                        <th>SKU</th>
                        <th>Description</th>
                        <th>Weight</th>
                        <th>Cost</th>
                        <th>Qty</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($section->products as $product)
                        @php
                            $rawCost = (float) preg_replace('/[^\d.]/', '', (string) $product->cost);
                            $rawWeight = (float) preg_replace('/[^\d.]/', '', (string) $product->weight);
                            $listDesc = $door->product_label.' - '.$product->sku.' - '.$product->label;
                        @endphp
                        <tr class="ow-product-row cabinet-label-cell"
                            data-product-id="{{ $product->id }}"
                            data-sku="{{ $product->sku }}"
                            data-label="{{ $product->label }}"
                            data-description="{{ $listDesc }}"
                            data-weight="{{ $rawWeight }}"
                            data-cost="{{ $rawCost }}"
                            data-cost1="{{ $rawCost }}"
                            data-cabinet="{{ $section->id }}"
                            data-cabinetid="{{ $product->id }}"
                            data-qty="{{ $product->qty }}"
                            data-ass-cost="{{ preg_replace('/[^\d.]/', '', (string) $product->assemble_cost) }}"
                            data-door-point="0"
                            data-parent-point="0"
                            data-representative-point="0">
                            <td class="ow-product-label">{{ $product->label }}</td>
                            <td>{{ $product->sku }}</td>
                            <td>{{ $listDesc }}</td>
                            <td>{{ $product->weight }}</td>
                            <td>{{ $product->cost }}</td>
                            <td>{{ $product->qty }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </details>
@endforeach

@php
    $claimLines = $claimLines ?? [];
    $orderId = $order->id ?? 0;
@endphp

<div class="tc-claim-bar d-flex justify-content-end align-items-center gap-2 mt-3 pt-3 border-top">
    <span class="text-muted small">Order is paid — you may file a warranty or damage claim.</span>
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tc-claim-modal">
        Claim
    </button>
</div>

<div class="modal fade" id="tc-claim-modal" tabindex="-1" role="dialog" aria-labelledby="tc-claim-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document" style="max-width:95%;">
        <div class="modal-content">
            <form method="post" action="{{ route('tenant_claim_store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="tc-claim-modal-label">Claims Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p class="fw-semibold mb-3">Job Name: {{ $order->job_name ?? '—' }}</p>

                    <div class="table-responsive" style="max-height:400px;">
                        <table class="table table-bordered table-sm mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Select</th>
                                    <th>Double Check</th>
                                    <th>Section</th>
                                    <th>Cabinet Name</th>
                                    <th>Description</th>
                                    <th>Weight</th>
                                    <th>Price</th>
                                    <th>Image</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($claimLines as $line)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="get_select_checkbox_val[]"
                                                value="{{ json_encode($line['payload']) }}">
                                        </td>
                                        <td class="tc-sq-admin__checks">
                                            <span class="tc-sq-check tc-sq-check--yellow{{ ($line['checkbox_val1'] ?? '0') === '1' ? ' is-on' : '' }}"></span>
                                            <span class="tc-sq-check tc-sq-check--green{{ ($line['checkbox_val2'] ?? '0') === '1' ? ' is-on' : '' }}"></span>
                                        </td>
                                        <td>{{ $line['section_name'] ?: '—' }}</td>
                                        <td>{{ $line['sku'] }}</td>
                                        <td>{{ $line['product_description'] }}</td>
                                        <td>{{ $line['weight'] }} lbs</td>
                                        <td>${{ number_format($line['cost'], 2) }}</td>
                                        <td>
                                            <label class="btn btn-light btn-sm mb-0">
                                                <i class="fa fa-camera"></i>
                                                <input type="file" class="d-none" multiple
                                                    name="claims_order_image_{{ $line['sku'] }}[]"
                                                    accept=".jpg,.jpeg,.png,.gif">
                                            </label>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        <label class="form-label fw-semibold">Message <span class="text-danger">*</span></label>
                        <textarea name="claims_order_message" class="form-control" rows="3" required
                            placeholder="Describe the issue with selected items">{{ old('claims_order_message') }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="claims_order_id" value="{{ $orderId }}">
                    <input type="hidden" name="claims_order_user_id" value="{{ auth()->id() }}">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit Claim</button>
                </div>
            </form>
        </div>
    </div>
</div>

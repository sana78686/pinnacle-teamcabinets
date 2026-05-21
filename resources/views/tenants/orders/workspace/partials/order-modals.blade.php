{{-- Quote name --}}
<div class="modal fade" id="ow-modal-quote" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Please add your quote name</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <label>Quote Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="ow-quote-name-field" maxlength="120">
                <span class="text-danger d-block mt-1" id="ow-err-quote-name"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="ow-btn-confirm-quote">Save</button>
            </div>
        </div>
    </div>
</div>

{{-- Shipping confirm --}}
<div class="modal fade" id="ow-modal-shipping-confirm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Shipping Quote Request Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">{!! $shippingPopup ?? '' !!}</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="ow-shipping-confirm-no" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary" id="ow-shipping-confirm-yes">Yes</button>
            </div>
        </div>
    </div>
</div>

{{-- Shipping info --}}
<div class="modal fade" id="ow-modal-shipping-info" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Shipping quote details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Shipping Quote Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="ow-shipping-quote-name">
                </div>
                <div class="form-group">
                    <label>Delivery Type <span class="text-danger">*</span></label>
                    <label class="d-block"><input type="radio" name="ow_delivery_type" value="commercial"> Commercial</label>
                    <label class="d-block"><input type="radio" name="ow_delivery_type" value="residential"> Residential</label>
                </div>
                <div class="form-group">
                    <label>Will you require Liftgate? <span class="text-danger">*</span></label>
                    <label class="d-block"><input type="radio" name="ow_liftgate" value="yes"> Yes</label>
                    <label class="d-block"><input type="radio" name="ow_liftgate" value="no"> No</label>
                </div>
                <div class="form-group">
                    <label>How will you unload? <span class="text-danger">*</span></label>
                    <label class="d-block"><input type="radio" name="ow_unload_type" value="by_hand"> By Hand</label>
                    <label class="d-block"><input type="radio" name="ow_unload_type" value="by_forklift"> By ForkLift</label>
                </div>
                <div class="ow-terms-box d-none border p-2 mt-2" id="ow-shipping-terms">
                    <small>{!! $shipTerms ?? '<p>Standard shipping terms apply.</p>' !!}</small>
                </div>
                <span class="text-danger d-block" id="ow-err-shipping"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="ow-btn-save-shipping">Save</button>
            </div>
        </div>
    </div>
</div>

{{-- Stock check confirm --}}
<div class="modal fade" id="ow-modal-stock-confirm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Stock Check Shipping Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">{!! $stockShippingPopup ?? '<p>Do you want shipping for this stock check?</p>' !!}</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="ow-stock-confirm-no">No</button>
                <button type="button" class="btn btn-primary" id="ow-stock-confirm-yes">Yes</button>
            </div>
        </div>
    </div>
</div>

{{-- Stock shipping info (no quote name) --}}
<div class="modal fade" id="ow-modal-stock-shipping" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Stock check shipping</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Delivery Type <span class="text-danger">*</span></label>
                    <label class="d-block"><input type="radio" name="ow_stock_delivery_type" value="commercial"> Commercial</label>
                    <label class="d-block"><input type="radio" name="ow_stock_delivery_type" value="residential"> Residential</label>
                </div>
                <div class="form-group">
                    <label>Will you require Liftgate? <span class="text-danger">*</span></label>
                    <label class="d-block"><input type="radio" name="ow_stock_liftgate" value="yes"> Yes</label>
                    <label class="d-block"><input type="radio" name="ow_stock_liftgate" value="no"> No</label>
                </div>
                <div class="form-group">
                    <label>How will you unload? <span class="text-danger">*</span></label>
                    <label class="d-block"><input type="radio" name="ow_stock_unload_type" value="by_hand"> By Hand</label>
                    <label class="d-block"><input type="radio" name="ow_stock_unload_type" value="by_forklift"> By ForkLift</label>
                </div>
                <span class="text-danger d-block" id="ow-err-stock-shipping"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="ow-btn-save-stock-shipping">Save</button>
            </div>
        </div>
    </div>
</div>

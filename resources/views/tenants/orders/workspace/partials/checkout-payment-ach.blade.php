<div class="tc-checkout__pay-card" data-pay="ach">
    <div class="tc-checkout__pay-head">
        <div>
            <input type="radio" name="credit_or_not_credit_card" id="pay_ach" value="pay_ach">
            <label for="pay_ach">I Will Pay Using ACH</label>
        </div>
        <span class="tc-checkout__save" data-save-ach>(You save ${{ number_format($savings['ach'] ?? 0, 2) }})</span>
    </div>
    <div class="tc-checkout__pay-body">
        <div class="row g-2">
            <div class="col-md-6">
                <label class="small">First Name <span class="tc-req">*</span></label>
                <input type="text" name="ach_checkout_fname" class="form-control form-control-sm" value="{{ old('ach_checkout_fname') }}">
                <div class="field-error err_ach_checkout_fname"></div>
            </div>
            <div class="col-md-6">
                <label class="small">Last Name <span class="tc-req">*</span></label>
                <input type="text" name="ach_checkout_lname" class="form-control form-control-sm" value="{{ old('ach_checkout_lname') }}">
                <div class="field-error err_ach_checkout_lname"></div>
            </div>
            <div class="col-12">
                <label class="small">Address <span class="tc-req">*</span></label>
                <textarea name="ach_checkout_address" class="form-control form-control-sm" rows="2">{{ old('ach_checkout_address') }}</textarea>
                <div class="field-error err_ach_checkout_address"></div>
            </div>
            <div class="col-md-4">
                <label class="small">City <span class="tc-req">*</span></label>
                <input type="text" name="ach_checkout_city" class="form-control form-control-sm" value="{{ old('ach_checkout_city') }}">
                <div class="field-error err_ach_checkout_city"></div>
            </div>
            <div class="col-md-4">
                <label class="small">State <span class="tc-req">*</span></label>
                <input type="text" name="ach_checkout_state" class="form-control form-control-sm" value="{{ old('ach_checkout_state') }}">
                <div class="field-error err_ach_checkout_state"></div>
            </div>
            <div class="col-md-4">
                <label class="small">Zip Code <span class="tc-req">*</span></label>
                <input type="text" name="ach_checkout_zipcode" class="form-control form-control-sm" value="{{ old('ach_checkout_zipcode') }}">
                <div class="field-error err_ach_checkout_zipcode"></div>
            </div>
            <div class="col-md-6">
                <label class="small">Account Number <span class="tc-req">*</span></label>
                <input type="text" name="account_number" class="form-control form-control-sm" value="{{ old('account_number') }}">
                <div class="field-error err_account_number"></div>
            </div>
            <div class="col-md-6">
                <label class="small">Route Number <span class="tc-req">*</span></label>
                <input type="text" name="route_number" class="form-control form-control-sm" value="{{ old('route_number') }}">
                <div class="field-error err_route_number"></div>
            </div>
        </div>
        <div class="tc-checkout__submit-row">
            <button type="submit" class="btn btn-primary final_frm_sub_btn" data-pay-type="pay_ach">Submit</button>
        </div>
    </div>
</div>

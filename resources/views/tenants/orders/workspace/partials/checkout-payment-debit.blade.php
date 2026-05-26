<div class="tc-checkout__pay-card" data-pay="debit">
    <div class="tc-checkout__pay-head">
        <label class="tc-checkout__pay-choice" for="by_debit_card">
            <input type="radio" name="credit_or_not_credit_card" id="by_debit_card" value="by_debit_card">
            <span>I Will Pay Using Debit Card</span>
        </label>
        <span class="tc-checkout__save" data-save-debit>You save ${{ number_format($savings['debit'] ?? 0, 2) }}</span>
    </div>
    <div class="tc-checkout__pay-body">
        <div class="row g-2">
            <div class="col-md-6">
                <label class="small">First Name <span class="tc-req">*</span></label>
                <input type="text" name="debit_checkout_fname" class="form-control form-control-sm" value="{{ old('debit_checkout_fname') }}">
                <div class="field-error err_debit_checkout_fname"></div>
            </div>
            <div class="col-md-6">
                <label class="small">Last Name <span class="tc-req">*</span></label>
                <input type="text" name="debit_checkout_lname" class="form-control form-control-sm" value="{{ old('debit_checkout_lname') }}">
                <div class="field-error err_debit_checkout_lname"></div>
            </div>
            <div class="col-12">
                <label class="small">Address <span class="tc-req">*</span></label>
                <textarea name="debit_checkout_address" class="form-control form-control-sm" rows="2">{{ old('debit_checkout_address') }}</textarea>
                <div class="field-error err_debit_checkout_address"></div>
            </div>
            <div class="col-md-4">
                <label class="small">City <span class="tc-req">*</span></label>
                <input type="text" name="debit_checkout_city" class="form-control form-control-sm" value="{{ old('debit_checkout_city') }}">
                <div class="field-error err_debit_checkout_city"></div>
            </div>
            <div class="col-md-4">
                <label class="small">State <span class="tc-req">*</span></label>
                <input type="text" name="debit_checkout_state" class="form-control form-control-sm" value="{{ old('debit_checkout_state') }}">
                <div class="field-error err_debit_checkout_state"></div>
            </div>
            <div class="col-md-4">
                <label class="small">Zip Code <span class="tc-req">*</span></label>
                <input type="text" name="debit_checkout_zipcode" class="form-control form-control-sm" value="{{ old('debit_checkout_zipcode') }}">
                <div class="field-error err_debit_checkout_zipcode"></div>
            </div>
            <div class="col-12">
                <label class="small">Card Number <span class="tc-req">*</span></label>
                <input type="text" name="debit_card_number" class="form-control form-control-sm" value="{{ old('debit_card_number') }}">
                <div class="field-error err_debit_card_number"></div>
            </div>
            <div class="col-md-6">
                <label class="small">Expiration Date <span class="tc-req">*</span></label>
                <input type="text" name="debit_expiry_date" class="form-control form-control-sm" placeholder="MM/YY" value="{{ old('debit_expiry_date') }}">
                <span class="small text-muted">Format: MM/YY e.g. 09/25</span>
                <div class="field-error err_debit_expiry_date"></div>
            </div>
            <div class="col-md-6">
                <label class="small">CVV Number <span class="tc-req">*</span></label>
                <input type="text" name="debit_cvv_number" class="form-control form-control-sm" value="{{ old('debit_cvv_number') }}">
                <div class="field-error err_debit_cvv_number"></div>
            </div>
            <div class="col-12">
                <label class="small d-flex align-items-start gap-2">
                    <input type="checkbox" name="membership_agree" value="1">
                    <span>As The Account Holder I Agree To The Membership Terms And Conditions.</span>
                </label>
                <div class="field-error err_membership_agree"></div>
            </div>
        </div>
        <div class="tc-checkout__submit-row">
            <button type="submit" class="btn btn-primary final_frm_sub_btn" data-pay-type="by_debit_card">Submit</button>
        </div>
    </div>
</div>

<div class="tc-checkout__pay-card" data-pay="cash">
    <div class="tc-checkout__pay-head">
        <label class="tc-checkout__pay-choice" for="not_credit_card_and_ach">
            <input type="radio" name="credit_or_not_credit_card" id="not_credit_card_and_ach" value="not_credit_card_and_ach">
            <span>I Will Pay By Cash/Wire Transfer</span>
        </label>
        <span class="tc-checkout__save" data-save-cash>You save ${{ number_format($savings['cash'] ?? 0, 2) }}</span>
    </div>
    <div class="tc-checkout__pay-body tc-checkout__pay-body--compact">
        <div class="tc-checkout__cash-options">
            <label><input type="radio" name="payment_method" value="cash" checked> Cash</label>
            <label><input type="radio" name="payment_method" value="wire transfer"> Wire Transfer</label>
        </div>
        <div class="tc-checkout__submit-row">
            <button type="submit" class="btn btn-primary final_frm_sub_btn" data-pay-type="not_credit_card_and_ach">Submit</button>
        </div>
    </div>
</div>

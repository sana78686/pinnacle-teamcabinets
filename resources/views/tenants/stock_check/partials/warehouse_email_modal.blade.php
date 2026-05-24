<div class="modal fade" id="stockCheckWarehouseModal" tabindex="-1" role="dialog" aria-labelledby="stockCheckWarehouseModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="stockCheckWarehouseModalLabel">Send Email To Warehouse</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" data-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="statusMsg mb-2"></div>
                <div class="form-group">
                    <label for="stock_check_warehouse_email">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="stock_check_warehouse_email"
                        name="stock_check_warehouse_email">
                    <input type="hidden" id="stock_check_request_id" name="stock_check_request_id">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                    data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary submitBtn"
                    onclick="submitStockCheckWarehouseEmail()">Submit</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="tc-order-help-modal" tabindex="-1" aria-labelledby="tcOrderHelpLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tcOrderHelpLabel">Order Query Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="tc-order-help-form">
                <div class="modal-body">
                    <div id="tc-order-help-status" class="small mb-2" role="status"></div>
                    <div class="mb-3">
                        <label for="tc-order-help-subject" class="form-label">Subject <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="tc-order-help-subject" name="subject" required placeholder="Enter subject">
                    </div>
                    <div class="mb-0">
                        <label for="tc-order-help-message" class="form-label">Message <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="tc-order-help-message" name="message" rows="5" required placeholder="Enter your message"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="tc-order-help-submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
(function () {
    'use strict';
    var form = document.getElementById('tc-order-help-form');
    if (!form) return;
    var statusEl = document.getElementById('tc-order-help-status');
    var submitBtn = document.getElementById('tc-order-help-submit');
    var csrf = document.querySelector('meta[name="csrf-token"]');
    form.addEventListener('submit', function (ev) {
        ev.preventDefault();
        var subject = document.getElementById('tc-order-help-subject').value.trim();
        var message = document.getElementById('tc-order-help-message').value.trim();
        if (!subject || !message) {
            statusEl.className = 'small mb-2 text-danger';
            statusEl.textContent = 'Please enter subject and message.';
            return;
        }
        submitBtn.disabled = true;
        statusEl.className = 'small mb-2 text-muted';
        statusEl.textContent = 'Sending…';
        fetch(@json(route('tenant_order_query_store')), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrf ? csrf.content : '',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ subject: subject, message: message })
        }).then(function (res) {
            return res.json().then(function (json) {
                if (!res.ok) throw new Error(json.message || 'Could not send message.');
                statusEl.className = 'small mb-2 text-success';
                statusEl.textContent = json.message || 'Message sent.';
                form.reset();
                setTimeout(function () {
                    if (window.bootstrap) {
                        window.bootstrap.Modal.getInstance(document.getElementById('tc-order-help-modal'))?.hide();
                    }
                    statusEl.textContent = '';
                }, 1800);
            });
        }).catch(function (err) {
            statusEl.className = 'small mb-2 text-danger';
            statusEl.textContent = err.message || 'Send failed.';
        }).finally(function () {
            submitBtn.disabled = false;
        });
    });
})();
</script>

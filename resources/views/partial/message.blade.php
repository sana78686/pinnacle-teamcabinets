@if (session('error'))
    <div class="tc-flash-messages">
        <div class="alert alert-danger outline alert-dismissible fade show" role="alert">
            <div class="tc-alert__text">{{ session('error') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif
@if (session('success'))
    <div class="tc-flash-messages">
        <div class="alert alert-success outline alert-dismissible fade show" role="alert">
            <div class="tc-alert__text">{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif
@if (session('info'))
    <div class="tc-flash-messages">
        <div class="alert alert-info outline alert-dismissible fade show" role="alert">
            <div class="tc-alert__text">{{ session('info') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

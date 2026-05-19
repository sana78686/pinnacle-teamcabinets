@if (Session::has('error'))
    <div class="p-2 card-body">

        <div class="alert alert-danger outline alert-dismissible fade show" role="alert"><i
                data-feather="thumbs-down"></i>
            <p>{{ Session::get('error') }}</p>
            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

    </div>
@elseif (Session::has('success'))
    <div class="p-2 card-body">
        <div class="alert alert-success outline alert-dismissible fade show" role="alert"><i
                data-feather="thumbs-up"></i>
                <p>{{ Session::get('success') }}</p>
            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif
@if (session('info'))
            <div class=" txt-danger" role="alert">
                <h4 class="alert-heading">Note!</h4>
                <p>{{ session('info') }}</p>
            </div>
        @endif

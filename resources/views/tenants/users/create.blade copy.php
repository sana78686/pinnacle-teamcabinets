<form method="POST" action="{{ route('users.store') }}">
    @csrf
    <div class="m-2 row">
        <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
            <div class="form-group">
                <strong>User Type:<span class="txt-danger">*</span></strong>
                <select class="js-example-basic-single col-sm-12 form-control b-r-0" id="search_role" name="role_id"
                    required data-toggle="tooltip" title="Select the role of the user, such as Admin or Customer" autofocus>
                    <!-- Options -->
                </select>
            </div>
        </div>

        <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
            <div class="form-group">
                <strong>User Name &nbsp;<span class="txt-danger">*</span></strong>
                <input class="form-control" name="username" id="username" type="text" placeholder="Enter a unique username"
                    required data-toggle="tooltip" title="Provide a unique username for the user" autofocus>
            </div>
        </div>

        <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
            <div class="form-group">
                <strong>Full Name &nbsp;<span class="txt-danger">*</span></strong>
                <input type="text" name="name" placeholder="Enter the full name" class="form-control" required
                    data-toggle="tooltip" title="Provide the user's full legal name" autofocus>
            </div>
        </div>

        <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
            <div class="form-group">
                <strong>Cell Phone &nbsp;<span class="txt-danger">*</span></strong>
                <input type="text" name="phone" placeholder="Enter the cell phone number" class="form-control" required
                    data-toggle="tooltip" title="Provide a valid mobile number, e.g., 1234567890" autofocus>
            </div>
        </div>

        <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
            <div class="form-group">
                <strong>Email &nbsp;<span class="txt-danger">*</span></strong>
                <input type="email" name="email" placeholder="Enter a valid email address" class="form-control" required
                    data-toggle="tooltip" title="Provide a valid email, e.g., user@example.com" autofocus>
            </div>
        </div>

        <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
            <div class="form-group">
                <strong>Password &nbsp;</strong>
                <input type="password" name="password" placeholder="Create a strong password" class="form-control"
                    data-toggle="tooltip" title="Enter a secure password with at least 8 characters">
            </div>
        </div>

        <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
            <div class="form-group">
                <strong>Country &nbsp;<span class="txt-danger">*</span></strong>
                <select class="js-example-basic-single col-sm-12 form-control b-r-0" id="search_country" name="country_id"
                    required data-toggle="tooltip" title="Select the country where the user resides" autofocus>
                    <!-- Options -->
                </select>
            </div>
        </div>

        <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
            <div class="form-group">
                <strong>State &nbsp;<span class="txt-danger">*</span></strong>
                <select class="js-example-basic-single col-sm-12 form-control b-r-0" id="search_state" name="state_id"
                    required data-toggle="tooltip" title="Select the state of residence" autofocus>
                    <!-- Options -->
                </select>
            </div>
        </div>

        <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
            <div class="form-group">
                <strong>City</strong>
                <select class="js-example-basic-single col-sm-12 form-control b-r-0" id="search_city" name="city_id"
                    required data-toggle="tooltip" title="Select the city of residence" autofocus>
                    <!-- Options -->
                </select>
            </div>
        </div>

        <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
            <div class="form-group">
                <strong>Zip &nbsp;<span class="txt-danger">*</span></strong>
                <input type="text" name="zip" placeholder="Enter the ZIP code" class="form-control" required
                    data-toggle="tooltip" title="Provide the postal code for the user's address" autofocus>
            </div>
        </div>

        <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
            <div class="form-group">
                <strong>Address &nbsp;<span class="txt-danger">*</span></strong>
                <textarea class="form-control" id="exampleFormControlTextarea4" rows="1" placeholder="Enter the full address"
                    data-toggle="tooltip" title="Provide the complete residential address"></textarea>
            </div>
        </div>

        <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
            <div class="form-group">
                <strong>Tax Exemption &nbsp;</strong>
                <div class="checkbox checkbox-primary">
                    <input id="checkbox-primary-0" type="checkbox" name="is_taxable_user" id="is_taxable_user">
                    <label class="form-label" for="checkbox-primary-0">Is Exempted?</label>
                </div>
            </div>
        </div>

        <div class="text-center col-xs-12 col-sm-12 col-md-12">
            <button type="submit" class="mt-2 mb-3 btn btn-primary btn-sm" data-toggle="tooltip"
                title="Click to create the user"><i class="fa-solid fa-floppy-disk"></i> Create User</button>
        </div>
    </div>
</form>

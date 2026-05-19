@if (Session::has('error'))
    <div class="d-flex justify-content-center w-100" id="error_alert">
        <div class="mx-auto text-center alert alert-danger w-25" style="position: fixed;top:3%;" id= "error-alert">
            {{Session::get('error')}} hello
        </div>
    </div>

    <script>
        $("#error_alert").fadeOut(2000,"swing",function(){
            $("#error_alert").html("");
        });
    </script>
@elseif (Session::has('success'))
    <div class="d-flex justify-content-center w-100" id="success_alert">
        <div class="mx-auto text-center alert alert-success w-25" style="position: fixed;top:3%;" id= "success-alert">
            {{Session::get('success')}}
        </div>
    </div>
    <script>
        $("#success_alert").fadeOut(2000,"swing",function(){
            $("#success_alert").html("");
        });
    </script>
@endif

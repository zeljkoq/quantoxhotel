
<div class="modal fade" id="mLogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                <form action="#" class="form-signin">
                    <div class="alert alert-danger" id="errors"></div>
                    <span id="reauth-email" class="reauth-email"></span>

                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                    @if ($errors->has('email'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                    @if ($errors->has('password'))
                        <span class="invalid-feedback">
                           <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                    <div id="remember" class="checkbox">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                        </label>
                    </div>
                </form><!-- /form -->
            </div>

            <div class="modal-footer">
                <a class="btn btn-link" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
                <button id="loginButton" type="button" class="btn btn-success">
                    {{ __('Login') }}
                </button>
                {{csrf_field()}}
            </div>
        </div>
    </div>
</div>

@section('scripts')

<script>
    $('#loginButton').click(function(){
        let email = $('#email').val();
        let password = $('#password').val();
        $.ajax({
            type: "POST",
            url: '{{route('login.api')}}',
            data: ({email: email, password: password}),
            success: function (response) {
                localStorage.setItem('token', response.token);
            },
            error: function (response) {
                $('#errors').text(response.responseJSON.errors);
            }
        });
    });
</script>
<script>
    $('#registerBtn').on('click', function () {
        console.log(123);
        var emailRegister = $('#emailRegister').val();
        var name = $('#name').val();
        var passwordRegister = $('#passwordRegister').val();
        var passwordConfirm = $('#password-confirm').val();
        $.ajax({
            url: '{{route('register.api')}}',
            type: 'POST',
            data: ({name: name, emailRegister: emailRegister, passwordRegister: passwordRegister, passwordConfirm: passwordConfirm}),
            success: function (data) {

                localStorage.setItem('token', data.token);
            },
            error: function (data) {

                // console.log(data.responseJSON);
            }
        });
    });
</script>
@endsection

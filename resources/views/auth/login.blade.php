<div class="modal fade" id="mLogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Login</h4>
            </div>
            <div class="modal-body">
                <div id="loginMessages"></div>
                <form action="#" class="form-signin">

                    <span id="reauth-email" class="reauth-email"></span>

                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' has-error' : '' }}"
                           name="email" value="{{ old('email') }}" required autofocus>

                    @if ($errors->has('email'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                    <input id="password" type="password"
                           class="form-control{{ $errors->has('password') ? ' has-error' : '' }}" name="password"
                           required>

                    @if ($errors->has('password'))
                        <span class="invalid-feedback">
                           <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                    <div id="remember" class="checkbox">
                        <label>
                            <input type="checkbox"
                                   name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
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
        $('#loginButton').click(function () {
            let email = $('#email').val();
            let password = $('#password').val();

            $.ajax({
                type: "POST",
                url: '{{route('login.api')}}',
                data: ({email: email, password: password}),
                success: function (response) {
                    localStorage.setItem('token', response.token);
                    window.location = '/';
                },
                error: function (response) {

                    if (typeof response.responseJSON.errors !== 'undefined') {
                        var errEmail = response.responseJSON.errors.email;
                        var errPassword = response.responseJSON.errors.password;

                        if (typeof errEmail !== 'undefined') {
                            for (a = 0; a < errEmail.length; a++) {
                                setModalMessage('loginMessages', 'error', errEmail[a]);
                            }
                        }

                        if (typeof errPassword !== 'undefined') {
                            for (t = 0; t < errPassword.length; t++) {
                                setModalMessage('loginMessages', 'error', errPassword[t]);
                            }
                        }
                    }
                    else {
                        var errorMessage = response.responseJSON.error;
                        setModalMessage('loginMessages', 'error', errorMessage);
                    }
                }
            });
        });
    </script>
    <script>
        $('#registerBtn').on('click', function () {
            var emailRegister = $('#emailRegister').val();
            var nameRegister = $('#nameRegister').val();
            var passwordRegister = $('#passwordRegister').val();
            var passwordConfirm = $('#passwordConfirm').val();

            $.ajax({
                url: '{{route('register.api')}}',
                type: 'POST',
                data: ({
                    name: nameRegister,
                    email: emailRegister,
                    password: passwordRegister,
                    passwordConfirm: passwordConfirm
                }),
                success: function (data) {
                    localStorage.setItem('token', data.token);
                },
                error: function (data) {
                    if (typeof data.responseJSON.errors !== 'undefined') {
                        var registerName = data.responseJSON.errors.name;
                        var registerEmail = data.responseJSON.errors.email;
                        var registerPassword = data.responseJSON.errors.password;
                        var registerPasswordConfirm = data.responseJSON.errors.passwordConfirm;

                        if (typeof registerName !== 'undefined') {
                            for (n = 0; n < registerName.length; n++) {
                                setModalMessage('registerMessages', 'error', registerName[n]);
                            }
                        }

                        if (typeof registerEmail !== 'undefined') {
                            for (e = 0; e < registerEmail.length; e++) {
                                setModalMessage('registerMessages', 'error', registerEmail[e]);
                            }
                        }

                        if (typeof registerPassword !== 'undefined') {
                            for (p = 0; p < registerPassword.length; p++) {
                                setModalMessage('registerMessages', 'error', registerPassword[p]);
                            }
                        }

                        if (typeof registerPasswordConfirm !== 'undefined') {
                            for (pc = 0; pc < registerPasswordConfirm.length; pc++) {
                                setModalMessage('registerMessages', 'error', registerPasswordConfirm[pc]);
                            }
                        }
                    }
                    else {

                        setModalMessage('error', 'asdasd');
                    }
                }
            });
        });
    </script>
@endsection

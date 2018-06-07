@extends('layouts.app')

@section('content')
<div class="card card-container">
    <!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->
    <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
    <p id="profile-name" class="profile-name-card"></p>
    {{--<form method="POST" action="{{ route('login.api') }}" class="form-signin">--}}
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
        <button id="loginButton" type="button" class="btn btn-success">
            {{ __('Login') }}
        </button>
        <a class="btn btn-link" href="{{ route('password.request') }}">
            {{ __('Forgot Your Password?') }}
        </a>
        {{csrf_field()}}
    {{--</form><!-- /form -->--}}
</div>

@endsection

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
                var arr = [];
                for (i = 0; i < response.user.roles.length; i++)
                {
                    arr += response.user.roles[i].name + ' ';
                }
                localStorage.setItem('roles', arr);
                // window.location = "/";
            }
        });
    });
</script>

@endsection


<!-- Modal -->
<div class="modal fade" id="mRegister" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                <form class="form-signin">
                    <div class="form-group row">
                        <label for="nameRegister" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                        <div class="col-md-6">
                            <input id="nameRegister" type="name" class="form-control{{ $errors->has('nameRegister') ? ' is-invalid' : '' }}" name="nameRegister" value="{{ old('nameRegister') }}" required>

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="emailRegister" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>

                        <div class="col-md-6">
                            <input id="emailRegister" type="emailRegister" class="form-control{{ $errors->has('emailRegister') ? ' is-invalid' : '' }}" name="emailRegister" value="{{ old('emailRegister') }}" required>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="passwordRegister" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                        <div class="col-md-6">
                            <input id="passwordRegister" type="password" class="form-control{{ $errors->has('passwordRegister') ? ' is-invalid' : '' }}" name="passwordRegister" required>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control"  required>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                <button id="registerBtn" type="button" class="btn btn-success">
                    {{ __('Register') }}
                </button>
            </div>
        </div>
    </div>
</div>
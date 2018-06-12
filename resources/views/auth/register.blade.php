
<!-- Modal -->
<div class="modal fade" id="mRegister" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Register</h4>
            </div>
            <div class="modal-body">
                <div id="registerMessages"></div>
                <form class="form-signin">
                    <div class="form-group row">
                        <label for="nameRegister" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                        <div class="col-md-6">
                            <input id="nameRegister" id="nameRegister" type="text" class="form-control" name="name" value="{{ old('nameRegister') }}" required>

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="emailRegister" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>

                        <div class="col-md-6">
                            <input id="emailRegister" id="emailRegister" type="emailRegister" class="form-control" name="email" value="{{ old('emailRegister') }}" required>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="passwordRegister" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                        <div class="col-md-6">
                            <input id="passwordRegister" type="password" class="form-control" name="password" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="passwordConfirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                        <div class="col-md-6">
                            <input id="passwordConfirm" name="passwordConfirm" type="password" class="form-control"  required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="roles" class="col-md-4 col-form-label text-md-right">{{ __('Choose Role') }}</label>

                        <div class="col-md-6">
                            <select id="userRoles" name="userRoles" class="form-control selectpicker" multiple>
                            </select>
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
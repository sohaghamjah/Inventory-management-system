<div class="modal fade show" id="store_or_update_modal" tabindex="-1" role="dialog" aria-labelledby="model-1" aria-modal="true">
    <div class="modal-dialog modal-lg" role="document">

      <!-- Modal Content -->
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header bg-primary text-white">
          <h3 class="modal-title text-white" id="model-1"></h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="text-white">×</span>
          </button>
        </div>
        <!-- /modal header -->

        <!-- Modal Body -->
        <form action="" id="store_or_update_form">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="update_id" id="update_id">
                    <x-forms.textbox labelName="Name" name="name" col="col-md-6" required="required" placeholder="Enter name..."/>
                    <x-forms.textbox labelName="Email" name="email" col="col-md-6" required="required" placeholder="Enter email..."/>
                    <x-forms.textbox labelName="Mobile Number" name="mobile" col="col-md-6" required="required" placeholder="Enter mobile no..."/>
                    <x-forms.selectbox labelName="Gender" name="gender" col="col-md-6" required="required" class="selectpicker">
                        <option value="1">Male</option>
                        <option value="0">Female</option>
                    </x-forms.selectbox>
                    <x-forms.selectbox labelName="Role" name="role_id" col="col-md-12" required="required" class="selectpicker">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                        @endforeach
                    </x-forms.selectbox>
                    <div class="form-group col-md-12">
                        <label for="password">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="password" id="password">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-warning" id="generate_password"
                                    data-toggle="tooltip" data-placement="top"
                                    data-original-title="Generate Password">
                                    <i class="fas fa-lock text-white" style="cursor: pointer;"></i>
                                </span>
                            </div>
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-primary">
                                    <i class="fas fa-eye toggle-password text-white" toggle="#password"
                                        style="cursor: pointer;"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="password_confirmation">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="password_confirmation"
                                id="password_confirmation">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-primary">
                                    <i class="fas fa-eye toggle-password text-white" toggle="#password_confirmation"
                                        style="cursor: pointer;"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /modal body -->

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-sm" id="save_btn"></button>
            </div>
        </form>
        <!-- /modal footer -->

      </div>
      <!-- /modal content -->

    </div>
  </div>

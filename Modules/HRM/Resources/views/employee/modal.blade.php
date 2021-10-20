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
                    <div class="col-md-9">
                      <div class="row">
                        <x-forms.textbox labelName="Employee Name" name="name" required="required" col="col-md-6" placeholder="Enter Employee name"/>
                        <x-forms.textbox labelName="Phone" name="phone" required="required" col="col-md-6" placeholder="Enter Phone Number"/>
                        <x-forms.selectbox labelName="Department" name="department_id" required="required" col="col-md-6" class="selectpicker">
                          @if (!$departments -> isEmpty())
                              @foreach ($departments as $department)
                                    <option value="{{ $department -> id }}">{{ $department -> name }}</option>
                              @endforeach              
                          @endif
                        </x-forms.selectbox>
                        <x-forms.textbox labelName="Address" name="address" col="col-md-6" required="required" placeholder="Enter Address"/>
                        <x-forms.textbox labelName="City" name="city" col="col-md-6" required="required" placeholder="Enter city"/>
                        <x-forms.textbox labelName="State" name="state" col="col-md-6" required="required" placeholder="Enter state"/>
                        <x-forms.textbox labelName="Postal code" name="postal_code" col="col-md-6" placeholder="Enter country"/>
                        <x-forms.textbox labelName="Country" name="country" col="col-md-6" required="required" placeholder="Enter country"/>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="row">
                        <div class="form-group col-md-12 required">
                          <label for="image">Employee Image</label>
                          <div class="col-md-12 px-0 text-center">
                              <div id="image">

                              </div>
                          </div>
                          <input type="hidden" name="old_image" id="old_image">
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

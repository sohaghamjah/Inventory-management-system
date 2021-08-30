<div class="modal fade show" id="store_or_update_modal" tabindex="-1" role="dialog" aria-labelledby="model-1" aria-modal="true">
    <div class="modal-dialog" role="document">

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
                    <x-forms.textbox labelName="Unit Name" name="unit_name" required="required" col="col-md-12" placeholder="Enter Unit Name"/>
                    <x-forms.textbox labelName="Unit Code" name="unit_code" required="required" col="col-md-12" placeholder="Enter Unit Code"/>
                    <x-forms.selectbox labelName="Base Unit" name="base_unit" col="col-md-12" class="form-control selectpicker">
                     
                    </x-forms.selectbox>
                    <x-forms.textbox labelName="Operator" name="operator" col="col-md-12" placeholder="Enter Operator"/>
                    <x-forms.textbox labelName="Operation Value" name="operation_value" col="col-md-12" placeholder="Enter Operation_value"/>
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

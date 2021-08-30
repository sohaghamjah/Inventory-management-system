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
                    <x-forms.textbox labelName="Name" name="name" required="required" col="col-md-12" placeholder="Enter name"/>
                    <x-forms.textbox labelName="Phone" name="phone" required="required" col="col-md-12" placeholder="Enter Phone Number"/>
                    <x-forms.textbox labelName="Email" name="email" type="email" required="required" col="col-md-12" placeholder="Enter Email Address"/>
                    <x-forms.textbox labelName="Address" name="address" required="required" col="col-md-12" placeholder="Enter Address"/>
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

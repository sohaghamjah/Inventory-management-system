<div class="modal fade show" id="payment_modal" tabindex="-1" role="dialog" aria-labelledby="model-1" aria-modal="true">
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
        <form action="" id="payment_form">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="payment_id" id="payment_id">
                    <input type="hidden" name="purchase_id" id="purchase_id">
                    <input type="hidden" name="balance" id="balance"/>
                    <x-forms.textbox labelName="Received Amount" name="paying_amount" required="required" col="col-md-6"/>
                    <div class="form-group col-md-6 required">
                      <label for="payable_amount">Paying Amount</label>
                      <input type="text" class="form-control" name="amount" id="amount">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="change_amount">Change Amount</label>
                        <input type="text" class="form-control" name="change_amount" id="change_amount" readonly>
                    </div>
                    <x-forms.selectbox labelName="Payment Method" name="payment_method" required="required"  col="col-md-6" class="selectpicker">
                        @foreach (PAYMENT_METHOD as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </x-forms.selectbox>
                    <x-forms.selectbox labelName="Account" name="account_id" required="required"  col="col-md-12" class="selectpicker">
                        @if (!$accounts->isEmpty())
                          @foreach ($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->name.' - '.$account->account_no }}</option>
                          @endforeach
                        @endif
                    </x-forms.selectbox>
                    <div class="form-group col-md-12 payment_no d-none">
                        <label for="payment_no"><span id="method-name"></span> No</label>
                        <input type="text" class="form-control" name="payment_no" id="payment_no">
                    </div>
                    <x-forms.textarea labelName="Payment Note" name="payment_note" col="col-md-12"/>
                </div>
            </div>
            <!-- /modal body -->

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-sm" id="payment_save_btn">Save</button>
            </div>
        </form>
        <!-- /modal footer -->

      </div>
      <!-- /modal content -->

    </div>
  </div>

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
                  <input type="hidden" name="update_id" id="update_id"/>
                  <x-forms.selectbox labelName="Employee" name="employee_id" required="required" col="col-md-12" class="selectpicker">
                    @if (!$employees->isEmpty())
                        @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                        @endforeach
                    @endif
                </x-forms.selectbox>
                <x-forms.textbox labelName="Amount" name="amount" required="required" col="col-md-12" placeholder="0.00"/>
                  <x-forms.selectbox labelName="Payment Method" name="payment_method" required="required" col="col-md-12" class="selectpicker">           
                      @foreach (PAYROLL_PAYMENT_METHOD as $key => $value)
                      <option value="{{ $key }}">{{ $value }}</option>
                      @endforeach
                </x-forms.selectbox>
                <x-forms.selectbox labelName="Account" name="account_id" required="required" col="col-md-12" class="selectpicker">
                    @if (!$accounts->isEmpty())
                        @foreach ($accounts as $account)
                        <option value="{{ $account->id }}">{{ $account->name }}</option>
                        @endforeach
                    @endif
                </x-forms.selectbox>
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

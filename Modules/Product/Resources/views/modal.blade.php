<div class="modal fade show" id="store_or_update_modal" tabindex="-1" role="dialog" aria-labelledby="model-1"
    aria-modal="true">
    <div class="modal-dialog modal-xl" role="document">

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
            <form action="" id="store_or_update_form" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="update_id" id="update_id">
                        <div class="col-md-8">
                            <div class="row">
                                <x-forms.textbox labelName="Name" name="name" required="required" col="col-md-6"
                                    placeholder="Enter name" />

                                <x-forms.selectbox labelName="Barcode Symbology" required="required" name="barcode_symbology"
                                    class="selectpicker" col="col-md-6">
                                    @foreach (BERCODE_SYMBOLOGY as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </x-forms.selectbox>

                                <div class="form-group col-md-6 required">
                                  <label for="">Barcode</label>
                                  <div class="input-group">
                                    <input type="text" name="code" id="code" class="form-control">
                                    <div class="input-group-prepend bg-primary">
                                        <span style="cursor: pointer" class="input-group-text bg-primary" id="generate_barcode">
                                            <i class="fas fa-retweet text-white" ></i>
                                        </span>
                                    </div>
                                  </div>
                                </div>

                                <x-forms.selectbox labelName="Brand" name="brand_id" class="selectpicker"
                                col="col-md-6">
                                    @if (!$brands->isEmpty())
                                    @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                    @endif
                                </x-forms.selectbox>             

                                <x-forms.selectbox required="required" labelName="Category" name="category_id" class="selectpicker"
                                    col="col-md-6">
                                    @if (!$categories->isEmpty())
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                    @endif
                                </x-forms.selectbox>

                                <x-forms.selectbox required="required" labelName="Unit" name="unit_id" class="selectpicker" col="col-md-6"
                                    onchange="populateUnit(this.value)">
                                    @if (!$units->isEmpty())
                                    @foreach ($units as $unit)
                                    @if ($unit->base_unit == null)
                                    <option value="{{ $unit->id }}">{{ $unit->unit_name }}</option>
                                    @endif
                                    @endforeach
                                    @endif
                                </x-forms.selectbox>
                                <x-forms.selectbox required="required" labelName="Purchase Unit" name="purchase_unit_id"
                                    class="selectpicker" col="col-md-6">

                                </x-forms.selectbox>
                                <x-forms.selectbox required="required" labelName="Sale Unit" name="sale_unit_id" class="selectpicker"
                                    col="col-md-6">

                                </x-forms.selectbox>

                                <x-forms.textbox required="required" labelName="Cost" name="cost" required="required" col="col-md-6"
                                    placeholder="0.00" />

                                <x-forms.textbox required="required" labelName="Price" name="price" required="required" col="col-md-6"
                                    placeholder="0.00" />

                                <x-forms.textbox labelName="Quantity" name="qty" required="required" col="col-md-6"
                                    placeholder="Enter Quantity" />

                                <x-forms.textbox labelName="Alert Quantity" name="alert_qty" required="required"
                                    col="col-md-6" placeholder="Enter Alert Quantity" />


                                <div class="form-group col-md-6">
                                  <label for="tax_id">Tax</label>
                                    <select name="tax_id" id="tax_id" class="selectpicker form-control"
                                        data-live-search="true" data-live-search-placeholder="Search">
                                        <option value="">No Tax</option>
                                        @if (!$taxes->isEmpty())
                                        @foreach ($taxes as $tax)
                                        <option value="{{ $tax->id }}">{{ $tax->name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>


                                <x-forms.selectbox required="required" labelName="Tax Method" name="tax_method" class="selectpicker"
                                    col="col-md-6">
                                    @foreach (TAX_METHOD as $key => $value)
                                    <option value="{{ $key }}" {{ $key == 1 ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </x-forms.selectbox>

                               
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="row">
                                <div class="form-group col-md-12 required">
                                    <label for="image">Product Image</label>
                                    <div class="col-md-12 px-0 text-center">
                                        <div id="image">

                                        </div>
                                    </div>
                                    <input type="hidden" name="old_image" id="old_image">
                                </div>
                                <x-forms.textarea labelName="Description" name="description" col="col-md-12" />
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

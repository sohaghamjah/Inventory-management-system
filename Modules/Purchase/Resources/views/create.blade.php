@extends('layouts.app')
@section('title')
    {{ $page_title }}
@endsection
@push('stylesheet')
    <style>
        li.ui-menu-item {
            padding: 5px !important;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('assets/default/assets/css/jquery-ui.css') }}">
@endpush
@section('content')
<div class="dt-content">

    <!-- Grid -->
    <div class="row">

        <div class="col-xl-12">
            <ol class="mb-4 breadcrumb bg-white">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">{{ $sub_title }}</li>
            </ol>
        </div>

        <!-- Grid Item -->
        <div class="col-xl-12">

            <!-- Entry Header -->
            <div class="dt-entry__header">

                <!-- Entry Heading -->
                <div class="dt-entry__heading">
                    <h3 class="dt-page__title mb-0 text-primary"><i class="{{ $page_icon }}"></i> {{ $sub_title }}</h3>
                </div>
                <!-- /entry heading -->
                <a href="{{ route('purchase') }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-plus-square"></i>
                    Add New
                </a>

            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

                <!-- Card Body -->
                <div class="dt-card__body">
                    {{-- Form Filter --}}
                    <form id="purchase_form" method="POST" enctype="multipart/form-data">
                        <div class="row">

                            <x-forms.selectbox labelName="Warehouse" required="required" name="warehouse_id" class="selectpicker" col="col-md-6">
                                @if (!$warehouses->isEmpty())
                                    @foreach ($warehouses as $warehouse)
                                        <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                    @endforeach
                                @endif
                            </x-forms.selectbox>

                            <x-forms.selectbox labelName="Suppliers" required="required" name="supplier_id" class="selectpicker" col="col-md-6">
                                @if (!$suppliers->isEmpty())
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }} {{ $supplier->company_name ? ' - '. $supplier->company_name : ''}}</option>
                                    @endforeach
                                @endif
                            </x-forms.selectbox>

                            <x-forms.selectbox labelName="Purchase Status" required="required" name="purchase_statuss" class="selectpicker" col="col-md-6">      
                                @foreach (PURCHASE_STATUS as $key => $purchase_status)
                                    <option value="{{ $key }}" {{ $key == 1 ? 'selected' : '' }}>{{ $purchase_status }}</option>
                                @endforeach
                            </x-forms.selectbox>

                            <div class="col-md-6">
                                <label for="document" >Attach Document</label>
                                <input type="file" class="form-control" name="document" id="document">
                            </div>

                            <div class="form-group col-md-12">
                                <label for="product_code_name">Select Product</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="product_code_name" id="product_code_name" 
                                    placeholder="Type barcode or name and select product">
                                </div>
                            </div>

                            <div class="col-md-12 text-dark form-group">
                                <table class="table table-bordered" id="product-list">
                                    <thead class="bg-primary">
                                        <th>Name</th>
                                        <th>Code</th>
                                        <th class="text-center">Unit</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-center d-none recived_product_qty">Recived</th>
                                        <th class="text-right">Net Unit Cost</th>
                                        <th class="text-right">Discount</th>
                                        <th class="text-right">Taxt</th>
                                        <th class="text-right">Subtotal</th>
                                        <th></th>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot class="bg-primary">
                                        <th colspan="3">Total</th>
                                        <th id="total_qty" class="text-center">0.00</th>
                                        <th class="d-none recived_product_qty">0.00</th>
                                        <th></th>
                                        <th id="total_discount" class="text-right">0.00</th>
                                        <th id="total_tax" class="text-right">0.00</th>
                                        <th id="total" class="text-right">0.00</th>
                                        <th></th>
                                    </tfoot>
                                </table>
                            </div>

                            <x-forms.selectbox labelName="Order Tax" name="order_tax" class="selectpicker" col="col-md-4">
                                <option value="0">No Tax</option>
                                @if (!$taxes->isEmpty())
                                    @foreach ($taxes as $tax)
                                        <option value="{{ $tax->id }}">{{ $tax->name }}</option>
                                    @endforeach
                                @endif
                            </x-forms.selectbox>

                            <div class="col-md-4">
                                <label for="order_discount">Order Discount</label>
                                <input type="text" class="form-control" name="order_discount" id="order_discount" placeholder="Order Discount">
                            </div>

                            <div class="col-md-4">
                                <label for="shipping_cost">Shipping Cost</label>
                                <input type="text" class="form-control" name="shipping_cost" id="shipping_cost" placeholder="Shipping Cost">
                            </div>

                            <div class="col-md-12">
                                <label for="shipping_cost">Note</label>
                                <textarea class="form-control" name="note" id="note"></textarea>
                            </div>

                            <div class="col-md-12" style="margin-top: 30px">
                                <table class="table table-bordered">
                                    <thead class="bg-primary">
                                        <th><strong>Items</strong><span class="float-right" id="items">0.00</span></th>
                                        <th><strong>Total</strong><span class="float-right" id="subtotal">0.00</span></th>
                                        <th><strong>Order Tax</strong><span class="float-right" id="order_tax">0.00</span></th>
                                        <th><strong>Order Discount</strong><span class="float-right" id="order_discount">0.00</span></th>
                                        <th><strong>Shipping Cost</strong><span class="float-right" id="shipping_cost">0.00</span></th>
                                        <th><strong>Grand Total</strong><span class="float-right" id="grand_total">0.00</span></th>
                                    </thead>
                                </table>
                            </div>

                            <div class="col-md-12">
                                <input type="hidden" name="total_qty">
                                <input type="hidden" name="total_discount">
                                <input type="hidden" name="total_tax">
                                <input type="hidden" name="total_cost">
                                <input type="hidden" name="item">
                                <input type="hidden" name="order_tax">
                                <input type="hidden" name="grand_total">
                            </div>
                            
                            <div class="col-md-12 form-group text-right">
                                <button class="btn btn-danger btn-sm" type="button" id="reset_btn">Reset</button>
                                <button class="btn btn-primary btn-sm" type="button" id="save_btn">Save</button>
                            </div>
                        </div>
                    </form>

                </div>
                <!-- /card body -->

            </div>
            <!-- /card -->

        </div>
        <!-- /grid item -->
 
    </div>
    <!-- /grid -->

</div>
@endsection
@push('script')
<script src="{{ asset('assets/default/assets/js/jquery-ui.js') }}"></script>
<script>
$(document).ready(function () {
    /************************************
    * Product search
    ****************************/
    $( "#product_code_name" ).autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "{{url('product-autocomplete-search')}}",
                type: "POST",
                data: {
                    _token: _token,
                    search : request.term
                },
                dataType: "json",
                success: function(data){
                    response(data);
                }
            });
        },
        minLength: 1,
        response: function(event, ui) {
            if(ui.content.length == 1)
            {
                var data = ui.content[0].value;
                product_search(data);
            }
        },
        select: function(event,ui){
            var data = ui.item.value;
            product_search(data);
        }
    });

    // Arrey data depend on wareshouse

    var product_array = [];
    var product_code  = [];
    var product_name  = [];
    var product_qty   = [];

    // Arrey data with selection
    var product_cost         = [];
    var product_discount     = [];
    var tax_name             = [];
    var tax_rate             = [];
    var tax_method           = [];
    var unit_name            = [];
    var unit_operator        = [];
    var unit_operation_value = [];

    // Temporary array

    var temp_unit_name           = [];
    var temp_unit_operator       = [];
    var temp_unit_operator_value = [];

    var rowIndex;
    var customer_group_rate;
    var row_product_cost;

    var count = 1;


    /************************************
    * Search wise data show in table
    ****************************/

    function product_search(data){
        $.ajax({
            type: "POST",
            url: "{{ url('product-search') }}",
            data: {
                _token: _token,
                data: data,
            },
            dataType: "JSON",
            success: function (data) {
                var flag = 1;
                $('.product-code').each(function(i){
                    if($(this).val() == data.code){
                        row_index = i;
                        var qty = parseFloat($('#product-list tbody tr:nth-child('+(row_index+1)+') .qty').val()) + 1;
                        $('#product-list tbody tr:nth-child('+(row_index + 1)+') .qty').val(qty);
                        // calculateProductData(qty);
                        flag = 0;
                    }
                });
                $('#product_code_name').val('');
                if(flag){
                    temp_unit_name = data.unit_name.split(',');
                    var newRow = $('<tr>');
                    var cols = '';
                    cols += '<td>'+data.name+'</td>';
                    cols += '<td>'+data.code+'</td>';
                    cols += '<td class="unit-name"></td>';
                    cols += '<td><input type="text" class="form-control qty" name="products['+count+'][qty]" id="products_'+count+'_qty" value="1"></td>';

                    if($('#purchase_statuss option:selected').val() == 1){
                        cols += '<td class="received-product-qty d-none"><input type="text" class="form-control received text-center" name="products['+count+'][received]" velue="1"></td>'
                    }else if($('#purchase_status option:selected').val() == 2){
                        cols += '<td class="received-product-qty"><input type="text" class="form-control received text-center" name="products['+count+'][received]" value="1"></td>';
                    }else{
                        cols += '<td class="received-product-qty d-none"><input type="text" class="form-control received text-center" name="products['+count+'][received]" value="0"></td>';
                    }

                    cols += '<td class="net_unit_cost text-right"></td>';
                    cols += '<td class="discount text-right"></td>';
                    cols += '<td class="tax text-right"></td>';
                    cols += '<td class="sub-total text-right"></td>';
                    cols += '<td><button type="button" class="edit-product btn btn-sm btn-primary mr-2" data-toggle="modal"data-target="#editModal"><i class="fas fa-edit"></i></button><button type="button" class="btn btn-danger btn-sm remove-product"><i class="fas fa-trash"></i></button></td>';
                    cols += '<input type="hidden" class="product-id" name="products['+count+'][id]"  value="'+data.id+'">';
                    cols += '<input type="hidden" class="product-code" name="products['+count+'][code]" value="'+data.code+'">';
                    cols += '<input type="hidden" class="product-unit" name="products['+count+'][unit]" value="'+temp_unit_name[0]+'">';
                    cols += '<input type="hidden" class="net_unit_cost" name="products['+count+'][net_unit_cost]">';
                    cols += '<input type="hidden" class="discount-value" name="products['+count+'][discount]">';
                    cols += '<input type="hidden" class="tax-rate" name="products['+count+'][tax_rate]" value="'+data.tax_rate+'">';
                    cols += '<input type="hidden" class="tax-value" name="products['+count+'][tax]">';
                    cols += '<input type="hidden" class="subtotal-value" name="products['+count+'][subtotal]">';

                    newRow.append(cols);

                    $('#product-list tbody').append(newRow);

                    product_cost.push(parseFloat(data.cost));
                    product_discount.push('0.00')
                    tax_rate.push(parseFloat(data.tax_rate));
                    tax_name.push(parseFloat(data.tax_name));
                    tax_method.push(parseFloat(data.tax_method));
                    unit_name.push(data.unit_name);
                    unit_operator.push(data.unit_operator);
                    unit_operation_value.push(data.unit_operation_value);

                    rowIndex = newRow.index();
                }
            }
        });
    }
});
</script>
@endpush

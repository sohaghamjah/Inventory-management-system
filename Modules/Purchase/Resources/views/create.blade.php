@extends('layouts.app')
@section('title')
    {{ $page_title }}
@endsection
@push('stylesheet')
    <style>
        li.ui-menu-item {
            padding: 5px !important;
        }
        .ui-autocomplete{
            background: #faad14 !important;
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
                        @csrf
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

                            <x-forms.selectbox labelName="Purchase Status" required="required" name="purchase_status" class="selectpicker" col="col-md-6">      
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
                                        <th class="text-center d-none received-product-qty">Recived</th>
                                        <th class="text-right">Net Unit Cost</th>
                                        <th class="text-right">Discount</th>
                                        <th class="text-right">Tax</th>
                                        <th class="text-right">Subtotal</th>
                                        <th></th>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot class="bg-primary">
                                        <th colspan="3">Total</th>
                                        <th id="total_qty" class="text-center">0.00</th>
                                        <th class="d-none received-product-qty"></th>
                                        <th></th>
                                        <th id="total_discount" class="text-right">0.00</th>
                                        <th id="total_tax" class="text-right">0.00</th>
                                        <th id="total" class="text-right">0.00</th>
                                        <th></th>
                                    </tfoot>
                                </table>
                            </div>

                            <x-forms.selectbox labelName="Order Tax" name="order_tax_rate" class="selectpicker" col="col-md-4">
                                <option value="0">No Tax</option>
                                @if (!$taxes->isEmpty())
                                    @foreach ($taxes as $tax)
                                        <option value="{{ $tax->rate }}">{{ $tax->name }}</option>
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
                                        <th><strong>Order Tax</strong><span class="float-right" id="order_total_tax">0.00</span></th>
                                        <th><strong>Order Discount</strong><span class="float-right" id="order_total_discount">0.00</span></th>
                                        <th><strong>Shipping Cost</strong><span class="float-right" id="shipping_total_cost">0.00</span></th>
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
                                <button class="btn btn-danger btn-sm" type="reset" id="reset_btn">Reset</button>
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
{{-- Start Edit Modal --}}
<div class="modal fade show" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="model-1" aria-modal="true">
    <div class="modal-dialog" role="document">

      <!-- Modal Content -->
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header bg-primary text-white">
          <h3 class="modal-title text-white" id="model-title"></h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="text-white">×</span>
          </button>
        </div>
        <!-- /modal header -->

        <!-- Modal Body -->
        <form action="" id="edit_form">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <x-forms.textbox labelName="Quantity" name="edit_qty" required="required" col="col-md-12" placeholder="Enter quantity"/>
                    <x-forms.textbox labelName="Unit Discount" name="edit_discount" col="col-md-12" placeholder="Unit Discount"/>
                    <x-forms.textbox labelName="Unit Cost" name="edit_unit_cost" col="col-md-12" placeholder="Unit Cost"/>

                    @php
                        $tax_name_all[] = 'No Tax';
                        $tax_rate_all[] = 0;

                        foreach ($taxes as $tax) {
                            $tax_name_all[] = $tax -> name;
                            $tax_rate_all[] = $tax -> rate;
                        }
                    @endphp

                    <div class="form-group col-md-12">
                        <label for="edit_tax_rate">Tax Rate</label>
                        <select name="edit_tax_rate" id="edit_tax_rate" class="form-control selectpicker">
                            @foreach ($tax_name_all as $key => $tax)
                                <option value="{{ $key }}">{{ $tax }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="edit_unit">Product Unit</label>
                        <select name="edit_unit" id="edit_unit" class="form-control selectpicker"></select>
                    </div>

                </div>
            </div>
            <!-- /modal body -->

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-sm" id="update_btn">Update</button>
            </div>
        </form>
        <!-- /modal footer -->

      </div>
      <!-- /modal content -->

    </div>
  </div>

{{-- End Edit Modal --}}
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
                $(this).autocomplete('close');
                product_search(data);
            }
        },
        select: function(event,ui){
            var data = ui.item.value;
            product_search(data);
        }
    }).data('ui-autocomplete')._renderItem = function(ul, item){
        return $("<li class='ui-autocomplete-row'></li>")
        .data("item.autocomplete",item)
        .append(item.label)
        .appendTo(ul);
    };

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
    var temp_unit_operation_value = [];

    var rowIndex;
    var row_product_cost;

    var count = 1;

    /************************************
    * Edit Product
    ****************************/
    $('#product-list').on('click','.edit-product', function(){
        rowIndex = $(this).closest('tr').index();
        var row_product_name = $('#product-list tbody tr:nth-child('+(rowIndex + 1)+')').find('td:nth-child(1)').text();
        var row_product_code= $('#product-list tbody tr:nth-child('+(rowIndex + 1)+')').find('td:nth-child(2)').text();
        $('#model-title').text(row_product_name+' ('+row_product_code+')');

        var qty = $(this).closest('tr').find('.qty').val();

        $('#edit_qty').val(qty);
        $('#edit_discount').val(parseFloat(product_discount[rowIndex]).toFixed(2));

        unitConversion();

        $('#edit_unit_cost').val(row_product_cost.toFixed(2));


        var tax_name_all = <?php echo json_encode($tax_name_all); ?>;
        var pos = tax_name_all.indexOf(tax_name[rowIndex]);
        $('#edit_tax_rate').val(pos);

        temp_unit_name = (unit_name[rowIndex]).split(',');
        temp_unit_name.pop();
        temp_unit_operator = (unit_operator[rowIndex]).split(',');
        temp_unit_operator.pop()
        temp_unit_operation_value = (unit_operation_value[rowIndex]).split(',');
        temp_unit_operation_value.pop();

        $('#edit_unit').empty(); 

        $.each(temp_unit_name, function (key, value) { 
            $('#edit_unit').append('<option value="'+key+'">'+value+'</option>');
        });
        
        $('.selectpicker').selectpicker('refresh');
    });

    /************************************
    * Update Product
    ****************************/

   $('#update_btn').on('click', function(){
        var edit_discount  = $('#edit_discount').val();
        var edit_qty       = $('#edit_qty').val();
        var edit_unit_cost = $('#edit_unit_cost').val();

        if(parseFloat(edit_discount) > parseFloat(edit_unit_cost)){
            notification('error', 'Invalid Discount Value');
            return;
        }
        if(edit_qty < 1){
            $('#edit_qty').val(1);
            edit_qty = 1;
            notification('error', 'Quantity can\'t be less then 1');
        }

        var row_unit_operator = unit_operator[rowIndex].slice(0,unit_operator[rowIndex].indexOf(','));
        var row_unit_operation_value = unit_operation_value[rowIndex].slice(0,unit_operation_value[rowIndex].indexOf(','));

        row_unit_operation_value = parseFloat(row_unit_operation_value);

        var tax_rate_all = <?php echo json_encode($tax_rate_all); ?>;


        tax_rate[rowIndex] = parseFloat(tax_rate_all[$('#edit_tax_rate option:selected').val()]);
        tax_name[rowIndex] = $('#edit_tax_rate option:selected').text();

        if(row_unit_operator == '*')
        {
            product_cost[rowIndex] = $('#edit_unit_cost').val() / row_unit_operation_value;
        }else{
            product_cost[rowIndex] = $('#edit_unit_cost').val() * row_unit_operation_value;
        }

        product_discount[rowIndex] = $('#edit_discount').val();
        var position = $('#edit_unit').val();
        var temp_operator = temp_unit_operator[position];
        var temp_operation_value = temp_unit_operation_value[position];
        $('#product-list tbody tr:nth-child('+(rowIndex + 1)+')').find('.purchase-unit').val(temp_unit_name[position]);
        temp_unit_name.splice(position,1);
        temp_unit_operator.splice(position,1);
        temp_unit_operation_value.splice(position,1);

        temp_unit_name.unshift($('#edit_unit option:selected').text());
        temp_unit_operator.unshift(temp_operator);
        temp_unit_operation_value.unshift(temp_operation_value);

        unit_name[rowIndex] = temp_unit_name.toString() + ',';
        unit_operator[rowIndex] = temp_unit_operator.toString() + ',';
        unit_operation_value[rowIndex] = temp_unit_operation_value.toString() + ',';
        
        checkQuantity(edit_qty, false);
   });

   $('#product-list').on('keyup','.qty',function(){
        rowIndex = $(this).closest('tr').index();

        if($(this).val() < 1 && $(this).val() != ''){
            $('#product-list tbody tr:nth-child('+(rowIndex + 1)+') .qty').val(1);
            notification('errpr', 'Quantity can\'t be less then 1 or null');
        }
        checkQuantity($(this).val(), true);
   });

   /***************************************
   *    Product delelte
   ***********************/

   $('#product-list').on('click','.remove-product',function(){
        rowindex = $(this).closest('tr').index();
        product_cost.splice(rowindex,1);
        product_discount.splice(rowindex,1);
        tax_rate.splice(rowindex,1);
        tax_name.splice(rowindex,1);
        tax_method.splice(rowindex,1);
        unit_name.splice(rowindex,1);
        unit_operator.splice(rowindex,1);
        unit_operation_value.splice(rowindex,1);
        $(this).closest('tr').remove();
        calculateTotal();
        notification('success','Product row deleted successfull');
   });

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
                type:'purchase',
            },
            dataType: "JSON",
            success: function (data) {
                var flag = 1;
                $('.product-code').each(function(i){
                    if($(this).val() == data.code){
                        row_index = i;
                        var qty = parseFloat($('#product-list tbody tr:nth-child('+(row_index+1)+') .qty').val()) + 1;
                        $('#product-list tbody tr:nth-child('+(row_index + 1)+') .qty').val(qty);
                        calculateProductData(qty);
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
                    cols += '<td><button type="button" class="edit-product btn btn-sm btn-primary mr-2" data-toggle="modal"data-target="#edit_modal"><i class="fas fa-edit"></i></button><button type="button" class="btn btn-danger btn-sm remove-product"><i class="fas fa-trash"></i></button></td>';
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
                    tax_name.push(data.tax_name);
                    tax_method.push(data.tax_method);
                    unit_name.push(data.unit_name);
                    unit_operator.push(data.unit_operator);
                    unit_operation_value.push(data.unit_operation_value);
                    rowIndex = newRow.index();
                    calculateProductData(1);   
                    count++;
                }
            }
        });
    }
    /*********************************
    *Check quantity
    **********************/

    function checkQuantity(purchase_qty, flag){
        var row_product_code = $('#product-list tbody tr:nth-child('+(rowIndex + 1)+')').find('td:nth-child(2)').text();
        var pos = product_code.indexOf(row_product_code);
        var operator = unit_operator[rowIndex].split(',');
        var operation_value = unit_operation_value[rowIndex].split(',');

        if(operator[0] == '*')
        {
            total_qty = purchase_qty * operation_value[0];
        }else if(operator[0] == '/'){
            total_qty = purchase_qty / operation_value[0];
        }
        
        $('#edit_modal').modal('hide');
        $('#product-list tbody tr:nth-child('+(rowIndex + 1)+')').find('.qty').val(purchase_qty);

        var status = $('#purchase_status option:selected').val();
        if(status == '1' || status == '2'){
            $('#product-list tbody tr:nth-child('+(rowIndex + 1)+')').find('.received').val(purchase_qty);
        }
        calculateProductData(purchase_qty);
    }

    // calculate product

    function calculateProductData(quantity){

        unitConversion();
        
        $('#product-list tbody tr:nth-child('+(rowIndex + 1)+')').find('td:nth-child(7)').text((product_discount[rowIndex] * quantity).toFixed(2));
        $('#product-list tbody tr:nth-child('+(rowIndex + 1)+')').find('.discount-value').val((product_discount[rowIndex] * quantity).toFixed(2));
        $('#product-list tbody tr:nth-child('+(rowIndex + 1)+')').find('.tax-rate').val(tax_rate[rowIndex].toFixed(2));
        $('#product-list tbody tr:nth-child('+(rowIndex + 1)+')').find('.unit-name').text(unit_name[rowIndex].slice(0,unit_name[rowIndex].indexOf(",")));

        if(tax_method[rowIndex] == 1){
            var net_unit_cost = row_product_cost - product_discount[rowIndex];
            var tax = net_unit_cost * quantity * (tax_rate[rowIndex]/100);
            var subtotal = (net_unit_cost * quantity) + tax;
        }else{
            var sub_total_unit_with_tax = row_product_cost - product_discount[rowIndex];
            var net_unit_cost = (100 / (100+tax[rowIndex])) * sub_total_unit_with_tax;
            var tax = (sub_total_unit_with_tax - net_unit_cost) * quantity;
            var subtotal = sub_total_unit_with_tax * quantity;
        }

        $('#product-list tbody tr:nth-child('+(rowIndex + 1)+')').find('td:nth-child(6)').text(net_unit_cost.toFixed(2));
        $('#product-list tbody tr:nth-child('+(rowIndex + 1)+')').find('.net_unit_cost').val(net_unit_cost.toFixed(2));
        $('#product-list tbody tr:nth-child('+(rowIndex + 1)+')').find('td:nth-child(8)').text(tax.toFixed(2));
        $('#product-list tbody tr:nth-child('+(rowIndex + 1)+')').find('.tax-value').val(tax.toFixed(2));
        $('#product-list tbody tr:nth-child('+(rowIndex + 1)+')').find('td:nth-child(9)').text(subtotal.toFixed(2));
        $('#product-list tbody tr:nth-child('+(rowIndex + 1)+')').find('.subtotal-value').val(subtotal.toFixed(2));

        calculateTotal()
    }

    // unit calculation 

    function unitConversion(){
        var row_unit_operator = unit_operator[rowIndex].slice(0,unit_operator[rowIndex].indexOf(','));
        var row_unit_operation_value = unit_operation_value[rowIndex].slice(0,unit_operation_value[rowIndex].indexOf(','));

        row_unit_operation_value = parseFloat(row_unit_operation_value);
        if(row_unit_operator == '*'){
            row_product_cost = product_cost[rowIndex] * row_unit_operation_value;
        }else{
            row_product_cost = product_cost[rowIndex] / row_unit_operation_value;
        }
    } 

    // Calculate total

    function calculateTotal(){

        // sum of quantity
        var total_qty = 0;
        $('.qty').each(function(){
            if($(this).val() == ''){
                total_qty += 0;
            }else{
                total_qty += parseFloat($(this).val())
            }
            $('#total_qty').text(total_qty);
            $('input[name="total_qty"]').val(total_qty);
        });

        // sum of discount

        var total_discount = 0;

        $('.discount').each(function(){
            total_discount += parseFloat($(this).text());
        });
        $('#total_discount').text(total_discount.toFixed(2));
        $('input[name="total_discount"]').val(total_discount.toFixed(2));

        // sum of tax

        var total_tax = 0;
        $('.tax').each(function(){
            total_tax += parseFloat($(this).text());
        });
        $('#total_tax').text(total_tax.toFixed(2));
        $('input[name="total_tax"]').val(total_tax.toFixed(2));

        //sum of subtotal
        var total = 0;
        $('.sub-total').each(function() {
            total += parseFloat($(this).text());
        });
        $('#total').text(total.toFixed(2));
        $('input[name="total_cost"]').val(total.toFixed(2));

        calculateGrandTotal();
    }

    // calculate grand total
    function calculateGrandTotal(){
        var item = $('#product-list tbody tr:last').index();
        var total_qty = parseFloat($('#total_qty').text());
        var subtotal = parseFloat($('#total').text());
        var order_tax = parseFloat($('select[name="order_tax_rate"]').val());
        var order_discount = parseFloat($('#order_discount').val());
        var shipping_cost = parseFloat($('#shipping_cost').val());

        if(!order_discount){
            order_discount = 0.00;
        }
        if(!shipping_cost){
            shipping_cost = 0.00;
        }
        if(!order_tax){
            order_tax = 0.00;
        }

        item = ++item + '('+total_qty+')';
        order_tax = (subtotal - order_discount) * (order_tax / 100);
        var grand_total = (subtotal + order_tax + shipping_cost) - order_discount;

        $('#item').text(item);
        $('input[name="item"]').val($('#product-list tbody tr:last').index() + 1);
        $('#subtotal').text(subtotal.toFixed(2));
        $('#order_total_tax').text(order_tax.toFixed(2));
        $('input[name="order_tax"]').val(order_tax.toFixed(2));
        $('#order_total_discount').text(order_discount.toFixed(2));
        $('#shipping_total_cost').text(shipping_cost.toFixed(2));
        $('#grand_total').text(grand_total.toFixed(2));
        $('input[name="grand_total"]').val(grand_total.toFixed(2));

    }

    $('input[name="order_discount"]').on('input',function(){
        calculateGrandTotal();
    });
    $('input[name="shipping_cost"]').on('input',function(){
        calculateGrandTotal();
    });
    $('select[name="order_tax_rate"]').on('change',function(){
        calculateGrandTotal();
    });

    /***************************
    * Purchase Status
    ******************/
    $('#purchase_status').on('change', function(){
        var status = $('#purchase_status option:selected').val();
        if(status == 2){
            $('.received-product-qty').removeClass('d-none');
            $('.qty').each(function(){
                rowindex = $(this).closest('tr').index();
                $('#product-list tbody tr:nth-child('+(rowindex + 1)+')').find('.received').val($(this).val());
            });
        }else if(status == 3 || status == 4){
            $('.received-product-qty').addClass('d-none');
            $('.received').each(function(){
                $(this).val(0)
            });
        }else{
            $('.received-product-qty').addClass('d-none');
            $('.qty').each(function(){
                rowindex = $(this).closest('tr').index();
                $('#product-list tbody tr:nth-child('+(rowindex + 1)+')').find('.received').val($(this).val());
            });
        }
    });

    /***************************
    * Purchase add
    ******************/

    $(document).on('click','#save_btn', function(e){
        var row_number = $('#product-list tbody tr:last').index();
        if(row_number < 0){
            notification('error','Please add product to order table');
        }else{
            let form = document.getElementById('purchase_form');
            let formData = new FormData(form);
            $.ajax({
                url: "{{route('purchase.store')}}",
                type: "POST",
                data: formData,
                dataType: "JSON",
                contentType: false,
                processData: false,
                cache: false,
                beforeSend: function(){
                    $('#save_btn').addClass('kt-spinner kt-spinner--mid kt-spinner--light');
                },
                complete: function(){
                    $('#save_btn').removeClass('kt-spinner kt-spinner--mid kt-spinner--light');
                },
                success: function (data) {
                    $('#purchase_form').find('.is-invalid').removeClass('is-invalid');
                    $('#purchase_form').find('.error').remove();
                    if (data.status == false) {
                        $.each(data.errors, function (key, value) {
                            var key = key.split('.').join('_');
                            $('#purchase_form input#' + key).addClass('is-invalid');
                            $('#purchase_form textarea#' + key).addClass('is-invalid');
                            $('#purchase_form select#' + key).parent().addClass('is-invalid');
                            $('#purchase_form #' + key).parent().append(
                            '<small class="error text-danger">' + value + '</small>');
                                                        
                        });
                    } else {
                        notification(data.status, data.message);
                        if (data.status == 'success') {
                            window.location.replace('{{route("purchase")}}');
                        }
                    }
                },
                error: function (xhr, ajaxOption, thrownError) {
                    console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr.responseText);
                }
            });
        }
    });

});
</script>
@endpush

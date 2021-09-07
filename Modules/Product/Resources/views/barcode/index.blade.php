@extends('layouts.app')
@section('title')
    {{ $page_title }}
@endsection
@push('stylesheet')

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
                
               @if (permission('product-access'))
                     <a href="{{ route('product') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-list"></i>
                        Add New
                    </a>
               @endif
                

            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

                <!-- Card Body -->
                <div class="dt-card__body">
                    {{-- Form Filter --}}
                    <form id="form_barcode" class="mb-5">
                        <div class="row">
                            <x-forms.selectbox labelName="Product" name="product" class="selectpicker" col="col-md-4">
                                @if (!$products->isEmpty())
                                    @foreach ($products as $product)
                                        <option value="{{ $product->code }}" data-name="{{ $product->name }}" data-price="{{ $product->price }}" data-barcode="{{ $product->barcode_symbology }}">{{ $product->name.' - '.$product->code }}</option>
                                    @endforeach
                                @endif
                            </x-forms.selectbox>
                            <div class="form-group col-md-4">
                                <label for="barcode_qty">No. of barcode</label>
                                <input type="text" class="form-control" name="barcode_qty" id="barcode_qty" placeholder="Enter barcode qty...">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="row_qty">Quantity each row</label>
                                <input type="text" class="form-control" name="row_qty" id="row_qty" placeholder="Enter enter row qty...">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="row_qty">Print With</label>
                                
                                <div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="product_name">
                                        <label class="custom-control-label" for="product_name">Product name</label>
                                    </div>   
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="price">
                                        <label class="custom-control-label" for="price">Price</label>
                                    </div>   
                                </div>

                            </div>
                            <div class="col-md-4 form-group">
                                <label for="row_qty">Barcode Size</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="width" id="width" placeholder="Width">
                                    <input type="text" class="form-control" name="height" id="height" placeholder="Height">

                                    <select name="unit" id="unit" class="selectpicker form-control">
                                        <option value="mm">mm</option>
                                        <option value="px">px</option>
                                        <option value="in">in</option>
                                        <option value="cm">cm</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4" style="margin-top: 30px">
                                <button id="generate_barcode" type="button" class="btn btn-primary btn-sm float-right" data-toggle="tooptip" data-placement="top" data-original-title="Generate Barcode"><i class="fas fa-barcode"></i>
                                    Generate
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="row" id="barcode_section">
                        
                    </div>

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
<script src="{{ asset('assets/default/assets/js/jquery.printarea.js') }}"></script>
<script>
$(document).ready(function () {
    // ============== form submit btn click================
    $(document).on('click', '#generate_barcode', function(){
        var code              = $('#product option:selected').val();
        var barcode_symbology = $('#product option:selected').data('barcode');
        var name              = '';
        var price             = '';
        var barcode_qty       = $('#barcode_qty').val();
        var row_qty           = $('#row_qty').val();
        var width             = $('#width').val();
        var height            = $('#height').val();
        var unit              = $('#unit option:selected').val();
        if($('#product_name').prop('checked') == true){
            name = $('#product option:selected').data('name');
        }
        if($('#price').prop('checked') == true){
            price = $('#product option:selected').data('price');
        }
        $.ajax({
            type: "POST",
            url: '{{ url("generate-barcode") }}',
            data: {
                code             : code,
                barcode_symbology: barcode_symbology,
                name             : name,
                price            : price,
                barcode_qty      : barcode_qty,
                row_qty          : row_qty,
                width            : width,
                height           : height,
                unit             : unit,
                _token           : _token,
            },
            beforeSend: function(){
                $('#generate_barcode').addClass('kt-spinner kt-spinner--mid kt-spinner--light');
            },
            complete: function(){
                $('#generate_barcode').removeClass('kt-spinner kt-spinner--mid kt-spinner--light');
            },
            success: function (data) {
                // validation form
                $('#form_barcode').find('.is-invalid').removeClass('is-invalid');
                $('#form_barcode').find('.error').remove();
                if(data.status == false){
                    $.each(data.errors, function (key, value) {
                        if(key == 'code'){
                            $('#form_barcode select#product').parent().addClass('is-invalid');
                            $('#form_barcode #product').parent().append('<small class="error text-danger d-block">'+value+'</small>');
                        }
                        $('#form_barcode input#'+key).addClass('is-invalid');
                        $('#form_barcode select#'+key).parent().addClass('is-invalid');
                        $('#form_barcode #'+key).parent().append('<small class="error text-danger d-block">'+value+'</small>');      
                    });
                }else{
                    $('#barcode_section').html('')
                    $('#barcode_section').html(data);
                }
            },
            error: function(xhr, ajaxOption, thrownError){
                console.log(thrownError+'\r\n'+xhr.statusText+'\r\n'+xhr.responseText);
                console.log('errors');
            },
        });
    });

    // invoice print

    $(document).on('click','#print_barcode',function(){
        var mode   = 'iframe';        //popup
        var close  = mode = 'popup';
        var options = {
            mode    : mode,
            popClose: close
        }
        $('#printableArea').printArea(options);
    });

});


</script>
@endpush

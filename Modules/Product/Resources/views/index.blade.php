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
                @if (permission('product-add'))
                    <button class="btn btn-primary btn-sm" onclick="showStoreFormModal('Add New Product', 'Save')">
                        <i class="fas fa-plus-square"></i>
                        Add New
                    </button>
                @endif

            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

                <!-- Card Body -->
                <div class="dt-card__body">
                    {{-- Form Filter --}}
                    <form id="form_filter" class="mb-5">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="name">Product Name</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter Product Name...">
                            </div>
                            <div class="col-md-4">
                                <label for="code">Code</label>
                                <input type="text" class="form-control" name="code" id="code" placeholder="Enter Barcode...">
                            </div>
                            <x-forms.selectbox labelName="Brand" name="brand_id" class="selectpicker" col="col-md-4">
                                @if (!$brands->isEmpty())
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand -> name }}</option>
                                    @endforeach
                                @endif
                            </x-forms.selectbox>
                            <x-forms.selectbox labelName="Category" name="category_id" class="selectpicker" col="col-md-4">
                                @if (!$categories->isEmpty())
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                @endif
                            </x-forms.selectbox>
                            <div class="col-md-8" style="margin-top: 20px">
                                <button id="btn_filter" type="button" class="btn btn-primary btn-sm float-right" data-toggle="tooptip" data-placement="top" data-original-title="Filter Data"><i class="fas fa-search"></i></button>
                                <button id="btn_reset" type="button" class="btn btn-danger btn-sm float-right mr-2" data-toggle="tooptip" data-placement="top" data-original-title="Reset Data"><i class="fas fa-redo-alt"></i></button>
                            </div>
                        </div>
                    </form>
                    <!-- Tables -->
                    <table id="dataTable" class="table table-striped table-bordered table-hover">
                        <thead class="bg-primary">
                            <tr>
                                @if (permission('product-bulk-delete'))
                                <th>                              
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="select_all"
                                            onchange="selectAll()">
                                        <label class="custom-control-label" for="select_all"></label>
                                    </div>        
                                </th>
                                @endif
                                <th>Sl</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Brand</th>
                                <th>Category</th>
                                <th>Unit</th>
                                <th>Cost</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Alert Qty</th>
                                <th>Tax</th>
                                <th>Tax Method</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>

                        </tbody>
                    </table>
                    <!-- /tables -->

                </div>
                <!-- /card body -->

            </div>
            <!-- /card -->

        </div>
        <!-- /grid item -->
 
    </div>
    <!-- /grid -->

</div>
@include('product::modal')
@include('product::view-modal')
@endsection
@push('script')
<script src="{{ asset('assets/default/assets/js/spartan-multi-image-picker-min.js') }}"></script>
<script>
    var table; 

    $(document).ready(function ($) {
    // ================Data Table show setup=============
        table = $('#dataTable').DataTable({
            "processing": true, //Feature control the processing indicator
            "serverSide": true, //Feature control DataTable server side processing mode
            "order": [], //Initial no order
            "responsive": true, //Make table responsive in mobile device
            "bInfo": true, //TO show the total number of data
            "bFilter": false, //For datatable default search box show/hide
            "lengthMenu": [
                [5, 10, 15, 25, 50, 100, 1000, 10000, -1],
                [5, 10, 15, 25, 50, 100, 1000, 10000, "All"]
            ],
            "pageLength": 25, //number of data show per page
            "language": {
                processing: `<i class="fas fa-spinner fa-spin fa-3x fa-fw text-primary"></i>`,
                emptyTable: '<strong class="text-danger">No Data Found</strong>',
                infoEmpty: '',
                zeroRecords: '<strong class="text-danger">No Data Found</strong>'
            },
            "ajax": {
                "url": "{{ route('product.datatable.data') }}",
                "type": "POST",
                "data": function (data) {
                    data.name =$('#form_filter #name').val();
                    data.code =$('#form_filter #code').val();
                    data.brand_id =$('#form_filter #brand_id').val();
                    data.category_id =$('#form_filter #category_id').val();
                    data._token = _token;
                }
            },
            "columnDefs": [{
                @if (permission('product-bulk-delete'))
                    "targets": [0, 14],
                @else
                    "targets": [13],
                @endif
                    "orderable": false,
                    "className": "text-center"
                },
                {
                    @if (permission('product-bulk-delete'))
                        "targets": [1,2,4,5,6,7,10,11,12,13,14],
                    @else
                        "targets": [0,1,3,4,5,6,9,10,11,12,13],
                    @endif
                    "className": "text-center"
                },
                {
                    @if (permission('product-bulk-delete'))
                        "targets": [8,9],
                    @else
                        "targets": [7,8],
                    @endif
                    "className": "text-right"
                },
            ],
            "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6' <'float-right'B>>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'<'float-right'p>>>",

            "buttons": [
                @if (permission('product-report'))
                {
                    'extend': 'colvis',
                    'className': 'btn btn-secondary btn-sm text-white',
                    'text': 'Column'
                },
                {
                    "extend": 'print',
                    'text': 'Print',
                    'className': 'btn btn-secondary btn-sm text-white',
                    "title": "Product List",
                    "orientation": "landscape", //portrait
                    "pageSize": "A4", //A3,A5,A6,legal,letter
                    "exportOptions": {
                        columns: function (index, data, node) {
                            return table.column(index).visible();
                        }
                    },
                    customize: function (win) {
                        $(win.document.body).addClass('bg-white');
                    },
                },
                {
                    "extend": 'csv',
                    'text': 'CSV',
                    'className': 'btn btn-secondary btn-sm text-white',
                    "title": "Product List",
                    "filename": "product-list",
                    "exportOptions": {
                        columns: function (index, data, node) {
                            return table.column(index).visible();
                        }
                    }
                },
                {
                    "extend": 'excel',
                    'text': 'Excel',
                    'className': 'btn btn-secondary btn-sm text-white',
                    "title": "Product List",
                    "filename": "product-list",
                    "exportOptions": {
                        columns: function (index, data, node) {
                            return table.column(index).visible();
                        }
                    }
                },
                {
                    "extend": 'pdf',
                    'text': 'PDF',
                    'className': 'btn btn-secondary btn-sm text-white',
                    "title": "Product List",
                    "filename": "product-list",
                    "orientation": "landscape", //portrait
                    "pageSize": "A4", //A3,A5,A6,legal,letter
                    "exportOptions": {
                        columns: [1, 2, 3]
                    },
                },
                @endif
                @if (permission('product-bulk-delete'))
                {
                    "className": "btn btn-danger btn-sm delete_btn d-none text-white",
                    "text": "Delete",
                    action: function (e, dt, node, config) {
                        multiDelete();
                    }
                }
                @endif
            ],
        });

 
    // ============== form submit btn click================
    $(document).on('click', '#save_btn', function(){
        var form = document.getElementById('store_or_update_form');
        var formData = new FormData(form);
        var url = "{{ route('product.store.or.update') }}";
        var id = $('update_id').val();
        var method;
        if (id){
            method = 'update';
        }else{
            method = 'add';
        }
        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            dataType: "json",
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
                // validation form
                $('#store_or_update_form').find('.is-invalid').removeClass('is-invalid');
                $('#store_or_update_form').find('.error').remove();
                if(data.status == false){
                    $.each(data.errors, function (key, value) {
                        $('#store_or_update_form input#'+key).addClass('is-invalid');
                        $('#store_or_update_form textarea#'+key).addClass('is-invalid');
                        $('#store_or_update_form select#'+key).parent().addClass('is-invalid');
                        if(key == 'code'){
                            $('#store_or_update_form #'+key).parents('.form-group').append('<small class="error text-danger d-block">'+value+'</small>');
                        }else{
                            $('#store_or_update_form #'+key).parent().append('<small class="error text-danger d-block">'+value+'</small>');
                        }
                        
                    });
                }else{
                    notification(data.status, data.message);
                    if(data.status == 'success'){
                        if(method == 'update'){
                            table.ajax.reload(null,false);
                        }else{
                            table.ajax.reload();
                        }
                        $('#store_or_update_modal').modal('hide');
                    }
                }
            },
            error: function(xhr, ajaxOption, thrownError){
                console.log(thrownError+'\r\n'+xhr.statusText+'\r\n'+xhr.responseText);
                console.log('errors');
            },
        });
    });

    //=================== Edit Data ======================

    $(document).on('click', '.edit_data', function () {
        let id = $(this).data('id');
        $('#store_or_update_form')[0].reset();
        $('#store_or_update_form').find('.is-invalid').removeClass('is-invalid');
        $('#store_or_update_form').find('.error').remove();
        if(id){
            $.ajax({
                type: "POST",
                url: "{{ route('product.edit') }}",
                data: {
                    id: id,
                    _token: _token
                },
                dataType: "json",
                success: function (data) {
                    $('#store_or_update_form #update_id').val(data.id);
                    $('#store_or_update_form #name').val(data.name);
                    $('#store_or_update_form #barcode_symbology').val(data.barcode_symbology);
                    $('#store_or_update_form #code').val(data.code);
                    $('#store_or_update_form #brand_id').val(data.brand_id);
                    $('#store_or_update_form #category_id').val(data.category_id);
                    $('#store_or_update_form #unit_id').val(data.unit_id);

                    $('#store_or_update_form #cost').val(data.cost);
                    $('#store_or_update_form #price').val(data.price);
                    $('#store_or_update_form #qty').val(data.qty);
                    $('#store_or_update_form #alert_qty').val(data.alert_qty);
                    $('#store_or_update_form #tax_id').val(data.tax_id);
                    $('#store_or_update_form #tax_method').val(data.tax_method);
                    $('#store_or_update_form #description').val(data.description);
                    $('#store_or_update_form #old_image').val(data.image);
                    $('#store_or_update_form .selectpicker').selectpicker('refresh');
                    populateUnit(data.unit_id,data.purchase_unit_id,data.sale_unit_id);
                    if(data.image){
                        var image = '{{ asset("storage/".PRODUCT_IMAGE_PATH)}}/'+data.image;
                        $('#store_or_update_form #image img.spartan_image_placeholder').css('display','none');
                        $('#store_or_update_form #image .spartan_remove_row').css('display','none');
                        $('#store_or_update_form #image .img_').css('display','block');
                        $('#store_or_update_form #image .img_').attr('src', image);
                    }else{ 
                        $('#store_or_update_form #image img.spartan_image_placeholder').css('display','block');
                        $('#store_or_update_form #image .spartan_remove_row').css('display','none');
                        $('#store_or_update_form #image .img_').css('display','none');
                        $('#store_or_update_form #image .img_').attr('src','');
                    }
                    $('#store_or_update_modal .modal-title').html('<i class="fas fa-edit"></i> <span>Edit '+data.name+'</span>');
                    $('#store_or_update_modal #save_btn').text('Update');
                    $('#store_or_update_modal').modal('show');
                },
                error: function(xhr, ajaxOption, thrownError){
                    console.log(thrownError+'\r\n'+xhr.statusText+'\r\n'+xhr.responseText);
                },
            });
        }
    });


    //=================== View Data ======================

    $(document).on('click', '.view_data', function () {
    let id = $(this).data('id');
        if(id){
            $.ajax({
                type: "POST",
                url: "{{ route('product.show') }}",
                data: {
                    id: id,
                    _token: _token
                },
                success: function (data) {
                    $('.details').html();
                    $('.details').html(data);

                $('#view_modal .modal-title').html('<i class="fas fa-edit"></i> <span>Product Details</span>');
                $('#view_modal').modal('show');
                },
                error: function(xhr, ajaxOption, thrownError){
                    console.log(thrownError+'\r\n'+xhr.statusText+'\r\n'+xhr.responseText);
                },
            });
        }
    });

    //================== Delete Data ======================

    $(document).on('click', '.delete_data', function () {
        let id = $(this).data('id');
        let name = $(this).data('name');
        let row = table.row($(this).parent('tr'));
        let url = "{{ route('product.delete') }}";
        deleteData(id,url,table,row,name)
    });

    // ============== Multiple data delete ================

    function multiDelete(){
        let ids = [];
        let rows;

        $('.select_data:checked').each(function(){
            ids.push($(this).val());
            rows = table.rows($('.select_data:checked').parents('tr'));
        });
        if(ids.length == 0){
            flashMessage('error', 'Please checked at list one row');
        }else{
            let url = "{{ route('product.bulk.delete') }}";
            bulkDelete(ids,url,table,rows);
        }
    }

    //================== Change user status ======================

    $(document).on('click', '.change_status', function () {
    let id = $(this).data('id');
    let status = $(this).data('status');
    let name = $(this).data('name');
    let row = table.row($(this).parent('tr'));
    let url = "{{ route('product.change.status') }}";

    changeStatus(id,status,name,table,url);
        
    });


    // ===================Data table filter===============
    $(document).on('click', '#btn_filter', function () {
        table.ajax.reload();
    });
    $(document).on('click', '#btn_reset', function () {
        $('#form_filter')[0].reset();
        $('#form_filter .selectpicker').selectpicker('refresh');
        table.ajax.reload();
    });


    $('#image').spartanMultiImagePicker({
        fieldName: 'image',
        maxCount: 1,
        rowHeight: '200px',
        groupClassName: 'col-md-12',
        maxFileSize: '',
        dropFileLabel: 'Drop Here',
        allowedExt: 'png|jpg|jpeg',
        onExtensionErr: function(index, file){
            Swal.fire({icon:'error',title:'Oops...',text: 'Only png, jpg and jpeg file format allowed!'});
        }
    });
    $('input[name="logo"],input[name="image"]').prop('required', true);
    $('input[name="logo"],input[name="image"]').prop('required', true);
    $('.remove-files').on('click', function(){
        $(this).parents('col-md-12').remove();
    });

    /********************************
     * Generate code
     ***************/
    $('#generate_barcode').click(function(){
        $.get('generate-code', function(data){
            $('#store_or_update_form #code').val(data);
        });
    });

});

function populateUnit(unit_id,purchase_unit_id='',sale_unit_id=''){
    $.ajax({
        type: "GET",
        url: "{{ url('populate-unit') }}/"+unit_id,
        dataType: "JSON",
        success: function (data) {
            $('#purchase_unit_id').empty();
            $('#sale_unit_id').empty();
            $.each(data, function (key, value) { 
                $('#purchase_unit_id').append('<option value="'+key+'">'+value+'</option>');
                $('#sale_unit_id').append('<option value="'+key+'">'+value+'</option>');
            });
            $('.selectpicker').selectpicker('refresh');
            if(purchase_unit_id){
                $('#purchase_unit_id').val(purchase_unit_id);
            }
            if(sale_unit_id){
                $('#sale_unit_id').val(sale_unit_id);
            }
            $('.selectpicker').selectpicker('refresh');
        }
    });
}


function showStoreFormModal(modal_title,btn_text){
    $('#store_or_update_form')[0].reset();
    $('#store_or_update_form .selectpicker').selectpicker('refresh');
    $('#store_or_update_form #update_id').val('');
    $('#store_or_update_form').find('.is-invalid').removeClass('is-invalid');
    $('#store_or_update_form').find('.error').remove();

    $('#store_or_update_form #image img.spartan_image_placeholder').css('display','block');
    $('#store_or_update_form #image .spartan_remove_row').css('display','none');
    $('#store_or_update_form #image .img_').css('display','none');
    $('#store_or_update_form #image .img_').attr('src','');

    $('#store_or_update_modal').modal('show');

    $('#store_or_update_modal .modal-title').html('<i class="fas fa-plus-square"></i> '+modal_title);
    $('#store_or_update_modal #save_btn').text(btn_text);
}
</script>
@endpush

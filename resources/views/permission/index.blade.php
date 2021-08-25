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
                @if (permission('permission-add'))
                    <button class="btn btn-primary btn-sm" onclick="showFormModal('Add New Permission', 'Save')">
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
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name...">
                            </div>
                            <div class="col-md-4">
                                <label for="module_id">Module</label>
                                <select name="module_id" id="module_id" class="form-control selectpicker" data-live-search="true"
                                data-live-search-placeholder="Search" title="Choose one of the following">
                                    <option value="">Select Please</option>
                                    @if (!empty($data['modules']))
                                        @foreach ($data['modules'] as $key => $item)
                                            <option value="{{ $key }}">{{ $item }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-4" style="margin-top: 20px">
                                <button id="btn_filter" type="button" class="btn btn-primary btn-sm float-right" data-toggle="tooptip" data-placement="top" data-original-title="Filter Data"><i class="fas fa-search"></i></button>
                                <button id="btn_reset" type="button" class="btn btn-danger btn-sm float-right mr-2" data-toggle="tooptip" data-placement="top" data-original-title="Reset Data"><i class="fas fa-redo-alt"></i></button>
                            </div>
                        </div>
                    </form>
                    <!-- Tables -->
                    <table id="dataTable" class="table table-striped table-bordered table-hover">
                        <thead class="bg-primary">
                            <tr>
                                @if (permission('permission-bulk-delete'))
                                <th>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="select_all"
                                            onchange="selectAll()">
                                        <label class="custom-control-label" for="select_all"></label>
                                    </div>
                                </th>
                                @endif
                                <th>Sl</th>
                                <th>Module</th>
                                <th>Permission name</th>
                                <th>Permission Slug</th>
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
@include('permission.modal')
@include('permission.edit-modal')
@endsection
@push('script')
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
                "url": "{{ route('menu.module.permission.datatable.data') }}",
                "type": "POST",
                "data": function (data) {
                    data.name      = $('#form_filter #name').val();
                    data.module_id = $('#form_filter #module_id').val();
                    data._token    = _token;
                }
            },
            "columnDefs": [{
                @if (permission('permission-bulk-delete'))
                    "targets": [0, 5],
                @else
                    "targets": [4],
                @endif
                    "orderable": false,
                    "className": "text-center"
                },
                {
                    @if (permission('permission-bulk-delete'))
                        "targets": [1],
                    @else
                        "targets": [0],
                    @endif
                    "className": "text-center"
                },
            ],
            "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6' <'float-right'B>>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'<'float-right'p>>>",

            "buttons": [
                @if (permission('permission-report'))
                {
                    'extend': 'colvis',
                    'className': 'btn btn-secondary btn-sm text-white',
                    'text': 'Column'
                },
                {
                    "extend": 'print',
                    'text': 'Print',
                    'className': 'btn btn-secondary btn-sm text-white',
                    "title": "Permission List",
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
                    "title": "Permission List",
                    "filename": "permission-list",
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
                    "title": "Permission List",
                    "filename": "permission-list",
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
                    "title": "Permission List",
                    "filename": "permission-list",
                    "orientation": "landscape", //portrait
                    "pageSize": "A4", //A3,A5,A6,legal,letter
                    "exportOptions": {
                        columns: [1, 2, 3]
                    },
                },
                @endif
                @if (permission('permission-bulk-delete'))
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
        var url = "{{ route('menu.module.permission.store') }}";
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
                        var key = key.split('.').join('_');
                        $('#store_or_update_form select#'+key).parent().addClass('is-invalid');
                        $('#store_or_update_form #'+key).parent().append('<small class="error text-danger d-block">'+value+'</small>');
                        $('#store_or_update_form table').find('#'+key).addClass('is-invalid');
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
        $('#update_form #module_id.selectpicker').selectpicker('refresh');
        if(id){
            $.ajax({
                type: "POST",
                url: "{{ route('menu.module.permission.edit') }}",
                data: {
                    id: id,
                    _token: _token
                },
                dataType: "json",
                success: function (data) {
                    $('#update_form #update_id').val(data.data.id);
                    $('#update_form #name').val(data.data.name);
                    $('#update_form #slug').val(data.data.slug);
                    $('#update_form #module_id.selectpicker').selectpicker('refresh');
                    $('#update_modal .modal-title').html('<i class="fas fa-edit"></i> <span>Edit '+data.data.name+'</span>');
                    $('#update_modal #update_btn').text('Update');
                    $('#update_modal').modal('show');
                },
                error: function(xhr, ajaxOption, thrownError){
                    console.log(thrownError+'\r\n'+xhr.statusText+'\r\n'+xhr.responseText);
                },
            });
        }
    });

    // ============== form update btn click================
    $(document).on('click', '#update_btn', function(){
        var form = document.getElementById('update_form');
        var formData = new FormData(form);
        var url = "{{ route('menu.module.permission.update') }}";
        var id = $('update_id').val();
        var method = 'update';

        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            cache: false,
            beforeSend: function(){
                $('#update_btn').addClass('kt-spinner kt-spinner--mid kt-spinner--light');
            },
            complete: function(){
                $('#update_btn').removeClass('kt-spinner kt-spinner--mid kt-spinner--light');
            },
            success: function (data) {
                // validation form
                $('#update_form').find('.is-invalid').removeClass('is-invalid');
                $('#update_form').find('.error').remove();
                if(data.status == false){
                    $.each(data.errors, function (key, value) {
                        var key = key.split('.').join('_');
                        $('#update_form select#'+key).parent().addClass('is-invalid');
                        $('#update_form #'+key).parent().append('<small class="error text-danger d-block">'+value+'</small>');
                    });
                }else{
                    notification(data.status, data.message);
                    if(data.status == 'success'){
                        if(method == 'update'){
                            table.ajax.reload(null,false);
                        }
                        $('#update_modal').modal('hide');
                    }
                }
            },
            error: function(xhr, ajaxOption, thrownError){
                console.log(thrownError+'\r\n'+xhr.statusText+'\r\n'+xhr.responseText);
                console.log('errors');
            },
        });
    });

    //================== Delete Data ======================

    $(document).on('click', '.delete_data', function () {
        let id = $(this).data('id');
        let name = $(this).data('name');
        let row = table.row($(this).parent('tr'));
        let url = "{{ route('menu.module.permission.delete') }}";
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
            let url = "{{ route('menu.module.permission.bulk.delete') }}";
            bulkDelete(ids,url,table,rows);
        }
    }

    //=============== Dynamic permission field ================

    var count = 1;

    function dynamicPermissionField(row){
        var html = `<tr>
                        <td>
                            <input type="text" name="permission[`+row+`][name]" id="permission_`+row+`_name" class="form-control" onkeyup="urlGenerator(this.value,'permission_`+row+`_slug')" placeholder="Enter Permission Name...">
                        </td>
                        <td>
                            <input type="text" name="permission[`+row+`][slug]" id="permission_`+row+`_slug" class="form-control" placeholder="Enter Permission Slug...">
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm remove_permission" data-toggle="tooptip" data-placement="top" data-original-title="Remove Permission Field"><i class="fas fa-minus-square"></i></button>
                        </td>
                    </tr>`;
        $('#permission_table tbody').append(html);
    }

    $(document).on('click', '#add_permission', function () {
        count++;
        dynamicPermissionField(count);
    });
    $(document).on('click', '.remove_permission', function () {
        count--;
        $(this).closest('tr').remove();
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


    });

    //============== Url Generator =====================

    function urlGenerator(input_value, output_id){
        var value = input_value.toLowerCase().trim();
        var str = value.replace(/ +(?= )/g,'');
        var name = str.split(' ').join('-');
        $('#'+output_id).val(name);
    }
</script>
@endpush

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
                @if (permission('employee-add'))
                    <button class="btn btn-primary btn-sm" onclick="showStoreFormModal('Add New Employee', 'Save')">
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
                            <div class="col-md-3">
                                <label for="name">Employe Name</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter Employe Name...">
                            </div>
                            <div class="col-md-3">
                                <label for="name">Phone No</label>
                                <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter Phone Number...">
                            </div>
                            <div class="col-md-3">
                                <label for="name">Department Id</label>
                                <select name="department_id" id="department_id" class="form-control selectpicker" data-live-search="true" 
                                data-live-search-placeholder="Search">
                                    <option value="">Select Please</option>
                                    @if (!$departments -> isEmpty())
                                        @foreach ($departments as $department)
                                             <option value="{{ $department -> id }}">{{ $department -> name }}</option>
                                        @endforeach              
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-3" style="margin-top: 20px">
                                <button id="btn_filter" type="button" class="btn btn-primary btn-sm float-right" data-toggle="tooptip" data-placement="top" data-original-title="Filter Data"><i class="fas fa-search"></i></button>
                                <button id="btn_reset" type="button" class="btn btn-danger btn-sm float-right mr-2" data-toggle="tooptip" data-placement="top" data-original-title="Reset Data"><i class="fas fa-redo-alt"></i></button>
                            </div>
                        </div>
                    </form>
                    <!-- Tables -->
                    <table id="dataTable" class="table table-striped table-bordered table-hover">
                        <thead class="bg-primary">
                            <tr>
                                @if (permission('employee-bulk-delete'))
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
                                <th>Phone</th>
                                <th>Department</th>
                                <th>Address</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Postal Code</th>
                                <th>Country</th>
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
@include('hrm::employee.modal')
@include('hrm::employee.view-modal')
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
                "url": "{{ route('employee.datatable.data') }}",
                "type": "POST",
                "data": function (data) {
                    data.department_id =$('#form_filter #department_id').val();
                    data.name =$('#form_filter #name').val();
                    data.phone =$('#form_filter #phone').val();
                    data._token = _token;
                }
            },
            "columnDefs": [{
                @if (permission('employee-bulk-delete'))
                    "targets": [0, 11],
                @else
                    "targets": [10],
                @endif
                    "orderable": false,
                    "className": "text-center"
                },
                {
                    @if (permission('employee-bulk-delete'))
                        "targets": [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                    @else
                        "targets": [0, 1, 3, 4, 5, 6, 7, 8, 9],
                    @endif
                    "className": "text-center"
                },
            ],
            "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6' <'float-right'B>>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'<'float-right'p>>>",

            "buttons": [
                @if (permission('employee-report'))
                {
                    'extend': 'colvis',
                    'className': 'btn btn-secondary btn-sm text-white',
                    'text': 'Column'
                },
                {
                    "extend": 'print',
                    'text': 'Print',
                    'className': 'btn btn-secondary btn-sm text-white',
                    "title": "Employee List",
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
                    "title": "Employee List",
                    "filename": "employee-list",
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
                    "title": "Employee List",
                    "filename": "employee-list",
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
                    "title": "Employee List",
                    "filename": "employee-list",
                    "orientation": "landscape", //portrait
                    "pageSize": "A4", //A3,A5,A6,legal,letter
                    "exportOptions": {
                        columns: [1, 2, 3]
                    },
                },
                @endif
                @if (permission('employee-bulk-delete'))
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
        var url = "{{ route('employee.store.or.update') }}";
        var id = $('update_id').val();
        var method;
        if (id){
            method = 'update';
        }else{
            method = 'add';
        }
        storeOrUpdateFormData(table,url,method,formData);
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
                url: "{{ route('employee.edit') }}",
                data: {
                    id: id,
                    _token: _token
                },
                dataType: "json",
                success: function (data) {
                    $('#store_or_update_form #update_id').val(data.id);
                    $('#store_or_update_form #department_id').val(data.department_id);
                    $('#store_or_update_form #name').val(data.name);
                    $('#store_or_update_form #phone').val(data.phone);
                    $('#store_or_update_form #city').val(data.city);
                    $('#store_or_update_form #state').val(data.state);
                    $('#store_or_update_form #postal_code').val(data.postal_code);
                    $('#store_or_update_form #country').val(data.country);


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
                url: "{{ route('employee.show') }}",
                data: {
                    id: id,
                    _token: _token
                },
                success: function (data) {
                    $('.details').html();
                    $('.details').html(data);

                $('#view_modal .modal-title').html('<i class="fas fa-edit"></i> <span>Employee Details</span>');
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
        let url = "{{ route('employee.delete') }}";
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
            let url = "{{ route('employee.bulk.delete') }}";
            bulkDelete(ids,url,table,rows);
        }
    }

    //================== Change user status ======================

    $(document).on('click', '.change_status', function () {
        let id = $(this).data('id');
        let status = $(this).data('status');
        let name = $(this).data('name');
        let row = table.row($(this).parent('tr'));
        let url = "{{ route('employee.change.status') }}";

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

});

function showStoreFormModal(modal_title,btn_text){
    $('#store_or_update_form')[0].reset();
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

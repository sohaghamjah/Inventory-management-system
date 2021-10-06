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
                @if (permission('expense-category-add'))
                    <button class="btn btn-primary btn-sm" onclick="showFormModal('Add New Expense', 'Save')">
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
                            <x-forms.selectbox labelName="Expense Category" name="expense_category_id"  required="required" col="col-md-3" class="selectpicker">
                                @if (!$categories->isEmpty())
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                @endif
                            </x-forms.selectbox>
                            <x-forms.selectbox labelName="Warehouse" name="warehouse_id"  required="required" col="col-md-3" class="selectpicker">
                                @if (!$warehouses->isEmpty())
                                    @foreach ($warehouses as $warehouse)
                                        <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                    @endforeach
                                @endif
                            </x-forms.selectbox>
                            <x-forms.selectbox labelName="Account" name="account_id"  required="required" col="col-md-3" class="selectpicker">
                                @if (!$accounts->isEmpty())
                                    @foreach ($accounts as $account)
                                        <option value="{{ $account->id }}">{{ $account->name.' - '.$account->account_no }}</option>
                                    @endforeach
                                @endif
                            </x-forms.selectbox>
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
                                @if (permission('expense-category-bulk-delete'))
                                <th>                              
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="select_all"
                                            onchange="selectAll()">
                                        <label class="custom-control-label" for="select_all"></label>
                                    </div>        
                                </th>
                                @endif
                                <th>Sl</th>
                                <th>Category</th>
                                <th>Warehouse</th>
                                <th>Account</th>
                                <th>Amount</th>
                                <th>Note</th>
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
@include('expense::.modal')
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
            "lengthCategory": [
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
                "url": "{{ route('expense.datatable.data') }}",
                "type": "POST",
                "data": function (data) {
                    data.expense_category_id =$('#form_filter #expense_category_id').val();
                    data.warehouse_id =$('#form_filter #warehouse_id').val();
                    data.account_id =$('#form_filter #account_id').val();
                    data._token = _token;
                }
            },
            "columnDefs": [{
                @if (permission('expense-category-bulk-delete'))
                    "targets": [0, 8],
                @else
                    "targets": [7],
                @endif
                    "orderable": false,
                    "className": "text-center"
                },
                {
                    @if (permission('expense-category-bulk-delete'))
                        "targets": [1, 2,3,4,6,7],
                    @else
                        "targets": [0,1,2,3,5,6],
                    @endif
                    "className": "text-center"
                },
                {
                    @if (permission('expense-category-bulk-delete'))
                        "targets": [5],
                    @else
                        "targets": [4],
                    @endif
                    "className": "text-right"
                },
            ],
            "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6' <'float-right'B>>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'<'float-right'p>>>",

            "buttons": [
                @if (permission('expense-category-report'))
                {
                    'extend': 'colvis',
                    'className': 'btn btn-secondary btn-sm text-white',
                    'text': 'Column'
                },
                {
                    "extend": 'print',
                    'text': 'Print',
                    'className': 'btn btn-secondary btn-sm text-white',
                    "title": "Expense Category List",
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
                    "title": "Expense Category List",
                    "filename": "expense-category-list",
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
                    "title": "Expense Category List",
                    "filename": "expense-category-list",
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
                    "title": "Expense Category List",
                    "filename": "expense-category-list",
                    "orientation": "landscape", //portrait
                    "pageSize": "A4", //A3,A5,A6,legal,letter
                    "exportOptions": {
                        columns: [1, 2, 3]
                    },
                },
                @endif
                @if (permission('expense-category-bulk-delete'))
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
        var url = "{{ route('expense.store.or.update') }}";
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
                url: "{{ route('expense.edit') }}",
                data: {
                    id: id,
                    _token: _token
                },
                dataType: "json",
                success: function (data) {
                    $('#store_or_update_form #update_id').val(data.id);
                    $('#store_or_update_form #expense_category_id').val(data.expense_category_id);
                    $('#store_or_update_form #warehouse_id').val(data.warehouse_id);
                    $('#store_or_update_form #account_id').val(data.account_id);
                    $('#store_or_update_form #amount').val(data.amount);
                    $('#store_or_update_form #note  ').val(data.note);
                    $('#store_or_update_form #selectpicker  ').selectpicker('refresh');


                    $('#store_or_update_modal .modal-title').html('<i class="fas fa-edit"></i> <span>Edit Expense</span>');
                    $('#store_or_update_modal #save_btn').text('Update');
                    $('#store_or_update_modal').modal('show');
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
        let url = "{{ route('expense.delete') }}";
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
            let url = "{{ route('expense.bulk.delete') }}";
            bulkDelete(ids,url,table,rows);
        }
    }

    //================== Change user status ======================

    $(document).on('click', '.change_status', function () {
    let id = $(this).data('id');
    let status = $(this).data('status');
    let name = $(this).data('name');
    let row = table.row($(this).parent('tr'));
    let url = "{{ route('expense.change.status') }}";

    Swal.fire({
        title: 'Are you sure to Change '+name+' status?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Change status!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        id: id,
                        status: status,
                        _token: _token,
                    },
                    dataType: "json",
                }).done(function(response){
                    if(response.status == 'success'){
                        swal.fire('Changed',response.message,"success").then(function(){
                            table.ajax.reload(null,false);
                        });
                    }
                    if(response.status == 'error'){
                        swal.fire('Ooops...',response.message, response.status);
                    }
                }).fail(function(){
                    swal.fire('Ooops...',"Something went wrong!", "error");
                });
            }
        });
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
</script>
@endpush

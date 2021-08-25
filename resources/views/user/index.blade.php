@extends('layouts.app')
@section('title')
    {{ $page_title }}
@endsection

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
                @if (permission('user-add'))
                    <button class="btn btn-primary btn-sm" onclick="showUserFormModal('Add New User', 'Save')">
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
                            <x-forms.textbox labelName="Name" name="name" col="col-md-4" placeholder="Enter name..."/>
                            <x-forms.textbox labelName="Email" name="email" col="col-md-4" placeholder="Enter email..."/>
                            <x-forms.textbox labelName="Mobile No" name="mobile" col="col-md-4" placeholder="Enter mobile no..."/>
                            <x-forms.selectbox labelName="Role" name="role_id" col="col-md-4" class="selectpicker">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                @endforeach
                            </x-forms.selectbox>
                            <x-forms.selectbox labelName="Status" name="status" col="col-md-4" class="selectpicker">
                                    <option value="1">Active</option>
                                    <option value="2">In Active</option>
                            </x-forms.selectbox>

                            <div class="col-md-4" style="margin-top: 25px">
                                <button id="btn_filter" type="button" class="btn btn-primary btn-sm float-right" data-toggle="tooptip" data-placement="top" data-original-title="Filter Data"><i class="fas fa-search"></i></button>
                                <button id="btn_reset" type="button" class="btn btn-danger btn-sm float-right mr-2" data-toggle="tooptip" data-placement="top" data-original-title="Reset Data"><i class="fas fa-redo-alt"></i></button>
                            </div>
                        </div>
                    </form>
                    <!-- Tables -->
                    <table id="dataTable" class="table table-striped table-bordered table-hover">
                        <thead class="bg-primary">
                            <tr>
                                @if (permission('user-bulk-delete'))
                                    <th>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="select_all"
                                                onchange="selectAll()">
                                            <label class="custom-control-label" for="select_all"></label>
                                        </div>
                                    </th>
                                @endif

                                <th>Sl</th>
                                <th>Avatar</th>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Email</th>
                                <th>Mobile No</th>
                                <th>Gender</th>
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
@include('user.modal')
@include('user.view-modal')
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
                    "url": "{{ route('user.datatable.data') }}",
                    "type": "POST",
                    "data": function (data) {
                        data.name =$('#form_filter #name').val();
                        data.email =$('#form_filter #email').val();
                        data.role_id =$('#form_filter #role_id').val();
                        data.mobile_no =$('#form_filter #mobile_no').val();
                        data.status =$('#form_filter #status').val();
                        data._token = _token;
                    }
                },
                "columnDefs": [{
                    @if (permission('user-bulk-delete'))
                        "targets": [0, 9],
                    @else
                        "targets": [8],
                    @endif
                        "orderable": false,
                        "className": "text-center"
                    },
                    {
                    @if (permission('user-bulk-delete'))
                        "targets": [1,2,4,6,7,8],
                    @else
                        "targets": [0,1,3,5,6,7],
                    @endif
                        "className": "text-center"
                    },
                ],
                "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6' <'float-right'B>>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'<'float-right'p>>>",

                "buttons": [
                    @if (permission('user-report'))
                    {
                        'extend': 'colvis',
                        'className': 'btn btn-secondary btn-sm text-white',
                        'text': 'Column'
                    },
                    {
                        "extend": 'print',
                        'text': 'Print',
                        'className': 'btn btn-secondary btn-sm text-white',
                        "title": "User List",
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
                        "title": "User List",
                        "filename": "user-list",
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
                        "title": "User List",
                        "filename": "user-list",
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
                        "title": "User List",
                        "filename": "user-list",
                        "orientation": "landscape", //portrait
                        "pageSize": "A4", //A3,A5,A6,legal,letter
                        "exportOptions": {
                            columns: function (index, data, node) {
                                return table.column(index).visible();
                            }
                        },
                    },
                    @endif
                    @if (permission('user-bulk-delete'))
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
            var url = "{{ route('user.store.or.update') }}";
            var id = $('update_id').val();
            var method;
            if (id){
                method = 'update';
            }else{
                method = 'add';
            }
            // ajax call
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
                            if(key == 'password' || key == 'password_confirmation'){
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
            $('#store_or_update_form .selectpicker').val('');
            $('#store_or_update_form .selectpicker').selectpicker('refresh');
            if(id){
                $.ajax({
                    type: "POST",
                    url: "{{ route('user.edit') }}",
                    data: {
                        id: id,
                        _token: _token
                    },
                    dataType: "json",
                    success: function (data) {
                        $('#store_or_update_form #update_id').val(data.data.id);
                        $('#store_or_update_form #name').val(data.data.name);
                        $('#store_or_update_form #mobile').val(data.data.mobile);
                        $('#store_or_update_form #email').val(data.data.email);
                        $('#store_or_update_form #gender').val(data.data.gender);
                        $('#store_or_update_form #role_id').val(data.data.role_id);
                        $('#store_or_update_form .selectpicker').selectpicker('refresh');
                        $('#password, #password_confirmation').parents('.form-group').removeClass('required');


                        $('#store_or_update_modal .modal-title').html('<i class="fas fa-edit"></i> <span>Edit '+data.data.name+'</span>');
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
                    url: "{{ route('user.show') }}",
                    data: {
                        id: id,
                        _token: _token
                    },
                    success: function (data) {
                        $('.user-details').html();
                        $('.user-details').html(data);

                    $('#view_modal .modal-title').html('<i class="fas fa-edit"></i> <span>User Details</span>');
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
            let url = "{{ route('user.delete') }}";
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
                let url = "{{ route('user.bulk.delete') }}";
                bulkDelete(ids,url,table,rows);
            }
        }


        // ===================Data table filter===============
        $(document).on('click', '#btn_filter', function () {
            table.ajax.reload();
        });
        $(document).on('click', '#btn_reset', function () {
            $('#form_filter')[0].reset();
            $('#form_filter .selectpicker').selectpicker('refresh');
            table.ajax.reload();
        });

        //================== Change user status ======================

        $(document).on('click', '.change_status', function () {
            let id = $(this).data('id');
            let status = $(this).data('status');
            let name = $(this).data('name');
            let row = table.row($(this).parent('tr'));
            let url = "{{ route('user.change.status') }}";

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

        // Password toggle

        $('.toggle-password').click(function(){
            $(this).toggleClass('fa-eye fa-eye-slash');
            var input = $($(this).attr('toggle'));
            if(input.attr('type') == 'password')
            {
                input.attr('type', 'text');
            }else{
                input.attr('type', 'password');
            }
        });

    });

    // =================== User Modal Show ==================

    function showUserFormModal(modal_title,btn_text){
        $('#store_or_update_form')[0].reset();
        $('#store_or_update_form #update_id').val('');
        $('#store_or_update_form').find('.is-invalid').removeClass('is-invalid');
        $('#store_or_update_form').find('.error').remove();
        $('.dropify-clear').trigger('click');
        $('#store_or_update_form .selectpicker').selectpicker('refresh');
        $('#password, #password_confirmation').parents('.form-group').addClass('required');
        $('#store_or_update_modal').modal('show');

        $('#store_or_update_modal .modal-title').html('<i class="fas fa-plus-square"></i> '+modal_title);
        $('#store_or_update_modal #save_btn').text(btn_text);
    }

    // ================= Password Generetor =================
    const randomFunc = {
        upper : getRandomUpperCase,
        lower : getRandomLowerCase,
        number : getRandomNumber,
        symbol : getRandomSymbol,
    };
    function getRandomUpperCase()
    {
        return String.fromCharCode(Math.floor(Math.random()*26)+65);
    }
    function getRandomLowerCase()
    {
        return String.fromCharCode(Math.floor(Math.random()*26)+97);
    }
    function getRandomNumber()
    {
        return String.fromCharCode(Math.floor(Math.random()*10)+48);
    }
    function getRandomSymbol()
    {
        var symbol = "!@#$%^&*=~?";
        return symbol[Math.floor(Math.random()*symbol.length)];
    }

    //generate event
    document.getElementById('generate_password').addEventListener('click', () => {
        const length = 8; //password length
        const hasUpper = true;
        const hasLower = true;
        const hasSymbol = true;
        const hasNumber = true;
        let password  = generatePassword(hasUpper,hasLower,hasNumber,hasSymbol,length);
        document.getElementById('password').value = password;
        document.getElementById('password_confirmation').value = password;
    });

    function generatePassword(upper,lower,number,symbol,length)
    {
        let generatedPassword = '';
        const typeCount = upper + lower + number + symbol;
        const typeArr = [{upper},{lower},{number},{symbol}].filter(item => Object.values(item)[0]);
        if(typeCount === 0)
        {
            return '';
        }
        for (let i = 0; i < length; i+=typeCount) {
            typeArr.forEach(type => {
                const funcName = Object.keys(type)[0];
                generatedPassword += randomFunc[funcName]();
            });
        }
        const finalPassword = generatedPassword.slice(0,length);
        return finalPassword;
    }
</script>
@endpush

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

                <a href="{{ route('role') }}" class="btn btn-danger btn-sm">
                    <i class="fas fa-arrow-circle-left"></i>
                    Back
                </a>

            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

                <!-- Card Body -->
                <div class="dt-card__body">
                    <form id="update_data_form" method="">
                        <input type="hidden" name="update_id" value="{{ $permission_data['role']->id }}" id="update_id">
                        @csrf
                        <div class="row">
                            <x-forms.textbox labelName="Role Name" name="role_name" required="required" col="col-md-12" value="{{ $permission_data['role']->role_name }}" placeholder="Enter role name..."/>
                            <div class="col-md-12">
                                <ul id="permission" class="text-left">
                                    @if (!$data -> isEmpty())
                                        @foreach ($data as $menu)
                                            @if ($menu -> submenu -> isEmpty())
                                                <li>
                                                    <input type="checkbox" name="module[]" class="module" value="{{ $menu->id }}" @if (collect($permission_data['module_role'])->contains($menu->id)) {{ 'checked' }} @endif>
                                                    {!! $menu->type == 1 ? $menu->divider_name." <small>(Divider)</small>" : $menu->module_name !!}
                                                    @if (!$menu->permission -> isEmpty())
                                                        <ul>
                                                            @foreach ($menu->permission as $permission)
                                                                <li>
                                                                    <input type="checkbox" name="permission[]" class="permission" value="{{ $permission->id }}"  @if (collect($permission_data['permission_role'])->contains($permission->id)) {{ 'checked' }} @endif> {{ $permission -> name }}
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </li>
                                            @else
                                               <li>
                                                    <input type="checkbox" name="module[]" class="module" value="{{ $menu->id }}" @if (collect($permission_data['module_role'])->contains($menu->id)) {{ 'checked' }} @endif>
                                                    {!! $menu->type == 1 ? $menu->divider_name." <small>(Divider)</small>" : $menu->module_name !!}
                                                    <ul>
                                                        @foreach ($menu -> submenu as $submenu)
                                                            <li>
                                                                <input type="checkbox" name="module[]" class="module" value="{{ $submenu->id }}" @if (collect($permission_data['module_role'])->contains($submenu->id)) {{ 'checked' }} @endif> {{ $submenu -> module_name }}
                                                                @if (!$submenu->permission -> isEmpty())
                                                                    <ul>
                                                                        @foreach ($submenu->permission as $permission)
                                                                            <li>
                                                                                <input type="checkbox" name="permission[]" class="permission" value="{{ $permission->id }}" @if (collect($permission_data['permission_role'])->contains($permission->id)) {{ 'checked' }} @endif> {{ $permission -> name }}
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                               </li>
                                            @endif
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            <div class="col-md-12 pt-4">
                                <a href="{{ route('role') }}" class="btn btn-danger btn-sm">
                                     Cancle
                                </a>
                                <button type="button" id="update_btn" class="btn btn-primary btn-sm">
                                    Update
                                </button>
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
<script src="{{ asset('assets/default/assets/js/tree.js') }}"></script>
<script>
    $(document).ready(function ($) {
        $('input[type=checkbox]').click(function(){
            $(this).next().find('input[type=checkbox]').prop('checked', this.checked);
            $(this).parents('ul').prev('input[type=checkbox]').prop('checked', function(){
                return $(this).next().find(':checked').length;
            })
        });

        $('#permission').treed(); //Initialized tree js


        // ============== form submit btn click================
        $(document).on('click', '#update_btn', function(){
            var form = document.getElementById('update_data_form');
            var formData = new FormData(form);
            if($('.module:checked').length >= 1){
                $.ajax({
                    type: "POST",
                    url: "{{ route('role.store.or.update') }}",
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
                        $('#update_data_form').find('.is-invalid').removeClass('is-invalid');
                        $('#update_data_form').find('.error').remove();

                        if(data.status == false){
                            $.each(data.errors, function (key, value) {
                                $('#update_data_form input#'+key).addClass('is-invalid');
                                $('#update_data_form #'+key).parent().append('<small class="error text-danger d-block">'+value+'</small>');
                            });
                        }else{
                            notification(data.status, data.message);
                            if(data.status == 'success'){
                                window.location.replace("{{ route('role') }}")
                            }
                        }
                    },
                    error: function(xhr, ajaxOption, thrownError){
                        console.log(thrownError+'\r\n'+xhr.statusText+'\r\n'+xhr.responseText);
                        console.log('errors');
                    },
                });
            }else{
                notification('error', 'Please check at last one menu');
            }

        });


    });
</script>
@endpush

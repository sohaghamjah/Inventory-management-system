@extends('layouts.app')
@section('title')
    {{ $page_title }}
@endsection
@push('stylesheet')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}">
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

            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

                <!-- Card Body -->
                <div class="dt-card__body">
                    {{-- Form Filter --}}
                    <form id="store_or_update_form" method="POST">
                        @csrf
                        <div class="row">
                             <input type="hidden" name="update_id" value="{{ $data ? $data->id : '' }}">
                            <div class="col-md-4">
                                <label for="check_in">Check In Time</label>
                                <input type="text" class="form-control time" name="check_in" id="check_in" placeholder="Check In Time" value="{{ $data ? $data -> check_in : '' }}">
                            </div>
                            <div class="col-md-4">
                                <label for="check_out">Check Out Time</label>
                                <input type="text" class="form-control time" name="check_out" id="check_out" placeholder="Check Out Time" value="{{ $data ? $data -> check_out : '' }}">
                            </div>
                    
                            <div class="col-md-4 form-group text-right" style="margin-top: 20px">
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

@endsection
@push('script')
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
<script>
$(document).ready(function () {
    $('.time').datetimepicker({format:'hh:mm A',ignoreReadonly:true});

    $(document).on('click','#save_btn', function(e){
        let form = document.getElementById('store_or_update_form');
        let formData = new FormData(form);
        $.ajax({
            url: "{{url('hrm-setting/store')}}",
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
                $('#store_or_update_form').find('.is-invalid').removeClass('is-invalid');
                $('#store_or_update_form').find('.error').remove();
                if(data.status == false) {
                    $.each(data.errors, function (key, value) {
                        var key = key.split('.').join('_');
                        $('#store_or_update_form input#' + key).addClass('is-invalid');
                        $('#store_or_update_form #' + key).parent().append(
                        '<small class="error text-danger">' + value + '</small>');
                         
                    });
                }else{
                    notification(data.status, data.message);
                    if (data.status == 'success') {
                        window.location.replace('{{url("hrm-setting")}}');
                    }
                }
            },
            error: function (xhr, ajaxOption, thrownError) {
                console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr.responseText);
            }
        });
    });

});
</script>
@endpush

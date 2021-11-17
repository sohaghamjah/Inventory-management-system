@extends('layouts.app')
@section('title')
    {{ $page_title }}
@endsection
@push('stylesheet')
<link rel="stylesheet" href="{{ asset('css/daterangepicker.min.css') }}">
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
                                <label for="name">Chose Your Date</label>
                                <div class="input-group">
                                    <input type="text" class="form-control daterangepicker-filed" value="{{ date('Y-m-').'-01' }} To {{ date('Y-m-d') }}">
                                    <input type="hidden" name="start_date" value="{{ date('Y-m-').'-01' }}">
                                    <input type="hidden" name="end_date" value="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                            
                            <div class="form-group col-md-1" style="padding-top: 20px;">
                                <button type="button" class="btn btn-primary spin_btn" id="btn-filter"
                                data-toggle="tooltip" data-placement="top" data-original-title="Filter Data">
                                    Search
                                 </button>
                             </div>
                        </div>
                    </form>

                    <div class="col-md-12">
                        <div class="animation">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: rgb(255, 255, 255); display: block; shape-rendering: auto;" width="200px" height="200px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                                <rect x="19" y="19" width="20" height="20" fill="#1d3f72">
                                  <animate attributeName="fill" values="#5699d2;#1d3f72;#1d3f72" keyTimes="0;0.125;1" dur="1s" repeatCount="indefinite" begin="0s" calcMode="discrete"></animate>
                                </rect><rect x="40" y="19" width="20" height="20" fill="#1d3f72">
                                  <animate attributeName="fill" values="#5699d2;#1d3f72;#1d3f72" keyTimes="0;0.125;1" dur="1s" repeatCount="indefinite" begin="0.125s" calcMode="discrete"></animate>
                                </rect><rect x="61" y="19" width="20" height="20" fill="#1d3f72">
                                  <animate attributeName="fill" values="#5699d2;#1d3f72;#1d3f72" keyTimes="0;0.125;1" dur="1s" repeatCount="indefinite" begin="0.25s" calcMode="discrete"></animate>
                                </rect><rect x="19" y="40" width="20" height="20" fill="#1d3f72">
                                  <animate attributeName="fill" values="#5699d2;#1d3f72;#1d3f72" keyTimes="0;0.125;1" dur="1s" repeatCount="indefinite" begin="0.875s" calcMode="discrete"></animate>
                                </rect><rect x="61" y="40" width="20" height="20" fill="#1d3f72">
                                  <animate attributeName="fill" values="#5699d2;#1d3f72;#1d3f72" keyTimes="0;0.125;1" dur="1s" repeatCount="indefinite" begin="0.375s" calcMode="discrete"></animate>
                                </rect><rect x="19" y="61" width="20" height="20" fill="#1d3f72">
                                  <animate attributeName="fill" values="#5699d2;#1d3f72;#1d3f72" keyTimes="0;0.125;1" dur="1s" repeatCount="indefinite" begin="0.75s" calcMode="discrete"></animate>
                                </rect><rect x="40" y="61" width="20" height="20" fill="#1d3f72">
                                  <animate attributeName="fill" values="#5699d2;#1d3f72;#1d3f72" keyTimes="0;0.125;1" dur="1s" repeatCount="indefinite" begin="0.625s" calcMode="discrete"></animate>
                                </rect><rect x="61" y="61" width="20" height="20" fill="#1d3f72">
                                  <animate attributeName="fill" values="#5699d2;#1d3f72;#1d3f72" keyTimes="0;0.125;1" dur="1s" repeatCount="indefinite" begin="0.5s" calcMode="discrete"></animate>
                                </rect>
                                <!-- [ldio] generated by https://loading.io/ --></svg>
                        </div>
                        <div class="row d-none" id="report">

                        </div>
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
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/knockout-3.4.2.js') }}"></script>
<script src="{{ asset('js/daterangepicker.min.js') }}"></script>
<script>
$(document).ready(function ($) {

    $('.daterangepicker-filed').daterangepicker({
        callback: function(startDate, endDate, period){
            var start_date = startDate.format('YYYY-MM-DD');
            var end_date   = endDate.format('YYYY-MM-DD');
            var title = start_date + ' To ' + end_date;
            $(this).val(title);
            $('input[name="start_date"]').val(start_date);
            $('input[name="end_date"]').val(end_date);
        }
    });

    report();

    $('#btn-filter').click(function () {
        report();
    });
    
    //=================== View Data ======================

    function report(){
        var start_date = $('input[name="start_date"]').val();
        var end_date = $('input[name="end_date"]').val();

        $.ajax({
            url: "{{route('summary.details')}}",
            type: "POST",
            data: { 
                start_date: start_date,
                end_date  : end_date,
                _token    : _token
            },
            beforeSend: function(){
                 $('.animation').addClass('d-none');
            },
            complete: function(){
                $('#report').removeClass('d-none');
            },
            success: function (data) {
                $('#report').html();
                $('#report').html(data);                                                                
            },
            error: function (xhr, ajaxOption, thrownError) {
                console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr.responseText);
            }
        });
        
    }

});
</script>
@endpush

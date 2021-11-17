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
                        <div class="row justify-content-center">

                            <x-forms.selectbox labelName="Warehouse" name="warehouse_id" required="required" col="col-md-3" class="selectpicker">
                                <option value="0" selected>All Warehouses</option>
                                @if (!$warehouses->isEmpty())
                                    @foreach ($warehouses as $warehouse)
                                        <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                    @endforeach
                                @endif
                            </x-forms.selectbox>
                        
                        </div>
                    </form>

                    <div class="col-md-12" id="report">

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

<script>
$(document).ready(function ($) {

    dailyReport(warehouse_id=0,year='{{ date("Y") }}',date='{{ date("m") }}');

    $(document).on('click','.previous',function(){
        var year = $('#prev_year').val();
        var month = $('#prev_month').val();
        var warehouse_id = $('#warehouse_id option:selected').val();
        dailyReport(warehouse_id,year,month);
    });
    $(document).on('click','.next',function(){
        var year = $('#next_year').val();
        var month = $('#next_month').val();
        var warehouse_id = $('#warehouse_id option:selected').val();
        dailyReport(warehouse_id,year,month);
    });

    $('#warehouse_id').change(function(){
        var warehouse_id = $('#warehouse_id option:selected').val();
        dailyReport(warehouse_id,year='{{ date("Y") }}',date='{{ date("m") }}');
    });


    function dailyReport(warehouse_id,year,month){
        $.ajax({
            type: "POST",
            url: "{{ route('daily.sale.report') }}",
            data: {
                warehouse_id: warehouse_id,
                year        : year,
                month       : month,
                _token      : _token
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

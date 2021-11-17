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
                            <div class="col-md-3">
                                <label for="name">Chose Your Date</label>
                                <div class="input-group">
                                    <input type="text" class="form-control daterangepicker-filed" value="">
                                    <input type="hidden" name="start_date" value="">
                                    <input type="hidden" name="end_date" value="">
                                </div>
                            </div>

                            <x-forms.selectbox labelName="Warehouse" name="warehouse_id" required="required" col="col-md-3" class="selectpicker">
                                <option value="0" selected>All Warehouses</option>
                                @if (!$warehouses->isEmpty())
                                    @foreach ($warehouses as $warehouse)
                                        <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                    @endforeach
                                @endif
                            </x-forms.selectbox>
                            
                            <div class="form-group col-md-1" style="padding-top: 20px;">
                                <button type="submit" class="btn btn-primary spin_btn" id="btn-filter"
                                data-toggle="tooltip" data-placement="top" data-original-title="Filter Data">
                                    Search
                                 </button>
                             </div>
                        </div>
                    </form>

                    <div class="col-md-12">
                        <table id="dataTable" class="table table-striped table-bordered table-hover">
                            <thead class="bg-primary">
                                <tr>
                                    <th>Sl</th>
                                    <th>Product Name</th>
                                    <th>Purchase Amount</th>
                                    <th>Purchased Qty</th>
                                    <th>Sold Amount</th>
                                    <th>Sold Qty</th>
                                    <th>Profit</th>
                                    <th>In Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($product_id))
                                    @foreach ($product_id as $key => $pro_id)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $product_name[$key] }}</td>
                                            @php
                                               if ($warehouse_id == 0) {
                                                    $purchased_cost = DB::table('purchase_products')
                                                                    ->where('product_id', $pro_id)
                                                                    ->whereDate('created_at','>=',$start_date)
                                                                    ->whereDate('created_at','<=',$end_date)
                                                                    ->sum('total');
                                                    $product_purchased_data = DB::table('purchase_products')
                                                                            ->where('product_id',$pro_id)
                                                                            ->whereDate('created_at','>=',$start_date)
                                                                            ->whereDate('created_at','<=',$end_date)
                                                                            ->get();
                                                    $sold_price = DB::table('sale_products')
                                                                    ->where('product_id',$pro_id)
                                                                    ->whereDate('created_at','>=',$start_date)
                                                                    ->whereDate('created_at','<=',$end_date)
                                                                    ->sum('total');
                                                    $product_sale_data = DB::table('sale_products')
                                                                        ->where('product_id',$pro_id)
                                                                        ->whereDate('created_at','>=',$start_date)
                                                                        ->whereDate('created_at','<=',$end_date)
                                                                        ->get();
                                                }else{
                                                    $purchased_cost = DB::table('purchases as p')
                                                                    ->join('purchase_products as pp','p.id','=','pp.purchase_id')
                                                                    ->where([
                                                                        ['pp.product_id',$pro_id],
                                                                        ['p.warehouse_id',$warehouse_id],
                                                                    ])
                                                                    ->whereDate('p.created_at','>=',$start_date)
                                                                    ->whereDate('p.created_at','<=',$end_date)
                                                                    ->sum('total');

                                                    $product_purchased_data = DB::table('purchases as p')
                                                                            ->join('purchase_products as pp','p.id','=','pp.purchase_id')
                                                                            ->where([
                                                                                ['pp.product_id',$pro_id],
                                                                                ['p.warehouse_id',$warehouse_id],
                                                                            ])
                                                                            ->whereDate('p.created_at','>=',$start_date)
                                                                            ->whereDate('p.created_at','<=',$end_date)
                                                                            ->get();
                                                    $sold_price = DB::table('sales as s')
                                                                ->join('sale_products as sp','s.id','=','sp.sale_id')
                                                                ->where([
                                                                    ['sp.product_id',$pro_id],
                                                                    ['s.warehouse_id',$warehouse_id],
                                                                ])
                                                                ->whereDate('s.created_at','>=',$start_date)
                                                                ->whereDate('s.created_at','<=',$end_date)
                                                                ->sum('total');
                                                    $product_sale_data = DB::table('sales as s')
                                                                        ->join('sale_products as sp','s.id','=','sp.sale_id')
                                                                        ->where([
                                                                            ['sp.product_id',$pro_id],
                                                                            ['s.warehouse_id',$warehouse_id],
                                                                        ])
                                                                        ->whereDate('s.created_at','>=',$start_date)
                                                                        ->whereDate('s.created_at','<=',$end_date)
                                                                        ->get();
                                                }
                                                $purchased_qty = 0;
                                                foreach ($product_purchased_data as $product_purchase) {
                                                    $unit = DB::table('units')->find($product_purchase->unit_id);
                                                    if($unit->operator == '*')
                                                    {
                                                        $purchased_qty +=  $product_purchase->qty * $unit->operation_value;
                                                    }elseif($unit->operator == '/'){
                                                        $purchased_qty +=  $product_purchase->qty / $unit->operation_value;
                                                    }
                                                }

                                                $sold_qty = 0;
                                                foreach ($product_sale_data as $product_sale) {
                                                    $unit = DB::table('units')->find($product_sale->sale_unit_id);
                                                    if ($unit) {            
                                                            if($unit->operator == '*')
                                                            {
                                                                $sold_qty +=  $product_sale->qty * $unit->operation_value;
                                                            }elseif($unit->operator == '/'){
                                                                $sold_qty +=  $product_sale->qty / $unit->operation_value;
                                                            }
                                                    }else {
                                                        $sold_qty += $product_sale->qty;
                                                    }
                                                }

                                                if ($purchased_qty > 0) {
                                                    $profit = $sold_price - (($purchased_cost / $purchased_qty) * $sold_qty);
                                                } else {
                                                    $profit = $sold_price;
                                                }
                                            @endphp
                                            <td>{{ number_format($purchased_cost,2) }}</td>
                                            <td>{{ $purchased_qty }}</td>
                                            <td>{{ number_format($sold_price,2) }}</td>
                                            <td>{{ $sold_qty }}</td>
                                            <td>{{ number_format($profit,2) }}</td>
                                            <td>{{ $product_qty[$key] }}</td> 
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr class="bg-primary">
                                    <th colspan="2" class="text-right">Total</th>
                                    <th class="text-right"></th>
                                    <th class="text-right"></th>
                                    <th class="text-right"></th>
                                    <th class="text-right"></th>
                                    <th class="text-right"></th>
                                    <th class="text-right"></th>
                                </tr>
                            </tfoot>
                        </table>
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

    table = $('#dataTable').DataTable({
            "processing": false, //Feature control the processing indicator
            "serverSide": false, //Feature control DataTable server side processing mode
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
            "columnDefs": [{
                "targets": [0],
                "orderable": false,
                "className": "text-center"
                },
            ],
            "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6' <'float-right'B>>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'<'float-right'p>>>",

            "buttons": [
                {
                    'extend': 'colvis',
                    'className': 'btn btn-secondary btn-sm text-white',
                    'text': 'Column'
                },
                {
                    "extend": 'print',
                    'text': 'Print',
                    'className': 'btn btn-secondary btn-sm text-white',
                    "title": "Sale List",
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
                    "title": "Sale List",
                    "filename": "sale-list",
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
                    "title": "Sale List",
                    "filename": "sale-list",
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
                    "title": "Sale List",
                    "filename": "sale-list",
                    "orientation": "landscape", //portrait
                    "pageSize": "A4", //A3,A5,A6,legal,letter
                    "exportOptions": {
                        columns: [1, 2, 3]
                    },
                },
            ],
            "footerCallback" : function(row,data,start,end,display)
            {
                var api = this.api(), data;
                var intVal = function(i){
                    return typeof i === 'string' ? i.replace(/[\$,]/g,'')*1 : typeof i === 'number' ?  i : 0;
                };
                for(var index=2;index <= 7;index++)
                {
                    total = api.column(index).data().reduce(function (a,b){
                        return intVal(a) + intVal(b);
                    },0);
                    pageTotal = api.column(index, {page: 'current'}).data().reduce(function (a,b){
                        return intVal(a) + intVal(b);
                    },0);
                    $(api.column(index).footer()).html('= '+parseFloat(pageTotal).toFixed(2)+' ('+parseFloat(total).toFixed(2)+' Total)');
                }
            }
    });

});
</script>
@endpush

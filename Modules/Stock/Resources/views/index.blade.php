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
            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

                <!-- Card Body -->
                <div class="dt-card__body">
                    {{-- Form Filter --}}
                    <form id="form_filter" class="mb-5">
                        <div class="row justify-content-center">
                            <div class="col-md-4">
                                <label for="name">Product Name</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter Product Name...">
                            </div>
                            <x-forms.selectbox labelName="Warehouse" name="warehouse_id" class="selectpicker" col="col-md-4">
                                <option value="0" selected>All Warehouse</option>
                                @if (!$warehouses->isEmpty())
                                    @foreach ($warehouses as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                @endif
                            </x-forms.selectbox>
                            <div class="col-md-2" style="margin-top: 20px">
                                <button id="btn_filter" type="button" class="btn btn-primary btn-sm float-right" data-toggle="tooptip" data-placement="top" data-original-title="Filter Data"><i class="fas fa-search"></i></button>
                                <button id="btn_reset" type="button" class="btn btn-danger btn-sm float-right mr-2" data-toggle="tooptip" data-placement="top" data-original-title="Reset Data"><i class="fas fa-redo-alt"></i></button>
                            </div>
                        </div>
                    </form>
                    <!-- Tables -->
                    <table id="dataTable" class="table table-striped table-bordered table-hover">
                        <thead class="bg-primary">
                            <tr>
                                <th>Sl</th>
                                <th>Warehouse</th>
                                <th>Product Name</th>
                                <th>Product Code</th>
                                <th>Cateogyr</th>
                                <th>Unit</th>
                                <th>Stock Quantity</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>

                        <tfoot class="bg-primary">
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th style="text-align:right; color:white; font-weight: bold">Total</th>
                                <th style="text-align:center; color:white; font-weight: bold"></th>
                            </tr>
                        </tfoot>
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
                "url": "{{ route('stock.datatable.data') }}",
                "type": "POST",
                "data": function (data) {
                    data.name =$('#form_filter #warehouse_id option:selected').val();
                    data.code =$('#form_filter #name').val();
                    data._token = _token;
                }
            },
            "columnDefs": [
                {
                    "targets": [0,1,3,4,5,6],
                    "className": "text-center"
                },
            ],
            "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6' <'float-right'B>>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'<'float-right'p>>>",

            "buttons": [
                @if (permission('stock-report'))
                {
                    'extend': 'colvis',
                    'className': 'btn btn-secondary btn-sm text-white',
                    'text': 'Column'
                },
                {
                    "extend": 'print',
                    'text': 'Print',
                    'className': 'btn btn-secondary btn-sm text-white',
                    "title": "Stock List",
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
                    "title": "Stock List",
                    "filename": "stock-report-list",
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
                    "title": "Stock List",
                    "filename": "stock-report-list",
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
                    "title": "Stock List",
                    "filename": "stock-report-list",
                    "orientation": "landscape", //portrait
                    "pageSize": "A4", //A3,A5,A6,legal,letter
                    "exportOptions": {
                        columns: function (index, data, node) {
                            return table.column(index).visible();
                        }
                    },
                },
                @endif
            ],
            "footerCallback" : function(row,data,start,end,display)
            {
                var api = this.api(), data;
                var intVal = function(i){
                    return typeof i === 'string' ? i.replace(/[\$,]/g,'')*1 : typeof i === 'number' ?  i : 0;
                };
                for(var index=6;index <= 6;index++)
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

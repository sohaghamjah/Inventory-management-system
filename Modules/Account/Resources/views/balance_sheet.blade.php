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
                    <table id="dataTable" class="table table-striped table-bordered table-hover">
                        <thead class="bg-primary">
                            <tr>
                                <th>Sl</th>
                                <th>Account Name</th>
                                <th>Account No</th>
                                <th>Credit</th>
                                <th>Debid</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!$accounts->isEmpty())
                                @php
                                    $i=1;
                                @endphp
                                @foreach ($accounts as $key => $account)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $account->name }}</td>
                                        <td>{{ $account->account_no }}</td>
                                        <td>{{ number_format((float)$credit[$key],2,'.',',') }}</td>
                                        <td>{{ number_format((float)($debit[$key] * -1),2,'.',',') }}</td>
                                        <td>{{ number_format((float)($credit[$key] - $debit[$key]),2,'.',',') }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            <tr class="bg-primary">
                                <th></th>
                                <th></th>
                                <th class="text-right">Total</th>
                                <th class="text-right"></th>
                                <th class="text-right"></th>
                                <th class="text-right"></th>
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
            "order": [], //Initial no order
            "responsive": true, //Make table responsive in mobile device
            "bInfo": true, //TO show the total number of data
            "bFilter": true, //For datatable default search box show/hide
            "lengthMenu": [
                [5, 10, 15, 25, 50, 100, 1000, 10000, -1],
                [5, 10, 15, 25, 50, 100, 1000, 10000, "All"]
            ],
            "pageLength": 25, //number of data show per page
            "language": { 
                processing: `<i class="fas fa-spinner fa-spin fa-3x fa-fw text-primary"></i> `,
                emptyTable: '<strong class="text-danger">No Data Found</strong>',
                infoEmpty: '',
                zeroRecords: '<strong class="text-danger">No Data Found</strong>'
            },
            "columnDefs": [{
                    "targets": [0,1,2,3,4,5],
                    "orderable": false,
                },
                {
                    "targets": [0],
                    "className": "text-center"
                },
                {
                    "targets": [3,4,5],
                    "className": "text-right"
                }
            ],
            "dom": "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-9' <'float-right'fB>>>" +
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
                    "title": "Account List",
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
                    footer: true,
                },
                {
                    "extend": 'csv',
                    'text': 'CSV',
                    'className': 'btn btn-secondary btn-sm text-white',
                    "title": "Account Balance Sheet",
                    "filename": "account-balance-sheet",
                    "exportOptions": {
                        columns: function (index, data, node) {
                            return table.column(index).visible();
                        }
                    },
                    footer: true,
                },
                {
                    "extend": 'excel',
                    'text': 'Excel',
                    'className': 'btn btn-secondary btn-sm text-white',
                    "title": "Account Balance Sheet",
                    "filename": "account-balance-sheet",
                    "exportOptions": {
                        columns: function (index, data, node) {
                            return table.column(index).visible();
                        }
                    },
                    footer: true,
                },
                {
                    "extend": 'pdf',
                    'text': 'PDF',
                    'className': 'btn btn-secondary btn-sm text-white',
                    "title": "Account Balance Sheet",
                    "filename": "account-balance-sheet",
                    "orientation": "landscape", //portrait
                    "pageSize": "A4", //A3,A5,A6,legal,letter
                    "exportOptions": {
                        columns: [0,1,2,3,4,5]
                    },
                    footer: true,
                },
            ],

            "footerCallback" : function(row,data,start,end,display)
            {
                var api = this.api(), data;
                var intVal = function(i){
                    return typeof i === 'string' ? i.replace(/[\$,]/g,'')*1 : typeof i === 'number' ?  i : 0;
                };
                for(var index=3;index <= 5;index++)
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

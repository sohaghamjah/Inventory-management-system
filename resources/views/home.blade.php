@extends('layouts.app')

@push('stylesheet')
    <link rel="stylesheet" href="{{ asset('css/chart.min.css') }}">
@endpush

@section('content')
<div class="dt-content">

    <!-- Grid -->
    <div class="row">

      <!-- Grid Item -->
      <div class="col-md-12">
        <div class="filter-toggle btn-group float-right">
          <div class="btn btn-primary data-btn" data-start_date="{{ date('Y-m-d') }}" data-end_date="{{ date('Y-m-d') }}">Today</div>
          <div class="btn btn-primary data-btn" data-start_date="{{ date('Y-m-d',strtotime('-7 day')) }}" data-end_date="{{ date('Y-m-d') }}">This Week</div>
          <div class="btn btn-primary data-btn active" data-start_date="{{ date('Y-m').'-01' }}" data-end_date="{{ date('Y-m-d') }}">This Month</div>
          <div class="btn btn-primary data-btn" data-start_date="{{ date('Y').'-01-01' }}" data-end_date="{{ date('Y').'-12-31' }}">This Year</div>
        </div>
      </div>
      <!-- /grid item -->

    </div>
    <!-- /grid -->

    <!-- Grid -->
    <div class="row" style="margin-top: 30px">

      <!-- Grid Item -->
      <div class="col-xl-2 col-sm-4">
        <div class="dt-card dt-chart dt-card__full-height bg-primary align-items-center pt-5">
          <img src="images/sale.svg" alt="Sale" width="30px;">
          <h4 class="text-white mt-3 mb-0" id="sale">{{ number_format($sale, 2) }}</h4>
          <h2 class="text-white mt-1">Sale</h2>
        </div>
      </div>

      <div class="col-xl-2 col-sm-4">
        <div class="dt-card dt-chart dt-card__full-height bg-warning align-items-center pt-5">
          <img src="images/purchase.svg" alt="Purchase" width="30px;">
          <h4 class="text-white mt-3 mb-0" id="purchase">{{ number_format($purchase, 2) }}</h4>
          <h2 class="text-white mt-1">Purchase</h2>
        </div>
      </div>

      <div class="col-xl-2 col-sm-4">
        <div class="dt-card dt-chart dt-card__full-height bg-success align-items-center pt-5">
          <img src="images/profit.svg" alt="Profit" width="30px;">
          <h4 class="text-white mt-3 mb-0" id="profit">{{ number_format($profit, 2) }}</h4>
          <h2 class="text-white mt-1">Profit</h2>
        </div>
      </div>

      <div class="col-xl-2 col-sm-4">
        <div class="dt-card dt-chart dt-card__full-height bg-danger align-items-center pt-5">
          <img src="images/expense.svg" alt="Expense" width="30px;">
          <h4 class="text-white mt-3 mb-0" id="expense">{{ number_format($expense,2) }}</h4>
          <h2 class="text-white mt-1">Expense</h2>
        </div>
      </div>

      <div class="col-xl-2 col-sm-4">
        <div class="dt-card dt-chart dt-card__full-height bg-dark align-items-center pt-5">
          <img src="images/customer.svg" alt="Customer" width="30px;">
          <h4 class="text-white mt-3 mb-0" id="customer">{{ number_format($customer, 2) }}</h4>
          <h2 class="text-white mt-1">Customer</h2>
        </div>
      </div>

      <div class="col-xl-2 col-sm-4">
        <div class="dt-card dt-chart dt-card__full-height bg-info align-items-center pt-5">
          <img src="images/supplier.svg" alt="Supplier" width="30px;">
          <h4 class="text-white mt-3 mb-0" id="supplier">{{ number_format($supplier,2) }}</h4>
          <h2 class="text-white mt-1">Supplier</h2>
        </div>
      </div>

      <!-- /grid item -->

    </div>
    <!-- /grid -->
    <div class="row pt-5">
      <!-- Start :: Cash Flow Graph -->
      <div class="col-md-7">
        <div class="card line-chart">
          <div class="card-header d-flex align-items-center">
            <h4>Cash Flow</h4>
          </div>
          <div class="card-body">
            <canvas id="cashFlow" data-color="#038fde" data-color_rgba="rgba(3, 143, 222, 1)" data-received="{{ json_encode($payment_received) }}"
            data-sent="{{ json_encode($payment_sent) }}" data-month="{{ json_encode($month) }}" data-label1="Payment Received" data-label2="Payment Sent"></canvas>
          </div>
        </div>
      </div>
      <!-- End :: Cash Flow Graph -->

      <!-- Start :: Transaction Chart-->
      <div class="col-md-5">
        <div class="card doughnut-chart">
          <div class="card-header d-flex align-items-center">
            <h4>{{ date('F') }} {{ date('Y') }}</h4>
          </div>
          <div class="card-body">
            <canvas id="transactionChart" data-color="#038fde" data-color_rgba="rgba(3, 143, 222, 1)" data-sale="{{ $sale }}"
            data-purchase="{{ $purchase }}" data-expense="{{ $expense }}" data-label1="Purchase" data-label2="Sale" data-label3="Expense"></canvas>
          </div>
        </div>
      </div>
      <!-- End :: Transaction Chart-->
    </div>

    <!-- Start :: Bar Chart-->
    <div class="row">
      <div class="col-md-12">
        <div class="card bar-chart">
          <div class="card-header d-flex align-items-center">
            <h4>Yearly Report </h4>
          </div>
          <div class="card-body">
            <canvas id="yearlyReportChart"  data-sale_chart_value="{{ json_encode( $yearly_sale_amount) }}"
            data-purchase_chart_value="{{ json_encode($yearly_purchase_amount) }}"  data-label1="Purchase Amount" data-label2="Sale Amount"></canvas>
          </div>
        </div>
      </div>
    </div>
    <!-- End :: Bar Chart-->

  </div>
@endsection
@push('script')
  <script src="{{ asset('js/chart.min.js') }}"></script>

  <script>
    $(document).ready(function () {

      $('.data-btn').on('click', function(){
        $('.data-btn').removeClass('active');
        $(this).addClass('active');
        var start_date = $(this).data('start_date');
        var end_date = $(this).data('end_date');

       $.get("{{ url('dashboard-data') }}/"+start_date+'/'+end_date, function(data){
          $('#sale').text(data.sale);
          $('#purchase').text(data.purchase);
          $('#profit').text(data.profit);
          $('#expense').text(data.expense);
          $('#customer').text(data.customer);
          $('#supplier').text(data.supplier);
       });

      });

      // Cash flow chart
      var brandPrimary;
      var brandPrimaryRgba;

      var CASHFLOW = $('#cashFlow');

      if(CASHFLOW.length > 0){
        brandPrimary = CASHFLOW.data('color');
        brandPrimaryRgba = CASHFLOW.data('color_rgba');
        var received = CASHFLOW.data('received');
        var sent = CASHFLOW.data('sent');
        var month = CASHFLOW.data('month');
        var label1 = CASHFLOW.data('label1');
        var label2 = CASHFLOW.data('label2');

        var cashFlow_chart = new Chart(CASHFLOW, {
          type:'line',
          data:{
            labels:[month[0],month[1],month[2],month[3],month[4],month[5],month[6]],
            datasets:[
              {
                label:label1,
                fill:true,
                lineTension:0.3,
                backgroundColor: 'transparent',
                borderColor: brandPrimary,
                borderCapStyle: 'butt',
                borderDash:[],
                borderDashOffset:0.0,
                borderJoinStyle:'miter',
                borderWidth:3,
                pointBorderColor: brandPrimary,
                pointBackgroundColor:'#fff',
                pointBorderWidth:5,
                pointHoverRadius:5,
                pointHoverBackgroundColor:brandPrimary,
                pointHoverBorderColor:brandPrimaryRgba,
                pointHoverBorderWidth:2,
                pointRadius:1,
                pointHitRadius:10,
                data:[received[0],received[1],received[2],received[3],received[4],received[5],received[6]],
                spanGaps:false
              },
              {
                label:label2,
                fill:true,
                lineTension:0.3,
                backgroundColor: 'transparent',
                borderColor: '#f5222d',
                borderCapStyle: 'butt',
                borderDash:[],
                borderDashOffset:0.0,
                borderJoinStyle:'miter',
                borderWidth:3,
                pointBorderColor: 'rgba(245, 34, 45, 1)',
                pointBackgroundColor:'#fff',
                pointBorderWidth:5,
                pointHoverRadius:5,
                pointHoverBackgroundColor:'#f5222d',
                pointHoverBorderColor:'rgba(245, 34, 45, 1)',
                pointHoverBorderWidth:2,
                pointRadius:1,
                pointHitRadius:10,
                data:[sent[0],sent[1],sent[2],sent[3],sent[4],sent[5],sent[6]],
                spanGaps:false
              }
            ]
          }
        })
      }

      // Transaction chart

      var TRANSACTIONCHART = $('#transactionChart');
      if(TRANSACTIONCHART.length > 0)
      {
        brandPrimary = TRANSACTIONCHART.data('color');
        brandPrimaryRgba = TRANSACTIONCHART.data('color_rgba');
        var sale = TRANSACTIONCHART.data('sale');
        var purchase = TRANSACTIONCHART.data('purchase');
        var expense = TRANSACTIONCHART.data('expense');
        var label1 = TRANSACTIONCHART.data('label1');
        var label2 = TRANSACTIONCHART.data('label2');
        var label3 = TRANSACTIONCHART.data('label3');

        var transaction_chart = new Chart(TRANSACTIONCHART, {
          type:'doughnut',
          data:{
            labels: [label1,label2,label3],
            datasets: [
              {
                data:[purchase,sale,expense],
                borderWidth:[1,1,1],
                backgroundColor:[ brandPrimary,'#52c41a','#f5222d'],
                hoverBackgroundColor:[
                  brandPrimaryRgba,
                  'rgba(82, 196, 26, 1)',
                  'rgba(245, 34, 45, 1)'
                ],
                hoverBorderWidth:[4,4,4],
                hoverBorderColor:[
                  brandPrimaryRgba,
                  'rgba(82, 196, 26, 1)',
                  'rgba(245, 34, 45, 1)'
                ]
              }
            ]
          }
        }) 
      }

      // Bar chart for yearly report

      var YEARLYREPORTCHART = $('#yearlyReportChart');
      if(YEARLYREPORTCHART.length > 0)
      {
        var yearly_sale_amount = YEARLYREPORTCHART.data('sale_chart_value');
        var yearly_purchase_amount = YEARLYREPORTCHART.data('purchase_chart_value');
        var label1 = YEARLYREPORTCHART.data('label1');
        var label2 = YEARLYREPORTCHART.data('label2');

        var yearly_report_chart = new Chart(YEARLYREPORTCHART, {
          type: 'bar',
          data:{
            labels:["January","February","March","April","May","June","July","August","September","October","November","December"],
            datasets:[
              {
                label: label1,
                backgroundColor:[
                  brandPrimaryRgba,
                  brandPrimaryRgba,
                  brandPrimaryRgba,
                  brandPrimaryRgba,
                  brandPrimaryRgba,
                  brandPrimaryRgba,
                  brandPrimaryRgba,
                  brandPrimaryRgba,
                  brandPrimaryRgba,
                  brandPrimaryRgba,
                  brandPrimaryRgba,
                  brandPrimaryRgba,
                  brandPrimaryRgba,
                ],
                borderColor:[
                  brandPrimary,
                  brandPrimary,
                  brandPrimary,
                  brandPrimary,
                  brandPrimary,
                  brandPrimary,
                  brandPrimary,
                  brandPrimary,
                  brandPrimary,
                  brandPrimary,
                  brandPrimary,
                  brandPrimary,
                  brandPrimary,
                ],
                borderWidth:1,
                data:[
                  yearly_purchase_amount[0],
                  yearly_purchase_amount[1],
                  yearly_purchase_amount[2],
                  yearly_purchase_amount[3],
                  yearly_purchase_amount[4],
                  yearly_purchase_amount[5],
                  yearly_purchase_amount[6],
                  yearly_purchase_amount[7],
                  yearly_purchase_amount[8],
                  yearly_purchase_amount[9],
                  yearly_purchase_amount[10],
                  yearly_purchase_amount[11], 
                  0
                ],
              },
              {
              label:label2,
              backgroundColor:[
                'rgba(82, 196, 26, 1)',
                'rgba(82, 196, 26, 1)',
                'rgba(82, 196, 26, 1)',
                'rgba(82, 196, 26, 1)',
                'rgba(82, 196, 26, 1)',
                'rgba(82, 196, 26, 1)',
                'rgba(82, 196, 26, 1)',
                'rgba(82, 196, 26, 1)',
                'rgba(82, 196, 26, 1)',
                'rgba(82, 196, 26, 1)',
                'rgba(82, 196, 26, 1)',
                'rgba(82, 196, 26, 1)',
                'rgba(82, 196, 26, 1)',
              ],
              borderColor:[
                '#52c41a',
                '#52c41a',
                '#52c41a',
                '#52c41a',
                '#52c41a',
                '#52c41a',
                '#52c41a',
                '#52c41a',
                '#52c41a',
                '#52c41a',
                '#52c41a',
                '#52c41a',
                '#52c41a',
              ],
              borderWidth:1,
              data:[
                yearly_sale_amount[0],
                yearly_sale_amount[1],
                yearly_sale_amount[2],
                yearly_sale_amount[3],
                yearly_sale_amount[4],
                yearly_sale_amount[5],
                yearly_sale_amount[6],
                yearly_sale_amount[7],
                yearly_sale_amount[8],
                yearly_sale_amount[9],
                yearly_sale_amount[10],
                yearly_sale_amount[11], 0
                ],
              },
            ]
          }
        })
      }

    });
  </script>

@endpush

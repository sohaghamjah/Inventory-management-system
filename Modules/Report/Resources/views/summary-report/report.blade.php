<!-- Begin :: Purchase Box -->
<div class="col-xl-4 col-sm-6 summary-report ">
    <div class="card text-white bg-primary">
        <h4 class="card-header text-white">Purchase</h4>
        <div class="card-body">
            <table class="table table-borderless">
                <tr>
                    <td><b>Amount</b></td>
                    <td><b>:</b></td>
                    <td>{{ number_format($purchase[0]->grand_total,2,'.',',') }}</td>
                </tr>
                <tr>
                    <td><b>Purchase</b></td>
                    <td><b>:</b></td>
                    <td>{{ $total_purchase }}</td>
                </tr>
                <tr>
                    <td><b>Paid</b></td>
                    <td><b>:</b></td>
                    <td>{{ number_format($purchase[0]->paid_amount,2,'.',',') }}</td>
                </tr>
                <tr>
                    <td><b>Tax</b></td>
                    <td><b>:</b></td>
                    <td>{{ number_format($purchase[0]->tax,2,'.',',') }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
<!-- End :: Purchase Box -->

<!-- Begin :: Sale Box -->
<div class="col-xl-4 col-sm-6 summary-report ">
    <div class="card text-white bg-primary">
        <h4 class="card-header text-white">Sale</h4>
        <div class="card-body">
            <table class="table table-borderless">
                <tr>
                    <td><b>Amount</b></td>
                    <td><b>:</b></td>
                    <td>{{ number_format($sale[0]->grand_total,2,'.',',') }}</td>
                </tr>
                <tr>
                    <td><b>sale</b></td>
                    <td><b>:</b></td>
                    <td>{{ $total_sale }}</td>
                </tr>
                <tr>
                    <td><b>Paid</b></td>
                    <td><b>:</b></td>
                    <td>{{ number_format($sale[0]->paid_amount,2,'.',',') }}</td>
                </tr>
                <tr>
                    <td><b>Tax</b></td>
                    <td><b>:</b></td>
                    <td>{{ number_format($sale[0]->tax,2,'.',',') }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
<!-- End :: Sale Box -->

<!-- Begin :: Profit/Loss Box -->
<div class="col-xl-4 col-sm-6 summary-report ">
    <div class="card text-white bg-primary">
        <h4 class="card-header text-white">Profit / Loss</h4>
        <div class="card-body">
            <table class="table table-borderless">
                <tr>
                    <td><b>Sale</b></td>
                    <td><b>:</b></td>
                    <td>{{ number_format($sale[0]->grand_total,2,'.',',') }}</td>
                </tr>
                <tr>
                    <td><b>Purchase</b></td>
                    <td><b>:</b></td>
                    <td>{{ number_format($purchase[0]->grand_total,2,'.',',') }}</td>
                </tr>
                <tr>
                    <td><b>Paid</b></td>
                    <td><b>:</b></td>
                    <td>{{ number_format(($sale[0]->paid_amount - $purchase[0]->grand_total),2,'.',',') }}</td>
                </tr>

            </table>
        </div>
    </div>
</div>
<!-- End :: Profit/Loss Box -->

<!-- Begin :: Net Profit/Net Loss Box -->
<div class="col-xl-4 col-sm-6 summary-report ">
    <div class="card text-white bg-primary">
        <h4 class="card-header text-white">Net Profit / Net Loss</h4>
        <div class="card-body">
            <h4 class="text-center text-white">{{ number_format((($sale[0]->grand_total - $sale[0]->tax) - ($purchase[0]->grand_total - $purchase[0]->tax)),2,'.',',') }}</h4>
            <p class="text-center"> (Sale {{ number_format($sale[0]->grand_total,2,'.',',') }} - Tax {{ number_format($sale[0]->tax,2,'.',',') }})</p>
            <p class="text-center"> (Purchase {{ number_format($purchase[0]->grand_total,2,'.',',') }} - Tax {{ number_format($purchase[0]->tax,2,'.',',') }})</p>
        </div>
    </div>
</div>
<!-- End :: Net Profit/Net Loss Box -->

<!-- Begin :: Payment Received Box -->
<div class="col-xl-4 col-sm-6 summary-report ">
    <div class="card text-white bg-primary">
        <h4 class="card-header text-white">Payment Received</h4>
        <div class="card-body">
            <table class="table table-borderless">
                <tr>
                    <td><b>Amount</b></td>
                    <td><b>:</b></td>
                    <td>{{ number_format($payment_received,2,'.',',') }}</td>
                </tr>
                <tr>
                    <td><b>Received</b></td>
                    <td><b>:</b></td>
                    <td>{{ $payment_received_number }}</td>
                </tr>
                <tr>
                    <td><b>Cash</b></td>
                    <td><b>:</b></td>
                    <td>{{ number_format($cash_payment_sale,2,'.',',') }}</td>
                </tr>
                <tr>
                    <td><b>Cheque</b></td>
                    <td><b>:</b></td>
                    <td>{{ number_format($cheque_payment_sale,2,'.',',') }}</td>
                </tr>
                <tr>
                    <td><b>Mobile</b></td>
                    <td><b>:</b></td>
                    <td>{{ number_format($mobile_payment_sale,2,'.',',') }}</td>
                </tr>

            </table>
        </div>
    </div>
</div>
<!-- End :: Payment Received Box -->

<!-- Begin :: Payment Sent Box -->
<div class="col-xl-4 col-sm-6 summary-report ">
    <div class="card text-white bg-primary">
        <h4 class="card-header text-white">Payment Sent</h4>
        <div class="card-body">
            <table class="table table-borderless">
                <tr>
                    <td><b>Amount</b></td>
                    <td><b>:</b></td>
                    <td>{{ number_format($payment_paid,2,'.',',') }}</td>
                </tr>
                <tr>
                    <td><b>Paid</b></td>
                    <td><b>:</b></td>
                    <td>{{ $payment_paid_number }}</td>
                </tr>
                <tr>
                    <td><b>Cash</b></td>
                    <td><b>:</b></td>
                    <td>{{ number_format($cash_payment_purchase,2,'.',',') }}</td>
                </tr>
                <tr>
                    <td><b>Cheque</b></td>
                    <td><b>:</b></td>
                    <td>{{ number_format($cheque_payment_purchase,2,'.',',') }}</td>
                </tr>
                <tr>
                    <td><b>Mobile</b></td>
                    <td><b>:</b></td>
                    <td>{{ number_format($mobile_payment_purchase,2,'.',',') }}</td>
                </tr>

            </table>
        </div>
    </div>
</div>
<!-- End :: Payment Sent Box -->

<!-- Begin :: Expense Box -->
<div class="col-xl-4 col-sm-6 summary-report ">
    <div class="card text-white bg-primary">
        <h4 class="card-header text-white">Expense</h4>
        <div class="card-body">
            <table class="table table-borderless">
                <tr>
                    <td><b>Amount</b></td>
                    <td><b>:</b></td>
                    <td>{{ number_format($expense,2,'.',',') }}</td>
                </tr>
                <tr>
                    <td><b>Expense</b></td>
                    <td><b>:</b></td>
                    <td>{{ $total_expense }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
<!-- End :: Expense Box -->

<!-- Begin :: Cash In Hand Box -->
<div class="col-xl-4 col-sm-6 summary-report ">
    <div class="card text-white bg-primary">
        <h4 class="card-header text-white">Cash In Hand</h4>
        <div class="card-body">
            <table class="table table-borderless">
                <tr>
                    <td><b>Received</b></td>
                    <td><b>:</b></td>
                    <td>{{ number_format($payment_received,2,'.',',') }}</td>
                </tr>
                <tr>
                    <td><b>Sent</b></td>
                    <td><b>:</b></td>
                    <td>{{ number_format($payment_paid,2,'.',',') }}</td>
                </tr>
                <tr>
                    <td><b>Expense</b></td>
                    <td><b>:</b></td>
                    <td>{{ number_format($expense,2,'.',',') }}</td>
                </tr>
                <tr>
                    <td><b>Payroll</b></td>
                    <td><b>:</b></td>
                    <td>{{ number_format($payroll,2,'.',',') }}</td>
                </tr>
                <tr>
                    <td><b>In Hand</b></td>
                    <td><b>:</b></td>
                    <td>{{ number_format(($payment_received - $payment_paid - $expense - $payroll),2,'.',',') }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
<!-- End :: Cash In Hand Box -->

@if (!empty($warehouse_name))
    @foreach ($warehouse_name as $key => $name)
    <div class="col-xl-4 col-sm-6 summary-report">
        <div class="card text-white bg-primary">
            <h4 class="card-header text-white">{{ $name }}</h4>
            <div class="card-body">
                <h4 class="text-center text-white">{{ number_format(($warehouse_sale[$key][0]->grand_total - $warehouse_purchase[$key][0]->grand_total),2,'.',',') }}</h4>
                <p class="text-center"> (Sale {{ number_format($warehouse_sale[$key][0]->grand_total,2,'.',',') }} - Purchase {{ number_format($warehouse_purchase[$key][0]->grand_total,2,'.',',') }})</p>
                
                <hr style="border-color: white;">

                <h4 class="text-center text-white">{{ number_format((($warehouse_sale[$key][0]->grand_total - $warehouse_sale[$key][0]->tax) - ($warehouse_purchase[$key][0]->grand_total - $warehouse_purchase[$key][0]->tax)),2,'.',',') }}</h4>
                <p class="text-center"> (Net Sale {{ number_format(($warehouse_sale[$key][0]->grand_total - $warehouse_sale[$key][0]->tax),2,'.',',') }} - Net Purchase {{ number_format(($warehouse_purchase[$key][0]->grand_total - $warehouse_purchase[$key][0]->tax),2,'.',',') }})</p>
                
                <hr style="border-color: white;">

                <h4 class="text-center text-white">{{ number_format($warehouse_expense[$key],2,'.',',') }}</h4>
                <p class="text-center">Expense</p>
                
            </div>
        </div>
    </div>
    @endforeach
@endif
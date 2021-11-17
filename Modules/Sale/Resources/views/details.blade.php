@extends('layouts.app')
@section('title')
    {{ $page_title }}
@endsection
@push('stylesheet')
    <link rel="stylesheet" href="{{ asset('assets/default/assets/css/print.css') }}">
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
                <div class="d-flex flex-wrap">
                    <button type="button" id="print-invoice" class="btn btn-primary btn-sm mr-3"> <i class="fas fa-print"></i> Print</button>
                    <a href="{{ route('sale') }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-plus-square"></i>
                        Back
                    </a>
                </div>

            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

                <!-- Card Body -->
                <div class="dt-card__body">
                    <div id="invoice">
                        <style>
                            body,
                            html {
                                background: #fff !important;
                                -webkit-print-color-adjust: exact !important;
                            }
                            .invoice {
                                /* position: relative; */
                                background: #fff !important;
                                /* min-height: 680px; */
                            }
                            .invoice header {
                                padding: 10px 0;
                                margin-bottom: 20px;
                                border-bottom: 1px solid #036;
                            }
                            .invoice .company-details {
                                text-align: right
                            }
                            .invoice .company-details .name {
                                margin-top: 0;
                                margin-bottom: 0;
                            }
                            .invoice .contacts {
                                margin-bottom: 20px;
                            }
                            .invoice .invoice-to {
                                text-align: left;
                            }
                            .invoice .invoice-to .to {
                                margin-top: 0;
                                margin-bottom: 0;
                            }
                            .invoice .invoice-details {
                                text-align: right;
                            }
                            .invoice .invoice-details .invoice-id {
                                margin-top: 0;
                                color: #036;
                            }
                            .invoice main {
                                padding-bottom: 50px
                            }
                            .invoice main .thanks {
                                margin-top: -100px;
                                font-size: 2em;
                                margin-bottom: 50px;
                            }
                            .invoice main .notices {
                                padding-left: 6px;
                                border-left: 6px solid #036;
                            }
                            .invoice table {
                                width: 100%;
                                border-collapse: collapse;
                                border-spacing: 0;
                                margin-bottom: 20px;
                            }
                            .invoice table th {
                                background: #036;
                                color: #fff;
                                padding: 15px;
                                border-bottom: 1px solid #fff
                            }
                            .invoice table td {
                                padding: 15px;
                                border-bottom: 1px solid #fff
                            }
                            .invoice table th {
                                white-space: nowrap;
                            }
                            .invoice table td h3 {
                                margin: 0;
                                color: #036;
                            }
                            .invoice table .qty {
                                text-align: center;
                            }
                            .invoice table .price,
                            .invoice table .discount,
                            .invoice table .tax,
                            .invoice table .total {
                                text-align: right;
                            }
                            .invoice table .no {
                                color: #fff;
                                background: #036
                            }
                            .invoice table .total {
                                background: #036;
                                color: #fff
                            }
                            .invoice table tbody tr:last-child td {
                                border: none
                            }
                            .invoice table tfoot td {
                                background: 0 0;
                                border-bottom: none;
                                white-space: nowrap;
                                text-align: right;
                                padding: 10px 20px;
                                border-top: 1px solid #aaa
                            }
                            .invoice table tfoot tr:first-child td {
                                border-top: none
                            }
                            .invoice table tfoot tr:last-child td {
                                color: #036;
                                border-top: 1px solid #036
                            }
                            .invoice table tfoot tr td:first-child {
                                border: none
                            }
                            .invoice footer {
                                width: 100%;
                                text-align: center;
                                color: #777;
                                border-top: 1px solid #aaa;
                                padding: 8px 0
                            }
                            .invoice a {
                                content: none !important;
                                text-decoration: none !important;
                                color: #036 !important;
                            }
                            .page-header,
                            .page-header-space {
                                height: 100px;
                            }
                            .page-footer,
                            .page-footer-space {
                                height: 20px;
                            }
                            .page-footer {
                                position: fixed;
                                bottom: 0;
                                width: 100%;
                                text-align: center;
                                color: #777;
                                border-top: 1px solid #aaa;
                                padding: 8px 0
                            }
                            .page-header {
                                position: fixed;
                                top: 0mm;
                                width: 100%;
                                border-bottom: 1px solid black;
                            }
                            .page {
                                page-break-after: always;
                            }
                            @media screen {
                                .no_screen {display: none;}
                                .no_print {display: block;}
                                thead {display: table-header-group;} 
                                tfoot {display: table-footer-group;}
                                button {display: none;}
                                body {margin: 0;}
                            }
                            @media print {
                                body,
                                html {
                                    /* background: #fff !important; */
                                    -webkit-print-color-adjust: exact !important;
                                    font-family: sans-serif;
                                    /* font-size: 12px !important; */
                                    margin-bottom: 100px !important;
                                }
                                .m-0 {
                                    margin: 0 !important;
                                }
                                h1,
                                h2,
                                h3,
                                h4,
                                h5,
                                h6 {
                                    margin: 0 !important;
                                }
                                .no_screen {
                                    display: block !important;
                                }
                                .no_print {
                                    display: none;
                                }
                                a {
                                    content: none !important;
                                    text-decoration: none !important;
                                    color: #036 !important;
                                }
                                .text-center {
                                    text-align: center !important;
                                }
                                .text-left {
                                    text-align: left !important;
                                }
                                .text-right {
                                    text-align: right !important;
                                }
                                .float-left {
                                    float: left !important;
                                }
                                .float-right {
                                    float: right !important;
                                }
                                .text-bold {
                                    font-weight: bold !important;
                                }
                                .invoice {
                                    /* font-size: 11px!important; */
                                    overflow: hidden !important;
                                    background: #fff !important;
                                    margin-bottom: 100px !important;
                                }
                                .invoice footer {
                                    position: absolute;
                                    bottom: 0;
                                    left: 0;
                                    /* page-break-after: always */
                                }
                                /* .invoice>div:last-child {
                                    page-break-before: always
                                } */
                                .hidden-print {
                                    display: none !important;
                                }
                            }
                            @page {
                                /* size: auto; */
                                margin: 5mm 5mm;
                            }
                        </style>
                        <div class="invoice overflow-auto">
                            <div>
                                <table>
                                    <tr>
                                        <td>
                                            <a href="{{ url('/') }}" class="logo_text">
                                                <img  src="{{ asset('storage/'.LOGO_PATH.config('settings.logo')) }}" alt="Logo" style="max-width: 250px;"/>
                                            </a>
                                        </td>
                                        <td class="text-right">
                                            <h2 class="name m-0">{{ config('settings.title') ? config('settings.title') : env('APP_NAME') }}</h2>
                                            <p class="m-0">{{ config('settings.address') }}</p>
                                        </td>
                                    </tr>
                                </table>
                                
                                <table>
                                    <tr>
                                        <td width="50%">
                                            <div class="invoice-to">
                                                <div class="text-grey-light">INVOICE TO:</div>
                                                <div class="to">{{ $sale->customer->name }}</div>
                                                <div class="phone">{{ $sale->customer->phone }}</div>
                                                @if($sale->customer->email)<div class="email">{{ $sale->customer->email }}</div>@endif
                                                @if($sale->customer->address)<div class="address">{{ $sale->customer->address }}</div>@endif
                                            </div>
                                        </td>
                                        <td width="50%" class="text-right">
                                            <h4 class="name m-0">{{ $sale->sale_no }}</h4>
                                            <div class="m-0 date">Date:{{ date('d-M-Y',strtotime($sale->created_at)) }}</div>
                                        </td>
                                    </tr>
                                </table>

                                <table border="0" cellspacing="0" cellpadding="0">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-left">DESCRIPTION</th>
                                            <th class="text-center">QUANTITY</th>
                                            <th class="text-right">PRICE</th>
                                            <th class="text-right">DISCOUNT</th>
                                            <th class="text-right">TAX</th>
                                            <th class="text-right">SUBTOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!$sale->sale_products->isEmpty())
                                            @foreach ($sale->sale_products as $key => $sale_product)
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td class="text-left">{{ $sale_product->name }}</td>
                                                    <td class="text-center qty">{{ $sale_product->pivot->qty.' '.DB::table('units')->where('id',$sale_product->pivot->sale_unit_id)->value('unit_name') }}</td>
                                                    <td class="text-right price">{{ number_format($sale_product->pivot->net_unit_price,2) }}</td>
                                                    <td class="text-right discount">{{ number_format($sale_product->pivot->discount,2) }}</td>
                                                    <td class="text-right tax">{{ number_format($sale_product->pivot->tax,2) }}</td>
                                                    <td class="text-right total">{{ number_format($sale_product->pivot->total,2) }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td colspan="2"  class="text-right">TOTAL</td>
                                            <td class="text-right">
                                                @if (config('settings.currency_position') == 'suffix')
                                                    {{ number_format($sale->total_price,2) }} {{ config('settings.currency_symbol') }}
                                                @else 
                                                    {{ config('settings.currency_symbol') }} {{ number_format($sale->total_price,2) }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td colspan="2"  class="text-right">DISCOUNT</td>
                                            <td class="text-right">
                                                @if (config('settings.currency_position') == 'suffix')
                                                    {{ number_format($sale->total_discount,2) }} {{ config('settings.currency_symbol') }}
                                                @else 
                                                    {{ config('settings.currency_symbol') }} {{ number_format($sale->total_discount,2) }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td colspan="2"  class="text-right">TAX {{ $sale->order_tax_rate }}%</td>
                                            <td class="text-right">
                                                @if (config('settings.currency_position') == 'suffix')
                                                    {{ number_format($sale->order_tax_rate,2) }} {{ config('settings.currency_symbol') }}
                                                @else 
                                                    {{ config('settings.currency_symbol') }} {{ number_format($sale->order_tax_rate,2) }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td colspan="2"  class="text-right">SHIPPING COST</td>
                                            <td class="text-right">
                                                @if (config('settings.currency_position') == 'suffix')
                                                    {{ number_format($sale->shipping_cost,2) }} {{ config('settings.currency_symbol') }}
                                                @else 
                                                    {{ config('settings.currency_symbol') }} {{ number_format($sale->shipping_cost,2) }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td colspan="2"  class="text-right">GRAND TOTAL</td>
                                            <td class="text-right">
                                                @if (config('settings.currency_position') == 'suffix')
                                                    {{ number_format($sale->grand_total,2) }} {{ config('settings.currency_symbol') }}
                                                @else 
                                                    {{ config('settings.currency_symbol') }} {{ number_format($sale->grand_total,2) }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td colspan="2"  class="text-right">PAID AMOUNT</td>
                                            <td class="text-right">
                                                @if (config('settings.currency_position') == 'suffix')
                                                    {{ number_format($sale->paid_amount,2) }} {{ config('settings.currency_symbol') }}
                                                @else 
                                                    {{ config('settings.currency_symbol') }} {{ number_format($sale->paid_amount,2) }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td colspan="2"  class="text-right">DUE AMOUNT</td>
                                            <td class="text-right">
                                                @if (config('settings.currency_position') == 'suffix')
                                                    {{ number_format(($sale->grand_total - $sale->paid_amount),2) }} {{ config('settings.currency_symbol') }}
                                                @else 
                                                    {{ config('settings.currency_symbol') }} {{ number_format(($sale->grand_total - $sale->paid_amount),2) }}
                                                @endif
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <table>
                                    <tr>
                                        <td>
                                            <div>
                                                <div class="thanks">Thank You</div>
                                            </div>
                                            <div class="notices">
                                                <div>NOTE:</div>
                                                <div class="notice">{{ $sale->note }}</div>
                                            </div>
                                        </td>
                                        
                                    </tr>
                                </table>
                            </div>
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
<script src="{{ asset('assets/default/assets/js/jquery.printarea.js') }}"></script>
<script>
$(document).ready(function () {
    $(document).on('click','#print-invoice',function(){
        var mode = 'iframe';
        var close = mode == "popup";
        var options = {
            mode:mode,
            popClose:close
        };
        $('#invoice').printArea(options);
    });
});
</script>
@endpush

<div style="width: 100%;">
    <button type="button" class="btn btn-warning btn-sm float-right mb-5" id="print_barcode"> <i class="fas fa-print"></i> Print</button>
    <div id="printableArea" style="width: 100%;">
        <link rel="stylesheet" href="{{ asset('assets/default/assets/css/print.css') }}">
        @if (!empty($code))
            <table width="100%">
                <?php 
                $counter = 0;
                for ($i=0; $i < $barcode_qty; $i++) { 
                ?>
                <?php 
                if($counter == $row_qty)
                {
                ?>
                <tr>
                <?php 
                    $counter =0; 
                }
                ?>
                    <td>
                        <div style="text-align: center;width:{{ $width ? $width : '38' }}{{ $unit ? $unit : 'mm' }};
                        height:{{ $height ? $height : '38' }}{{ $unit ? $unit : 'mm' }};font-size:12px;">

                            <div style="padding-top:20px;font-weight:bold; ">
                                <b>{{ config('settings.title') }}</b>
                            </div>
                            @if (!empty($name))
                                <div style="padding-bottom: 5px;"><p style="margin:0;">{{ $name }}</p></div>
                            @endif
                            <div style="width:100%;text-align:center; padding: 5px 0;">
                                @php
                                    echo DNS1D::getBarcodeSVG($code, 'C39',0.8,33,'',false);
                                @endphp
                            </div>
                            <div style="letter-spacing: 4.2px; padding-bottom: 5px">{{ $code }}</div>
                            @if (!empty($price))
                                <div><b>M.R.P. : </b>
                                {{ (config('settings.currency_position') == 'prefix') ? config('settings.currency_symbol').' '.$price : 
                                $price.' '.config('settings.currency_symbol') }}
                                </div>
                            @endif
                        </div>
                    </td>
                    <?php if($counter == 5){ ?>
                </tr>
                <?php 
                    $counter = 0;
                    }
                    $counter++;
                }
                ?>
            </table>
        @endif
    </div>
</div>
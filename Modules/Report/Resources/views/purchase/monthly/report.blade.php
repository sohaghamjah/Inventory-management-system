<div class="table-responsive">
    <table class="table table-bordered">
        <thead class="bg-primary">
           <tr>
                <th class="text-center">
                    <p class="previous" style="cursor: pointer;"><i class="fas fa-arrow-left"></i> Previous</p>
                    <input type="hidden" name="prev_year" id="prev_year" value="{{ $year-1 }}">
                </th>  
                <th colspan="10" class="text-center">
                    <p class="previous">{{ $year }}
                </th>
                <th class="text-center">
                    <p class="next"   style="cursor: pointer;"><i class="fas fa-arrow-right"></i> Next</p>
                    <input type="hidden" name="next_year" id="next_year" value="{{ $year+1 }}">
                </th>
           </tr> 
        </thead>
        <tbody>
            <tr>
                <td><b>January</b></td>
                <td><b>February</b></td>
                <td><b>March</b></td>
                <td><b>April</b></td>
                <td><b>May</b></td>
                <td><b>June</b></td>
                <td><b>July</b></td>
                <td><b>August</b></td>
                <td><b>September</b></td>
                <td><b>October</b></td>
                <td><b>November</b></td>
                <td><b>December</b></td>
            </tr>
            <tr>
                @foreach ($total_discount as $key => $value)
                    <td>
                        @if($value > 0)
                            <b>Product Discount</b><br><span>{{ $value }}</span><br><br>
                        @endif
                        @if($order_discount[$key] > 0)
                            <b>Order Discount</b><br><span>{{ $order_discount[$key] }}</span><br><br>
                        @endif
                        @if($total_tax[$key] > 0)
                            <b>Total Tax</b><br><span>{{ $total_tax[$key] }}</span><br><br>
                        @endif
                        @if($order_tax[$key] > 0)
                            <b>Order Tax</b><br><span>{{ $order_tax[$key] }}</span><br><br>
                        @endif
                        @if($shipping_cost[$key] > 0)
                            <b>Shipping Cost</b><br><span>{{ $shipping_cost[$key] }}</span><br><br>
                        @endif
                        @if($grand_total[$key] > 0)
                            <b>Grand Total</b><br><span>{{ $grand_total[$key] }}</span><br><br>
                        @endif
                    </td>
                @endforeach
            </tr>
        </tbody>
    </table>
</div>
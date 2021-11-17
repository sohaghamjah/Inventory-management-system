<div class="table-responsive">
    <table class="table table-bordered">
        <thead class="bg-primary">
           <tr>
                <th class="text-center">
                    <p class="previous" style="cursor: pointer;"><i class="fas fa-arrow-left"></i> Previous</p>
                    <input type="hidden" name="prev_year" id="prev_year" value="{{ $prev_year }}">
                    <input type="hidden" name="prev_month" id="prev_month" value="{{ $prev_month }}">
                </th>  
                <th colspan="5" class="text-center">
                    <p class="previous">{{ date('F',strtotime($year.'-'.$month.'-01')).' '.$year }}
                </th>
                <th class="text-center">
                    <p class="next"   style="cursor: pointer;"><i class="fas fa-arrow-right"></i> Next</p>
                    <input type="hidden" name="next_year" id="next_year" value="{{ $next_year }}">
                    <input type="hidden" name="next_month" id="next_month" value="{{ $next_month }}">
                </th>
           </tr>
        </thead>
        <tbody>
            <tr>
                <td><b>Sunday</b></td>
                <td><b>Monday</b></td>
                <td><b>Tuesday</b></td>
                <td><b>Wednesday</b></td>
                <td><b>Thursday</b></td>
                <td><b>Friday</b></td>
                <td><b>Saturday</b></td>
            </tr>
             @php
                 $i =  1;
                 $flag = 0;
                 while($i <= $number_of_day){
                    echo '<tr>';
                        for ($j=1; $j <=7 ; $j++){
                            if($i > $number_of_day)
                            {
                                break;
                            }
                            if($flag){
                                if($year.'-'.$month.'-'.$i == date('Y').'-'.date('m').'-'.(int)date('d'))
                                {
                                    echo '<td><p style="color:red;"><strong>'.$i.'</strong></p>';
                                }else{
                                    echo '<td><p><strong>'.$i.'</strong></p>';
                                }

                                if($total_discount[$i])
                                {
                                    echo '<strong>Product Discount</strong><br><span>'.$total_discount[$i].'</span><br><br>';
                                }
                                if($order_discount[$i])
                                {
                                    echo '<strong>Order Discount</strong><br><span>'.$order_discount[$i].'</span><br><br>';
                                }
                                if($total_tax[$i])
                                {
                                    echo '<strong>Total Tax</strong><br><span>'.$total_tax[$i].'</span><br><br>';
                                }
                                if($order_tax[$i])
                                {
                                    echo '<strong>Order Tax</strong><br><span>'.$order_tax[$i].'</span><br><br>';
                                }
                                if($shipping_cost[$i])
                                {
                                    echo '<strong>Shipping Cost</strong><br><span>'.$shipping_cost[$i].'</span><br><br>';
                                }
                                if($grand_total[$i])
                                {
                                    echo '<strong>Grand Total</strong><br><span>'.$grand_total[$i].'</span><br><br>';
                                }
                                echo '</td>';
                                $i++;
                            }elseif ($j == $start_date) {
                                if($year.'-'.$month.'-'.$i == date('Y').'-'.date('m').'-'.(int)date('d'))
                                {
                                    echo '<td><p style="color:red;"><strong>'.$i.'</strong></p>';
                                }else{
                                    echo '<td><p><strong>'.$i.'</strong></p>';
                                }

                                if($total_discount[$i])
                                {
                                    echo '<strong>Product Discount</strong><br><span>'.$total_discount[$i].'</span><br><br>';
                                }
                                if($order_discount[$i])
                                {
                                    echo '<strong>Order Discount</strong><br><span>'.$order_discount[$i].'</span><br><br>';
                                }
                                if($total_tax[$i])
                                {
                                    echo '<strong>Total Tax</strong><br><span>'.$total_tax[$i].'</span><br><br>';
                                }
                                if($order_tax[$i])
                                {
                                    echo '<strong>Order Tax</strong><br><span>'.$order_tax[$i].'</span><br><br>';
                                }
                                if($shipping_cost[$i])
                                {
                                    echo '<strong>Shipping Cost</strong><br><span>'.$shipping_cost[$i].'</span><br><br>';
                                }
                                if($grand_total[$i])
                                {
                                    echo '<strong>Grand Total</strong><br><span>'.$grand_total[$i].'</span><br><br>';
                                }
                                echo '</td>';
                                $flag=1;
                                $i++;
                                continue;
                            }else{
                                echo '<td></td>';
                            }
                        }
                    echo '</tr>';
                }
            @endphp
        </tbody>
    </table>
</div>
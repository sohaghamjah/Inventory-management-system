<?php

namespace Modules\Sale\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Modules\Sale\Entities\Sale;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Account\Entities\Payment;
use Illuminate\Contracts\Support\Renderable;
use Modules\Sale\Http\Requests\SalePaymentFormRequest;

class SalePaymentController extends Controller
{
    public function storeOrUpdate(SalePaymentFormRequest $request)
    {
        if($request->ajax())
        {
            if(permission('sale-payment-add')){
                DB::beginTransaction();
                try {
                    $sale_data = sale::find($request->sale_id);
                    if($sale_data){
                        if(empty($request->payment_id)){
                            $sale_data->paid_amount += $request->amount;
                            $balance = $sale_data->grand_total - $sale_data->paid_amount;
                            if($balance == 0)
                            {
                                $sale_data->payment_status = 1;//paid
                            }else if($balance == $sale_data->grand_total)
                            {
                                $sale_data->payment_status = 3;//due
                            }else{
                                $sale_data->payment_status = 2;//partial
                            }
                        }else{
                            $payment_data = Payment::find($request->payment_id);
                            $amount_diff = $payment_data->amount - $request->amount;
                            $sale_data->paid_amount -= $amount_diff;
                            $balance = $sale_data->grand_total - $sale_data->paid_amount;
                            if($balance == 0)
                            {
                                $sale_data->payment_status = 1;//paid
                            }else if($balance == $sale_data->grand_total)
                            {
                                $sale_data->payment_status = 3;//due
                            }else{
                                $sale_data->payment_status = 2;//partial
                            }
                        }
                        
                        $sale_data->updated_by = auth()->user()->name;
                        $sale_data->update();
                    }
                    $payment_data = [
                        'account_id' => $request->account_id,
                        'sale_id' => $request->sale_id,
                        'amount' => $request->amount,
                        'change' => $request->change_amount,
                        'payment_method' => $request->payment_method,
                        'payment_no' => $request->payment_method != 1 ? $request->payment_no : null,
                    ];
                    if($request->payment_id)
                    {
                        $payment_data['created_by'] = auth()->user()->name;
                        $payment_data['created_at'] = date('Y-m-d H:i:s');
                        
                    }else{
                        $payment_data['updated_by'] = auth()->user()->name;
                        $payment_data['updated_at'] = date('Y-m-d H:i:s');
                    }
                    $result = Payment::updateOrCreate(['id'=>$request->payment_id],$payment_data);
                    $output = $result ? ['status'=>'success','message'=> 'Payment Data Saved Successfully'] : ['status'=>'error','message'=> 'Failed to Save Payment Data'];
                    DB::commit();
                } catch (Exception $e) {
                    DB::rollback();
                    $output = ['status'=>'error','message'=>$e->getMessage()];
                }
                return response()->json($output);

            }else{
                return response()->json(['status'=>'error','message'=>'Unauthorized Access Blocked']);
            }
        }
    }

    public function show(Request $request)
    {
        if($request->ajax())
        {
            if(permission('sale-payment-show')){
                $payments = Payment::with('account')->where('sale_id',$request->id)->get();
                return view('sale::payment.view',compact('payments'))->render();
            }
        }
    }

    public function delete(Request $request)
    {
        if($request->ajax())
        {
            if(permission('sale-payment-delete')){
                $payment_data = Payment::find($request->id);
                $sale_data = Sale::find($payment_data->sale_id);
                $sale_data->paid_amount -= $payment_data->amount;
                $balance = $sale_data->grand_total - $sale_data->paid_amount;
                if($balance == 0)
                {
                    $sale_data->payment_status = 1;//paid
                }else if($balance == $sale_data->grand_total)
                {
                    $sale_data->payment_status = 3;//due
                }else{
                    $sale_data->payment_status = 2;//partial
                }
                if($sale_data->update()){
                    $result = $payment_data->delete();
                    $output = $result ?  ['status'=>'success','message'=>'Data deleted successfully'] :  ['status'=>'error','message'=>'Faild to delete data'];
                }else{
                    $output = ['status'=>'error','message'=>'Faild to delete data'];
                }
                return response()->json($output);
            }else{
                return response()->json( ['status'=>'error','message'=>'Unauthorized Access Blocked']);
            }
        }
    }
}

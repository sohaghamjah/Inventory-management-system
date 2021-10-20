<?php

namespace Modules\Purchase\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Purchase\Entities\Purchase;
use Modules\Account\Entities\Payment;
use Modules\Purchase\Http\Requests\PurchasePaymentFormRequst;

class PurchasePaymentController extends Controller
{
    public function storeOrUpdate(PurchasePaymentFormRequst $request)
    {
        if($request->ajax())
        {
            if(permission('purchase-payment-add')){
                DB::beginTransaction();
                try {
                    $purchase_data = Purchase::find($request->purchase_id);
                    if($purchase_data){
                        if(empty($request->payment_id)){
                            $purchase_data->paid_amount += $request->amount;
                            $purchase_data->payment_status = ($purchase_data->grand_total - $purchase_data->paid_amount) == 0 ? 1 : 2; //1=Paid,2=Due
                        }else{
                            $payment_data = Payment::find($request->payment_id);
                            $amount_diff = $payment_data->amount - $request->amount;
                            $purchase_data->paid_amount -= $amount_diff;
                            $purchase_data->payment_status = ($purchase_data->grand_total - $purchase_data->paid_amount) == 0 ? 1 : 2; //1=Paid,2=Due
                        }
                        
                        $purchase_data->updated_by = auth()->user()->name;
                        $purchase_data->update();
                    }
                    $payment_data = [
                        'account_id' => $request->account_id,
                        'purchase_id' => $request->purchase_id,
                        'amount' => $request->amount,
                        'change' => $request->change_amount,
                        'payment_method' => $request->payment_method,
                        'payment_note' => $request->payment_note,
                        'payment_no' => $request->payment_method != 1 ? $request->payment_no : null,
                    ];
                    if($request->payment_id)
                    {
                        $payment_data['updated_by'] = auth()->user()->name;
                        $payment_data['updated_at'] = date('Y-m-d H:i:s');
                    }else{
                        $payment_data['created_by'] = auth()->user()->name;
                        $payment_data['created_at'] = date('Y-m-d H:i:s');
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
            if(permission('purchase-payment-show')){
                $payments = Payment::with('account')->where('purchase_id',$request->id)->get();
                return view('purchase::payment.view',compact('payments'))->render();
            }
        }
    }

    public function delete(Request $request)
    {
        if($request->ajax())
        {
            if(permission('purchase-payment-delete')){
                $payment_data = Payment::find($request->id);
                $purchase_data = Purchase::find($payment_data->purchase_id);
                $purchase_data->paid_amount -= $payment_data->amount;
                $purchase_data->payment_status = ($purchase_data->grand_total - $purchase_data->paid_amount) == 0 ? 1 : 2; //1=Paid,2=Due
                if($purchase_data->update()){
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

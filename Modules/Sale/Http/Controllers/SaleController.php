<?php

namespace Modules\Sale\Http\Controllers;

use Modules\Base\Http\Controllers\BaseController;
use App\Traits\UploadAble;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Customer\Entities\Customer;
use Modules\Account\Entities\Account;
use Modules\Account\Entities\Payment;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\WarehouseProduct;
use Modules\Sale\Entities\Sale;
use Modules\Sale\Http\Requests\SaleFormRequst;
use Modules\System\Entities\Tax;
use Modules\System\Entities\Unit;
use Modules\System\Entities\Warehouse;

class SaleController extends BaseController
{
    use UploadAble;

    public function __construct(Sale $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if(permission('sale-access')){
            $this->setPageData('Manage Sale','Manage Sale','fas fa-shoppingcart');
            $customers = Customer::all();
            $accounts  = Account::where('status',1)->get();
            return view('sale::index',compact('customers','accounts'));
        }else{
            return $this->unauthorized_access_blocked();
        }
    }

        /**
     * getDataTableData function
     *
     * @param Request $request
     * @return void
     */
    public function getDataTableData(Request $request){
        if(permission('sale-access')){
            if($request -> ajax()){
                // Filter datatable
                if (!empty($request->sale_no)) {
                    $this->model->setSaleNo($request->sale_no);
                }
                if (!empty($request->customer_id)) {
                    $this->model->setCustomerID($request->customer_id);
                }
                if (!empty($request->from_date)) {
                    $this->model->setFromDate($request->from_date);
                }
                if (!empty($request->to_date)) {
                    $this->model->setToDate($request->to_date);
                }
                if (!empty($request->sale_status)) {
                    $this->model->setSaleStatus($request->sale_status);
                }
                if (!empty($request->payment_status)) {
                    $this->model->setPaymentStatus($request->payment_status);
                }


                // Show uer list
                $this->setDatatableDefalutlProperty($request);

                $list = $this->model->getDataTableList(); 

                $data = [];
                $no = $request->input('start');
                foreach ($list as $value) {
                    $no++;
                    $action = '';
                    if(permission('sale-edit')){
                        $action .= ' <a style="cursor: pointer" class="dropdown-item edit_data" href="'.url("sale/edit",$value->id).'" data-id="'.$value->id.'"><i class="fas fa-edit text-primary"></i> Edit</a>';
                    }
                    // if(permission('sale-show')){
                    //     $action .= ' <a style="cursor: pointer" class="dropdown-item view_data" href="'.url("sale/details",$value->id).'" data-id="'.$value->id.'"><i class="fas fa-eye text-success"></i> View</a>';
                    // }
                    if(permission('sale-show')){
                        $action .= ' <a style="cursor: pointer" class="dropdown-item invoice_data" data-name="'.$value->name.'" data-id="'.$value->id.'"><i class="fas fa-file text-warning"></i> Invoice</a>';
                    }
                    if(permission('sale-payment-add')){
                        if(($value->grand_total - $value->paid_amount) != 0){
                            $action .= ' <a style="cursor: pointer" class="dropdown-item add_payment"  data-id="' . $value->id . '" data-due="'.($value->grand_total - $value->paid_amount).'"><i class="fas fa-plus-square text-info"></i> Add Payment</a>';
                        }
                    }
                    if(permission('sale-payment-show')){
                        $action .= ' <a style="cursor: pointer" class="dropdown-item view_payment_list" data-name="'.$value->name.'" data-id="'.$value->id.'"><i class="fas fa-file-invoice-dollar text-default"></i> Payment List</a>';
                    }
                    if(permission('sale-delete')){
                        $action .= ' <a style="cursor: pointer" class="dropdown-item delete_data" data-name="'.$value->name.'" data-id="'.$value->id.'"><i class="fas fa-trash text-danger"></i> Delete</a>';
                    }
                    $row = [];
                    if(permission('sale-bulk-delete')){
                        $row [] = tableCheckBox($value->id);
                    }
    
                    $row[] = $no;
                    $row[] = $value->sale_no;
                    $row[] = $value->customer->name.' - '.$value->customer->phone;
                    $row[] = number_format($value->item,2,'.',',');
                    $row[] = number_format($value->total_qty,2,'.',',');
                    $row[] = number_format($value->total_discount,2,'.',',');
                    $row[] = number_format($value->total_tax,2,'.',',');
                    $row[] = number_format($value->total_price,2,'.',',');
                    $row[] = number_format($value->order_tax_rate,2,'.',',');
                    $row[] = number_format($value->order_tax,2,'.',',');
                    $row[] = number_format($value->order_discount,2,'.',',');
                    $row[] = number_format($value->shipping_cost,2,'.',',');
                    $row[] = number_format($value->grand_total,2,'.',',');
                    $row[] = number_format($value->paid_amount,2,'.',',');
                    $row[] = number_format(($value->grand_total - $value->paid_amount),2,'.',',');
                    $row[] = SALE_STATUS_LABEL[$value->sale_status];
                    $row[] = SALE_PAYMENT_STATUS_LABEL[$value->payment_status];
                    $row[] = $value->created_by;
                    $row[] = date(config('settings.date_format'),strtotime($value->created_at));
                    $row[] = actionButton($action);
                    $data[] = $row;
                }
                return $this->datatableDraw($request->input('draw'), $this->model-> countFilter(), $this->model-> countAll(), $data);
            }else{
                $output = $this->accessBlocked();
            }
            return response()->json($output);
        }
    }

    public function create()
    {
        if(permission('sale-add')){
            $this->setPageData('Add Sale','Add Sale','fas fa-plus-square');
            $customers  = Customer::all();
            $warehouses = Warehouse::where('status',1)->get();
            $taxes      = Tax::where('status',1)->get();
            $accounts   = Account::where('status',1)->get();
            return view('sale::create',compact('customers','accounts','warehouses','taxes'));
        }else{
            return $this->unauthorized_access_blocked();
        }
    }


    public function store(SaleFormRequst $request)
    {
        if($request->ajax())
        {
            if(permission('sale-add'))
            {
                DB::beginTransaction();
                try {
                    $sale_data = [
                        'sale_no'     => 'SINV-'.date('Ymd').'-'.date('His'),
                        'customer_id'     => $request->customer_id,
                        'warehouse_id'    => $request->warehouse_id,
                        'item'            => $request->item,
                        'total_qty'       => $request->total_qty,
                        'total_discount'  => $request->total_discount,
                        'total_tax'       => $request->total_tax,
                        'total_price'      => $request->total_price,
                        'order_tax_rate'  => $request->order_tax_rate,
                        'order_tax'       => $request->order_tax,
                        'order_discount'  => $request->order_discount ? $request->order_discount : 0,
                        'shipping_cost'   => $request->shipping_cost ? $request->shipping_cost : 0,
                        'grand_total'     => $request->grand_total,
                        'sale_status' => $request->sale_status,
                        'payment_status'  => 2,
                        'note'            => $request->note,
                        'created_by'      => auth()->user()->name
                    ];

                    if($request->sale_status == 1 && $request->payment_status != 3)
                    {
                        $sale_data['paid_amount']     = $request->paid_amount;
                        $sale_data['payment_status']     = $request->payment_status;
                    }else{
                        $sale_data['paid_amount']     = 0;
                        $sale_data['payment_status']     = 3; //Due
                    }
            
                    if($request->hasFile('document')){
                        $sale_data['document'] = $this->upload_file($request->file('document'),SALE_DOCUMENT_PATH);
                    }

                    $products = [];
                    if($request->has('products'))
                    {
                        foreach ($request->products as $key => $value) {
                            $unit = Unit::where('unit_name',$value['unit'])->first();
                            if($unit->operator == '*'){
                                $qty = $value['qty'] * $unit->operation_value;
                            }else{
                                $qty = $value['qty'] / $unit->operation_value;
                            }

                            $products[$value['id']] = [
                                'qty'           => $value['qty'],
                                'sale_unit_id'  => $unit ? $unit->id : null,
                                'net_unit_price' => $value['net_unit_price'],
                                'discount'      => $value['discount'],
                                'tax_rate'      => $value['tax_rate'],
                                'tax'           => $value['tax'],
                                'total'         => $value['subtotal']
                            ];

                            $product = Product::find($value['id']);
                            $product->qty -= $qty;
                            $product->save();

                            $warehouse_product = WarehouseProduct::where(['warehouse_id'=>$request->warehouse_id,'product_id'=>$value['id']])->first();
                            if($warehouse_product){
                                $warehouse_product->qty -= $qty;
                                $warehouse_product->save();
                            }
                        }
                    }

                    $sale = $this->model->create($sale_data);
                    $saleData = $this->model->with('sale_products')->find($sale->id);
                    $saleData->sale_products()->sync($products);
                    if($request->sale_status == 1 && $request->payment_status != 3)
                    {
                        if($request->paid_amount > 0)
                        {
                            $payment_data = [
                                'account_id' => $request->account_id,
                                'sale_id' => $sale->id,
                                'amount' => $request->paid_amount,
                                'change' => $request->change_amount,
                                'payment_method' => $request->payment_method,
                                'payment_no' => $request->payment_method != 1 ? $request->payment_no : null,
                            ];
                            Payment::create($payment_data);
                        }
                        
                    }
                    $output = $sale ? ['status' => 'success','message' => 'Data saved successfully'] : ['status' => 'error','message' => 'Data failed to save'];
                    DB::commit();
                } catch (Exception $e) {
                    DB::rollBack();
                    $output = ['status'=>'error','message'=>$e->getMessage()];
                }
                return response()->json($output);
            }
        }else{
            return response()->json($this->access_blocked());
        }
    }

    public function edit(int $id)
    {
        if(permission('sale-edit')){
            $this->setPageData('Edit Sale','Edit Sale','fas fa-edit');
            $data = [
                'sale'=> $this->model->with('sale_products')->findOrFail($id),
                'customers'  => Customer::where('status',1)->get(),
                'warehouses' => Warehouse::where('status',1)->get(),
                'taxes'      => Tax::where('status',1)->get(),
            ];
            return view('sale::edit',$data);
        }else{
            return $this->unauthorized_access_blocked();
        }
    }



    public function update(SaleFormRequst $request)
    {
        if($request->ajax())
        {
            if(permission('sale-edit'))
            {
                DB::beginTransaction();
                try {
                    $sale_data = [
                        'customer_id'     => $request->customer_id,
                        'warehouse_id'    => $request->warehouse_id,
                        'item'            => $request->item,
                        'total_qty'       => $request->total_qty,
                        'total_discount'  => $request->total_discount,
                        'total_tax'       => $request->total_tax,
                        'total_price'      => $request->total_price,
                        'order_tax_rate'  => $request->order_tax_rate,
                        'order_tax'       => $request->order_tax,
                        'order_discount'  => $request->order_discount ? $request->order_discount : 0,
                        'shipping_cost'   => $request->shipping_cost ? $request->shipping_cost : 0,
                        'grand_total'     => $request->grand_total,
                        'sale_status'     => $request->sale_status,
                        'note'            => $request->note,
                        'updated_by'      => auth()->user()->name
                    ];
            
                    if($request->hasFile('document')){
                        $sale_data['document'] = $this->upload_file($request->file('document'),SALE_DOCUMENT_PATH);
                    }
                    $saleData = $this->model->with('sale_products')->find($request->sale_id);
                    $old_document = $saleData ? $saleData->document : '';

                    if(!$saleData->sale_products->isEmpty())
                    {
                        foreach ($saleData->sale_products as  $sale_product) {
                            $old_sold_qty = $sale_product->pivot->qty;
                            $sale_unit = Unit::find($sale_product->pivot->sale_unit_id);
                            if($sale_unit->operator == '*'){
                                $old_sold_qty = $old_sold_qty * $sale_unit->operation_value;
                            }else{
                                $old_sold_qty = $old_sold_qty / $sale_unit->operation_value;
                            }
                            $product_data = Product::find($sale_product->id);
                            $product_data->qty += $old_sold_qty;
                            $product_data->update();

                            $warehouse_product = WarehouseProduct::where([
                                'warehouse_id'=>$saleData->warehouse_id,
                                'product_id'=>$sale_product->id])->first();
                            $warehouse_product->qty += $old_sold_qty;
                            $warehouse_product->update();
                        }
                    }



                    $products = [];
                    if($request->has('products'))
                    {
                        foreach ($request->products as $key => $value) {
                            $unit = Unit::where('unit_name',$value['unit'])->first();
                            if($unit->operator == '*'){
                                $qty = $value['qty'] * $unit->operation_value;
                            }else{
                                $qty = $value['qty'] / $unit->operation_value;
                            }

                            $products[$value['id']] = [
                                'qty'           => $value['qty'],
                                'sale_unit_id'  => $unit ? $unit->id : null,
                                'net_unit_price' => $value['net_unit_price'],
                                'discount'      => $value['discount'],
                                'tax_rate'      => $value['tax_rate'],
                                'tax'           => $value['tax'],
                                'total'         => $value['subtotal']
                            ];

                            $product = Product::find($value['id']);
                            $product->qty -= $qty;
                            $product->save();

                            $warehouse_product = WarehouseProduct::where(['warehouse_id'=>$request->warehouse_id,'product_id'=>$value['id']])->first();
                            if($warehouse_product){
                                $warehouse_product->qty -= $qty;
                                $warehouse_product->save();
                            }
                        }
                    }

                    $sale = $saleData->update($sale_data);
                    if($sale && $old_document != '')
                    {
                        $this->delete_file($old_document,SALE_DOCUMENT_PATH);
                    }
                    $saleData->sale_products()->sync($products);
                    
                    $output = $sale ? ['status' => 'success','message' => 'Data updated successfully'] 
                    : ['status' => 'error','message' => 'Data failed to update'];
                    DB::commit();
                } catch (Exception $e) {
                    DB::rollBack();
                    $output = ['status'=>'error','message'=>$e->getMessage()];
                }
                return response()->json($output);
            }
        }else{
            return response()->json($this->access_blocked());
        }
    }

    public function show(int $id)
    {
        if(permission('sale-view')){
            $this->setPageData('Sale Details','Sale Details','fas fa-eye');
            $data = [
                'sale'=> $this->model->with('sale_products','customer')->findOrFail($id),
            ];
            return view('sale::details',$data);
        }else{
            return $this->unauthorized_access_blocked();
        }
    }

    public function delete(Request $request)
    {
        if($request->ajax())
        {
            if(permission('sale-delete'))
            {
                DB::beginTransaction();
                try {
                
                    $saleData = $this->model->with('sale_products','payments')->find($request->id);
                    $old_document = $saleData ? $saleData->document : '';

                    if(!$saleData->sale_products->isEmpty())
                    {
                        foreach ($saleData->sale_products as  $sale_product) {
                            $old_sold_qty = $sale_product->pivot->qty;
                            $sale_unit = Unit::find($sale_product->pivot->sale_unit_id);
                            if($sale_unit->operator == '*'){
                                $old_sold_qty = $old_sold_qty * $sale_unit->operation_value;
                            }else{
                                $old_sold_qty = $old_sold_qty / $sale_unit->operation_value;
                            }
                            $product_data = Product::find($sale_product->id);
                            $product_data->qty += $old_sold_qty;
                            $product_data->update();

                            $warehouse_product = WarehouseProduct::where([
                                'warehouse_id'=>$saleData->warehouse_id,
                                'product_id'=>$sale_product->id])->first();
                            $warehouse_product->qty += $old_sold_qty;
                            $warehouse_product->update();
                        }
                    }
                    if(!$saleData->sale_products->isEmpty())
                    {
                        $saleData->sale_products()->detach();
                    }
                    if(!$saleData->payments->isEmpty())
                    {
                        $saleData->payments()->delete();
                    }
                    $result = $saleData->delete();
                    if($result && $old_document != '')
                    {
                        $this->delete_file($old_document,SALE_DOCUMENT_PATH);
                    }
                    
                    $output = $result ? ['status' => 'success','message' => 'Data updated successfully'] 
                    : ['status' => 'error','message' => 'Data failed to update'];
                    DB::commit();
                } catch (Exception $e) {
                    DB::rollBack();
                    $output = ['status'=>'error','message'=>$e->getMessage()];
                }
                return response()->json($output);
            }
        }else{
            return response()->json($this->access_blocked());
        }
    }
    public function bulkDelete(Request $request)
    {
        if($request->ajax())
        {
            if(permission('sale-bulk-delete'))
            {
                DB::beginTransaction();
                try {
                
                    foreach ($request->ids as $id) {
                        $saleData = $this->model->with('sale_products','payments')->find($id);
                        $old_document = $saleData ? $saleData->document : '';

                        if(!$saleData->sale_products->isEmpty())
                        {
                            foreach ($saleData->sale_products as  $sale_product) {
                                $old_sold_qty = $sale_product->pivot->qty;
                                $sale_unit = Unit::find($sale_product->pivot->sale_unit_id);
                                if($sale_unit->operator == '*'){
                                    $old_sold_qty = $old_sold_qty * $sale_unit->operation_value;
                                }else{
                                    $old_sold_qty = $old_sold_qty / $sale_unit->operation_value;
                                }
                                $product_data = Product::find($sale_product->id);
                                $product_data->qty += $old_sold_qty;
                                $product_data->update();

                                $warehouse_product = WarehouseProduct::where([
                                    'warehouse_id'=>$saleData->warehouse_id,
                                    'product_id'=>$sale_product->id])->first();
                                $warehouse_product->qty += $old_sold_qty;
                                $warehouse_product->update();
                            }
                        }
                        if(!$saleData->sale_products->isEmpty())
                        {
                            $saleData->sale_products()->detach();
                        }
                        if(!$saleData->payments->isEmpty())
                        {
                            $saleData->payments()->delete();
                        }
                        $result = $saleData->delete();
                        if($result && $old_document != '')
                        {
                            $this->delete_file($old_document,SALE_DOCUMENT_PATH);
                        }
                    }
                    
                    $output = $result ? ['status' => 'success','message' => 'Data updated successfully'] 
                    : ['status' => 'error','message' => 'Data failed to update'];
                    DB::commit();
                } catch (Exception $e) {
                    DB::rollBack();
                    $output = ['status'=>'error','message'=>$e->getMessage()];
                }
                return response()->json($output);
            }
        }else{
            return response()->json($this->access_blocked());
        }
    }
}

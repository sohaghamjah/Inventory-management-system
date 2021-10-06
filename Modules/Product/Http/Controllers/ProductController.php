<?php

namespace Modules\Product\Http\Controllers;

use Modules\Base\Http\Controllers\BaseController;
use App\Traits\UploadAble;
use Modules\Product\Entities\Product;
use Illuminate\Http\Request;
use Keygen;
use Modules\Category\Entities\Category;
use Modules\Product\Entities\WarehouseProduct;
use Modules\Product\Http\Requests\ProductFormRequest;
use Modules\System\Entities\Brand;
use Modules\System\Entities\Tax;
use Modules\System\Entities\Unit;

class ProductController extends BaseController
{
    use UploadAble;
    
    public function __construct(Product $model)
    {
        $this->model = $model;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if(permission('product-access')){
            $this -> setPageData('Product', 'Product', 'fab fa-box');
            $data = [
                'brands' => Brand::toBase()->get(),
                'categories' => Category::toBase()->get(),
                'units' => Unit::toBase()->get(),
                'taxes' => Tax::toBase()->get(),
            ];
            return view('product::index', $data);
        }else{
            return $this->unauthorizedAccessBlocked();
        }
    }

    /**
     * getDataTableData function
     *
     * @param Request $request
     * @return void
     */
    public function getDataTableData(Request $request){
        if(permission('product-access')){
             if($request -> ajax()){
                             // Filter datatable
            if(!empty($request->name)){
                $this->model->setName($request->name);
            }
            if(!empty($request->code)){
                $this->model->setCode($request->code);
            }
            if(!empty($request->brand_id)){
                $this->model->setBrandId($request->brand_id);
            }
            if(!empty($request->category_id)){
                $this->model->setCategoryId($request->category_id);
            }

            // Show uer list
            $this->setDatatableDefalutlProperty($request);

            $list = $this->model->getDataTableList();

            $data = [];
            $no = $request->input('start');
            foreach ($list as $value) {
                $no++;
                $action = '';
                if(permission('product-edit')){
                     $action .= ' <a style="cursor: pointer" class="dropdown-item edit_data" data-id="'.$value->id.'"><i class="fas fa-edit text-primary"></i> Edit</a>';
                }
                if(permission('product-show')){
                     $action .= ' <a style="cursor: pointer" class="dropdown-item view_data" data-id="'.$value->id.'"><i class="fas fa-eye text-success"></i> View</a>';
                }
                if(permission('product-delete')){
                    $action .= ' <a style="cursor: pointer" class="dropdown-item delete_data" data-name="'.$value->name.'" data-id="'.$value->id.'"><i class="fas fa-trash text-danger"></i> Delete</a>';
                }
                $row = [];
                if(permission('product-bulk-delete')){
                    $row [] = tableCheckBox($value->id);
                }
  
                $row []    = $no;
                $row []    = tableImage($value->image,PRODUCT_IMAGE_PATH,$value->name);
                $row []    = $value->name;
                $row []    = $value->code; 
                $row []    = $value->brand->name;
                $row []    = $value->category->name;
                $row []    = $value->unit->unit_name;
                $row []    = number_format($value->cost, 2);
                $row []    = number_format($value->price, 2);
                $row []    = $value->qty;
                $row []    = $value->alert_qty ? $value->alert_qty : 0;
                $row []    = $value->tax->name;
                $row []    = TAX_METHOD[$value->tax_method];
                $row []    = permission('product-edit') ? changeStatus($value->id,$value->status,$value->name) : STATUS_LABEL[$value->status];
                $row []    = actionButton ($action);
                $data[]    = $row;
            }
            return $this->datatableDraw($request->input('draw'), $this->model-> countFilter(), $this->model-> countAll(), $data);
             }else{
                 $output = $this->accessBlocked();
             }
             return response()->json($output);
        }
    }

    /**
     * storeOrUppdate function
     *
     * @param  $request
     * @return void
     */

    public function storeOrUpdate(ProductFormRequest $request){
        if($request->ajax()){
            if(permission('product-add') || permission('product-edit')){
                $collection = collect($request->validated())->except('image','created_by','updated_by','qty','alert_qty');
                $qty = $request->qty ? $request->qty : null;
                $alert_qty = $request->alert_qty ? $request->alert_qty : null;

                $collection = $this->trackData($collection,$request->update_id);

                $image = $request->old_image;
                if($request -> hasFile('image')){
                    $image = $this->uploadFile($request->file('image'), PRODUCT_IMAGE_PATH);
                    if(!empty($request -> old_image)){
                        $this->deleteFile($request->old_image, PRODUCT_IMAGE_PATH);
                    }
                }

                $collection =$collection->merge(compact('image','qty','alert_qty'));

                $result = $this->model->updateOrCreate(['id' => $request->update_id], $collection->all());
                $output = $this->storeMessage($result, $request->update_id);
            }else{
                return $this->accessBlocked();
            }
            return response() -> json($output);
        }else{
            return response() -> json($this->accessBlocked());
        }
    }
    /**
     * Edit function
     *
     * @param Request $request
     * @return void
     */
    public function edit(Request $request){
        if($request->ajax()){
            if(permission('product-edit')){
                $data = $this->model->findOrFail($request->id);
                $output = $this->dataMessage($data);
            }else{
                return $this->accessBlocked();
            }
            return response() -> json($output);
        }else{
            return response() -> json($this->accessBlocked());
        }
    }

    /**
     * View data
     */
    public function show(Request $request){
        if($request->ajax()){
            if(permission('product-show')){
                $product = $this->model->with('brand','category','unit','purchaseUnit','saleUnit','tax')->findOrFail($request->id);
                return view('product::details', compact('product')) -> render();
            }
        } 
    }

    /**
     * delete function
     *
     * @param Request $request
     * @return void
     */
    public function delete(Request $request){
        if($request->ajax()){
            if(permission('product-delete')){
               $product = $this->model->find($request->id);
               $image = $product->image;
               $result = $product->delete();
               if($result){
                    if(!empty($image)){
                        $this->deleteFile($image, PRODUCT_IMAGE_PATH);
                    }
               }
               $output = $this->deleteMessage($result);
            }else{
                return $this->accessBlocked();
            }
            return response() -> json($output);
        }else{
            return response() -> json($this->accessBlocked());
        }
    }

    public function bulkDelete(Request $request){
        if($request->ajax()){
            if(permission('product-bulk-delete')){
                $products = $this->model->toBase()->select('image')->whereIn('id', $request->ids)->get();
                $result = $this->model->destroy($request->ids);

                if($result){
                    if(!empty($products)){
                        foreach($products as $product){
                            if($product->image != null){
                                $this->deleteFile($product->image, PRODUCT_IMAGE_PATH);
                            }
                        }
                    }
                }

                $output = $this->bulkDeleteMessage($result);
            }else{
                return $this->accessBlocked();
            }
            return response() -> json($output);
        }else{
            return response() -> json($this->accessBlocked());
        }
    }

    public function changeStatus(Request $request){
        if($request->ajax()){
            if(permission('product-edit')){
                $result = $this->model->find($request->id)->update(['status' => $request->status]);
                $output = $result ? ['status' => 'success', 'message' => 'Status has been updated successfully'] : ['status' => 'error', 'message' => 'Faield to updated sataus'];
            }else{
                return $this->accessBlocked();
            }
            return response() -> json($output);
        }else{
            return response() -> json($this->accessBlocked());
        }
    }

    public function generateCode(){
        return Keygen::numeric(8)->generate();
    }

    public function populateUnit($id){
        $units = Unit::where('base_unit',$id)->orWhere('id',$id)->pluck('unit_name','id');
        return response()->json($units);
    }

    // Product autocomplete search

    public function productAutoComplete(Request $request){
        if($request->ajax())
        {
            if(!empty($request->search))
            {
                if(!$request->has('warehouse_id')){
                    $output = [];
                    $data = $this->model->where('name','like','%'.$request->search.'%')
                                    ->orWhere('code','like','%'.$request->search.'%')
                                    ->get();
                    if(!$data->isEmpty())
                    {
                        foreach ($data as $value) {
                            $item['value'] = $value->code.' - '.$value->name;
                            $item['label'] = $value->code.' - '.$value->name;
                            $item['id'] = $value->id;
                            $output[] = $item;
                        }
                    }else{
                        $output['value'] = '';
                        $output['label'] = 'No Records Found';
                    }
                }else{
                    $search_text = $request->search;
                    $data = WarehouseProduct::with('product')->where([
                       [ 'warehouse_id', $request->warehouse_id],['qty','>',0]
                    ])->whereHas('product',function($q) use ($search_text){
                        $q->where('name','like','%'.$search_text.'%')
                        ->orWhere('code','like','%'.$search_text.'%');
                    })->get();
                    
                    if(!$data->isEmpty())
                    {
                        foreach ($data as $key => $value) {
                            $item['id'] = $value->product->id;
                            $item['value'] = $value->product->code.' - '.$value->product->name;
                            $item['label'] = $value->product->code.' - '.$value->product->name;
                            $output[] = $item;
                        }
                    }else{
                        $output['value'] = '';
                        $output['label'] = 'No Record Found';
                    }
                }
                
                return $output;
            }
        }
    }

    // Product search 

    public function productSearch(Request $request){
        if($request->ajax()){
            $code = explode('-', $request['data']);
            $product_data = $this->model->with('tax')->where('code', $code[0])->first();

            $product['id']         = $product_data->id;
            $product['name']       = $product_data->name;
            $product['code']       = $product_data->code;
            if($request->type == 'purchase'){
                $product['cost']       = $product_data->cost;
            }else{
                $product['price']       = $product_data->price;
            }
            $product['tax_rate']   = $product_data->tax->rate;
            $product['tax_name']   = $product_data->tax->name;
            $product['tax_method'] = $product_data->tax_method;

            if($request->type == 'sale'){
                $warehouse_product = WarehouseProduct::where([
                    'warehouse_id'=>$request->warehouse_id,'product_id'=>$product_data->id])->first();
                $product['qty'] = $warehouse_product ? $warehouse_product->qty : 0;
            }

            $units = Unit::where('base_unit',$product_data->unit_id)->orWhere('id',$product_data->unit_id)->get();

            $unit_name            = [];
            $unit_operator        = [];
            $unit_operation_value = [];
            if($units){
                foreach ($units as $unit) {
                    if($request->type == 'purchase'){
                        if($product_data->purchase_unit_id == $unit->id)
                        {
                            array_unshift($unit_name,$unit->unit_name);
                            array_unshift($unit_operator,$unit->operator);
                            array_unshift($unit_operation_value,$unit->operation_value);
                        }else{
                            $unit_name           [] = $unit->unit_name;
                            $unit_operator       [] = $unit->operator;
                            $unit_operation_value[] = $unit->operation_value;
                        }
                    }else{ 
                        if($product_data->sale_unit_id == $unit->id)
                        {
                            array_unshift($unit_name,$unit->unit_name);
                            array_unshift($unit_operator,$unit->operator);
                            array_unshift($unit_operation_value,$unit->operation_value);
                        }else{
                            $unit_name           [] = $unit->unit_name;
                            $unit_operator       [] = $unit->operator;
                            $unit_operation_value[] = $unit->operation_value;
                        }
                    }        
                }
            }

            $product['unit_name']            = implode(',',$unit_name).',';
            $product['unit_operator']        = implode(',',$unit_operator).',';
            $product['unit_operation_value'] = implode(',',$unit_operation_value).',';
            return $product;
        }
    }
}

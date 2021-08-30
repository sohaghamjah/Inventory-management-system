<?php

namespace Modules\Supplier\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Supplier\Entities\Supplier;
use Modules\Supplier\Http\Requests\SupplierFormRequest;

class SupplierController extends BaseController
{
    public function __construct(Supplier $model)
    {
        $this->model = $model;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if(permission('supplier-access')){
            $this -> setPageData('Supplier', 'Supplier', 'fas fa-user-tie');
            return view('supplier::index');
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
        if(permission('supplier-access')){
             if($request -> ajax()){
                             // Filter datatable
            if(!empty($request->name)){
                $this->model->setName($request->name);
            }
            if(!empty($request->phone)){
                $this->model->setPhone($request->phone);
            }
            if(!empty($request->email)){
                $this->model->setEmail($request->email);
            }

            // Show uer list
            $this->setDatatableDefalutlProperty($request);

            $list = $this->model->getDataTableList();

            $data = [];
            $no = $request->input('start');
            foreach ($list as $value) {
                $no++;
                $action = '';
                if(permission('supplier-edit')){
                     $action .= ' <a style="cursor: pointer" class="dropdown-item edit_data" data-id="'.$value->id.'"><i class="fas fa-edit text-primary"></i> Edit</a>';
                }
                if(permission('supplier-show')){
                     $action .= ' <a style="cursor: pointer" class="dropdown-item view_data" data-id="'.$value->id.'"><i class="fas fa-eye text-success"></i> View</a>';
                }
                if(permission('supplier-delete')){
                    $action .= ' <a style="cursor: pointer" class="dropdown-item delete_data" data-name="'.$value->name.'" data-id="'.$value->id.'"><i class="fas fa-trash text-danger"></i> Delete</a>';
                }
                $row = [];
                if(permission('supplier-bulk-delete')){
                    $row [] = tableCheckBox($value->id);
                }
                $row []    = $no;
                $row []    = $value->name;
                $row []    = $value->phone;
                $row []    = $value->company_name;
                $row []    = $value->vat_number;
                $row []    = $value->email;
                $row []    = $value->address;
                $row []    = $value->city;
                $row []    = $value->state;
                $row []    = $value->postal_code;
                $row []    = $value->country;
                $row []    = permission('supplier-edit') ? changeStatus($value->id,$value->status,$value->name) : STATUS_LABEL[$value->status];
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

    public function storeOrUpdate(SupplierFormRequest $request){
        if($request->ajax()){
            if(permission('supplier-add') || permission('supplier-edit')){
                $collection = collect($request->validated());
                $collection = $this->trackData($collection,$request->update_id);
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
            if(permission('supplier-add')){
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
            if(permission('supplier-show')){
                $supplier = $this->model->findOrFail($request->id);
                return view('supplier::details', compact('supplier')) -> render();
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
            if(permission('supplier-delete')){
               $result = $this->model->find($request->id)->delete();
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
            if(permission('supplier-bulk-delete')){
                $result = $this->model->destroy($request->ids);
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
            if(permission('supplier-edit')){
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
}

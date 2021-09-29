<?php

namespace Modules\System\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Base\Http\Controllers\BaseController;
use Modules\System\Entities\Unit;
use Modules\System\Http\Requests\UnitFormRequst;

class UnitController extends BaseController
{
    public function __construct(Unit $model)
    {
        $this->model = $model;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if(permission('unit-access')){
            $this -> setPageData('Unit', 'Unit', 'fas fa-weight-hanging');
            return view('system::unit.index');
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
        if(permission('unit-access')){
             if($request -> ajax()){
                             // Filter datatable
            if(!empty($request->unit_name)){
                $this->model->setUnitName($request->unit_name);
            }

            // Show uer list
            $this->setDatatableDefalutlProperty($request);

            $list = $this->model->getDataTableList();

            $data = [];
            $no = $request->input('start');
            foreach ($list as $value) {
                $no++;
                $action = '';
                if(permission('unit-edit')){
                     $action .= ' <a style="cursor: pointer" class="dropdown-item edit_data" data-id="'.$value->id.'"><i class="fas fa-edit text-primary"></i> Edit</a>';
                }
                if(permission('unit-delete')){
                    $action .= ' <a style="cursor: pointer" class="dropdown-item delete_data" data-name="'.$value->unit_name.'" data-id="'.$value->id.'"><i class="fas fa-trash text-danger"></i> Delete</a>';
                }
                $row = [];
                if(permission('unit-bulk-delete')){
                    $row [] = tableCheckBox($value->id);
                }
                $row []    = $no;
                $row []    = $value->unit_name;
                $row []    = $value->unit_code;
                $row []    = $value->baseUnit->unit_name;
                $row []    = $value->operator;
                $row []    = $value->operation_value;
                $row []    = permission('unit-edit') ? changeStatus($value->id,$value->status,$value->group_name) : STATUS_LABEL[$value->status];
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

    public function storeOrUpdate(UnitFormRequst $request){
        if($request->ajax()){
            if(permission('unit-add') || permission('unit-edit')){
                $collection = collect($request->validated())->except('operator','operation_value');
                $base_unit = $request->base_unit ? $request->base_unit : null;
                $operator = $request->operator ? $request->operator : null;
                $operation_value = $request->operation_value ? $request->operation_value : null;
                $collection = $collection->merge(compact('base_unit','operator','operation_value'));
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
            if(permission('unit-edit')){
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
     * delete function
     *
     * @param Request $request
     * @return void
     */
    public function delete(Request $request){
        if($request->ajax()){
            if(permission('unit-delete')){
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
            if(permission('unit-bulk-delete')){
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
            if(permission('unit-edit')){
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

    public function baseUnit(Request $request){
        if($request->ajax()){
            $units = $this->model->where(['base_unit'=>null,'status'=>1])->get();
            $output = '';
            $output = "<option value=''>Select Please</option>";
            if (!$units->isEmpty()){
                foreach($units as $unit){
                   $output .= '<option value="'.$unit->id.'">'.$unit->unit_name." (".$unit->unit_code.")" .'</option>';
                }
            }
            return $output;
        }
    }
}

<?php

namespace Modules\Category\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Category\Entities\Category;
use Modules\Category\Http\Requests\CategoryFormRequest;

class CategoryController extends BaseController
{
    public function __construct(Category $model)
    {
        $this->model = $model;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if(permission('category-access')){
            $this -> setPageData('Menu', 'Menu', 'fas fa-th-list');
            return view('category::index');
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
        if(permission('category-access')){
             if($request -> ajax()){
                             // Filter datatable
            if(!empty($request->name)){
                $this->model->setName($request->name);
            }

            // Show uer list
            $this->setDatatableDefalutlProperty($request);

            $list = $this->model->getDataTableList();

            $data = [];
            $no = $request->input('start');
            foreach ($list as $value) {
                $no++;
                $action = '';
                if(permission('category-edit')){
                     $action .= ' <a style="cursor: pointer" class="dropdown-item edit_data" data-id="'.$value->id.'"><i class="fas fa-edit text-primary"></i> Edit</a>';
                }
                if(permission('category-delete')){
                    $action .= ' <a style="cursor: pointer" class="dropdown-item delete_data" data-name="'.$value->name.'" data-id="'.$value->id.'"><i class="fas fa-trash text-danger"></i> Delete</a>';
                }
                $row = [];
                if(permission('category-bulk-delete')){
                    $row [] = tableCheckBox($value->id);
                }
                $row []    = $no;
                $row []    = $value->name;
                $row []    = permission('category-edit') ? changeStatus($value->id,$value->status,$value->name) : STATUS_LABEL[$value->status];
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

    public function storeOrUpdate(CategoryFormRequest $request){
        if($request->ajax()){
            if(permission('category-add') || permission('category-edit')){
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
            if(permission('category-add')){
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
            if(permission('category-delete')){
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
            if(permission('category-bulk-delete')){
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
            if(permission('category-edit')){
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

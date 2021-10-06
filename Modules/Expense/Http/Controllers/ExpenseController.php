<?php

namespace Modules\Expense\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Expense\Entities\Expense;
use Modules\Expense\Entities\ExpenseCategory;
use Modules\System\Entities\Warehouse;
use Modules\Account\Entities\Account;
use Modules\Expense\Http\Requests\ExpenseFormRequest;

class ExpenseController extends BaseController
{
    public function __construct(Expense $model)
    {
        $this->model = $model;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if(permission('expense-access')){
            $this -> setPageData('Expense', 'Expense', 'fas fa-credit-card');
            $data = [
                'categories' => ExpenseCategory::where('status',1)->get(),
                'warehouses' => Warehouse::where('status',1)->get(),
                'accounts' => Account::where('status',1)->get(),
            ];
            return view('expense::index', $data);
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
        if(permission('expense-access')){
            if($request -> ajax()){
                // Filter datatable
                if (!empty($request->expense_category_id)) {
                    $this->model->setCategoryID($request->expense_category_id);
                }
                if (!empty($request->warehouse_id)) {
                    $this->model->setWarehouseID($request->warehouse_id);
                }
                if (!empty($request->account_id)) {
                    $this->model->setAccountID($request->account_id);
                }

                // Show uer list
                $this->setDatatableDefalutlProperty($request);

                $list = $this->model->getDataTableList();

                $data = [];
                $no = $request->input('start');
                foreach ($list as $value) {
                    $no++;
                    $action = '';
                    if(permission('expense-edit')){
                        $action .= ' <a style="cursor: pointer" class="dropdown-item edit_data" data-id="'.$value->id.'"><i class="fas fa-edit text-primary"></i> Edit</a>';
                    }
                    if(permission('expense-delete')){
                        $action .= ' <a style="cursor: pointer" class="dropdown-item delete_data" data-name="" data-id="'.$value->id.'"><i class="fas fa-trash text-danger"></i> Delete</a>';
                    }
                    $row = [];
                    if(permission('expense-bulk-delete')){
                        $row [] = tableCheckBox($value->id);
                    }
                    $row []    = $no;
                    $row []    = $value->category->name;
                    $row []    = $value->warehouse->name;
                    $row []    = $value->account->name;
                    $row []    = number_format($value->amount, 2);
                    $row []    = $value->note;
                    $row []    = permission('expense-edit') ? changeStatus($value->id,$value->status,$value->name) : STATUS_LABEL[$value->status];
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

    public function storeOrUpdate(ExpenseFormRequest $request){
        if($request->ajax()){
            if(permission('expense-add') || permission('expense-edit')){
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
            if(permission('expense-add')){
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
            if(permission('expense-delete')){
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
            if(permission('expense-bulk-delete')){
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
            if(permission('expense-edit')){
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

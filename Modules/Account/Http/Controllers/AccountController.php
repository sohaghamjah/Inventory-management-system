<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Account\Entities\Account;
use Modules\Account\Http\Requests\AccountFormRequest;
use Modules\Base\Http\Controllers\BaseController;

class AccountController extends BaseController
{
    public function __construct(Account $model)
    {
        $this->model = $model;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if(permission('account-access')){
            $this -> setPageData('Account', 'Account', 'fas fa-money-check-alt');
            return view('account::index');
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
        if(permission('account-access')){
             if($request -> ajax()){
                             // Filter datatable
            if(!empty($request->account_no)){
                $this->model->setAccountNo($request->account_no);
            }
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
                if(permission('account-edit')){
                     $action .= ' <a style="cursor: pointer" class="dropdown-item edit_data" data-id="'.$value->id.'"><i class="fas fa-edit text-primary"></i> Edit</a>';
                }
                if(permission('account-delete')){
                    $action .= ' <a style="cursor: pointer" class="dropdown-item delete_data" data-name="'.$value->name.'" data-id="'.$value->id.'"><i class="fas fa-trash text-danger"></i> Delete</a>';
                }
                $row = [];
                if(permission('account-bulk-delete')){
                    $row [] = tableCheckBox($value->id);
                }
                $row  [] = $no;
                $row  [] = $value->account_no;
                $row  [] = $value->name;
                $row  [] = $value->initial_balance ? number_format($value->initial_balance,2) : 0;
                $row  [] = $value->note;
                $row  [] = permission('account-edit') ? changeStatus($value->id,$value->status,$value->name) : STATUS_LABEL[$value->status];
                $row  [] = actionButton ($action);
                $data [] = $row;
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

    public function storeOrUpdate(AccountFormRequest $request){
        if($request->ajax()){
            if(permission('account-add') || permission('account-edit')){
                $collection = collect($request->validated());
                $initial_balance = $request->initial_balance ? $request->initial_balance : 0;
                $collection = $collection->merge(compact('initial_balance'));
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
            if(permission('account-add')){
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
            if(permission('account-delete')){
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
            if(permission('account-bulk-delete')){
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
            if(permission('account-edit')){
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

    public function balanceSheet()
    {
        if(permission('balance-sheet-access')){
            $this -> setPageData('Balance Sheet', 'Balance Sheet', 'fas fa-money-check-alt');
            return view('account::balance_sheet');
        }else{
            return $this->unauthorizedAccessBlocked();
        }
       
    }
}

<?php

namespace Modules\HRM\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Account\Entities\Account;
use Modules\Base\Http\Controllers\BaseController;
use Modules\HRM\Entities\Employee;
use Modules\HRM\Entities\Payroll;
use Modules\HRM\Http\Requests\PayrollFormRrequest;

class PayrollController extends BaseController
{
    public function __construct(Payroll $model)
    {
        $this->model = $model;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if(permission('payroll-access')){
            $this -> setPageData('Payroll', 'Payroll', 'fas fa-money-bill-alt');
            $employees = Employee::where('status',1)->get();
            $accounts = Account::where('status',1)->get();
            return view('hrm::payroll.index', compact('employees','accounts'));
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
        if(permission('payroll-access')){
             if($request -> ajax()){
                             // Filter datatable
            if(!empty($request->account_id)){
                $this->model->setAccountID($request->account_id);
            }
            if(!empty($request->employee_id)){
                $this->model->setEmployeeID($request->employee_id);
            }
            if(!empty($request->from_date)){
                $this->model->setFromDate($request->from_date);
            }
            if(!empty($request->to_date)){
                $this->model->setToDate($request->to_date);
            }

            // Show uer list
            $this->setDatatableDefalutlProperty($request);

            $list = $this->model->getDataTableList();

            $data = [];
            $no = $request->input('start');
            foreach ($list as $value) {
                $no++;
                $action = '';
                if(permission('payroll-edit')){
                     $action .= ' <a style="cursor: pointer" class="dropdown-item edit_data" data-id="'.$value->id.'"><i class="fas fa-edit text-primary"></i> Edit</a>';
                }
                if(permission('payroll-delete')){
                    $action .= ' <a style="cursor: pointer" class="dropdown-item delete_data" data-name="'.$value->name.'" data-id="'.$value->id.'"><i class="fas fa-trash text-danger"></i> Delete</a>';
                }
                $row = [];
                if(permission('payroll-bulk-delete')){
                    $row [] = tableCheckBox($value->id);
                }
                $row []    = $no;
                $row []    = $value->employee->name;
                $row []    = $value->account->name;
                $row []    = number_format($value->amount,2);
                $row []    = PAYROLL_PAYMENT_METHOD[$value->payment_method];
                $row []    = date('d F, Y', strtotime($value->created_at));
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

    public function storeOrUpdate(PayrollFormRrequest $request){
        if($request->ajax()){
            if(permission('payroll-add') || permission('payroll-edit')){
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
            if(permission('payroll-add')){
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
            if(permission('payroll-delete')){
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
            if(permission('payroll-bulk-delete')){
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
}

<?php

namespace Modules\HRM\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Base\Http\Controllers\BaseController;
use Modules\HRM\Entities\Attendance;
use Modules\HRM\Entities\Employee;
use Modules\HRM\Http\Requests\AttendanceFormRequest;
use Modules\System\Entities\HRMSetting;

class AttendanceController extends BaseController
{
    public function __construct(Attendance $model)
    {
        $this->model = $model;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if(permission('attendance-access')){
            $this -> setPageData('Attendance', 'Attendance', 'fas fa-business-time');
            $employees = Employee::where('status',1)->get();
            return view('hrm::attendance.index', compact('employees'));
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
        if(permission('attendance-access')){
             if($request -> ajax()){
                             // Filter datatable
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
                if(permission('attendance-edit')){
                     $action .= ' <a style="cursor: pointer" class="dropdown-item edit_data" data-id="'.$value->id.'"><i class="fas fa-edit text-primary"></i> Edit</a>';
                }
                if(permission('attendance-delete')){
                    $action .= ' <a style="cursor: pointer" class="dropdown-item delete_data" data-name="'.$value->name.'" data-id="'.$value->id.'"><i class="fas fa-trash text-danger"></i> Delete</a>';
                }
                $row = [];
                if(permission('attendance-bulk-delete')){
                    $row [] = tableCheckBox($value->id);
                }
                $row []    = $no;
                $row []    = $value->employee->name;
                $row []    = $value->check_in;
                $row []    = $value->check_out;
                $row []    = date('d-M-Y',strtotime($value->date));
                $row []    = ATTENDANCE_STATUS_LABEL[$value->status];
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

    public function storeOrUpdate(AttendanceFormRequest $request){
        if($request->ajax()){
            if(permission('attendance-add') || permission('attendance-edit')){
                $hrm_setting = HRMSetting::latest()->first();
                $attendance = $this->model->where(['employee_id'=>$request->employee_id,'date'=>$request->date])->first();
                if($hrm_setting)
                {
                    if((strtotime($hrm_setting->check_in) - strtotime($request->check_in)) >= 0)
                    {
                        $status = 1; //Present
                    }else{
                        $status = 2; //Late
                    }
                }
                if(!$attendance)
                {
                    $collection = collect($request->validated());
                    $collection = $collection->merge(compact('status'));
                    $collection = $this->trackData($collection,$request->update_id);
                    $result = $this->model->updateOrCreate(['id' => $request->update_id], $collection->all());
                    $output = $this->storeMessage($result, $request->update_id);
                }else{
                    $attendance->check_in = $request->check_in;
                    $attendance->check_out = $request->check_out;
                    $attendance->status = $status;
                    if($attendance->update())
                    {
                        $output = ['status'=>'success','message'=>'Attendance data updated successfully'];
                    }else{
                        $output = ['status'=>'error','message'=>'Attendance data failed to update'];
                    }
                }
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
            if(permission('attendance-add')){
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
            if(permission('attendance-delete')){
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
            if(permission('attendance-bulk-delete')){
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

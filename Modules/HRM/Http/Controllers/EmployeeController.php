<?php

namespace Modules\HRM\Http\Controllers;

use App\Traits\UploadAble;
use Illuminate\Http\Request;
use Modules\Base\Http\Controllers\BaseController;
use Modules\HRM\Entities\Department;
use Modules\HRM\Entities\Employee;
use Modules\HRM\Http\Requests\EmployeeFormRequest;

class EmployeeController extends BaseController
{
    use UploadAble;
    public function __construct(Employee $model)
    {
        $this->model = $model;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if(permission('employee-access')){
            $this -> setPageData('Employee', 'Employee', 'fas fa-user');
            $departments = Department::where('status',1) -> get();
            return view('hrm::employee.index', compact('departments'));
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
        if(permission('employee-access')){
             if($request -> ajax()){
            // Filter datatable
            if(!empty($request->name)){
                $this->model->setName($request->name);
            }
            if(!empty($request->department_id)){
                $this->model->setDepartmentId($request->department_id);
            }
            if(!empty($request->phone)){
                $this->model->setPhone($request->phone);
            }

            // Show uer list
            $this->setDatatableDefalutlProperty($request);

            $list = $this->model->getDataTableList();

            $data = [];
            $no = $request->input('start');
            foreach ($list as $value) {
                $no++;
                $action = '';
                if(permission('employee-edit')){
                     $action .= ' <a style="cursor: pointer" class="dropdown-item edit_data" data-id="'.$value->id.'"><i class="fas fa-edit text-primary"></i> Edit</a>';
                }
                if(permission('employee-show')){
                     $action .= ' <a style="cursor: pointer" class="dropdown-item view_data" data-id="'.$value->id.'"><i class="fas fa-eye text-success"></i> View</a>';
                }
                if(permission('employee-delete')){
                    $action .= ' <a style="cursor: pointer" class="dropdown-item delete_data" data-name="'.$value->name.'" data-id="'.$value->id.'"><i class="fas fa-trash text-danger"></i> Delete</a>';
                }
                $row = [];
                if(permission('employee-bulk-delete')){
                    $row [] = tableCheckBox($value->id);
                }
                $row []    = $no;
                $row []    = $this->avatar($value);
                $row []    = $value->name;
                $row []    = $value->phone;
                $row []    = $value->department->name;
                $row []    = $value->address;
                $row []    = $value->city;
                $row []    = $value->state;
                $row []    = $value->postal_code;
                $row []    = $value->country;
                $row []    = permission('employee-edit') ? changeStatus($value->id,$value->status,$value->name) : STATUS_LABEL[$value->status];
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

     protected function avatar($employee){
        if($employee->image){
            return "<img src='storage/".EMPLOYEE_IMAGE_PATH.$employee->image."' style='width:50px;'/>";
        }else{
            return "<img src='images/male.svg' style='width: 50px'>";
        }
    }

    /**
     * storeOrUppdate function
     *
     * @param  $request
     * @return void
     */

    public function storeOrUpdate(EmployeeFormRequest $request){
        if($request->ajax()){
            if(permission('employee-add') || permission('employee-edit')){
                $collection = collect($request->validated())->except('image');
                $image = $request->old_image;
                if($request -> hasFile('image')){
                    $image = $this->uploadFile($request->file('image'), EMPLOYEE_IMAGE_PATH);
                    if(!empty($request -> old_image)){
                        $this->deleteFile($request->old_image, EMPLOYEE_IMAGE_PATH);
                    }
                }
                $collection = $collection->merge(compact('image'));
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
            if(permission('employee-add')){
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
            if(permission('employee-show')){
                $employee = $this->model->with('department')->findOrFail($request->id);
                return view('hrm::employee.details', compact('employee')) -> render();
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
            if(permission('employee-delete')){
               $employee = $this->model->find($request->id);
               $image = $employee -> image;
               $result = $employee->delete();
               if($result && !empty($image)){
                    $this->deleteFile($image, EMPLOYEE_IMAGE_PATH);
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
            if(permission('employee-bulk-delete')){
                $employees = $this->model->toBase()->select('image')->whereIn('id',$request->ids)->get();
                $result = $this->model->destroy($request->ids);
                if($result){
                    if(!empty($employees)){
                        foreach ($employees as $employee) {
                            if($employee->image){
                                $this->deleteFile($employee->image,EMPLOYEE_IMAGE_PATH);
                            }
                        }
                    }
                }
                $output = $this->bulkDeleteMessage($result);
            }else{
                $output = $this->accessBlocked();
            }
            return response() -> json($output);
        }else{
            return response() -> json($this->accessBlocked());
        }
    }

    public function changeStatus(Request $request){
        if($request->ajax()){
            if(permission('employee-edit')){
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

    public function groupData(int $id){
        $data = $this->model->with('customerGroup')->find($id);
        return $data ? $data->customerGroup->percentage : 0;
    }
}

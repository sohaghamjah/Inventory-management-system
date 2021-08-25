<?php
namespace App\Services;
use App\Services\BaseService;
use App\Repositories\UserRepositories as User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class UserService extends BaseService{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * getDatatableData function
     *
     * @param Request $request
     * @return void
     */
    public function getDatatableData(Request $request){
        if($request -> ajax()){

            // Filter datatable
            if(!empty($request->role_id)){
                $this->user-> setRoleId($request->role_id);
            }
            if(!empty($request->name)){
                $this->user-> setName($request->name);
            }
            if(!empty($request->email)){
                $this->user-> setEmail($request->email);
            }
            if(!empty($request->mobile)){
                $this->user-> setMobile($request->mobile);
            }
            if(!empty($request->status)){
                $this->user-> setStatus($request->status);
            }

            // Show uer list
            $this->user-> setOrderValue($request->input('order.0.column'));
            $this->user-> setDirValue($request->input('order.0.dir'));
            $this->user-> setLengthValue($request->input('length'));
            $this->user-> setStartValue($request->input('start'));

            $list = $this->user-> getDataTableList();

            $data = [];
            $no = $request->input('start');
            foreach ($list as $value) {
                $no++;
                $action = '';
                if(permission('user-edit')){
                    $action .= ' <a style="cursor: pointer" class="dropdown-item edit_data" data-id="'. $value->id.'"><i class="fas fa-edit text-primary"></i> Edit</a>';
                }
                if(permission('user-show')){
                    $action .= ' <a style="cursor: pointer" class="dropdown-item view_data" data-id="'.$value->id.'"><i class="fas fa-eye text-warning"></i> View</a>';
                }
                if(permission('user-delete')){
                    $action .= ' <a style="cursor: pointer" class="dropdown-item delete_data" data-name="'.$value->name.'" data-id="'.$value->id.'"><i class="fas fa-trash text-danger"></i> Delete</a>';
                }

                $row = [];
                if(permission('user-bulk-delete')){
                $row []    = tableCheckBox($value->id);
                }
                $row []    = $no;
                $row []    = $this->avatar($value);
                $row []    = $value->name;
                $row []    = $value->role->role_name;
                $row []    = $value->email;
                $row []    = $value->mobile;
                $row []    = GENDER[$value->gender];
                $row []    = permission('user-edit') ? changeStatus($value->id,$value->status,$value->name) : STATUS_LABEL[$value->status];
                $row []    = actionButton($action);
                $data[]    = $row;
            }
            return $this->datatableDraw($request->input('draw'), $this->user-> countFilter(), $this->user-> countAll(), $data);
        }
    }

    protected function avatar($user){
        if($user->avatar){
            return "<img src='storage/'".USER_AVATAR_PATH.$user->avatar." style='width: 50px'>";
        }else{
            return "<img src='images/".($user->gender == 1 ? 'male-persion' : 'female-persion').".jpg' style='width: 50px'>";
        }
    }

    public function storeOrUpdate(Request $request){
        $collection = collect($request->validated()) -> except(['password','password_confirmation']);
        $created_at = $updated_at = Carbon::now();
        $created_by = $modified_by = auth()->user()->name;
        if($request->update_id){
            $collection = $collection -> merge(compact('modified_by','updated_at'));
        }else{
            $collection = $collection -> merge(compact('created_by','created_at'));
        }
        if($request->password){
            $collection = $collection -> merge(['password' => $request -> password]);
        }
        return $this->user->updateOrCreate(['id' => $request->update_id], $collection->all());
    }

    public function edit(Request $request){
        return $this->user->find($request->id);
    }

    public function delete(Request $request){
        return $this->user->delete($request->id);
    }

    public function bulkDelete(Request $request){
        return $this->user->destroy($request->ids);
    }

    public function changeStatus(Request $request){
        $user = $this->user->find($request->id);
        return $user -> update(['status' => $request -> status]);
    }
}

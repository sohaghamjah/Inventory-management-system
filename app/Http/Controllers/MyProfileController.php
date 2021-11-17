<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordUpdateFormRequest;
use App\Http\Requests\ProfileUpdateFormRequest;
use App\Models\User;
use App\Traits\UploadAble;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MyProfileController extends Controller
{

    use UploadAble;
    protected function setPageData($page_title, $sub_title, $page_icon){
        view()->share(['page_title' => $page_title, 'sub_title' => $sub_title, 'page_icon' => $page_icon]);
    }

    public function index(){
        $this->setPageData("My Profile","My Profile", "fas fa-id-badge");
        return view('user.my-profile');
    }

    public function updateProfile(ProfileUpdateFormRequest $request){
        if($request->ajax()){
            $collection = collect($request->validated())->except(['email','avatar']);
            $avatar = !empty($request->old_avatar) ? $request->old_avatar : null;
            if($request->hasFile('avatar')){
                $avatar = $this->uploadFile($request->file('avatar'),USER_AVATAR_PATH);
            }
            $collection = $collection->merge(compact('avatar'));

            $result = User::find(Auth::user()->id)->update($collection->all());

            if($result){
                if($request->hasFile('avatar')){
                    $this->deleteFile($request->old_avatar, USER_AVATAR_PATH);
                }
                $output = ['status'=>'success','message'=>'Profile Data Uploaded Successfull'];
            }else{
                if($request->hasFile('avatar'))
                {
                    $this->deleteFile($avatar,USER_AVATAR_PATH);
                }
                $output = ['status'=>'error','message'=>'Failed to Update Profile Data'];
            }

            return response()->json($output);
        }
    }


    public function updatePassword(PasswordUpdateFormRequest $request)
    {
        if ($request->ajax()) {
            if (auth()->check()) {
                $user = Auth::user();
                if(!Hash::check($request->current_password, $user->password))
                {
                    $output = ['status'=>'error','message'=>'Current Password Does Not Match!'];
                }else{
                    $user->password = $request->password;
                    if($user->save()){
                        $output = ['status'=>'success','message'=>'Password Changed Successfully'];
                    }else{
                        $output = ['status'=>'error','message'=>'Failed to Change Password'];
                    }
                }
                return response()->json($output);
            }
        }
    }

    
}

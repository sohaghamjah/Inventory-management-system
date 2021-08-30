<?php

namespace Modules\Base\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class BaseController extends Controller
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * setPageData function
     *
     * @param [type] $pageTitle
     * @param [type] $subTitle
     * @param [type] $pageIcon
     * @return void
     */
    protected function setPageData($page_title, $sub_title, $page_icon){
        view()->share(['page_title' => $page_title, 'sub_title' => $sub_title, 'page_icon' => $page_icon]);
    }

    protected function setDatatableDefalutlProperty(Request $request){
        $this->model-> setOrderValue($request->input('order.0.column'));
        $this->model-> setDirValue($request->input('order.0.dir'));
        $this->model-> setLengthValue($request->input('length'));
        $this->model-> setStartValue($request->input('start'));
    }

    protected function datatableDraw($draw, $recordsTotal, $recordsFiltered, $data){
        return array(
            "draw" => $draw,
            "recordsTotal"    => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            "data"            => $data,
        );
    }

    protected function storeMessage($result, $update_id=null){
        return $result ? ['status'=>'success', 'message'=>!empty($update_id) ? 'Data has been updated successfull' : 'Data has been saved successfull'] : ['status'=>'error', 'message'=>!empty($update_id) ? 'Faild to updated data' : 'Failed to saved data'];
    }

    protected function deleteMessage($result){
        return $result ? ['status'=>'success', 'message'=>'Data has been deleted successfull'] : ['status'=>'eroor', 'message'=>'Failed to delete data'];
    }

    protected function bulkDeleteMessage($result)
    {
        return $result ? ['status'=>'success','message'=> 'Selected data has been deleted successfull']
        : ['status'=>'error','message'=> 'Failed to delete selected data'];
    }

    protected function unauthorizedAccessBlocked(){
        return redirect('unauthorized');
    }

    protected function accessBlocked()
    {
        return ['status'=>'error','message'=> 'Unauthorized access blocked'];
    }

    protected function trackData($collection,$update_id=null){
        $created_by = $updated_by =  auth()->user()->name;
        $created_at = $updated_at = Carbon::now();
        return $update_id ? $collection->merge(compact('updated_by', 'updated_at')) : $collection->merge(compact('created_by', 'created_at'));
    }

    protected function dataMessage($data){
        return $data ? $data : ['status'=>'error', 'message' => 'Data not found'];
    }
}

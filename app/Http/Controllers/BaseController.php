<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    protected $output;
    protected $service;

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

    /**
     * showErrorPage function
     *
     * @param integer $error_code
     * @param [type] $message
     * @return response
     */
    protected function showErrorPage($error_code = 404, $message = null){
        $data['message'] = $message;
        return response() -> view('errors.'.$error_code, $data, $error_code);
    }

    protected function responseJson($status='success',$message=null,$data=null,$response_code=200)
    {
        return response()->json([
            'status'        => $status,
            'message'       => $message,
            'data'          => $data,
            'response_code' => $response_code,
        ]);
    }

    protected function unauthorizedAccessBlocked(){
        return redirect('unauthorized');
    }
}

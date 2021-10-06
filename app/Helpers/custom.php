<?php
define('USER_AVATAR_PATH', 'user/');
define('LOGO_PATH', 'logo/');
define('BRAND_IMAGE_PATH', 'brand/');
define('PRODUCT_IMAGE_PATH', 'product/');
define('PURCHASE_DOCUMENT_PATH','purchase-document/');
define('DATE_FORMATE', date('d M, Y'));
define('STATUS', ['1' => 'Active', '2' => 'Inactive']);
define('PAYMENT_STATUS', ['1' => 'Paid', '2' => 'Due']);
define('PAYMENT_STATUS_LABEL', [
    '1' => '<span class="badge badge-success">Paid</span>', 
    '2' => '<span class="badge badge-danger">Due</span>'
]);
define('PURCHASE_STATUS', ['1' => 'Recived', '2' => 'Partial', '3' => 'Pending', '4' => 'Orderd']);
define('SALE_STATUS', ['1' => 'Completed', '2' => 'Pending']);
define('PURCHASE_STATUS_LABEL', [
    '1' => '<span class="badge badge-success">Recived</span>', 
    '2' => '<span class="badge badge-warning">Partial</span>',
    '3' => '<span class="badge badge-danger">Pending</span>',
    '4' => '<span class="badge badge-info">Orderd</span>',
]);
define('SALE_STATUS_LABEL', [
    '1' => '<span class="badge badge-success">Completed</span>', 
    '2' => '<span class="badge badge-warning">Pending</span>',
]);
define('GENDER', ['1' => 'Male', '2' => 'Female']);
define('TAX_METHOD', ['1' => 'Exclusive', '2' => 'Inclusive']);
define('DELETABLE',['1'=>'No','2'=>'Yes']);
define('PAYMENT_METHOD',['1'=>'Cash','2'=>'Chaque', '3' => 'Mobile']);
define('STATUS_LABEL', [
    '1' => '<span class="badge badge-success">Active</span>', 
    '2' => '<span class="badge badge-success">Inactive</span>'
]);
define('BERCODE_SYMBOLOGY', [
    'C128'   => 'Code 128',
    'C39'    => 'Code 39',
    'UPCA'   => 'UPC-A',
    'UPCE'   => 'UPC-E',
    'EANB'   => 'EAN-B',
    'EAN13'  => 'EAN-13',
]);
define('MAIL_MAILER', ['smtp','sendmail','mail']);
define('MAIL_ENCRYPTION', ['none'=>'null','tls'=>'tls','ssl'=>'ssl']);

// Permission wise page veiw 

if(!function_exists('permission')){
    function permission (string $value){
        if(collect(\Illuminate\Support\Facades\Session::get('permission'))->contains($value)){
            return true;
        }else{
            return false;
        }
    }
}

if(!function_exists('actionButton')){
    function actionButton ($action){
        return '<div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-th-list"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        '.$action.'
                    </div>
                </div>';
    }
}

if(!function_exists('tableCheckBox')){
    function tableCheckBox ($id){
        return ' <div class="custom-control custom-checkbox">
                    <input value="'.$id.'" name="did[]" class="custom-control-input select_data" onchange="selectSingleItem('.$id.')" type="checkbox" value="" id="checkBox'.$id.'">
                    <label class="custom-control-label" for="checkBox'.$id.'">
                    </label>
                </div>';
    }
}

if(!function_exists('changeStatus')){
    function changeStatus (int $id,int $status,string $name = null){
        return $status == 1 ? '<span class="badge badge-success change_status" data-status="2" data-name="'.$name.'" data-id="'.$id.'" style="cursor: pointer">Active</span>' :'<span class="badge badge-danger change_status" data-status="1" data-name="'.$name.'" data-id="'.$id.'" style="cursor: pointer">Inactive</span>';
    }
}

if(!function_exists('tableImage')){
    function tableImage ($image = null,$path,string $name = null){
        return $image ? "<img src='storage/".$path.$image."' alt='".$name."' style='width: 60px'>" : "<img src='images/default.jpg' alt='Default Image' style='width: 60px'>";
    }
}

<?php  
    if(!function_exists('asset')){
        function asset($pathFile,$isAdmin=false)
        {
            if($pathFile){
                if($isAdmin){
                    if(file_exists(PATH_PUBLIC_ADMIN.$pathFile)){
                        return PATH_PUBLIC_ADMIN.$pathFile;
                    }
                }else{
                    if(file_exists(PATH_PUBLIC.$pathFile))
                    {
                        return PATH_PUBLIC.$pathFile;
                    }
                }
            }
        }
    }
    if(!function_exists('route')){
        function route($c,$m,$param=[])
        {
            $p='';
            if(!empty($param)){
                foreach($param as $key=>$val){
                    $p.=empty($p)?"{$key}={$val}":"&{$key}={$val}";
                }
            }
            return empty($p)?APP_PATH."?c={$c}&m={$m}":APP_PATH."?c={$c}&m={$m}&{$p}";
        }
    }
    if(!function_exists('redirect')){
        function redirect($c,$m,$param=[])
        {
            $p='';
            if(!empty($param)){
                foreach($param as $key=>$val){
                    $p.=empty($p)?"{$key}={$val}":"&{$key}={$val}";
                }
            }
            $linkRedirect = empty($p) ? APP_PATH."?c={$c}&m={$m}" : APP_PATH."?c={$c}&m={$m}&{$p}";
            header("Location:".$linkRedirect);
        }
    } 
    if(!function_exists('validationBandData')){
        function validationBandData($name,$email,$tel)
        {
            $error = [];
            $error['name'] = empty($name) ? 'Vui long nhap name' : '';
            $error['email'] = empty($email) ? 'Vui long nhap email' : '';
            $error['tel'] = empty($tel) ? 'Vui long nhap tel' : '';
            return $error;
        }
    }
    if(!function_exists('validationSpData')){
        function validationSpData($name,$price,$so_luong,$ncc,$logo)
        {
            $error = [];
            $error['name'] = empty($name) ? 'Vui long nhap ten sản phẩm' : '';
            $error['price'] = empty($price) ? 'Vui long nhap giá sản phẩm' : '';
            $error['ncc'] = empty($ncc) ? 'Vui long chọn nhà cung cấp' : '';
            $error['logo'] = empty($logo) ? 'Vui long chọn ảnh' : '';
            $error['so_luong'] = empty($so_luong) ? 'Vui long nhap so luong' : '';
            return $error;
        }
    }
    if(!function_exists('isRequestAjax')){
        function isRequestAjax()
        {
            if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {    
                return true;
                // day la cac ajax request
            }
            return false;
        }
    }

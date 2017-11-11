<?php
class payset{
    function index(){
        global $_W, $_GPC;
        $payset = Setting :: wlsetting_read('payset');
        $value = unserialize($payset['value']);
        $status = unserialize($payset['status']);
        $cert = file_exists(PATH_DATA . "cert/" . $_W['uniacid'] . "/wechat/apiclient_cert.pem");
        $key = file_exists(PATH_DATA . "cert/" . $_W['uniacid'] . "/wechat/apiclient_key.pem");
        $path = is_dir(PATH_DATA . "cert/" . $_W['uniacid'] . "/wechat/")? PATH_DATA . "cert/" . $_W['uniacid'] . "/wechat/":mkdir(PATH_DATA . "cert/" . $_W['uniacid'] . "/wechat/", 0777, true);
        $message = Setting :: wlsetting_read('payset');;
        if(checksubmit('submit')){
            if(!empty($_FILES["cert"]["tmp_name"])){
                if ($_FILES["cert"]["error"] > 0){
                    wl_message("上传失败！", '', 'error');
                }else{
                    if ($cert){
                        unlink($_FILES["cert"]["name"]);
                        $r1 = move_uploaded_file($_FILES["cert"]["tmp_name"], $path . $_FILES["cert"]["name"]);
                    }else{
                        $r1 = move_uploaded_file($_FILES["cert"]["tmp_name"], $path . $_FILES["cert"]["name"]);
                    }
                }
            }
            if(!empty($_FILES["key"]["tmp_name"])){
                if ($_FILES["key"]["error"] > 0){
                    wl_message("上传失败！", '', 'error');
                }else{
                    if ($key){
                        unlink($_FILES["key"]["name"]);
                        $r2 = move_uploaded_file($_FILES["key"]["tmp_name"], $path . $_FILES["key"]["name"]);
                    }else{
                        $r2 = move_uploaded_file($_FILES["key"]["tmp_name"], $path . $_FILES["key"]["name"]);
                    }
                }
            }
            $value = $_GPC['value'];
            $p_status = $_GPC['p_status'];
            $data1['status'] = iserializer($p_status);
            $data1['value'] = iserializer($value);
            Setting :: wlsetting_save($data1, 'payset');
            message('提交成功！', '', 'success');
        }
        include wl_template('setting/payset');
    }
}

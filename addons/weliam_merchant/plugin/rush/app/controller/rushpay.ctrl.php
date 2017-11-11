<?php
 class rushpay{
    function createOrder(){
        global $_W, $_GPC;
        $id = intval($_GPC['id']);
        if(!empty($id)){
            $orderid = Rush :: createOrder($id);
            wl_message(array('errno' => 0, 'message' => $orderid));
        }else{
            wl_message(array('errno' => 1, 'message' => '缺少重要参数，请刷新重试'));
        }
    }
}

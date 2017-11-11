<?php
defined('IN_IA')or exit('Access Denied');
class hotarea{
    public function index(){
        global $_W, $_GPC;
        $addresses = pdo_getall(PDO_NAME . 'oparea', array('uniacid' => $_W['uniacid']));
        if(checksubmit()){
            $status = $_GPC['status'];
            $ishot = $_GPC['ishot'];
            foreach ($addresses as $key => $value){
                $onstatus = !empty($status[$value['id']])? 1 : 0;
                $onhot = !empty($ishot[$value['id']])? 1 : 0;
                pdo_update(PDO_NAME . 'oparea', array('status' => $onstatus, 'ishot' => $onhot), array('id' => $value['id']));
            }
            wl_message('更新地区信息成功', 'referer', 'success');
        }
        foreach ($addresses as $key => $value){
            $addresses[$key]['addressname'] = pdo_getcolumn(PDO_NAME . 'area', array('id' => $value['areaid']), 'name');
            $addresses[$key]['agentname'] = pdo_getcolumn(PDO_NAME . 'agentusers', array('id' => $value['aid']), 'agentname');
        }
        include wl_template('area/opareaAdd');
    }
}

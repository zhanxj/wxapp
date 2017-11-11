<?php
defined('IN_IA')or exit('Access Denied');
class region{
    public function select_region(){
        global $_W, $_GPC;
        $pagetitle = !empty($_W['wlsetting']['base']['name'])? '切换城市 - ' . $_W['wlsetting']['base']['name'] : '切换城市';
        $area = Area :: get_all_area();
        $maera = Area :: get_area();
        $terarea = pdo_getall(PDO_NAME . 'oparea', array('uniacid' => $_W['uniacid'], 'status' => 1, 'ishot' => 1), 'areaid');
        $terarea = Util :: i_array_column($terarea, 'areaid');
        $address_tree = array();
        foreach($terarea as $key => $val){
            $name = pdo_getcolumn(PDO_NAME . 'area', array('id' => $val), 'name');
            $address_tree[$key] = array('id' => $val, 'name' => $name);
        }
        include wl_template('area/select_region');
    }
}

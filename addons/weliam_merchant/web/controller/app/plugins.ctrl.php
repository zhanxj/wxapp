<?php
defined('IN_IA')or exit('Access Denied');
class plugins{
    public function index(){
        global $_W, $_GPC;
        $pluginsset = App :: getPlugins();
        $category = App :: getCategory();
        include wl_template('app/plugins_list');
    }
}

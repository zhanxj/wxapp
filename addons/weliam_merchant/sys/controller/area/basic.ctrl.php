<?php
defined('IN_IA')or exit('Access Denied');
class basic{
    public function index(){
        global $_W, $_GPC;
        $agents = Merchant :: sysAgentSurvey(1);
        include wl_template('area/summary');
    }
}

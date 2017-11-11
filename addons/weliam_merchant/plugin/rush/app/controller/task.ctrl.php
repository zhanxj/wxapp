<?php
 defined('IN_IA')or exit('Access Denied');
class task{
    function autoTask(){
        global $_W, $_GPC;
        Queue :: autoDealRushOrder();
        $input['time'] = date('Y-m-d H:i:s', time());
        Util :: wl_log('sinaTask', PATH_PLUGIN . 'rush/data/log/task', $input);
    }
    function autoTaskBack(){
        global $_W, $_GPC;
        $input['time'] = date('Y-m-d H:i:s', time());
        Util :: wl_log('sinaTask', PATH_PLUGIN . 'rush/data/log/taskBack', $input);
    }
    function autoTaskFail(){
        global $_W, $_GPC;
        $input['time'] = date('Y-m-d H:i:s', time());
        Util :: wl_log('sinaTask', PATH_PLUGIN . 'rush/data/log/taskFail', $input);
    }
}

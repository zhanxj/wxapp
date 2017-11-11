<?php
defined('IN_IA')or exit('Access Denied');
class sort{
    public function index(){
        global $_W;
        include wl_template('dashboard/sort');
    }
}

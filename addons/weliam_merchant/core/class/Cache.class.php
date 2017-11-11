<?php
defined('IN_IA')or exit('Access Denied');
class Cache{
    static function getDateByCacheFirst($key, $name, $funcname, $valuearray){
        $data = self :: getCache($key, $name);
        if(empty($data)){
            $data = call_user_func_array($funcname, $valuearray);
            self :: setCache($key, $name, $data);
        }
        return $data;
    }
    static function getCache($key, $name){
        global $_W;
        if(empty($key) || empty($name))return false;
        return cache_read(MODULE_NAME . ':' . $_W['uniacid'] . ':' . $key . ':' . $name);
    }
    static function setCache($key, $name, $value){
        global $_W;
        if(empty($key) || empty($name))return false;
        return cache_write(MODULE_NAME . ':' . $_W['uniacid'] . ':' . $key . ':' . $name, $value);
    }
    static function deleteCache($key, $name){
        global $_W;
        if(empty($key) || empty($name))return false;
        return cache_delete(MODULE_NAME . ':' . $_W['uniacid'] . ':' . $key . ':' . $name);
    }
    static function deleteThisModuleCache(){
        return cache_clean(MODULE_NAME);
    }
    static function setSingleLockByCache($arr, $time = 15){
        if($arr == '' || empty($arr) || $arr['single'] == 'table')return false;
        $tableCache = self :: getCache($arr['tablename'], 'table');
        if(!empty($tableCache) && $tableCache > time())return false;
        $singleCache = self :: getCache($arr['tablename'], $arr['single']);
        if(!empty($singleCache) && $singleCache > time())return false;
        return self :: setCache($arr['tablename'], $arr['single'], time() + $time);
    }
    static function setTableLockByCache($arr, $time = 15){
        if($arr == '' || empty($arr) || $arr['single'] == 'table')return false;
        $tableCache = self :: getCache($arr['tablename'], 'table');
        if(!empty($tableCache) && $tableCache > time())return false;
        return self :: setCache($arr['tablename'], 'table', time() + $time);
    }
}

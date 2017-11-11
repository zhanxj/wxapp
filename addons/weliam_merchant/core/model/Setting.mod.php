<?php
defined('IN_IA')or exit('Access Denied');
class Setting{
    static function wlsetting_load(){
        global $_W;
        $settings = Cache :: getCache('setting', 'allset');
        if (empty($settings)){
            $setting = pdo_getall(PDO_NAME . 'setting', array('uniacid' => $_W['uniacid']), array('key', 'value'));
            if (is_array($setting)){
                foreach ($setting as $k => & $v){
                    $settings[$v['key']] = iunserializer($v['value']);
                    unset($setting[$k]);
                }
            }else{
                $settings = array();
            }
            Cache :: setCache('setting', 'allset', $settings);
        }
        return $settings;
    }
    static function wlsetting_save($data, $key){
        global $_W;
        if (empty($key)){
            return FALSE;
        }
        $record = array();
        $record['value'] = iserializer($data);
        $exists = pdo_getcolumn(PDO_NAME . 'setting', array('key' => $key, 'uniacid' => $_W['uniacid']), 'id');
        if ($exists){
            $return = pdo_update(PDO_NAME . 'setting', $record, array('key' => $key, 'uniacid' => $_W['uniacid']));
        }else{
            $record['key'] = $key;
            $record['uniacid'] = $_W['uniacid'];
            $return = pdo_insert(PDO_NAME . 'setting', $record);
        }
        Cache :: deleteCache('setting', 'allset');
        return $return;
    }
    static function wlsetting_read($key){
        global $_W;
        $settings = pdo_get(PDO_NAME . 'setting', array('key' => $key, 'uniacid' => $_W['uniacid']), array('value'));
        if (is_array($settings)){
            $settings = iunserializer($settings['value']);
        }else{
            $settings = array();
        }
        return $settings;
    }
    static function agentsetting_load(){
        global $_W;
        $settings = Cache :: getCache('setting', 'allagentset');
        if (empty($settings)){
            $setting = pdo_getall(PDO_NAME . 'agentsetting', array('uniacid' => $_W['uniacid'], 'aid' => $_W['aid']), array('key', 'value'));
            if (is_array($setting)){
                foreach ($setting as $k => & $v){
                    $settings[$v['key']] = iunserializer($v['value']);
                    unset($setting[$k]);
                }
            }else{
                $settings = array();
            }
            Cache :: setCache('setting', 'allagentset', $settings);
        }
        return $settings;
    }
    static function agentsetting_save($data, $key){
        global $_W;
        if (empty($key)){
            return FALSE;
        }
        $record = array();
        $record['value'] = iserializer($data);
        $exists = pdo_getcolumn(PDO_NAME . 'agentsetting', array('key' => $key, 'uniacid' => $_W['uniacid'], 'aid' => $_W['aid']), 'id');
        if ($exists){
            $return = pdo_update(PDO_NAME . 'agentsetting', $record, array('key' => $key, 'uniacid' => $_W['uniacid'], 'aid' => $_W['aid']));
        }else{
            $record['key'] = $key;
            $record['uniacid'] = $_W['uniacid'];
            $record['aid'] = $_W['aid'];
            $return = pdo_insert(PDO_NAME . 'agentsetting', $record);
        }
        Cache :: deleteCache('setting', 'allagentset');
        return $return;
    }
    static function agentsetting_read($key){
        global $_W;
        $settings = pdo_get(PDO_NAME . 'agentsetting', array('key' => $key, 'uniacid' => $_W['uniacid'], 'aid' => $_W['aid']), array('value'));
        if (is_array($settings)){
            $settings = iunserializer($settings['value']);
        }else{
            $settings = array();
        }
        return $settings;
    }
    static function saveRule($name, $url, $arr = array()){
        global $_W;
        $rule = pdo_get('rule', array('uniacid' => $_W['uniacid'], 'module' => 'cover', 'name' => MODULE_NAME . $name . '入口设置'));
        if (!empty($rule)){
            $keyword = pdo_get('rule_keyword', array('uniacid' => $_W['uniacid'], 'rid' => $rule['id']));
            $cover = pdo_get('cover_reply', array('uniacid' => $_W['uniacid'], 'rid' => $rule['id']));
        }
        $data = $arr;
        if (empty($data['keyword']))return '请输入关键词!';
        $keyword1 = self :: keyExist($data['keyword']);
        if (!empty($keyword1)){
            if ($keyword1['name'] != (MODULE_NAME . $name . '入口设置'))return '关键字已存在!';
        }
        if (!empty($rule)){
            pdo_delete('rule', array('id' => $rule['id'], 'uniacid' => $_W['uniacid']));
            pdo_delete('rule_keyword', array('rid' => $rule['id'], 'uniacid' => $_W['uniacid']));
            pdo_delete('cover_reply', array('rid' => $rule['id'], 'uniacid' => $_W['uniacid']));
        }
        $rule_data = array('uniacid' => $_W['uniacid'], 'name' => MODULE_NAME . $name . '入口设置', 'module' => 'cover', 'displayorder' => 0, 'status' => intval($data['status']));
        pdo_insert('rule', $rule_data);
        $rid = pdo_insertid();
        $keyword_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => 'cover', 'content' => trim($data['keyword']), 'type' => 1, 'displayorder' => 0, 'status' => intval($data['status']));
        pdo_insert('rule_keyword', $keyword_data);
        $cover_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => MODULE_NAME, 'title' => trim($data['title']), 'description' => trim($data['desc']), 'thumb' => $data['thumb'], 'url' => $url);
        pdo_insert('cover_reply', $cover_data);
        return '保存成功！';
    }
    static function keyExist($key = ''){
        global $_W;
        if (empty($key))return NULL;
        $keyword = pdo_get('rule_keyword', array('content' => trim($key), 'uniacid' => $_W['uniacid']), array('rid'));
        if (!empty($keyword)){
            $rule = pdo_get('rule', array('id' => $keyword['rid'], 'uniacid' => $_W['uniacid']));
            if (!empty($rule))return $rule;
        }
    }
}

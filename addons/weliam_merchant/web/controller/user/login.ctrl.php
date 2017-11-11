<?php
class login{
    public function agent_login(){
        global $_W, $_GPC;
        if(checksubmit() || $_W['isajax']){
            $this -> _login($_GPC['referer']);
        }
        include wl_template('user/agent_login');
    }
    public function logout(){
        isetcookie('__wlagent_session', '', -10000);
        header('Location:' . web_url('user/login/agent_login'));
    }
    public function _login($forward = ''){
        global $_GPC, $_W;
        $member = array();
        $username = trim($_GPC['username']);
        pdo_query('DELETE FROM' . tablename('users_failed_login') . ' WHERE lastupdate < :timestamp', array(':timestamp' => TIMESTAMP-300));
        $failed = pdo_get('users_failed_login', array('username' => $username, 'ip' => CLIENT_IP));
        if ($failed['count'] >= 5){
            wl_message('输入密码错误次数超过5次，请在5分钟后再登录', referer(), 'info');
        }
        if(empty($username)){
            wl_message('请输入要登录的用户名');
        }
        $member['username'] = $username;
        $member['password'] = $_GPC['password'];
        if(empty($member['password'])){
            wl_message('请输入密码');
        }
        $record = User :: agentuser_single($member);
        if(!empty($record)){
            if($record['status'] != 1){
                wl_message('您的账号正在审核或是已经被系统禁止，请联系网站管理员解决！');
            }
            if (!empty($record['endtime']) && $record['endtime'] < TIMESTAMP){
                wl_message('您的账号有效期限已过，请联系网站管理员解决！');
            }
            $cookie = array();
            $cookie['id'] = $record['id'];
            $cookie['uniacid'] = $record['uniacid'];
            $cookie['hash'] = md5($record['password'] . $record['salt']);
            $session = base64_encode(json_encode($cookie));
            isetcookie('__wlagent_session', $session, 7 * 86400, true);
            $status = array();
            $status['id'] = $record['id'];
            $status['lastvisit'] = TIMESTAMP;
            $status['lastip'] = CLIENT_IP;
            User :: agentuser_update($status);
            pdo_delete('users_failed_login', array('id' => $failed['id']));
            wl_message("欢迎回来，{$record['username']}。", web_url('dashboard/dashboard'));
        }else{
            if (empty($failed)){
                pdo_insert('users_failed_login', array('ip' => CLIENT_IP, 'username' => $username, 'count' => '1', 'lastupdate' => TIMESTAMP));
            }else{
                pdo_update('users_failed_login', array('count' => $failed['count'] + 1, 'lastupdate' => TIMESTAMP), array('id' => $failed['id']));
            }
            wl_message('登录失败，请检查您输入的用户名和密码！');
        }
    }
}

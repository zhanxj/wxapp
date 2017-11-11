<?php
defined('IN_IA')or exit('Access Denied');
class userset{
    public function profile(){
        global $_W, $_GPC;
        $user = pdo_get(PDO_NAME . 'agentusers', array('uniacid' => $_W['uniacid'], 'id' => $_W['aid']));
        if (checksubmit('submit')){
            if (empty($_GPC['pw']) || empty($_GPC['pw2'])){
                wl_message('密码不能为空，请重新填写！', 'referer', 'error');
            }
            if ($_GPC['pw'] == $_GPC['pw2']){
                wl_message('新密码与原密码一致，请检查！', 'referer', 'error');
            }
            $password_old = Util :: encryptedPassword($_GPC['pw'], $user['salt']);
            if ($user['password'] != $password_old){
                wl_message('原密码错误，请重新填写！', 'referer', 'error');
            }
            $result = '';
            $members = array('password' => Util :: encryptedPassword($_GPC['pw2'], $user['salt']));
            $result = pdo_update(PDO_NAME . 'agentusers', $members, array('id' => $_W['aid']));
            wl_message('修改成功！', 'referer', 'success');
        }
        include wl_template('agentset/profile');
    }
}

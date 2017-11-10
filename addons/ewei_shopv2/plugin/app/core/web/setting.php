<?php


if (!defined('IN_IA')) {
	exit('Access Denied');
}
class Setting_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$data = m('common')->getSysset('app');
		$template_sms = com('sms')->sms_temp();
		$tmessage = pdo_fetchall('SELECT id, `name` FROM ' . tablename('ewei_shop_wxapp_tmessage') . 'WHERE uniacid=:uniacid AND status=1', array(':uniacid' => $_W['uniacid']));
		if ($_W['ispost']) {
			ca('app.setting.edit');
			$data['appid'] = trim($_GPC['data']['appid']);
			$data['secret'] = trim($_GPC['data']['secret']);
			$data['isclose'] = intval($_GPC['data']['isclose']);
			$data['closetext'] = trim($_GPC['data']['closetext']);
			$data['openbind'] = intval($_GPC['data']['openbind']);
			$data['sms_bind'] = intval($_GPC['data']['sms_bind']);
			$data['bindtext'] = trim($_GPC['data']['bindtext']);
			$data['hidecom'] = intval($_GPC['data']['hidecom']);
			$data['sendappurl'] = trim($_GPC['data']['sendappurl']);
			$data['customer'] = intval($_GPC['data']['customer']);
			$data['tmessage_pay'] = intval($_GPC['data']['tmessage_pay']);
			$data['tmessage_send'] = intval($_GPC['data']['tmessage_send']);
			$data['tmessage_virtualsend'] = intval($_GPC['data']['tmessage_virtualsend']);
			$data['tmessage_finish'] = intval($_GPC['data']['tmessage_finish']);
			m('common')->updateSysset(array('app' => $data));
			plog('app.setting.edit', '保存基本设置');
			show_json(1);
		}
		include $this->template();
	}
}
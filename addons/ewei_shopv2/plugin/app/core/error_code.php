<?php


class AppError
{
	public static $OK = 0;
	public static $SystemError = -1;
	public static $ParamsError = -2;
	public static $UserNotLogin = -3;
	public static $VerifyFailed = -10;
	public static $PluginNotFound = -9;
	public static $VerifyCodeError = 90000;
	public static $VerifyCodeTimeOut = 90001;
	public static $SMSTplidNull = 91000;
	public static $SMSRateError = 91001;
	public static $BindSelfBinded = 92000;
	public static $BindWillRelieve = 92001;
	public static $BindWillMerge = 92002;
	public static $BindError = 92003;
	public static $BindNotOpen = 92004;
	public static $UploadNoFile = 101000;
	public static $UploadFail = 101001;
	public static $UserLoginFail = 10000;
	public static $UserTokenFail = 10001;
	public static $UserMobileExists = 10002;
	public static $UserNotFound = 10003;
	public static $UserIsBlack = 10004;
	public static $UserNotBindMobile = 10010;
	public static $GoodsNotFound = 20000;
	public static $GoodsNotChecked = 20001;
	public static $NotAddCart = 20002;
	public static $NotInCart = 20003;
	public static $AddressNotFound = 30000;
	public static $WithdrawNotOpen = 30101;
	public static $WithdrawError = 30102;
	public static $WithdrawBig = 30103;
	public static $WithdrawNotType = 30104;
	public static $WithdrawRealName = 30105;
	public static $WithdrawAlipay = 30106;
	public static $WithdrawAlipay1 = 30107;
	public static $WithdrawDiffAlipay = 30108;
	public static $WithdrawBank = 30109;
	public static $WithdrawBankCard = 30110;
	public static $WithdrawBankCard1 = 30111;
	public static $WithdrawDiffBankCard = 30112;
	public static $WxPayNotOpen = 40000;
	public static $WxPayParamsError = 40001;
	public static $OrderNotFound = 50000;
	public static $OrderNoExpress = 50001;
	public static $OrderCannotCancel = 50002;
	public static $OrderCannotFinish = 50003;
	public static $OrderCannotRestore = 50004;
	public static $OrderCannotDelete = 50005;
	public static $OrderCreateNoGoods = 50006;
	public static $OrderCreateMinBuyLimit = 50007;
	public static $OrderCreateOneBuyLimit = 50008;
	public static $OrderCreateMaxBuyLimit = 50009;
	public static $OrderCreateTimeNotStart = 50010;
	public static $OrderCreateTimeEnd = 50011;
	public static $OrderCreateMemberLevelLimit = 50012;
	public static $OrderCreateMemberGroupLimit = 50013;
	public static $OrderCreateStockError = 50014;
	public static $OrderCannotPay = 50015;
	public static $OrderPayNoPayType = 50016;
	public static $OrderPayFail = 50017;
	public static $OrderAlreadyPay = 50018;
	public static $OrderCanNotResubmit = 50019;
	public static $OrderCanNotRefund = 51000;
	public static $OrderCanNotComment = 51001;
	public static $OrderCreateTaskGoodsCart = 50202;
	public static $OrderCreateNoDispatch = 50203;
	public static $OrderCreateFalse = 50204;
	public static $OrderCreateNoPackage = 50205;
	public static $OrderCreatePackageTimeNotStart = 50206;
	public static $OrderCreatePackageTimeEnd = 50207;
	public static $MemberRechargeError = 60000;
	public static $CouponNotFound = 61000;
	public static $CouponCanNotBuy = 61001;
	public static $CouponRecordNotFound = 61002;
	public static $CouponBuyError = 61003;
	public static $CommissionReg = 70000;
	public static $CommissionNoUserInfo = 70001;
	public static $CommissionNotShortTimeSubmit = 70002;
	public static $CommissionIsAgent = 70003;
	public static $CommissionQrcodeNoOpen = 70004;
	public static $PageNotFound = 80000;
	public static $MenuNotFound = 80001;
	public static $WxAppError = 9900001;
	public static $WxAppLoginError = 9900002;
	public static $errCode = array(0 => '处理成功', -1 => '系统内部错误', -2 => '参数错误', -3 => '未登录', -9 => '插件未找到', 90000 => '验证码错误', 90001 => '验证码失效', 10000 => '登录失败', 10001 => '登录失效', 10002 => '手机号已存在', 10003 => '用户不存在', 10004 => '用户是黑名单', 10010 => '用户未绑定手机号', 20000 => '商品不存在', 20001 => '商品不存在(1)', 20002 => '不能加入购物车', 20003 => '无购物车记录', 30000 => '地址未找到', 30101 => '系统未开启提现', 30102 => '提现金额错误', 30103 => '提现金额过大', 30104 => '未选择提现方式', 30105 => '请填写姓名', 30106 => '请填写支付宝帐号', 30107 => '请填写确认帐号', 30108 => '支付宝帐号与确认帐号不一致', 30109 => '请选择银行', 30110 => '请填写银行卡号', 30111 => '请填写确认卡号', 30112 => '银行卡号与确认卡号不一致', 40000 => '微信支付未开启', 40001 => '微信支付参数错误', 80000 => '页面不存在', 80001 => '菜单不存在', 91000 => '短信发送失败(SMSidNull)', 91001 => '60秒内只能发送一次', 92000 => '此手机号已与当前账号绑定', 92001 => '此手机号已与其他帐号绑定, 如果继续将会解绑之前帐号', 92002 => '此手机号已通过其他方式注册, 如果继续将会合并账号信息', 92003 => '绑定失败', 92004 => '未开启绑定', 101000 => '未选择文件', 101001 => '上传失败', 50000 => '订单未找到', 50001 => '无物流信息', 50002 => '订单无法取消', 50003 => '订单无法收货', 50004 => '订单无法恢复', 50005 => '订单无法删除', 50006 => '商品出错', 50007 => '最低购买限制', 50008 => '一次最多购买限制', 50009 => '最多购买限制', 50010 => '限时购时间未开始', 50011 => '限时购时间已结束', 50012 => '会员等级限制', 50013 => '会员组限制', 50014 => '库存不足', 50015 => '订单不能支付', 50016 => '没有合适的支付方式', 50017 => '支付出错', 50018 => '订单已经支付', 50019 => '请不要重复提交', 51000 => '订单不能申请退款', 51001 => '订单不能评论', 50201 => '任务活动优惠最多购买限制', 50202 => '任务活动优惠商品不能放入购物车下单', 50203 => '不配送区域', 50204 => '下单失败', 50205 => '未找到套餐', 50206 => '套餐未开始', 50207 => '套餐已结束', 61000 => '优惠券不存在', 61001 => '无法从领券中心领取', 61002 => '未找到优惠券领取记录', 61003 => '优惠券领取失败', 70000 => '跳转到注册页面', 70001 => '需要您完善资料才能继续操作', 70002 => '不要短时间重复下提交', 70003 => '您已经是分销商了', 70004 => '没有开启推广二维码!');
	public static function getError($errcode = 0)
	{
		return isset(self::$errCode[$errcode]) ? self::$errCode[$errcode] : '';
	}
}
if (!defined('IN_IA')) {
	exit('Access Denied');
}
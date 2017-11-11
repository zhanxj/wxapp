<?php
if (!defined('IN_IA')){
    exit('Access Denied');
}
class Smsnum{
    private $extend;
    private $recNum;
    private $smsFreeSignName;
    private $smsParam;
    private $smsTemplateCode;
    private $smsType;
    private $apiParas = array();
    public function setExtend($extend){
        $this -> extend = $extend;
        $this -> apiParas["extend"] = $extend;
    }
    public function getExtend(){
        return $this -> extend;
    }
    public function setRecNum($recNum){
        $this -> recNum = $recNum;
        $this -> apiParas["rec_num"] = $recNum;
    }
    public function getRecNum(){
        return $this -> recNum;
    }
    public function setSmsFreeSignName($smsFreeSignName){
        $this -> smsFreeSignName = $smsFreeSignName;
        $this -> apiParas["sms_free_sign_name"] = $smsFreeSignName;
    }
    public function getSmsFreeSignName(){
        return $this -> smsFreeSignName;
    }
    public function setSmsParam($smsParam){
        $this -> smsParam = $smsParam;
        $this -> apiParas["sms_param"] = $smsParam;
    }
    public function getSmsParam(){
        return $this -> smsParam;
    }
    public function setSmsTemplateCode($smsTemplateCode){
        $this -> smsTemplateCode = $smsTemplateCode;
        $this -> apiParas["sms_template_code"] = $smsTemplateCode;
    }
    public function getSmsTemplateCode(){
        return $this -> smsTemplateCode;
    }
    public function setSmsType($smsType){
        $this -> smsType = $smsType;
        $this -> apiParas["sms_type"] = $smsType;
    }
    public function getSmsType(){
        return $this -> smsType;
    }
    public function getApiMethodName(){
        return "alibaba.aliqin.fc.sms.num.send";
    }
    public function getApiParas(){
        return $this -> apiParas;
    }
    public function check(){
        RequestCheckUtil :: checkNotNull($this -> recNum, "recNum");
        RequestCheckUtil :: checkNotNull($this -> smsFreeSignName, "smsFreeSignName");
        RequestCheckUtil :: checkNotNull($this -> smsTemplateCode, "smsTemplateCode");
        RequestCheckUtil :: checkNotNull($this -> smsType, "smsType");
    }
    public function putOtherTextParam($key, $value){
        $this -> apiParas[$key] = $value;
        $this -> $key = $value;
    }
}
class RequestCheckUtil{
    public static function checkNotNull($value, $fieldName){
        if(self :: checkEmpty($value)){
            throw new Exception("client-check-error:Missing Required Arguments: " . $fieldName , 40);
        }
    }
    public static function checkMaxLength($value, $maxLength, $fieldName){
        if(!self :: checkEmpty($value) && mb_strlen($value , "UTF-8") > $maxLength){
            throw new Exception("client-check-error:Invalid Arguments:the length of " . $fieldName . " can not be larger than " . $maxLength . "." , 41);
        }
    }
    public static function checkMaxListSize($value, $maxSize, $fieldName){
        if(self :: checkEmpty($value))return ;
        $list = preg_split("/,/", $value);
        if(count($list) > $maxSize){
            throw new Exception("client-check-error:Invalid Arguments:the listsize(the string split by \",\") of " . $fieldName . " must be less than " . $maxSize . " ." , 41);
        }
    }
    public static function checkMaxValue($value, $maxValue, $fieldName){
        if(self :: checkEmpty($value))return ;
        self :: checkNumeric($value, $fieldName);
        if($value > $maxValue){
            throw new Exception("client-check-error:Invalid Arguments:the value of " . $fieldName . " can not be larger than " . $maxValue . " ." , 41);
        }
    }
    public static function checkMinValue($value, $minValue, $fieldName){
        if(self :: checkEmpty($value))return ;
        self :: checkNumeric($value, $fieldName);
        if($value < $minValue){
            throw new Exception("client-check-error:Invalid Arguments:the value of " . $fieldName . " can not be less than " . $minValue . " ." , 41);
        }
    }
    protected static function checkNumeric($value, $fieldName){
        if(!is_numeric($value))throw new Exception("client-check-error:Invalid Arguments:the value of " . $fieldName . " is not number : " . $value . " ." , 41);
    }
    public static function checkEmpty($value){
        if(!isset($value))return true ;
        if($value === null)return true;
        if(trim($value) === "")return true;
        return false;
    }
}

<?php
namespace Zhuobin\FaDaDa\Src;

/**
 * 数据对象基础类，该类中定义数据类最基本的行为，包括：
 * 计算/设置/获取签名、输出xml格式的参数、从xml读取数据对象等
 * @author widyhu
 */
class FddDataBase
{
    protected $values = array();

    /**
     * 输出xml字符
     * @throws FddException
     **/
    public function ToXml()
    {
        if (!is_array($this->values) || count($this->values) <= 0) {
            throw new FddException("数组数据异常！");
        }

        $xml = "<xml>";
        foreach ($this->values as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
            }
        }
        $xml .= "</xml>";
        return $xml;
    }

    /**
     * 将xml转为array
     * @param string $xml
     * @throws FddException
     * @return  $this->value
     */
    public function FromXml($xml)
    {
        if (!$xml) {
            throw new FddException("xml数据异常！");
        }
        //将XML转为array
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $this->values = json_decode(json_encode(simplexml_load_string($xml, "SimpleXMLElement", LIBXML_NOCDATA)), true);
        return $this->values;
    }

    /**
     * 格式化参数格式化成url参数
     */
    public function ToUrlParams()
    {
        $buff = "";
        foreach ($this->values as $k => $v) {
            if ($k != "sign" && $v != "" && !is_array($v)) {
                $buff .= $k . "=" . $v . "&";
            }
        }

        $buff = trim($buff, "&");
        return $buff;
    }

    /**
     * 设置Url
     * @param string $value
     **/
    public function SetUrl($value)
    {
        $this->values["api_url"] = $value;

        return $this;
    }

    /**
     * 获取Url
     * @param string $value
     **/
    public function GetUrl()
    {
        return $this->values["api_url"];
    }

    /**
     * 设置AppID
     * @param string $value
     **/
    public function SetApp_id($value)
    {
        $this->values["app_id"] = $value;

        return $this;
    }

    /**
     * 获取AppId
     * @return 值
     **/
    public function GetApp_id()
    {
        return $this->values["app_id"];
    }

    /**
     * 判断AppId是否存在
     * @return true 或 false
     **/
    public function IsApp_idSet()
    {
        return array_key_exists("app_id", $this->values);
    }

    /**
     * 设置App秘钥
     * @param string $value
     **/
    public function SetApp_secret($value)
    {
        $this->values["app_secret"] = $value;

        return $this;
    }

    /**
     * 获取App秘钥
     * @return 值
     **/
    public function GetApp_secret()
    {
        return $this->values["app_secret"];
    }

    /**
     * 判断App秘钥是否存在
     * @return true 或 false
     **/
    public function IsApp_secret()
    {
        return array_key_exists("app_secret", $this->values);
    }

    /**
     * 设置请求时间
     * @param string $value
     **/
    public function SetTimestamp($value)
    {
        $this->values["timestamp"] = $value;

        return $this;
    }

    /**
     * 获取请求时间
     * @return 值
     **/
    public function GetTimestamp()
    {
        return $this->values["timestamp"];
    }

    /**
     * 判断请求时间是否存在
     * @return true 或 false
     **/
    public function IsTimestampSet()
    {
        return array_key_exists("timestamp", $this->values);
    }

    /**
     * 设置版本号
     * @param string $value
     **/
    public function SetV($value)
    {
        $this->values["v"] = $value;

        return $this;
    }

    /**
     * 获取版本号
     * @return 值
     **/
    public function GetV()
    {
        return $this->values["v"];
    }

    /**
     * 判断版本号是否存在
     * @return true 或 false
     **/
    public function IsVSet()
    {
        return array_key_exists("v", $this->values);
    }

    /**
     * 设置消息摘要
     * @param string $value
     **/
    public function SetMsg_digest($value)
    {
        $this->values["msg_digest"] = $value;
    }

    /**
     * 获取消息摘要
     * @return 值
     **/
    public function GetMsg_digest()
    {
        return $this->values["msg_digest"];
    }

    /**
     * 判断消息摘要是否存在
     * @return true 或 false
     **/
    public function IsMsg_digestSet()
    {
        return array_key_exists("msg_digest", $this->values);
    }

    /**
     * 获取设置的值
     */
    public function GetValues()
    {
        return $this->values;
    }
}

/**
 * 实名认证类
 * Class FddRealNameAuth
 */
class FddRealNameAuth extends FddDataBase
{

    /**
     * 设置版本号
     * @param string $value
     **/
    public function SetName($value)
    {
        $this->values['name'] = $value;

        return $this;
    }

    /**
     * 获取版本号
     * @return 值
     **/
    public function GetName()
    {
        return $this->values['name'];
    }

    /**
     * 判断版本号是否存在
     * @return true 或 false
     **/
    public function IsNameSet()
    {
        return array_key_exists('name', $this->values);
    }

    /**
     * 设置身份证号码
     * @param string $value
     **/
    public function SetId_card($value)
    {
        $this->values['idCard'] = $value;

        return $this;
    }

    /**
     * 获取身份证号码
     * @return 值
     **/
    public function GetId_card()
    {
        return $this->values['idCard'];
    }

    /**
     * 判断身份证号码是否存在
     * @return true 或 false
     **/
    public function IsId_cardSet()
    {
        return array_key_exists('idCard', $this->values);
    }

    /**
     * 设置手机号码
     * @param string $value
     **/
    public function SetMobile($value)
    {
        $this->values['mobile'] = $value;

        return $this;
    }

    /**
     * 获取手机号码
     * @return 值
     **/
    public function GetMobile()
    {
        return $this->values['mobile'];
    }

    /**
     * 判断手机号码是否存在
     * @return true 或 false
     **/
    public function IsMobileSet()
    {
        return array_key_exists('mobile', $this->values);
    }

    /**
     * 设置银行卡号
     * @param string $value
     **/
    public function SetBank_number($value)
    {
        $this->values['bank_number'] = $value;
    }

    /**
     * 获取银行卡号
     * @return 值
     **/
    public function GetBank_number()
    {
        return $this->values['bank_number'];
    }

    /**
     * 判断银行卡号是否存在
     * @return true 或 false
     **/
    public function IsBank_numberSet()
    {
        return array_key_exists('bank_number', $this->values);
    }

    /**
     * 设置三要素秘钥
     * @param string $value
     **/
    public function SetVerify_element($value)
    {
        $this->values['verify_element'] = $value;

        return $this;
    }

    /**
     * 设置交易号
     * @param $value
     * @return $this
     */
    public function SetVerified_serialNo($value)
    {
        $this->values['verified_serialno'] = $value;

        return $this;
    }

    /**
     * 返回交易号
     * @param $value
     * @return $this
     */
    public function GetVerified_serialNo()
    {
        return $this->values['verified_serialno'];
    }

    /**
     * 获取三要素秘钥
     * @return 值
     **/
    public function GetVerify_element()
    {
        return $this->values['verify_element'];
    }

    /**
     * 判断三要素秘钥是否存在
     * @return true 或 false
     **/
    public function IsVerify_elementSet()
    {
        return array_key_exists('verify_element', $this->values);
    }

    /**
     * 设置证件号码(蛇型字段)
     * @param string $value
     **/
    public function SetSnake_idCard($value)
    {
        $this->values['id_card'] = $value;
    }

    /**
     * 获取证件号码(蛇型字段)
     * @return 值
     **/
    public function GetSnake_idCard()
    {
        return $this->values['id_card'];
    }

    /**
     * 判断证件号码(蛇型字段)是否存在
     * @return true 或 false
     **/
    public function IsSnake_idCardSet()
    {
        return array_key_exists('id_card', $this->values);
    }

    /**
     * 设置证件号码(蛇型字段)
     * @param string $value
     **/
    public function SetImg_base64($value)
    {
        $this->values['img_base64'] = $value;
    }

    /**
     * 获取证件号码(蛇型字段)
     * @return 值
     **/
    public function GetImg_base64()
    {
        return $this->values['img_base64'];
    }

    /**
     * 判断证件号码(蛇型字段)是否存在
     * @return true 或 false
     **/
    public function IsImg_base64Set()
    {
        return array_key_exists('img_base64', $this->values);
    }


}

/**
 * H5人脸识别类
 * Class FddRealNameAuthFace
 */
class FddRealNameAuthFace extends FddDataBase
{
    /**
     * 设置真实姓名
     * @param string $value
     **/
    public function SetName($value)
    {
        $this->values['name'] = $value;
    }

    /**
     * 获取真实姓名
     * @return string $value
     **/
    public function GetName()
    {
        return $this->values['name'];
    }

    /**
     * 判断真实姓名是否存在
     * @return true 或 false
     **/
    public function IsNameSet()
    {
        return array_key_exists('name', $this->values);
    }

    /**
     * 设置身份证号码
     * @param string $value
     **/
    public function SetId_number($value)
    {
        $this->values['id_number'] = $value;
    }

    /**
     * 获取身份证号码
     * @return string $value
     **/
    public function GetId_number()
    {
        return $this->values['id_number'];
    }

    /**
     * 判断身份证号码是否存在
     * @return true 或 false
     **/
    public function IsId_numberSet()
    {
        return array_key_exists('id_number', $this->values);
    }

    /**
     * 设置手机号码
     * @param string $value
     **/
    public function SetMobile($value)
    {
        $this->values['mobile'] = $value;
    }

    /**
     * 获取手机号码
     * @return string $value
     **/
    public function GetMobile()
    {
        return $this->values['mobile'];
    }

    /**
     * 判断手机号码是否存在
     * @return true 或 false
     **/
    public function IsMobileSet()
    {
        return array_key_exists('mobile', $this->values);
    }

    /**
     * 设置交易号
     * @param string $value
     **/
    public function SetOrder_no($value)
    {
        $this->values['order_no'] = $value;
    }

    /**
     * 获取交易号
     * @return string $value
     **/
    public function GetOrder_no()
    {
        return $this->values['order_no'];
    }

    /**
     * 判断交易号是否存在
     * @return true 或 false
     **/
    public function IsOrder_noSet()
    {
        return array_key_exists('order_no', $this->values);
    }

    /**
     * 设置异步通知地址
     * @param string $value
     **/
    public function SetNotify_url($value)
    {
        $this->values['notify_url'] = $value;
    }

    /**
     * 判断异步通知地址是否存在
     * @return true 或 false
     **/
    public function IsNotify_urlSet()
    {
        return array_key_exists('notify_url', $this->values);
    }

    /**
     * 设置同步通知地址
     * 如果有值则跳转到接入方提供的页面，不传则跳转到法大大指定页面
     * @param string $value
     **/
    public function SetFront_url($value)
    {
        $this->values['front_url'] = $value;
    }

    /**
     * 获取同步通知地址
     * @return string $value
     **/
    public function GetFront_url()
    {
        return $this->values['front_url'];
    }

    /**
     * 判断同步通知地址是否存在
     * @return true 或 false
     **/
    public function IsFront_urlSet()
    {
        return array_key_exists('front_url', $this->values);
    }

    /**
     * 设置审核状态
     * @param string $value
     **/
    public function SetStatus($value)
    {
        $this->values['status'] = $value;
    }

    /**
     * 获取审核状态
     * @return string $value
     **/
    public function GetStatus()
    {
        return $this->values['status'];
    }

    /**
     * 判断审核状态是否存在
     * @return true 或 false
     **/
    public function IsStatusSet()
    {
        return array_key_exists('status', $this->values);
    }
}

/**
 * 企业页面认证
 * Class FddCompanyPageAuth
 */
class FddCompanyPageAuth extends FddDataBase
{
    /**
     * 设置客户在携程的唯一标识
     * @param string $value
     **/
    public function SetCtrip_user_id($value)
    {
        $this->values['ctrip_user_id'] = $value;
    }

    /**
     * 获取客户在携程的唯一标识
     * @return mixed
     */
    public function GetCtrip_user_id()
    {
        return $this->values['ctrip_user_id'];
    }

    /**
     * 设置企业名称
     * @param string $value
     **/
    public function SetName($value)
    {
        $this->values['name'] = $value;
    }

    /**
     * 获取企业名称
     * @return mixed
     */
    public function GetName()
    {
        return $this->values['name'];
    }

    /**
     * 设置证件号码
     * @param string $value
     **/
    public function SetIdent_no($value)
    {
        $this->values['ident_no'] = $value;
    }

    /**
     * 获取证件号码
     * @return mixed
     */
    public function GetIdent_no()
    {
        return $this->values['ident_no'];
    }

    /**
     * 设置页面跳转同步通知URL
     * @param string $value
     **/
    public function SetReturn_url($value)
    {
        $this->values['return_url'] = $value;
    }

}

/**
 * 企业对公打款类
 * Class FddRealNameAuthCompanyRemittance
 */
class FddRealNameAuthCompanyRemittance extends FddDataBase
{
    /**
     * 设置操作类型  add:新增  modify:修改
     * @param string $value
     **/
    public function SetOption($value)
    {
        $this->values['option'] = $value;
    }

    /**
     * 获取操作类型  add:新增  modify:修改
     * @return 值
     **/
    public function GetOption()
    {
        return $this->values['option'];
    }

    /**
     * 判断操作类型  add:新增  modify:修改是否存在
     * @return true 或 false
     **/
    public function IsOptionSet()
    {
        return array_key_exists('option', $this->values);
    }

    /**
     * 设置企业注册申请表图片(文件)
     * @param string $value
     **/
    public function SetAuthorization_image_file($value)
    {
        $this->values['authorization_image_file'] = $value;
    }

    /**
     * 获取企业注册申请表图片(文件)
     * @return 值
     **/
    public function GetAuthorization_image_file()
    {
        return $this->values['authorization_image_file'];
    }

    /**
     * 判断企业注册申请表图片(文件)是否存在
     * @return true 或 false
     **/
    public function IsAuthorization_image_fileSet()
    {
        return array_key_exists('authorization_image_file', $this->values);
    }

    /**
     * 设置企业注册申请表图片(图片路径)
     * @param string $value
     **/
    public function SetAuthorization_image_url($value)
    {
        $this->values['authorization_image_url'] = $value;
    }

    /**
     * 获取企业注册申请表图片(图片路径)
     * @return 值
     **/
    public function GetAuthorization_image_url()
    {
        return $this->values['authorization_image_url'];
    }

    /**
     * 判断企业注册申请表图片(图片路径)是否存在
     * @return true 或 false
     **/
    public function IsAuthorization_image_urlSet()
    {
        return array_key_exists('authorization_image_url', $this->values);
    }

    /**
     * 设置企业信息
     * @param string $value
     **/
    public function SetCompany_info($value)
    {
        $this->values['company_info'] = $value;
    }

    /**
     * 获取企业信息
     * @return 值
     **/
    public function GetCompany_info()
    {
        return $this->values['company_info'];
    }

    /**
     * 判断企业信息是否存在
     * @return true 或 false
     **/
    public function IsCompany_infoSet()
    {
        return array_key_exists('company_info', $this->values);
    }

    /**
     * 设置多合一营业执照图片(文件)
     * @param string $value
     **/
    public function SetLicense_image_file($value)
    {
        $this->values['license_image_file'] = $value;
    }

    /**
     * 获取多合一营业执照图片(文件)
     * @return 值
     **/
    public function GetLicense_image_file()
    {
        return $this->values['license_image_file'];
    }

    /**
     * 判断多合一营业执照图片(文件)是否存在
     * @return true 或 false
     **/
    public function IsLicense_image_fileSet()
    {
        return array_key_exists('license_image_file', $this->values);
    }

    /**
     * 设置多合一营业执照图片(图片)
     * @param string $value
     **/
    public function SetLicense_image_url($value)
    {
        $this->values['license_image_url'] = $value;
    }

    /**
     * 获取多合一营业执照图片(图片)
     * @return 值
     **/
    public function GetLicense_image_url()
    {
        return $this->values['license_image_url'];
    }

    /**
     * 判断多合一营业执照图片(图片)是否存在
     * @return true 或 false
     **/
    public function IsLicense_image_urlSet()
    {
        return array_key_exists('license_image_url', $this->values);
    }

    /**
     * 设置对公账号信息
     * @param string $value
     **/
    public function SetBank_info($value)
    {
        $this->values['bank_info'] = $value;
    }

    /**
     * 获取对公账号信息
     * @return 值
     **/
    public function GetBank_info()
    {
        return $this->values['bank_info'];
    }

    /**
     * 判断对公账号信息是否存在
     * @return true 或 false
     **/
    public function IsBank_infoSet()
    {
        return array_key_exists('bank_info', $this->values);
    }

    /**
     * 设置法人信息
     * @param string $value
     **/
    public function SetLegal_info($value)
    {
        $this->values['legal_info'] = $value;
    }

    /**
     * 获取法人信息
     * @return $value
     **/
    public function GetLegal_info()
    {
        return $this->values['legal_info'];
    }

    /**
     * 判断法人信息是否存在
     * @return true 或 false
     **/
    public function IsLegal_infoSet()
    {
        return array_key_exists('legal_info', $this->values);
    }

    /**
     * 设置法人手持身份证照片(文件)
     * @param string $value
     **/
    public function SetLegal_image_file($value)
    {
        $this->values['legal_image_file'] = $value;
    }

    /**
     * 获取法人手持身份证照片(文件)
     * @return 值
     **/
    public function GetLegal_image_file()
    {
        return $this->values['legal_image_file'];
    }

    /**
     * 判断法人手持身份证照片(文件)是否存在
     * @return true 或 false
     **/
    public function IsLegal_image_fileSet()
    {
        return array_key_exists('legal_image_file', $this->values);
    }

    /**
     * 设置法人手持身份证照片(图片)
     * @param string $value
     **/
    public function SetLegal_image_url($value)
    {
        $this->values['legal_image_url'] = $value;
    }

    /**
     * 获取法人手持身份证照片(图片)
     * @return 值
     **/
    public function GetLegal_image_url()
    {
        return $this->values['legal_image_url'];
    }

    /**
     * 判断法人手持身份证照片(图片)是否存在
     * @return true 或 false
     **/
    public function IsLegal_image_urlSet()
    {
        return array_key_exists('legal_image_url', $this->values);
    }

    /**
     * 设置代理人信息
     * @param string $value
     **/
    public function SetAgent_info($value)
    {
        $this->values['agent_info'] = $value;
    }

    /**
     * 获取代理人信息
     * @return $value
     **/
    public function GetAgent_info()
    {
        return $this->values['agent_info'];
    }

    /**
     * 判断代理人信息是否存在
     * @return true 或 false
     **/
    public function IsAgent_infoSet()
    {
        return array_key_exists('agent_info', $this->values);
    }

    /**
     * 设置代理人手持身份证照片(文件)
     * @param string $value
     **/
    public function SetAgent_image_file($value)
    {
        $this->values['agent_image_file'] = $value;
    }

    /**
     * 获取代理人手持身份证照片(文件)
     * @return 值
     **/
    public function GetAgent_image_file()
    {
        return $this->values['agent_image_file'];
    }

    /**
     * 判断代理人手持身份证照片(文件)是否存在
     * @return true 或 false
     **/
    public function IsAgent_image_fileSet()
    {
        return array_key_exists('agent_image_file', $this->values);
    }

    /**
     * 设置代理人手持身份证照片(图片)
     * @param string $value
     **/
    public function SetAgent_image_url($value)
    {
        $this->values['agent_image_url'] = $value;
    }

    /**
     * 获取代理人手持身份证照片(图片)
     * @return 值
     **/
    public function GetAgent_image_url()
    {
        return $this->values['agent_image_url'];
    }

    /**
     * 判断代理人手持身份证照片(图片)是否存在
     * @return true 或 false
     **/
    public function IsAgent_image_urlSet()
    {
        return array_key_exists('agent_image_url', $this->values);
    }

    /**
     * 设置代理人手持身份证照片(文件)
     * @param string $value
     **/
    public function SetLegal_id_image_file($value)
    {
        $this->values['legal_id_image_file'] = $value;
    }

    /**
     * 获取代理人手持身份证照片(文件)
     * @return 值
     **/
    public function GetLegal_id_image_file()
    {
        return $this->values['legal_id_image_file'];
    }

    /**
     * 判断代理人手持身份证照片(文件)是否存在
     * @return true 或 false
     **/
    public function IsLegal_id_image_fileSet()
    {
        return array_key_exists('legal_id_image_file', $this->values);
    }

    /**
     * 设置代理人手持身份证照片(图片)
     * @param string $value
     **/
    public function SetLegal_id_image_url($value)
    {
        $this->values['legal_id_image_url'] = $value;
    }

    /**
     * 获取代理人手持身份证照片(图片)
     * @return 值
     **/
    public function GetLegal_id_image_url()
    {
        return $this->values['legal_id_image_url'];
    }

    /**
     * 判断代理人手持身份证照片(图片)是否存在
     * @return true 或 false
     **/
    public function IsLegal_id_image_urlSet()
    {
        return array_key_exists('legal_id_image_url', $this->values);
    }

    /**
     * 设置银行名称
     * @param string $value
     **/
    public function SetBank_name($value)
    {
        $this->values['bank_name'] = $value;
    }

    /**
     * 获取银行名称
     * @return 值
     **/
    public function GetBank_name()
    {
        return $this->values['bank_name'];
    }

    /**
     * 判断银行名称是否存在
     * @return true 或 false
     **/
    public function IsBank_nameSet()
    {
        return array_key_exists('bank_name', $this->values);
    }

    /**
     * 设置银行帐号
     * @param string $value
     **/
    public function SetBank_id($value)
    {
        $this->values['bank_id'] = $value;
    }

    /**
     * 获取银行帐号
     * @return 值
     **/
    public function GetBank_id()
    {
        return $this->values['bank_id'];
    }

    /**
     * 判断银行帐号是否存在
     * @return true 或 false
     **/
    public function IsBank_idSet()
    {
        return array_key_exists('bank_id', $this->values);
    }

    /**
     * 设置开户支行名称
     * @param string $value
     **/
    public function SetSubbranch_name($value)
    {
        $this->values['subbranch_name'] = $value;
    }

    /**
     * 获取开户支行名称
     * @return 值
     **/
    public function GetSubbranch_name()
    {
        return $this->values['subbranch_name'];
    }

    /**
     * 判断开户支行名称是否存在
     * @return true 或 false
     **/
    public function IsSubbranch_nameSet()
    {
        return array_key_exists('subbranch_name', $this->values);
    }

    /**
     * 设置开户支行所在省份
     * @param string $value
     **/
    public function SetSubbranch_province($value)
    {
        $this->values['subbranch_province'] = $value;
    }

    /**
     * 获取开户支行所在省份
     * @return 值
     **/
    public function GetSubbranch_province()
    {
        return $this->values['subbranch_province'];
    }

    /**
     * 判断开户支行所在省份是否存在
     * @return true 或 false
     **/
    public function IsSubbranch_province()
    {
        return array_key_exists('subbranch_province', $this->values);
    }

    /**
     * 设置开户支行所在城市
     * @param string $value
     **/
    public function SetSubbranch_city($value)
    {
        $this->values['subbranch_city'] = $value;
    }

    /**
     * 获取开户支行所在城市
     * @return 值
     **/
    public function GetSubbranch_city()
    {
        return $this->values['subbranch_city'];
    }

    /**
     * 判断开户支行所在城市是否存在
     * @return true 或 false
     **/
    public function IsSubbranch_city()
    {
        return array_key_exists('subbranch_city', $this->values);
    }

    /**
     * 设置企业邮箱
     * @param string $value
     **/
    public function SetEmail($value)
    {
        $this->values['email'] = $value;
    }

    /**
     * 获取企业邮箱
     * @return 值
     **/
    public function GetEmail()
    {
        return $this->values['email'];
    }

    /**
     * 判断企业邮箱是否存在
     * @return true 或 false
     **/
    public function IsEmailSet()
    {
        return array_key_exists('email', $this->values);
    }

    /**
     * 设置企业名称
     * @param string $value
     **/
    public function SetCompany_name($value)
    {
        $this->values['company_name'] = $value;
    }

    /**
     * 获取企业名称
     * @return 值
     **/
    public function GetCompany_name()
    {
        return $this->values['company_name'];
    }

    /**
     * 判断企业名称是否存在
     * @return true 或 false
     **/
    public function IsCompany_nameSet()
    {
        return array_key_exists('company_name', $this->values);
    }

    /**
     * 设置企业营业执照号（统一社会信用代码）
     * @param string $value
     **/
    public function SetLicense_no($value)
    {
        $this->values['license_no'] = $value;
    }

    /**
     * 获取企业营业执照号（统一社会信用代码）
     * @return 值
     **/
    public function GetLicense_no()
    {
        return $this->values['license_no'];
    }

    /**
     * 判断企业营业执照号（统一社会信用代码）是否存在
     * @return true 或 false
     **/
    public function IsLicense_noSet()
    {
        return array_key_exists('license_no', $this->values);
    }

    /**
     * 设置企业营业执照号（统一社会信用代码）
     * @param string $value
     **/
    public function SetResource_id($value)
    {
        $this->values['resource_id'] = $value;
    }

    /**
     * 获取企业营业执照号（统一社会信用代码）
     * @return 值
     **/
    public function GetResource_id()
    {
        return $this->values['resource_id'];
    }

    /**
     * 判断企业营业执照号（统一社会信用代码）是否存在
     * @return true 或 false
     **/
    public function IsResource_idSet()
    {
        return array_key_exists('resource_id', $this->values);
    }

    /**
     * 设置 打款金额
     * @param string $value
     **/
    public function SetAmount($value)
    {
        $this->values['amount'] = $value;
    }

    /**
     * 获取 打款金额
     * @return 值
     **/
    public function GetAmount()
    {
        return $this->values['amount'];
    }

    /**
     * 打款金额是否存在
     * @return true 或 false
     **/
    public function IsAmountSet()
    {
        return array_key_exists('amount', $this->values);
    }

}

/**
 * 企业实名认证类
 * Class FddRealNameAuthCompany
 */
class FddRealNameAuthCompany extends FddDataBase
{
    /**
     * 设置企业名称
     * @param string $value
     **/
    public function SetCompany_name($value)
    {
        $this->values['company_name'] = $value;
    }

    /**
     * 获取企业名称
     * @return 值
     **/
    public function GetCompany_name()
    {
        return $this->values['company_name'];
    }

    /**
     * 判断企业名称是否存在
     * @return true 或 false
     **/
    public function IsCompany_nameSet()
    {
        return array_key_exists('company_name', $this->values);
    }

    /**
     * 设置法人姓名
     * @param string $value
     **/
    public function SetLegal_name($value)
    {
        $this->values['legal_name'] = $value;
    }

    /**
     * 获取法人姓名
     * @return 值
     **/
    public function GetLegal_name()
    {
        return $this->values['legal_name'];
    }

    /**
     * 判断法人姓名是否存在
     * @return true 或 false
     **/
    public function IsLegal_nameSet()
    {
        return array_key_exists('legal_name', $this->values);
    }

    /**
     * 设置统一社会信用代码
     * @param string $value
     **/
    public function SetCredit_no($value)
    {
        $this->values['credit_no'] = $value;
    }

    /**
     * 获取统一社会信用代码
     * @return 值
     **/
    public function GetCredit_no()
    {
        return $this->values['credit_no'];
    }

    /**
     * 判断统一社会信用代码是否存在
     * @return true 或 false
     **/
    public function IsCredit_noSet()
    {
        return array_key_exists('credit_no', $this->values);
    }

    /**
     * 设置工商注册号
     * @param string $value
     **/
    public function SetLicence_no($value)
    {
        $this->values['licence_no'] = $value;
    }

    /**
     * 获取工商注册号
     * @return 值
     **/
    public function GetLicence_no()
    {
        return $this->values['licence_no'];
    }

    /**
     * 判断工商注册号是否存在
     * @return true 或 false
     **/
    public function IsLicence_noSet()
    {
        return array_key_exists('licence_no', $this->values);
    }

    /**
     * 设置组织机构代码
     * @param string $value
     **/
    public function SetOrganization_no($value)
    {
        $this->values['organization_no'] = $value;
    }

    /**
     * 获取组织机构代码
     * @return 值
     **/
    public function GetOrganization_no()
    {
        return $this->values['organization_no'];
    }

    /**
     * 判断组织机构代码是否存在
     * @return true 或 false
     **/
    public function IsOrganization_noSet()
    {
        return array_key_exists('organization_no', $this->values);
    }

    /**
     * 设置法人身份证号码
     * @param string $value
     **/
    public function SetLegal_id($value)
    {
        $this->values['legal_id'] = $value;
    }

    /**
     * 获取法人身份证号码
     * @return string $value
     **/
    public function GetLegal_id()
    {
        return $this->values['legal_id'];
    }

    /**
     * 判断法人身份证号码是否存在
     * @return true 或 false
     **/
    public function IsLegal_idSet()
    {
        return array_key_exists('legal_id', $this->values);
    }
}

/**
 * OCR识别接口类
 * Class FddOcrIdentification
 */
class FddOcrIdentification extends FddDataBase
{
    /**
     * 设置图片类型
     * @param string $value
     **/
    public function SetOcr_type($value)
    {
        $this->values['ocr_type'] = $value;
    }

    /**
     * 判断图片类型是否存在
     * @return true 或 false
     **/
    public function IsOcr_typeSet()
    {
        return array_key_exists('ocr_type', $this->values);
    }

    /**
     * 设置base64图片
     * @param string $value
     **/
    public function SetPic_base64($value)
    {
        $this->values['pic_base64'] = $value;
    }

    /**
     * 判断base64图片是否存在
     * @return true 或 false
     **/
    public function IsPic_base64Set()
    {
        return array_key_exists('pic_base64', $this->values);
    }

    /**
     * 设置 图片格式
     * @param string $value
     **/
    public function SetPic_type($value)
    {
        $this->values['pic_type'] = $value;
    }

    /**
     * 判断 图片格式 是否存在
     * @return true 或 false
     **/
    public function IsPic_typeSet()
    {
        return array_key_exists('pic_type', $this->values);
    }

}

/**
 * 以下可配置各个基类  个人CA证书申请接口
 * Class FddDataBaseCA
 */
class FddDataBaseCA extends FddDataBase
{
    /**
     * 设置接入方id
     * @param string $value
     **/
    public function SetApp_id($value)
    {
        $this->values['app_id'] = $value;
    }

    /**
     * 获取设置接入方 id
     * @return 值
     **/
    public function GetApp_id()
    {
        return $this->values['app_id'];
    }

    /**
     * 判断设置接入方id是否存在
     * @return true 或 false
     **/
    public function IsApp_idSet()
    {
        return array_key_exists('app_id', $this->values);
    }

    /**
     * 设置请求时间
     * @param string $value
     **/
    public function SetTimestamp($value)
    {
        $this->values['timestamp'] = $value;
    }

    /**
     * 获取请求时间
     * @return 值
     **/
    public function GetTimestamp()
    {
        return $this->values['timestamp'];
    }

    /**
     * 判断请求时间是否存在
     * @return true 或 false
     **/
    public function IsTimestampSet()
    {
        return array_key_exists('timestamp', $this->values);
    }

    /**
     * 设置版本号
     * @param string $value
     **/
    public function SetV($value)
    {
        $this->values['v'] = $value;
    }

    /**
     * 获取版本号
     * @return 值
     **/
    public function GetV()
    {
        return $this->values['v'];
    }

    /**
     * 判断版本号是否存在
     * @return true 或 false
     **/
    public function IsVSet()
    {
        return array_key_exists('v', $this->values);
    }

    /**
     * 设置客户姓名
     * @param string $value
     **/
    public function SetCustomer_name($value)
    {
        $this->values['customer_name'] = $value;

        return $this;
    }

    /**
     * 获取客户姓名
     * @return 值
     **/
    public function GetCustomer_name()
    {
        return $this->values['customer_name'];
    }

    /**
     * 判断客户姓名是否存在
     * @return true 或 false
     **/
    public function IsCustomer_nameSet()
    {
        return array_key_exists('customer_name', $this->values);
    }

    /**
     * 设置身份证号码
     * @param string $value
     **/
    public function SetId_card($value)
    {
        $this->values['Id_card'] = $value;

        return $this;
    }

    /**
     * 获取身份证号码
     * @return 值
     **/
    public function GetId_card()
    {
        return $this->values['Id_card'];
    }

    /**
     * 判断身份证号码是否存在
     * @return true 或 false
     **/
    public function IsId_cardSet()
    {
        return array_key_exists('Id_card', $this->values);
    }

    /**
     * 设置手机号码
     * @param string $value
     **/
    public function SetMobile($value)
    {
        $this->values['mobile'] = $value;

        return $this;
    }

    /**
     * 获取手机号码
     * @return 值
     **/
    public function GetMobile()
    {
        return $this->values['mobile'];
    }

    /**
     * 判断手机号码是否存在
     * @return true 或 false
     **/
    public function IsMobileSet()
    {
        return array_key_exists('mobile', $this->values);
    }

    /**
     * 设置密码
     * @param string $value
     **/
    public function SetCa_password($value)
    {
        $this->values['ca_password'] = $value;
    }

    /**
     * 获取密码
     * @return 值
     **/
    public function GetCa_password1()
    {
        return $this->values['ca_password'];
    }

    /**
     * 判断密码是否存在
     * @return true 或 false
     **/
    public function IsCa_passwordSet()
    {
        return array_key_exists('ca_password', $this->values);
    }

    /**
     * 设置消息摘要
     * @param string $value
     **/
    public function SetMsg_digest($value)
    {
        $this->values['msg_digest'] = $value;
    }

    /**
     * 获取消息摘要
     * @return 值
     **/
    public function GetMsg_digest()
    {
        return $this->values['msg_digest'];
    }

    /**
     * 判断消息摘要是否存在
     * @return true 或 false
     **/
    public function IsMsg_digestSet()
    {
        return array_key_exists('msg_digest', $this->values);
    }

    /**
     * 设置证件类型
     * @param string $value
     **/
    public function SetIdent_type($value)
    {
        $this->values['ident_type'] = $value;
    }

    /**
     * 获取证件类型
     * @return 值
     **/
    public function GetIdent_type()
    {
        return $this->values['ident_type'];
    }

    /**
     * 设置邮件
     * @param string $value
     **/
    public function SetEmail($value)
    {
        $this->values['email'] = $value;
    }

    /**
     * 获取邮件
     * @return 值
     **/
    public function GetEmail()
    {
        return $this->values['email'];
    }

    /**
     * 判断邮件是否存在
     * @return true 或 false
     **/
    public function IsEmailSet()
    {
        return array_key_exists('email', $this->values);
    }

    /**
     * 设置加密证件手机号
     * @param string $value
     **/
    public function SetId_Mobile($value)
    {
        $this->values['id_mobile'] = $value;

        return $this;
    }

    /**
     * 获取加密证件手机号
     * @return string $value
     **/
    public function GetId_Mobile()
    {
        return $this->values['id_mobile'];
    }

    /**
     * 设置客户编号
     * @param string $value
     **/
    public function SetCustomer_id($value)
    {
        $this->values['customer_id'] = $value;

        return $this;
    }

    /**
     * 设置交易号
     * @param $value
     * @return $this
     */
    public function SetVerified_serialNo($value)
    {
        $this->values['verified_serialno'] = $value;

        return $this;
    }

    /**
     * 获取客户编号
     * @return 值
     **/
    public function GetCustomer_id()
    {
        return $this->values['customer_id'];
    }

    /**
     * 判断客户编号是否存在
     * @return true 或 false
     **/
    public function IsCustomer_idSet()
    {
        return array_key_exists('customer_id', $this->values);
    }

    /**
     * 设置用户在平台方的 唯一标识
     * @param string $value
     **/
    public function SetUser_id($value)
    {
        $this->values['user_id'] = $value;
    }

    /**
     * 获取用户在平台方的 唯一标识
     * @return 值
     **/
    public function GetUser_id()
    {
        return $this->values['user_id'];
    }

    /**
     * 判断用户在平台方的 唯一标识是否存在
     * @return true 或 false
     **/
    public function IsUser_idSet()
    {
        return array_key_exists('user_id', $this->values);
    }

    /**
     * 设置企业名称
     * @param string $value
     **/
    public function SetCompany_name($value)
    {
        $this->values['company_name'] = $value;
    }

    /**
     * 获取企业名称
     * @return 值
     **/
    public function GetCompany_name()
    {
        return $this->values['company_name'];
    }

    /**
     * 判断企业名称是否存在
     * @return true 或 false
     **/
    public function IsCompany_nameSet()
    {
        return array_key_exists('company_name', $this->values);
    }

    /**
     * 设置企业证件类型
     * @param string $value
     **/
    public function SetCompany_ident_type($value)
    {
        $this->values['company_ident_type'] = $value;
    }

    /**
     * 获取企业证件类型
     * @return 值
     **/
    public function GetCompany_ident_type()
    {
        return $this->values['company_ident_type'];
    }

    /**
     * 判断企业证件类型是否存在
     * @return true 或 false
     **/
    public function IsCompany_ident_typeSet()
    {
        return array_key_exists('company_ident_type', $this->values);
    }

    /**
     * 设置企业证件号码
     * @param string $value
     **/
    public function SetCompany_ident_no($value)
    {
        $this->values['company_ident_no'] = $value;
    }

    /**
     * 获取企业证件号码
     * @return 值
     **/
    public function GetCompany_ident_no()
    {
        return $this->values['company_ident_no'];
    }

    /**
     * 判断企业证件号码是否存在
     * @return true 或 false
     **/
    public function IsCompany_ident_noSet()
    {
        return array_key_exists('company_ident_no', $this->values);
    }

    /**
     * 设置企业证件扫描件（图片）
     * @param string $value
     **/
    public function SetCompany_ident_file($value)
    {
        $this->values['company_ident_file'] = $value;
    }

    /**
     * 获取企业证件扫描件（图片）
     * @return 值
     **/
    public function GetCompany_ident_file()
    {
        return $this->values['company_ident_file'];
    }

    /**
     * 判断企业证件扫描件（图片）是否存在
     * @return true 或 false
     **/
    public function IsCompany_ident_fileSet()
    {
        return array_key_exists('company_ident_file', $this->values);
    }

    /**
     * 设置企业证件扫描件（图片）下载地 址
     * @param string $value
     **/
    public function SetCompany_ident_url($value)
    {
        $this->values['company_ident_url'] = $value;
    }

    /**
     * 获取企业证件扫描件（图片）下载地 址
     * @return 值
     **/
    public function GetCompany_ident_url()
    {
        return $this->values['company_ident_url'];
    }

    /**
     * 判断企业证件扫描件（图片）下载地 址是否存在
     * @return true 或 false
     **/
    public function IsCompany_ident_urlSet()
    {
        return array_key_exists('company_ident_url', $this->values);
    }

    /**
     * 设置营业执照号
     * @param string $value
     **/
    public function SetLicense_no($value)
    {
        $this->values['license_no'] = $value;
    }

    /**
     * 获取营业执照号
     * @return 值
     **/
    public function GetLicense_no()
    {
        return $this->values['license_no'];
    }

    /**
     * 判断营业执照号是否存在
     * @return true 或 false
     **/
    public function IsLicense_noSet()
    {
        return array_key_exists('license_no', $this->values);
    }

    /**
     * 设置营业执照扫描件（图片）
     * @param string $value
     **/
    public function SetLicense_file($value)
    {
        $this->values['license_file'] = $value;
    }

    /**
     * 获取营业执照扫描件（图片）
     * @return 值
     **/
    public function GetLicense_file()
    {
        return $this->values['license_file'];
    }

    /**
     * 判断营业执照扫描件（图片）是否存在
     * @return true 或 false
     **/
    public function IsLicense_fileSet()
    {
        return array_key_exists('license_file', $this->values);
    }

    /**
     * 设置营业执照扫描件（图片）的下载 地址
     * @param string $value
     **/
    public function SetLicense_url($value)
    {
        $this->values['license_url'] = $value;
    }

    /**
     * 获取营业执照扫描件（图片）的下载 地址
     * @return 值
     **/
    public function GetLicense_url()
    {
        return $this->values['license_url'];
    }

    /**
     * 判断营业执照扫描件（图片）的下载 地址是否存在
     * @return true 或 false
     **/
    public function IsLicense_urlSet()
    {
        return array_key_exists('license_url', $this->values);
    }

    /**
     * 设置法人姓名
     * @param string $value
     **/
    public function SetLegal_name($value)
    {
        $this->values['legal_name'] = $value;
    }

    /**
     * 获取法人姓名
     * @return 值
     **/
    public function GetLegal_name()
    {
        return $this->values['legal_name'];
    }

    /**
     * 判断法人姓名是否存在
     * @return true 或 false
     **/
    public function IsLegal_nameSet()
    {
        return array_key_exists('legal_name', $this->values);
    }

    /**
     * 设置法人证件号码
     * @param string $value
     **/
    public function SetLegal_ident_no($value)
    {
        $this->values['legal_ident_no'] = $value;
    }

    /**
     * 获取法人证件号码
     * @return 值
     **/
    public function GetLegal_ident_no()
    {
        return $this->values['legal_ident_no'];
    }

    /**
     * 判断法人证件号码是否存在
     * @return true 或 false
     **/
    public function IsLegal_ident_noSet()
    {
        return array_key_exists('legal_ident_no', $this->values);
    }

    /**
     * 设置法人手持证件照
     * @param string $value
     **/
    public function SetLegal_file($value)
    {
        $this->values['legal_file'] = $value;
    }

    /**
     * 获取法人手持证件照
     * @return 值
     **/
    public function GetLegal_file()
    {
        return $this->values['legal_file'];
    }

    /**
     * 判断法人手持证件照是否存在
     * @return true 或 false
     **/
    public function IsLegal_fileSet()
    {
        return array_key_exists('legal_file', $this->values);
    }

    /**
     * 设置法人手持证件照的下载地址
     * @param string $value
     **/
    public function SetLegal_url($value)
    {
        $this->values['legal_url'] = $value;
    }

    /**
     * 获取法人手持证件照的下载地址
     * @return 值
     **/
    public function GetLegal_url()
    {
        return $this->values['legal_url'];
    }

    /**
     * 判断法人手持证件照的下载地址是否存在
     * @return true 或 false
     **/
    public function IsLegal_urlSet()
    {
        return array_key_exists('legal_url', $this->values);
    }

    /**
     * 设置代理人姓名
     * @param string $value
     **/
    public function SetAgent_name($value)
    {
        $this->values['agent_name'] = $value;
    }

    /**
     * 获取代理人姓名
     * @return 值
     **/
    public function GetAgent_name()
    {
        return $this->values['agent_name'];
    }

    /**
     * 判断代理人姓名是否存在
     * @return true 或 false
     **/
    public function IsAgent_nameSet()
    {
        return array_key_exists('agent_name', $this->values);
    }

    /**
     * 设置代理人证件号码
     * @param string $value
     **/
    public function SetAgent_ident_no($value)
    {
        $this->values['agent_ident_no'] = $value;
    }

    /**
     * 获取代理人证件号码
     * @return 值
     **/
    public function GetAgent_ident_no()
    {
        return $this->values['agent_ident_no'];
    }

    /**
     * 判断代理人证件号码是否存在
     * @return true 或 false
     **/
    public function IsAgent_ident_noSet()
    {
        return array_key_exists('agent_ident_no', $this->values);
    }

    /**
     * 设置代理人手持证件照
     * @param string $value
     **/
    public function SetAgent_file($value)
    {
        $this->values['agent_file'] = $value;
    }

    /**
     * 获取代理人手持证件照
     * @return 值
     **/
    public function GetAgent_file()
    {
        return $this->values['agent_file'];
    }

    /**
     * 判断代理人手持证件照是否存在
     * @return true 或 false
     **/
    public function IsAgent_fileSet()
    {
        return array_key_exists('agent_file', $this->values);
    }

    /**
     * 设置代理人手持证件照的下载地址
     * @param string $value
     **/
    public function SetAgent_url($value)
    {
        $this->values['agent_url'] = $value;
    }

    /**
     * 获取代理人手持证件照的下载地址
     * @return 值
     **/
    public function GetAgent_url()
    {
        return $this->values['agent_url'];
    }

    /**
     * 判断代理人手持证件照的下载地址是否存在
     * @return true 或 false
     **/
    public function IsAgent_urlSet()
    {
        return array_key_exists('agent_url', $this->values);
    }

    /**
     * 设置代理人手持证件照的下载地址
     * @param string $value
     **/
    public function SetOrganization($value)
    {
        $this->values['organization'] = $value;

        return $this;
    }

    /**
     * 获取代理人手持证件照的下载地址
     * @return 值
     **/
    public function GetOrganization()
    {
        return $this->values['organization'];
    }

    /**
     * 判断代理人手持证件照的下载地址是否存在
     * @return true 或 false
     **/
    public function IsOrganizationSet()
    {
        return array_key_exists('organization', $this->values);
    }

}

/**
 * 印章管理类
 * Class FddSignature
 */
class FddSignature extends FddDataBase
{
    /**
     * 设置 客户编号
     * @param string $value
     **/
    public function SetCustomer_id($value)
    {
        $this->values['customer_id'] = $value;

        return $this;
    }

    /**
     * 获取 客户编号
     * @return 值
     **/
    public function GetCustomer_id()
    {
        return $this->values['customer_id'];
    }

    /**
     * 判断 客户编号 是否存在
     * @return true 或 false
     **/
    public function IsCustomer_idSet()
    {
        return array_key_exists('customer_id', $this->values);
    }

    /**
     * 设置 签章图片编号
     * @param string $value
     **/
    public function SetSignature_id($value)
    {
        $this->values['signature_id'] = $value;

        return $this;
    }

    /**
     * 判断 签章图片编号 是否存在
     * @return true 或 false
     **/
    public function IsSignature_idSet()
    {
        return array_key_exists('signature_id', $this->values);
    }

    /**
     * 设置 签章图片base64
     * @param string $value
     **/
    public function SetSignature_img_base64($value)
    {
        $this->values['signature_img_base64'] = $value;

        return $this;
    }

    /**
     * 判断 签章图片base64 是否存在
     * @return true 或 false
     **/
    public function IsSignature_img_base64Set()
    {
        return array_key_exists('signature_img_base64', $this->values);
    }

    /**
     * 设置 签章图片base64
     * @param string $value
     **/
    public function SetContent($value)
    {
        $this->values['content'] = $value;
    }

    /**
     * 判断 签章图片base64 是否存在
     * @return true 或 false
     **/
    public function IsContentSet()
    {
        return array_key_exists('content', $this->values);
    }

}

/**
 * 企业授权类
 * Class FddAuthorization
 */
class FddAuthorization extends FddDataBase
{
    /**
     * 设置 企业客户编号
     * @param string $value
     **/
    public function SetCompany_id($value)
    {
        $this->values['company_id'] = $value;

        return $this;
    }

    /**
     * 判断 企业客户编号 是否存在
     * @return true 或 false
     **/
    public function IsCompany_idSet()
    {
        return array_key_exists('company_id', $this->values);
    }

    /**
     * 设置 个人客户编号
     * @param string $value
     **/
    public function SetPerson_id($value)
    {
        $this->values['person_id'] = $value;

        return $this;
    }

    /**
     * 判断 个人客户编号 是否存在
     * @return true 或 false
     **/
    public function IsPerson_idSet()
    {
        return array_key_exists('person_id', $this->values);
    }

    /**
     * 设置 操作类型
     * @param string $value
     **/
    public function SetOperate_type($value)
    {
        $this->values['operate_type'] = $value;

        return $this;
    }

    /**
     * 设置 操作类型
     * @param string $value
     **/
    public function SetSignature_id($value)
    {
        $this->values['signature_id '] = $value;

        return $this;
    }

    /**
     * 判断 操作类型 是否存在
     * @return true 或 false
     **/
    public function IsOperate_typeSet()
    {
        return array_key_exists('operate_type', $this->values);
    }

    /**
     * 设置 被授权客户编号
     * @param string $value
     **/
    public function SetOuth_customer_id($value)
    {
        $this->values['outh_customer_id'] = $value;
    }

}

/**
 * 合同文档模板和生成类
 * Class FddTemplate
 */
class FddTemplate extends FddDataBase
{

    public function GetValues()
    {
        return parent::GetValues(); // TODO: Change the autogenerated stub
    }

    /**
     * 设置 模板编号
     * @param string $value
     **/
    public function SetTemplate_id($value)
    {
        $this->values['template_id'] = $value;

        return $this;
    }

    /**
     * 获取 模板编号
     * @return 值
     **/
    public function GetTemplate_id()
    {
        return $this->values['template_id'];
    }

    /**
     * 判断 模板编号 是否存在
     * @return true 或 false
     **/
    public function IsTemplate_idSet()
    {
        return array_key_exists('template_id', $this->values);
    }

    /**
     * 设置 文档类型
     * @param string $value
     **/
    public function SetDoc_type($value)
    {
        $this->values['doc_type'] = $value;
    }

    /**
     * 判断 文档类型 是否存在
     * @param string $value
     **/
    public function IsDoc_typeSet()
    {
        return array_key_exists('doc_type', $this->values);
    }

    /**
     * 设置 文档地址
     * @param string $value
     **/
    public function SetDoc_url($value)
    {
        $this->values['doc_url'] = $value;

        return $this;
    }

    /**
     * 判断 文档地址 是否存在
     * @return true 或 false
     **/
    public function IsDoc_urlSet()
    {
        return array_key_exists('doc_url', $this->values);
    }

    /**
     * 设置 文档标题
     * @param string $value
     **/
    public function SetDoc_title($value)
    {
        $this->values['doc_title'] = $value;

        return $this;
    }

    /**
     * 获取 文档标题
     * @return 值
     **/
    public function GetDoc_title()
    {
        return $this->values['doc_title'];
    }

    /**
     * 判断 文档标题 是否存在
     * @return true 或 false
     **/
    public function IsDoc_titleSet()
    {
        return array_key_exists('doc_title', $this->values);
    }

    /**
     * 设置 PDF模板
     * @param string $value
     **/
    public function SetFile($value)
    {
        $this->values['file'] = $value;
    }

    /**
     * 判断 PDF模板 是否存在
     * @return true 或 false
     **/
    public function IsFileSet()
    {
        return array_key_exists('file', $this->values);
    }

    /**
     * 设置 合同编号
     * @param string $value
     **/
    public function SetContract_id($value)
    {
        $this->values['contract_id'] = $value;

        return $this;
    }

    /**
     * 获取 合同编号
     * @return 值
     **/
    public function GetContract_id()
    {
        return $this->values['contract_id'];
    }

    /**
     * 判断 合同编号 是否存在
     * @return true 或 false
     **/
    public function IsContract_idSet()
    {
        return array_key_exists('contract_id', $this->values);
    }

    /**
     * 设置 字体大小
     * @param string $value
     **/
    public function SetFont_size($value)
    {
        $this->values['font_size'] = $value;
    }

    /**
     * 获取 字体大小
     * @return 值
     **/
    public function GetFont_size()
    {
        return $this->values['font_size'];
    }

    /**
     * 判断 字体大小 是否存在
     * @return true 或 false
     **/
    public function IsFont_sizeSet()
    {
        return array_key_exists('font_size', $this->values);
    }

    /**
     * 设置 字体类型
     * @param string $value
     **/
    public function SetFont_type($value)
    {
        $this->values['font_type'] = $value;
    }

    /**
     * 获取 字体类型
     * @return 值
     **/
    public function GetFont_type()
    {
        return $this->values['font_type'];
    }

    /**
     * 判断 字体类型 是否存在
     * @return true 或 false
     **/
    public function IsFont_typeSet()
    {
        return array_key_exists('font_type', $this->values);
    }

    /**
     * 设置 填充内容
     * @param string $value
     **/
    public function SetParameter_map($value)
    {
        $this->values['parameter_map'] = $value;

        return $this;
    }

    /**
     * 获取 填充内容
     * @return 值
     **/
    public function GetParameter_map()
    {
        return $this->values['parameter_map'];
    }

    /**
     * 判断 填充内容 是否存在
     * @return true 或 false
     **/
    public function IsParameter_mapSet()
    {
        return array_key_exists('parameter_map', $this->values);
    }

    /**
     * 设置 动态表格
     * @param string $value
     **/
    public function SetDynamic_tables($value)
    {
        $this->values['dynamic_tables'] = $value;
    }

    /**
     * 获取 动态表格
     * @return 值
     **/
    public function GetDynamic_tables()
    {
        return $this->values['dynamic_tables'];
    }

    /**
     * 判断 动态表格 是否存在
     * @return true 或 false
     **/
    public function IsDynamic_tablesSet()
    {
        return array_key_exists('dynamic_tables', $this->values);
    }

    /**
     * 设置 页面添加table
     * @param string $value
     **/
    public function SetInsertWay($value)
    {
        $this->values['insertWay'] = $value;
    }

    /**
     * 获取 页面添加table
     * @return 值
     **/
    public function GetInsertWay()
    {
        return $this->values['insertWay'];
    }

    /**
     * 判断 页面添加table 是否存在
     * @return true 或 false
     **/
    public function IsInsertWaySet()
    {
        return array_key_exists('insertWay', $this->values);
    }

    /**
     * 设置 关键字
     * @param string $value
     **/
    public function SetKeyword($value)
    {
        $this->values['keyword'] = $value;
    }

    /**
     * 获取 关键字
     * @return 值
     **/
    public function GetKeyword()
    {
        return $this->values['keyword'];
    }

    /**
     * 判断 关键字 是否存在
     * @return true 或 false
     **/
    public function IsKeywordSet()
    {
        return array_key_exists('keyword', $this->values);
    }

    /**
     * 设置 从第几页开始
     * @param string $value
     **/
    public function SetPageBegin($value)
    {
        $this->values['pageBegin'] = $value;
    }

    /**
     * 获取 从第几页开始
     * @return 值
     **/
    public function GetPageBegin()
    {
        return $this->values['pageBegin'];
    }

    /**
     * 判断 从第几页开始 是否存在
     * @return true 或 false
     **/
    public function IsPageBeginSet()
    {
        return array_key_exists('pageBegin', $this->values);
    }

    /**
     * 设置 边框
     * @param string $value
     **/
    public function SetBorderFlag($value)
    {
        $this->values['borderFlag'] = $value;
    }

    /**
     * 获取 边框
     * @return 值
     **/
    public function GetBorderFlag()
    {
        return $this->values['borderFlag'];
    }

    /**
     * 判断 边框 是否存在
     * @return true 或 false
     **/
    public function IsBorderFlagSet()
    {
        return array_key_exists('borderFlag', $this->values);
    }

    /**
     * 设置 正文行高
     * @param string $value
     **/
    public function SetCellHeight($value)
    {
        $this->values['cellHeight'] = $value;
    }

    /**
     * 获取 正文行高
     * @return 值
     **/
    public function GetCellHeight()
    {
        return $this->values['cellHeight'];
    }

    /**
     * 判断 正文行高 是否存在
     * @return true 或 false
     **/
    public function IsCellHeightSet()
    {
        return array_key_exists('cellHeight', $this->values);
    }

    /**
     * 设置 Table中每个单元的水平对齐方式
     * @param string $value
     **/
    public function SetCellHorizontalAlignment($value)
    {
        $this->values['cellHorizontalAlignment'] = $value;
    }

    /**
     * 获取 Table中每个单元的水平对齐方式
     * @return 值
     **/
    public function GetCellHorizontalAlignment()
    {
        return $this->values['cellHorizontalAlignment'];
    }

    /**
     * 判断 Table中每个单元的水平对齐方式 是否存在
     * @return true 或 false
     **/
    public function IsCellHorizontalAlignmentSet()
    {
        return array_key_exists('cellHorizontalAlignment', $this->values);
    }

    /**
     * 设置 Table中每个单元的垂直对齐方式
     * @param string $value
     **/
    public function SetCellVerticalAlignment($value)
    {
        $this->values['cellVerticalAlignment'] = $value;
    }

    /**
     * 获取 Table中每个单元的垂直对齐方式
     * @return 值
     **/
    public function GetCellVerticalAlignment()
    {
        return $this->values['cellVerticalAlignment'];
    }

    /**
     * 判断 Table中每个单元的垂直对齐方式 是否存在
     * @return true 或 false
     **/
    public function IsCellVerticalAlignmentSet()
    {
        return array_key_exists('cellVerticalAlignment', $this->values);
    }

    /**
     * 设置 表头上方的一级标题
     * @param string $value
     **/
    public function SetTheFirstHeader($value)
    {
        $this->values['theFirstHeader'] = $value;
    }

    /**
     * 获取 表头上方的一级标题
     * @return 值
     **/
    public function GetTheFirstHeader()
    {
        return $this->values['theFirstHeader'];
    }

    /**
     * 判断 表头上方的一级标题 是否存在
     * @return true 或 false
     **/
    public function IsTheFirstHeaderSet()
    {
        return array_key_exists('theFirstHeader', $this->values);
    }

    /**
     * 设置 表头信息
     * @param string $value
     **/
    public function SetHeaders($value)
    {
        $this->values['headers'] = $value;
    }

    /**
     * 获取 表头信息
     * @return 值
     **/
    public function GetHeaders()
    {
        return $this->values['headers'];
    }

    /**
     * 判断 表头信息 是否存在
     * @return true 或 false
     **/
    public function IsHeadersSet()
    {
        return array_key_exists('headers', $this->values);
    }

    /**
     * 设置 表头对齐方式
     * @param string $value
     **/
    public function SetHeadersAlignment($value)
    {
        $this->values['headersAlignment'] = $value;
    }

    /**
     * 获取 表头对齐方式
     * @return 值
     **/
    public function GetHeadersAlignment()
    {
        return $this->values['headersAlignment'];
    }

    /**
     * 判断 表头对齐方式 是否存在
     * @return true 或 false
     **/
    public function IsHeadersAlignmentSet()
    {
        return array_key_exists('headersAlignment', $this->values);
    }

    /**
     * 设置 正文
     * @param string $value
     **/
    public function SetDatas($value)
    {
        $this->values['datas'] = $value;
    }

    /**
     * 获取 正文
     * @return 值
     **/
    public function GetDatas()
    {
        return $this->values['datas'];
    }

    /**
     * 判断 正文 是否存在
     * @return true 或 false
     **/
    public function IsDatasSet()
    {
        return array_key_exists('datas', $this->values);
    }

    /**
     * 设置 各列宽度比例
     * @param string $value
     **/
    public function SetColWidthPercent($value)
    {
        $this->values['colWidthPercent'] = $value;
    }

    /**
     * 获取 各列宽度比例
     * @return 值
     **/
    public function GetColWidthPercent()
    {
        return $this->values['colWidthPercent'];
    }

    /**
     * 判断 各列宽度比例 是否存在
     * @return true 或 false
     **/
    public function IsColWidthPercentSet()
    {
        return array_key_exists('colWidthPercent', $this->values);
    }

    /**
     * 设置 table的水平对齐方式
     * @param string $value
     **/
    public function SetTableHorizontalAlignment($value)
    {
        $this->values['tableHorizontalAlignment'] = $value;
    }

    /**
     * 获取 table的水平对齐方式
     * @return 值
     **/
    public function GetTableHorizontalAlignment()
    {
        return $this->values['tableHorizontalAlignment'];
    }

    /**
     * 判断 table的水平对齐方式 是否存在
     * @return true 或 false
     **/
    public function IsTableHorizontalAlignmentSet()
    {
        return array_key_exists('tableHorizontalAlignment', $this->values);
    }

    /**
     * 设置 table宽度的百分比
     * @param string $value
     **/
    public function SetTableWidthPercentage($value)
    {
        $this->values['tableWidthPercentage'] = $value;
    }

    /**
     * 获取 table宽度的百分比
     * @return 值
     **/
    public function GetTableWidthPercentage()
    {
        return $this->values['tableWidthPercentage'];
    }

    /**
     * 判断 table宽度的百分比 是否存在
     * @return true 或 false
     **/
    public function IsTableWidthPercentageSet()
    {
        return array_key_exists('tableWidthPercentage', $this->values);
    }

    /**
     * 设置 设置table居左居中居右后的水平偏移量
     * @param string $value
     **/
    public function SetTableHorizontalOffset($value)
    {
        $this->values['tableHorizontalOffset'] = $value;
    }

    /**
     * 获取 设置table居左居中居右后的水平偏移量
     * @return 值
     **/
    public function GetTableHorizontalOffset()
    {
        return $this->values['tableHorizontalOffset'];
    }

    /**
     * 判断 设置table居左居中居右后的水平偏移量 是否存在
     * @return true 或 false
     **/
    public function IsTableHorizontalOffsetSet()
    {
        return array_key_exists('tableHorizontalOffset', $this->values);
    }

}

/**
 * 合同签署类
 * Class FddSignContract
 */
class FddSignContract extends FddDataBase
{
    /**
     * 设置 签署时所传合同编号
     * @param string $value
     **/
    public function SetContract_id($value)
    {
        $this->values['contract_id'] = $value;

        return $this;
    }

    /**
     * 获取 签署时所传合同编号
     * @param string $value
     **/
    public function GetContract_id()
    {
        return $this->values['contract_id'];
    }

    /**
     * 判断 签署时所传合同编号 是否存在
     * @return true 或 false
     **/
    public function IsContract_idSet()
    {
        return array_key_exists('contract_id', $this->values);
    }

    /**
     * 设置 签署时所传客户编号
     * @param string $value
     **/
    public function SetCustomer_id($value)
    {
        $this->values['customer_id'] = $value;

        return $this;
    }

    /**
     * 获取 签署时所传合同编号
     * @param string $value
     **/
    public function GetCustomer_id()
    {
        return $this->values['customer_id'];
    }

    /**
     * 判断 签署时所传客户编号 是否存在
     * @return true 或 false
     **/
    public function IsCustomer_idSet()
    {
        return array_key_exists('customer_id', $this->values);
    }

    /**
     * 设置 签署时所传交易号
     * @param string $value
     **/
    public function SetTransaction_id($value)
    {
        $this->values['transaction_id'] = $value;

        return $this;
    }

    /**
     * 获取 是否设置有效期
     * @param string $value
     **/
    public function GetTransaction_id()
    {
        return $this->values['transaction_id'];
    }

    /**
     * 判断 签署时所传交易号 是否存在
     **/
    public function IsTransaction_idSet()
    {
        return array_key_exists('transaction_id', $this->values);
    }

    /**
     * 设置 有效时间
     * @param string $value
     **/
    public function SetExpire_time($value)
    {
        $this->values['expire_time'] = $value;
    }

    /**
     * 设置 传入url
     * @param string $value
     **/
    public function SetSource_url($value)
    {
        $this->values['source_url'] = $value;
    }

    /**
     * 判断 传入url 是否存在
     **/
    public function IsSource_urlSet()
    {
        return array_key_exists('source_url', $this->values);
    }

    /**
     * 设置 短信标识
     * @param string $value
     **/
    public function SetPush_type($value)
    {
        $this->values['push_type'] = $value;
    }

    /**
     * 判断 短信标识 是否存在
     **/
    public function IsPush_typeSet()
    {
        return array_key_exists('push_type', $this->values);
    }

    /**
     * 设置 定位关键字
     * @param string $value
     **/
    public function SetSign_keyword($value)
    {
        $this->values['sign_keyword'] = $value;

        return $this;
    }

    /**
     * 获取 有效期
     **/
    public function GetSign_keyword()
    {
        return $this->values['sign_keyword'];
    }

    /**
     * 判断 定位关键字 是否存在
     **/
    public function IsSign_keywordSet()
    {
        return array_key_exists('sign_keyword', $this->values);
    }

    /**
     * 设置 定位关键字(多)
     * @param string $value
     **/
    public function SetSign_keywords($value)
    {
        $this->values['sign_keywords'] = $value;
    }

    /**
     * 判断 定位关键字（多） 是否存在
     **/
    public function IsSign_keywordsSet()
    {
        return array_key_exists('sign_keywords', $this->values);
    }

    /**
     * 设置 是否设置有效期
     * @param string $value
     **/
    public function SetLimit_type($value)
    {
        $this->values['limit_type'] = $value;
    }

    /**
     * 获取 是否设置有效期
     **/
    public function GetLimit_type()
    {
        return $this->values['limit_type'];
    }

    /**
     * 判断 是否设置有效期 是否存在
     **/
    public function IsLimit_typeSet()
    {
        return array_key_exists('limit_type', $this->values);
    }

    /**
     * 设置 有效期
     * @param string $value
     **/
    public function SetValidity($value)
    {
        $this->values['validity'] = $value;

        return $this;
    }

    /**
     * 获取 有效期
     **/
    public function GetValidity()
    {
        return $this->values['validity'];
    }

    /**
     * 判断 有效期 是否存在
     **/
    public function IsValiditySet()
    {
        return array_key_exists('validity', $this->values);
    }

    /**
     * 设置 页面跳转url（签名结果同步通知）
     * @param string $value
     **/
    public function SetReturn_url($value)
    {
        $this->values['return_url'] = $value;

        return $this;
    }

    /**
     * 判断 页面跳转url（签名结果同步通知） 是否存在
     **/
    public function IsReturn_urlSet()
    {
        return array_key_exists('return_url', $this->values);
    }

    /**
     * 设置 签名结果异步步通知url
     * @param string $value
     **/
    public function SetNotify_url($value)
    {
        $this->values['notify_url'] = $value;

        return $this;
    }

    /**
     * 设置 签名结果异步步通知url
     * @param string $value
     **/
    public function IsNotify_urlSet()
    {
        return array_key_exists('notify_url', $this->values);
    }

    /**
     * 设置 文档标题
     * @param string $value
     **/
    public function SetDoc_title($value)
    {
        $this->values['doc_title'] = $value;

        return $this;
    }

    /**
     * 获取 文档标题
     * @param string $value
     **/
    public function GetDoc_title()
    {
        return $this->values['doc_title'];
    }

    /**
     * 判断 文档标题 是否存在
     * @return true 或 false
     **/
    public function IsDoc_titleSet()
    {
        return array_key_exists('doc_title', $this->values);
    }

    /**
     * 设置 手写章
     * @param string $value
     **/
    public function SetHandsignimg($value)
    {
        $this->values['handsignimg'] = $value;
    }

    /**
     * 设置 短信验证码
     * @param string $value
     **/
    public function SetSms($value)
    {
        $this->values['sms'] = $value;
    }

    /**
     * 判断 短信验证码 是否存在
     * @param string $value
     **/
    public function IsSmsSet()
    {
        return array_key_exists('sms', $this->values);
    }

    /**
     * 设置 短信校验令牌
     * @param string $value
     **/
    public function SetMarkUUID($value)
    {
        $this->values['markUUID'] = $value;
    }

    /**
     * 判断 短信校验令牌 是否存在
     * @param string $value
     **/
    public function IsMarkUUIDSet()
    {
        return array_key_exists('markUUID', $this->values);
    }

    /**
     * 设置 批量签署记录主键
     * @param string $value
     **/
    public function SetExtBatchSignId($value)
    {
        $this->values['extBatchSignId'] = $value;
    }

    /**
     * 判断 批量签署记录主键 是否存在
     * @param string $value
     **/
    public function IsExtBatchSignIdSet()
    {
        return array_key_exists('extBatchSignId', $this->values);
    }

    /**
     * 设置 填充内容
     * @param string $value
     **/
    public function SetParameter_map($value)
    {
        $this->values['parameter_map'] = $value;
    }

    /**
     * 判断 填充内容 是否存在
     * @return true 或 false
     **/
    public function IsParameter_mapSet()
    {
        return array_key_exists('parameter_map', $this->values);
    }

    /**
     * 设置 签署截止时间
     * @param string $value
     **/
    public function SetExpiration_time($value)
    {
        $this->values['expiration_time'] = $value;
    }

    /**
     * 判断 签署截止时间 是否存在
     * @return true 或 false
     **/
    public function IsExpiration_timeSet()
    {
        return array_key_exists('expiration_time', $this->values);
    }

    /**
     * 设置 是否发送通知（短信 及邮件）
     * @param string $value
     **/
    public function SetSend_msg($value)
    {
        $this->values['send_msg'] = $value;
    }

    /**
     * 判断 是否发送通知（短信 及邮件） 是否存在
     * @return true 或 false
     **/
    public function IsSend_msgSet()
    {
        return array_key_exists('send_msg', $this->values);
    }

    /**
     * 设置 待签署人姓名
     * @param string $value
     **/
    public function SetUser_names($value)
    {
        $this->values['user_names'] = $value;
    }

    /**
     * 判断 待签署人姓名 是否存在
     * @return true 或 false
     **/
    public function IsUser_namesSet()
    {
        return array_key_exists('user_names', $this->values);
    }

    /**
     * 设置 待签署人手机号
     * @param string $value
     **/
    public function SetUser_mobiles($value)
    {
        $this->values['user_mobiles'] = $value;
    }

    /**
     * 判断 待签署人手机号 是否存在
     * @return true 或 false
     **/
    public function IsUser_mobilesSet()
    {
        return array_key_exists('user_mobiles', $this->values);
    }

    /**
     * 设置 待签署人邮箱
     * @param string $value
     **/
    public function SetUser_emails($value)
    {
        $this->values['user_emails'] = $value;
    }

    /**
     * 判断 待签署人邮箱 是否存在
     * @return true 或 false
     **/
    public function IsUser_emailsSet()
    {
        return array_key_exists('user_emails', $this->values);
    }

    /**
     * 设置 批次号（流水号）
     * @param string $value
     **/
    public function SetBatch_id($value)
    {
        $this->values['batch_id'] = $value;

        return $this;
    }

    /**
     * 获取 批次号（流水号）
     * @param string $value
     **/
    public function GetBatch_id()
    {
        return $this->values['batch_id'];
    }

    /**
     * 判断 批次号（流水号） 是否存在
     * @return true 或 false
     **/
    public function IsBatch_idSet()
    {
        return array_key_exists('batch_id', $this->values);
    }

    /**
     * 设置 代理人客户编号
     * @param string $value
     **/
    public function SetOuth_customer_id($value)
    {
        $this->values['outh_customer_id'] = $value;
    }

    /**
     * 获取 代理人客户编号
     * @param string $value
     **/
    public function GetOuth_customer_id()
    {
        return $this->values['outh_customer_id'];
    }

    /**
     * 判断 代理人客户编号 是否存在
     * @return true 或 false
     **/
    public function IsOuth_customer_idSet()
    {
        return array_key_exists('outh_customer_id', $this->values);
    }

    /**
     * 设置 签章数据
     * @param string $value
     **/
    public function SetSign_data($value)
    {
        $this->values['sign_data'] = $value;

        return $this;
    }

    /**
     * 获取 签章数据
     * @param string $value
     **/
    public function GetSign_data()
    {
        return $this->values['sign_data'];
    }

    /**
     * 判断 签章数据 是否存在
     * @return true 或 false
     **/
    public function IsSign_dataSet()
    {
        return array_key_exists('sign_data', $this->values);
    }

    /**
     * 设置 批量请求标题
     * @param string $value
     **/
    public function SetBatch_title($value)
    {
        $this->values['batch_title'] = $value;

        return $this;
    }

    /**
     * 获取 批量请求标题
     * @param string $value
     **/
    public function GetBatch_title()
    {
        return $this->values['batch_title'];
    }

    /**
     * 判断 批量请求标题 是否存在
     * @return true 或 false
     **/
    public function IsBatch_titleSet()
    {
        return array_key_exists('batch_title', $this->values);
    }

    /**
     * 设置 客户类型
     * @param string $value
     **/
    public function SetClientType($value)
    {
        $this->values['clientType'] = $value;
    }

    /**
     * 判断 客户类型 是否存在
     * @return true 或 false
     **/
    public function IsClientTypeSet()
    {
        return array_key_exists('clientType', $this->values);
    }

    /**
     * 设置 客户角色
     * @param string $value
     **/
    public function SetClient_role($value)
    {
        $this->values['client_role'] = $value;
    }

    /**
     * 判断 客户角色 是否存在
     * @return true 或 false
     **/
    public function IsClient_roleSet()
    {
        return array_key_exists('client_role', $this->values);
    }

    /**
     * 设置 有效次数
     * @param string $value
     **/
    public function SetQuantity($value)
    {
        $this->values['quantity'] = $value;

        return $this;
    }

    /**
     * 获取 有效次数
     * @param string $value
     **/
    public function GetQuantity()
    {
        return $this->values['quantity'];
    }

    /**
     * 判断 有效次数 是否存在
     * @return true 或 false
     **/
    public function IsQuantitySet()
    {
        return array_key_exists('quantity', $this->values);
    }

    /**
     * 设置 关键字签章策略
     * @param string $value
     **/
    public function SetKeyword_strategy($value)
    {
        $this->values['keyword_strategy'] = $value;
    }

    /**
     * 判断 关键字签章策略 是否存在
     * @return true 或 false
     **/
    public function IsKeyword_strategySet()
    {
        return array_key_exists('keyword_strategy', $this->values);
    }

    /**
     * 设置 关键字签章策略
     * @param string $value
     **/
    public function SetAcrosspage_customer_id($value)
    {
        $this->values['acrosspage_customer_id'] = $value;
    }

    /**
     * 判断 关键字签章策略 是否存在
     * @return true 或 false
     **/
    public function IsAcrosspage_customer_idSet()
    {
        return array_key_exists('acrosspage_customer_id', $this->values);
    }

    /**
     * 设置 定位类型
     * @param string $value
     **/
    public function SetPosition_type($value)
    {
        $this->values['position_type'] = $value;
    }

    /**
     * 获取 定位类型
     * @param string $value
     **/
    public function GetPosition_type()
    {
        return $this->values['position_type'];
    }

    /**
     * 判断 定位类型 是否存在
     * @return true 或 false
     **/
    public function IsPosition_typeSet()
    {
        return array_key_exists('position_type', $this->values);
    }

    /**
     * 设置 盖章点x坐标
     * @param string $value
     **/
    public function SetX($value)
    {
        $this->values['x'] = $value;
    }

    /**
     * 获取 盖章点X坐标
     * @param string $value
     **/
    public function GetX()
    {
        return $this->values['x'];
    }

    /**
     * 判断 盖章点x坐标 是否存在
     * @return true 或 false
     **/
    public function IsXSet()
    {
        return array_key_exists('x', $this->values);
    }

    /**
     * 设置 签章页码，从0开始。
     * @param string $value
     **/
    public function SetPagenum($value)
    {
        $this->values['pagenum'] = $value;
    }

    /**
     * 获取 盖章点Y坐标
     * @param string $value
     **/
    public function GetPagenum()
    {
        return $this->values['pagenum'];
    }

    /**
     * 判断 签章页码，从 0开始。 是否存在
     * @return true 或 false
     **/
    public function IsPagenumSet()
    {
        return array_key_exists('pagenum', $this->values);
    }

    /**
     * 设置 定位坐标
     * @param string $value
     **/
    public function SetSignature_positions($value)
    {
        $this->values['signature_positions'] = $value;
    }

    /**
     * 设置 盖章点Y坐标
     * @param string $value
     **/
    public function SetY($value)
    {
        $this->values['y'] = $value;
    }

    /**
     * 获取 盖章点Y坐标
     * @param string $value
     **/
    public function GetY()
    {
        return $this->values['y'];
    }

    /**
     * 判断 盖章点Y坐标 是否存在
     * @return true 或 false
     **/
    public function IsYSet()
    {
        return array_key_exists('Y', $this->values);
    }

    /**
     * 设置 签章图片类型
     * @param string $value
     **/
    public function SetShow_type($value)
    {
        $this->values['show_type'] = $value;
    }

    /**
     * 设置 替换标志
     * @param string $value
     **/
    public function SetReplace_signature_flag($value)
    {
        $this->values['replace_signature_flag'] = $value;
    }

    /**
     * 设置 合同 url 地址
     * @param string $value
     **/
    public function SetDoc_url($value)
    {
        $this->values['doc_url'] = $value;
    }

    /**
     * 判断 合同 url 地址 是否存在
     * @return true 或 false
     **/
    public function IsDoc_urlSet()
    {
        return array_key_exists('doc_url', $this->values);
    }

    /**
     * 设置 合同流文件
     * @param string $value
     **/
    public function SetFile($value)
    {
        $this->values['file'] = $value;
    }

    /**
     * 判断 合同流文件 是否存在
     * @return true 或 false
     **/
    public function IsFileSet()
    {
        return array_key_exists('file', $this->values);
    }
}

/**
 * 合同管理类
 * Class FddContractManageMent
 */
class FddContractManageMent extends FddDataBase
{
    /**
     * 设置 合同编号
     * @param string $value
     **/
    public function SetContract_id($value)
    {
        $this->values['contract_id'] = $value;

        return $this;
    }

    /**
     * 获取 签署时所传合同编号
     * @param string $value
     **/
    public function GetContract_id()
    {
        return $this->values['contract_id'];
    }

    /**
     * 判断 签署时所传合同编号 是否存在
     * @return true 或 false
     **/
    public function IsContract_idSet()
    {
        return array_key_exists('contract_id', $this->values);
    }

    /**
     * 设置 合同编号（多）
     * @param string $value
     **/
    public function SetContract_ids($value)
    {
        $this->values['contract_ids'] = $value;
    }

    /**
     * 判断 签署时所传合同编号 是否存在
     * @return true 或 false
     **/
    public function IsContract_idsSet()
    {
        return array_key_exists('contract_ids', $this->values);
    }

    /**
     * 设置用户ID
     * @param string $value
     **/
    public function SetCustomer_id($value)
    {
        $this->values['customer_id'] = $value;
    }

    /**
     * 设置 有效期
     * @param string $value
     **/
    public function SetValidity($value)
    {
        $this->values['validity'] = $value;
    }

    /**
     * 判断 有效期 是否存在
     * @param string $value
     **/
    public function IsValiditySet()
    {
        return array_key_exists('validity', $this->values);
    }

    /**
     * 设置 有效次数
     * @param string $value
     **/
    public function SetQuantity($value)
    {
        $this->values['quantity'] = $value;
    }

    /**
     * 判断 有效次数 是否存在
     * @return true 或 false
     **/
    public function IsQuantitySet()
    {
        return array_key_exists('quantity', $this->values);
    }
}

/**
 * 用户管理类
 * Class FddUserManage
 */
class FddUserManage extends FddDataBase
{
    /**
     * 设置 合同ID
     * @param string $value
     **/
    public function SetContract_id($value)
    {
        $this->values['contract_id'] = $value;
    }

    /**
     * 设置 用户ID
     * @param string $value
     **/
    public function SetCustomer_id($value)
    {
        $this->values['customer_id'] = $value;
    }

    /**
     * 判断 用户ID 是否存在
     * @return true 或 false
     **/
    public function IsCustomer_idSet()
    {
        return array_key_exists('customer_id', $this->values);
    }

    /**
     * 设置 电子邮箱
     * @param string $value
     **/
    public function SetEmail($value)
    {
        $this->values['email'] = $value;
    }

    /**
     * 设置 手机号码
     * @param string $value
     **/
    public function SetMobile($value)
    {
        $this->values['mobile'] = $value;
    }
}

/**
 * 查看存证界面
 * Class FddWitnessView
 */
class FddWitnessView extends FddDataBase
{
    /**
     * 设置合同ID
     * @param string $value
     **/
    public function SetContract_id($value)
    {
        $this->values['contract_id'] = $value;
    }

    /**
     * 设置用户ID
     * @param string $value
     **/
    public function SetCustomer_id($value)
    {
        $this->values['customer_id'] = $value;
    }

}

/**
 * 文件加密存证
 * Class FddFileEncryptWitness
 */
class FddFileEncryptWitness extends FddDataBase
{
    /**
     * 设置文件名
     * @param string $value
     **/
    public function SetFile_name($value)
    {
        $this->values['file_name'] = $value;
    }

    /**
     * 设置文件最后修改时间
     * @param string $value
     **/
    public function SetNoper_time($value)
    {
        $this->values['noper_time'] = $value;
    }

    /**
     * 设置文件大小
     * @param string $value
     **/
    public function SetFile_size($value)
    {
        $this->values['file_size'] = $value;
    }

    /**
     * 设置原文hash值
     * @param string $value
     **/
    public function SetSha256($value)
    {
        $this->values['sha256'] = $value;
    }

    /**
     * 设置密文hash值，用于出证接口
     * @param string $value
     **/
    public function SetEncrypt_sha256($value)
    {
        $this->values['encrypt_sha256'] = $value;
    }

    /**
     * 设置 秘钥
     * @param string $value
     **/
    public function SetKey($value)
    {
        $this->values['key'] = $value;
    }

    /**
     * 获取 秘钥
     * @param string $value
     **/
    public function GetKey()
    {
        return $this->values['key'];
    }

    /**
     * 设置文档地址
     * @param string $value
     **/
    public function SetDoc_url($value)
    {
        $this->values['doc_url'] = $value;
    }

    /**
     * 获取 文档地址
     * @param string $value
     **/
    public function GetDoc_url()
    {
        return $this->values['doc_url'];
    }

    /**
     * 判断 合同 url 地址 是否存在
     * @return true 或 false
     **/
    public function IsDoc_urlSet()
    {
        return array_key_exists('doc_url', $this->values);
    }

    /**
     * 设置 流文件
     * @param string $value
     **/
    public function SetFile($value)
    {
        $this->values['file'] = $value;
    }

    /**
     * 判断 流文件 是否存在
     * @return true 或 false
     **/
    public function IsFileSet()
    {
        return array_key_exists('file', $this->values);
    }

    /**
     * 设置交易号
     * @param string $value
     **/
    public function SetTransaction_id($value)
    {
        $this->values['transaction_id'] = $value;
    }
}

/**
 * 加密出证
 * Class FddGetEncryptWitness
 */
class FddGetEncryptWitness extends FddDataBase
{
    /**
     * 设置序列号
     * @param string $value
     **/
    public function SetSerialno($value)
    {
        $this->values['serialno'] = $value;
    }

    /**
     * 设置加密类型 1 AES128   (目前仅支持AES128)
     * @param string $value
     **/
    public function SetEncryption_type($value)
    {
        $this->values['encryption_type'] = $value;
    }

    /**
     * 设置加密秘钥
     * @param string $value
     **/
    public function SetSecurity_key($value)
    {
        $this->values['security_key'] = $value;
    }

    /**
     * 获取加密秘钥
     * @return $this
     **/
    public function GetSecurity_key()
    {
        return $this->values['security_key'];
    }
}

/**
 * 存证校验
 * Class FddWitnessVerifyEncrypt
 */
class FddWitnessVerifyEncrypt extends FddDataBase
{
    /**
     * 设置序列号 存证接口返回的序列号
     * @param string $value
     **/
    public function SetSerialno($value)
    {
        $this->values['serialno'] = $value;
    }

    /**
     * 判断 序列号 是否存在
     * @return true 或 false
     **/
    public function IsSerialnoSet()
    {
        return array_key_exists('serialno', $this->values);
    }

    /**
     * 设置 存证类型：1哈希存证 ;2文件存证;3密文存证
     * @param string $value
     **/
    public function SetWitness_type($value)
    {
        $this->values['witness_type'] = $value;
    }

    /**
     * 获取 存证类型：1哈希存证 ;2文件存证
     * @param string $value
     **/
    public function GetWitness_type()
    {
        return $this->values['witness_type'];
    }

    /**
     * 判断 存证类型：1哈希存证 ;2文件存证;3密文存证 是否存在
     * @return true 或 false
     **/
    public function IsWitness_typeSet()
    {
        return array_key_exists('witness_type', $this->values);
    }

    /**
     * 设置 原文hash值：sha256算法
     * @param string $value
     **/
    public function SetSha256($value)
    {
        $this->values['sha256'] = $value;
    }

    /**
     * 判断 原文hash值：sha256算法 是否存在
     * @return true 或 false
     **/
    public function IsSha256Set()
    {
        return array_key_exists('sha256', $this->values);
    }

    /**
     * 设置 待比对原文件
     * @param object $value
     **/
    public function SetFile($value)
    {
        $this->values['file'] = $value;
    }

    /**
     * 判断 待比对原文件 是否存在
     * @return true 或 false
     **/
    public function IsFileSet()
    {
        return array_key_exists('file', $this->values);
    }

    /**
     * 设置 文件名
     * @param string $value
     **/
    public function SetFile_name($value)
    {
        $this->values['file_name'] = $value;
    }

    /**
     * 判断 文件名 是否存在
     * @return true 或 false
     **/
    public function IsFile_nameSet()
    {
        return array_key_exists('file_name', $this->values);
    }

    /**
     * 设置 文件大小
     * @param string $value
     **/
    public function SetFile_size($value)
    {
        $this->values['file_size'] = $value;
    }

    /**
     * 判断 文件大小 是否存在
     * @return true 或 false
     **/
    public function IsFile_sizeSet()
    {
        return array_key_exists('file_size', $this->values);
    }

    /**
     * 设置 文件最后修改时间
     * @param string $value
     **/
    public function SetNoper_time($value)
    {
        $this->values['noper_time'] = $value;
    }

    /**
     * 判断 文件最后修改时间 是否存在
     * @return true 或 false
     **/
    public function IsNoper_timeSet()
    {
        return array_key_exists('noper_time', $this->values);
    }

    /**
     * 设置密文hash值 当witness_type为3时encrypt_sha256为必选
     * @param string $value
     **/
    public function SetEncrypt_sha256($value)
    {
        $this->values['encrypt_sha256'] = $value;
    }

    /**
     * 设置 签署时所传交易号
     * @param string $value
     **/
    public function SetTransaction_id($value)
    {
        $this->values['transaction_id'] = $value;
    }

    /**
     * 获取 是否设置有效期
     * @param string $value
     **/
    public function GetTransaction_id()
    {
        return $this->values['transaction_id'];
    }

    /**
     * 判断 签署时所传交易号 是否存在
     * @param string $value
     **/
    public function IsTransaction_idSet()
    {
        return array_key_exists('transaction_id', $this->values);
    }

    /**
     * 设置 文档地址
     * @param string $value
     **/
    public function SetDoc_url($value)
    {
        $this->values['doc_url'] = $value;
    }

    /**
     * 判断 文档地址 是否存在
     * @param string $value
     **/
    public function IsDoc_urlSet()
    {
        return array_key_exists('doc_url', $this->values);
    }
}

?>
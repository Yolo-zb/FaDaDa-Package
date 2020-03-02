<?php
namespace Zhuobin\FaDaDa\Src;
/**
 * 3DES加解密类
 */
class FddEncryption
{

    public $key = '';

    public function __construct()
    {
        $this->key = \Config::get('fadada.' . \Config::get('app.env') . '.app_secret');
    }

    /**
     * 兼容PHP7.2 3DES加密
     * @param $message
     * @return string
     */
    public  function encrypt($message){
        return $str  = bin2hex(openssl_encrypt($message, "des-ede3", $this->key,1));
    }

    /**
     * 合同生成msg_digest加密
     * @param FddTemplate $param
     * @return string
     */
    public static function ContractDigest(FddTemplate $param)
    {
        $sha1 = $param->GetApp_secret().$param->GetTemplate_id().$param->GetContract_id();
        $enc = base64_encode(strtoupper(sha1($param->GetApp_id().strtoupper(md5($param->GetTimestamp())).strtoupper(sha1($sha1)).$param->GetParameter_map())));
        return $enc;
    }
















    /**
     * 通用msg_digest加密函数
     * @param $param
     * @param $enc
     * @return string
     */
    public static function GeneralDigest($param, $enc)
    {
        $value = $param->GetValues();
        $md5Str = $param->GetTimestamp();
        $sha1Str = FddConfig::AppSecret;
        foreach ($enc as $k => $v) {
            switch ($k) {
                case "md5":
                    foreach ($v as $md5Key => $md5Value) {
                        if (isset($value[$md5Value])) {
                            $md5Str .= $value[$md5Value];
                        }
                    }
                    break;
                case "sha1":
                    foreach ($v as $sha1Key => $sha1Value) {
                        if (isset($value[$sha1Value])) {
                            $sha1Str .= $value[$sha1Value];
                        }
                    }
                    break;
            }
        }

        $enc = base64_encode(strtoupper(sha1(FddConfig::AppId . strtoupper(md5($md5Str)) . strtoupper(sha1($sha1Str)))));
        return $enc;
    }

    /**
     * 数组参数转字符串格式
     * @param $Array
     * @return string
     */
    public function ArrayParamToStr($Array)
    {
        $Str = "?";
        if (!empty($Array)) {
            foreach ($Array as $k => $v) {
                $Str .= $k . "=" . $v . "&";
            }
        }
        return trim($Str, "&");

    }


    /**
     * 字符串转ASCII
     * @param $array
     * @return array
     */
    public function Str2Ascii($array)
    {
        $AscII = [];
        // print_r($array);
        foreach ($array as $k => $v) {
            $AscII[trim($this->AsciiEncode($v))] = $v;
            // print_r($this->AsciiEncode($v));
        }
        array_multisort($AscII);
        return $AscII;
    }

    /**
     * 单字符串转ASCII值
     * @param $Str
     * @return string
     */
    public function AsciiEncode($Str)
    {
        $len = strlen($Str);
        $k = 0;
        $Asc = '';
        while ($k < $len) {
            $ascStr = ord($Str[$k]) . ' ';
            $zero = '';
            if (strlen($ascStr) < 4) {
                for ($i = 0; $i < 4 - strlen($ascStr); $i++) {
                    $zero .= '0';
                }
            }
            $Asc .= $zero . $ascStr;
            $k++;
        }
        return $Asc;
    }

    /**
     * 企业页面认证加密
     * @param FddCompanyPageAuth $param
     * @return string
     */
    public static function RealNameSyncCompanyDigest(FddCompanyPageAuth $param)
    {
        $enc = base64_encode(strtoupper(sha1(FddConfig::AppId . strtoupper(md5($param->GetCtrip_user_id() . $param->GetTimestamp())) . strtoupper(sha1(FddConfig::AppSecret . $param->GetIdent_no() . $param->GetName())))));
        return $enc;
    }

    /**
     * 合同推送接口msg_digest加密 (平台代理注册,用户自行注册)
     * @param FddSignContract $param
     * @return string
     */
    public static function PushDocsDigest(FddSignContract $param)
    {
        $sha1 = FddConfig::AppSecret . $param->GetContract_id();
        $enc = base64_encode(strtoupper(sha1(FddConfig::AppId . strtoupper(md5($param->GetTransaction_id() . $param->GetTimestamp())) . strtoupper(sha1($sha1)))));
        return $enc;
    }

    /**
     * 文档批量签署接口(半自动模式)msg_digest加密
     * @param FddSignContract $param
     * @return string
     */
    public static function GotoBatchDigest(FddSignContract $param)
    {
        $sha1 = FddConfig::AppSecret . $param->GetCustomer_id() . $param->GetOuth_customer_id();
        $enc = base64_encode(strtoupper(sha1(FddConfig::AppId . strtoupper(md5($param->GetBatch_id() . $param->GetTimestamp())) . strtoupper(sha1($sha1)))));
        return $enc;
    }

    /**
     * 文档批量签署接口(全自动模式)msg_digest加密
     * @param FddSignContract $param
     * @return string
     */
    public static function ExtBatchSignAutoDigest(FddSignContract $param)
    {
        $sha1 = FddConfig::AppSecret . $param->GetSign_data();
        $enc = base64_encode(strtoupper(sha1(FddConfig::AppId . strtoupper(md5($param->GetBatch_id() . $param->GetTimestamp())) . strtoupper(sha1($sha1)))));
        return $enc;
    }

    /**
     * 十六进制转化二进制
     * @param $hex
     * @return string
     */
    public static function hexToStr($hex)
    {

        $string = '';
        for ($i = 0; $i < strlen($hex) - 1; $i += 2) {
            $string .= chr(hexdec($hex[$i] . $hex[$i + 1]));

        }
        return $string;
    }

}

?>
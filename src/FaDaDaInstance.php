<?php

/**
 * Created by PhpStorm.
 * User: ZhuoBin
 * Date: 2019/6/17
 * Time: 上午10:46
 */

namespace Zhuobin\FaDaDa\Src;

use App\Exceptions\ApiException;

class FaDaDaInstance
{
    private $FaDaDa;

    public $required_class_arr = [
        [
            'GetUserAccount',//注册接口
            'GetShortUrl',//短链接口
            'GetUserIdentificationUrl',//获取个人实名认证地址
            'GetUuidFile',//通过uuid下载文件（例：身份证照片）
            'GetPersonVerifyInfo',//查询个人实名认证信息
            'PigeonholeContract'//合同归档接口
        ],
        'FddRealNameAuth' => [
            'RealNameAuthOperator',//三要素验证
            'FindPersonCertInfo'//通过CA证书查询客户信息
        ],
        'FddTemplate' => [
            'UploadContractTemplateCreate',//合同模版上传
            'ViewTemplate',//查看合同模版
            'GetPdfTemplateKeys',//获取模版key值接口
            'FillTemplateKeys'//填充合同接口
        ],
        'FddSignContract' => [
            'BatchSignContract',//批量文档签署（仅企业适用）
            'HandSignContract',//手动签署
            'AddSignature',//新增签章
            'SetSignature',//设置默认签章
            'GetSignature'//获取用户所有签章
        ],
        'FddDataBaseCA' => [
            'ApplyPersonalCA',//申请个人CA证书
            'ComEmailApplyCA'//申请企业CA证书
        ],
        'FddContractManageMent' => [
            'DeleteContract'//删档
        ],
        'FddAuthorization' => [
            'AuthorizeSignature'//企业授权给个人用户盖章
        ]
    ];
    /**
     * 实例
     * @var array
     */
    private $__helperInstance = array();

    public function __construct($function_name, $params)
    {
        // 初始化加载法大大类包
        $this->FaDaDa = new \Zhuobin\FaDaDa\FaBigBigOrigin ();

        if (!method_exists($this->FaDaDa, $function_name)) {
            throw new ApiException('方法不存在！');
        }

        $this->load_function($function_name, $params);
    }

    /**
     * 加载helper
     * @param $helper_name
     * @return bool
     */
    public function load_function($function_name, $params)
    {
        $required_class_name = '';

        foreach ($this->required_class_arr as $k => $v) {
            if (array_search($function_name, $v)) {
                $required_class_name = $k;
            }
        }

        if ($required_class_name) {
            $required_class = new $required_class_name ();

            $res = $this->FaDaDa->$function_name($required_class, $params);
        } else {
            $res = $this->FaDaDa->$function_name($params);
        }

        return $res;
    }
}
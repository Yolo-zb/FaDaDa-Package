<?php
/**
 * Created by PhpStorm.
 * User: hanzi
 * Date: 2019/4/22
 * Time: 下午4:16
 */

namespace Zhuobin\FaDaDa;

use App\Exceptions\ApiException;

require 'Fdd.Encryption.php';


class FaBigBigOrigin
{
    public $Fdd_Params = '';

    const Account_url = 'account_register.api';//法大大注册接口

    const User_verify_url = 'get_person_verify_url.api';//获取个人实名认证地址

    const Template_create_url = 'uploadtemplate.api';//合同模版生成

    const Three_element_verify_mobile_url = 'three_element_verify_mobile.api';//三要素验证接口

    const Check_Template_url = 'view_template.api';//查看模版

    const Template_key_url = 'get_pdftemplate_keys.api';//获取模版Key值

    const Fill_Template_url = 'generate_contract.api';//填充模版key值

    const Sign_contract_url = 'extsign_validation.api';//文档签署

//    const Batch_sign_contract_url = 'gotoBatchSemiautoSignPage.api';//批量文档签署

    const Batch_sign_contract_url = 'extBatchSign.api';//批量文档手动签署

    const Hand_sign_contract_url = 'extsign.api';//手动签署

    const Check_person_verify_url = 'find_personCertInfo.api';//查询个人实名认证信息

    const Apply_personCA_url = 'apply_cert.api';//获取个人CA证书

    const Pigeonhole_url = 'contractFiling.api';//合同归档

    const Person_cert_info_url = 'find_personCertInfo.api';//通过CA交易号获取用户信息接口

    const Short_url = 'short_url.api';//生成短链

    const Get_file_url = 'get_file.api ';//通过Uuid下载文件

    const Auto_company_apply_url = 'syncCompany_auto.api';//企业申请Ca接口

    const Delete_contract_url = 'contract_delete.api';//删除合同接口

    const Add_signature_url = 'add_signature.api';//新增签章接口

    const Set_signature_url = 'default_signature.api';//设置默认签章接口

    const Get_signature_url = 'query_signature.api';//设置默认签章接口

//    const Authorize_signature_url = 'authorize_signature.api';

    const Authorize_signature_url = 'authorization.api';

    static $Project_url = '';//Api接口地址

//    static $Project_url = 'https://kaola.kaolashebao.com/api';

//    const Project_url = 'https://kaolashebao.han-zi.cn/api';//项目URL

//    const Project_url = 'http://zhuobintwo.han-zi.cn/api';

    public function __construct()
    {
        self::$Project_url = \Config::get('app.url');

        $fddParams = new FddDataBase();

        $this->Fdd_Params = $fddParams->SetUrl(\Config::get('fabigbig.' . \Config::get('app.env') . '.url'))//设置ApiUrl
        ->SetApp_id(\Config::get('fabigbig.' . \Config::get('app.env') . '.app_id'))//设置app_id
        ->SetApp_secret(\Config::get('fabigbig.' . \Config::get('app.env') . '.app_secret'))//设置app_secret
        ->SetTimestamp(time())//设置时间戳
        ->SetV('2.5')//设置版本号
        ->GetValues();
    }

    //注册接口,ywu
    public function GetUserAccount($open_id)
    {
        //业务参数
        $param = [
            'account_type' => '1', //个人类型
            'open_id' => $open_id //用户在接入方的唯一标识//手机号
        ];

        $enc = [
            'md5' => [],
            'sha1' => ['account_type', 'open_id']
        ];

        $res = $this->_post(self::Account_url, $param, $enc);

        return $res;
    }

    //短链接
    public function GetShortUrl($url)
    {
        //业务参数
        $param = [
            'source_url' => $url //网址
        ];

        $enc = [
            'md5' => [],
            'sha1' => ['source_url']
        ];

        $res = $this->_post(self::Short_url, $param, $enc);

        return $res;
    }

    //获取个人实名认证地址
    public function GetUserIdentificationUrl($customer_data, $type = 1)
    {
//        $param = [
//            'customer_ident_type' => '0',
//            'verified_way' => '4',//实名认证套餐
//            'page_modify' => $customer_data['page_modify'],//是否允许用户修改1可修改，2不可修改
////            'notify_url' => 'http://zhuobin1.han-zi.cn/api/fbb/verify/notify',
////            'return_url' => 'http://zhuobin1.han-zi.cn/api/fbb/verify/return?customerId=F995536F966C523DD5328ADCA3D452EB&contractId=1557469966',
////            'customer_name' => '何卓斌',
////            'customer_ident_no' => '441324199711150090',
////            'mobile' => '13670617001',
////            'customer_id' => 'F995536F966C523DD5328ADCA3D452EB'
//            'notify_url' => $customer_data['notify_url'],//回调地址
//            'return_url' => $customer_data['return_url'],//回调地址
////            'customer_name' => $customer_data['name'],
////            'customer_ident_no' => $customer_data['identity_num'],
//            'mobile' => $customer_data['mobile'],
//            'customer_id' => $customer_data['customer_id'],//客户编号
//        ];

        $enc = [
            'md5' => [],
            'sha1' => ['customer_id', 'customer_ident_no', 'customer_ident_type', 'customer_name', 'mobile', 'notify_url', 'page_modify', 'return_url', 'verified_way']
        ];

        $res = $this->_post(self::User_verify_url, $customer_data, $enc);

        return $res;
    }

    /**
     * 通过uuid下载文件
     * @param $uuid
     * @return mixed|string
     */
    public function GetUuidFile($data)
    {
        $params['uuid'] = $data['uuid'];

        $enc = [
            'md5' => [],
            'sha1' => ['uuid']
        ];

        $res = $this->_post(self::Get_file_url, $params, $enc, 'http', 'file');

        $file_name = time() . rand(1000, 9999);

        file_put_contents($data['path'] . $file_name . '.png', $res);

        load_helper('file');

        upload_to_cloud($data['path'] . $file_name . '.png', 'ContractIdCard/' . $file_name . '.png', true);

        return $data['path'] . $file_name . '.png';
    }

    //三要素验证
    public function RealNameAuthOperator(FddRealNameAuth $param, $data)
    {
        $encrypt = new FddEncryption();

        $params = $param->SetName($data['name'])
            ->SetMobile($data['phone'])
            ->SetId_card($data['identity_num'])
            ->SetVerify_element($encrypt->encrypt($param->GetName() . '|' . $param->GetId_card() . '|' . $param->GetMobile()))
            ->GetValues();

        $enc = [
            'md5' => [],
            'sha1' => ['verify_element']
        ];

        $data = $this->_post(self::Three_element_verify_mobile_url, $params, $enc);

        return $data;
    }

    //合同模版上传
    public function UploadContractTemplateCreate(FddTemplate $param, $data)
    {
        $params = $param->SetTemplate_id($data['template_id'])//设置模版ID
        ->SetDoc_url($data['template_path'])//设置模版PDF路径
        ->GetValues();

        $enc = [
            'md5' => [],
            'sha1' => ['template_id']
        ];

        $data = $this->_post(self::Template_create_url, $params, $enc);

        return $data;
    }

    /**
     * 通过CA证书查询客户信息
     * @param FddTemplate $param
     * @param $data
     */
    public function FindPersonCertInfo(FddRealNameAuth $param, $data)
    {
        $params = $param->SetVerified_serialNo($data['verified_serialno'])
            ->GetValues();//设置模版ID

        $enc = [
            'md5' => [],
            'sha1' => ['verified_serialno']
        ];

        $data = $this->_post(self::Person_cert_info_url, $params, $enc);

        return $data;
    }

    //查看合同模版
    public function ViewTemplate(FddTemplate $param, $data)
    {
        //查看合同模板 地址
        //$param->SetTemplate_id($data['template_id']);
        $param->SetTemplate_id($data);
        //实例化3DES类
        $des = new FddEncryption();
        //设置加密串
        $enc = [
            'md5' => [],
            'sha1' => ['template_id']
        ];

        $params = $param->GetValues();

        return $this->_post(self::Check_Template_url, $params, $enc, 'url');
    }

    //获取pdf模版表单域key值接口
    public function GetPdfTemplateKeys(FddTemplate $param, $template_id)
    {
        //参数处理
        $param->SetTemplate_id($template_id);

        //实例化3DES类
        $des = new FddEncryption();
        //设置加密串
        $enc = [
            'md5' => [],
            'sha1' => ['template_id']
        ];
        $params = $param->GetValues();
        $res = $this->_post(self::Template_key_url, $params, $enc);
        return $res;
    }

    //填充模版
    public function FillTemplateKeys(FddTemplate $param, $data)
    {
        //$json = '{"platformName":"名字1","borrower":"名字2","homeUrl":"名字3"}';
        //参数处理
        $param->SetDoc_title($data['title']);
        $param->SetTemplate_id($data['template_id']);
        $param->SetContract_id($data['contract_id']);
        $param->SetParameter_map($data['fill_data']);

        $enc = [
            'md5' => [],
            'sha1' => ['template_id', 'contract_id']
        ];

        $params = $param->GetValues();
        $res = $this->_post(self::Fill_Template_url, $params, $enc);
        return $res;
    }

    //批量文档签署
    public function BatchSignContract(FddSignContract $param, $data, $type = 1)
    {

        //实例化3DES类
        $des = new FddEncryption();
        //参数处理
        $params = $param->SetTransaction_id($data['second_transaction_id'])
            ->SetBatch_id($data['batch_id'])
            ->SetBatch_title($data['batch_title'])
            ->SetSign_data($data['sign_data'])
            ->SetDoc_title($data['doc_title'])
            ->SetCustomer_id($data['customer_id'])
            ->SetReturn_url($data['return_url'])
            ->SetNotify_url($data['notify_url']);

        $enc = [
            'md5' => ['batch_id'],
            'sha1' => ['customer_id']
        ];


        if (isset($data['outh_customer_id'])) {
            $param->SetOuth_customer_id($data['outh_customer_id']);
            array_push($enc['sha1'], 'outh_customer_id');
        }

        $params = $param->GetValues();

        return $this->_post(self::Batch_sign_contract_url, $params, $enc, 'url');
    }

    //手动签署
    public function HandSignContract(FddSignContract $param, $data)
    {
        //实例化3DES类
        $des = new FddEncryption();
        //参数处理
        $params = $param->SetTransaction_id($data['transaction_id'])
            ->SetContract_id($data['contract_id'])
            ->SetCustomer_id($data['customer_id'])
            ->SetReturn_url($data['return_url'])
            ->SetNotify_url($data['notify_url'])
            ->SetSign_keyword($data['sign_keyword'])
            ->SetDoc_title($data['doc_title'])
            ->GetValues();

        $enc = [
            'md5' => ['transaction_id'],
            'sha1' => ['customer_id']
        ];

        return $this->_post(self::Hand_sign_contract_url, $params, $enc, 'url');
    }

    //合同归档
    public function PigeonholeContract($contract_id)
    {
        $params['contract_id'] = $contract_id;

        $enc = [
            'md5' => [],
            'sha1' => ['contract_id']
        ];

        $res = $this->_post(self::Pigeonhole_url, $params, $enc);

        if ($res['code'] !== '1000') {
            return 'a';
        }

        return $res;
    }

    //查询个人实名认证信息
    public function GetPersonVerifyInfo($serial_no)
    {
        $params['verified_serialno'] = $serial_no;

        $enc = [
            'md5' => [],
            'sha1' => ['verified_serialno']
        ];

        $res = $this->_post(self::Check_person_verify_url, $params, $enc);

        dd($res);
    }

    //个人CA证书
    public function ApplyPersonalCA(FddDataBaseCA $param, $customer_data)
    {
        $params = $param->SetCustomer_id($customer_data['customer_id'])
            ->SetVerified_serialNo($customer_data['verified_serialno'])
            ->GetValues();

        $enc = [
            'md5' => [],
            'sha1' => ['customer_id', 'verified_serialno']
        ];

        $res = $this->_post(self::Apply_personCA_url, $params, $enc);

        return $res;
    }

    /**
     * 新增盖章
     */
    public function AddSignature(FddSignature $param, $data)
    {
        $params = $param->SetCustomer_id($data['customer_id'])
            ->SetSignature_img_base64($data['signature_img_base64'])
            ->GetValues();

        $enc = [
            'md5' => [],
            'sha1' => ['customer_id', 'signature_img_base64']
        ];

        $res = $this->_post(self::Add_signature_url, $params, $enc);

        return $res;
    }

    /**
     * 设置默认盖章
     */
    public function SetSignature(FddSignature $param, $data)
    {
        $params = $param->SetCustomer_id($data['customer_id'])
            ->SetSignature_id($data['signature_id'])
            ->GetValues();

        $enc = [
            'md5' => [],
            'sha1' => ['customer_id', 'signature_id']
        ];

        $res = $this->_post(self::Set_signature_url, $params, $enc);

        return $res;
    }

    /**
     * 获取用户签章
     * @param FddSignature $param
     * @param $data
     * @return mixed|string
     */
    public function GetSignature(FddSignature $param, $data)
    {
        $params = $param->SetCustomer_id($data['customer_id'])
//            ->SetSignature_id($data['signature_id'])
            ->GetValues();

        $enc = [
            'md5' => [],
            'sha1' => ['customer_id']
        ];

        $res = $this->_post(self::Get_signature_url, $params, $enc);

        return $res;
    }

    /**
     * 企业CA申请
     */
    public function ComEmailApplyCA(FddDataBaseCA $class, $param)
    {
        $encrypt = new FddEncryption();

        $params = $class->SetCustomer_name($param['customer_name'])
            ->SetMobile($param['mobile'])
            ->SetOrganization($param['organization'])
            ->SetId_Mobile($encrypt->encrypt($class->GetOrganization() . '|' . $class->GetMobile()))
            ->GetValues();

        $enc = [
            'md5' => [],
            'sha1' => []
        ];

        $res = $this->_post(self::Auto_company_apply_url, $params, $enc);

        return $res;
    }

    /**
     * 删除合同接口
     * @param FddContractManageMent $class
     * @param $param
     * @return mixed|string
     */
    public function DeleteContract(FddContractManageMent $class, $param)
    {
        $params = $class->SetContract_id($param['contract_id'])
            ->GetValues();

        $enc = [
            'md5' => [],
            'sha1' => ['contract_id']
        ];

        $res = $this->_post(self::Delete_contract_url, $params, $enc);

        return $res;
    }

    /**
     * 授权接口
     * @param FddAuthorization $param
     * @param $data
     * @return mixed|string
     */
    public function AuthorizeSignature(FddAuthorization $param, $data)
    {
        $params = $param->SetCompany_id($data['company_id'])
            ->SetPerson_id($data['person_id'])
            ->SetOperate_type($data['operate_type'])
//            ->SetSignature_id($data['signature_id'])
            ->GetValues();

        $enc = [
            'md5' => [],
//            'sha1' => ['company_id', 'operate_type', 'person_id', 'signature_id']
            'sha1' => ['company_id', 'person_id', 'operate_type']
        ];

        $data = $this->_post(self::Authorize_signature_url, $params, $enc);

        return $data;
    }

    //参数处理
    protected function _post($url_suffix, $param, $enc, $action = 'http', $type = 'array')
    {
        $msg_digest = $this->handleMsgDigest($param, $enc);

        $query = array(
            'app_id' => $this->Fdd_Params['app_id'],

            'timestamp' => $this->Fdd_Params['timestamp'],

            'v' => $this->Fdd_Params['v'],

            'msg_digest' => $msg_digest
        );

        if (!empty($param)) {
            foreach ($param as $k => $v) {
                $query[$k] = $v;
            }
        }

        \Log::error($this->Fdd_Params['api_url'] . $url_suffix);
        \Log::error($query);

        if ($action == 'url') {
            //实例化3DES类
            $des = new FddEncryption();

            return $this->Fdd_Params['api_url'] . $url_suffix . $des->ArrayParamToStr($query);
        }

        return self::https_request($url_suffix, $query, 'post', $type);
    }

    //处理msg_digest参数
    protected function handleMsgDigest($param, $enc)
    {
        $md5Str = '';
        $sha1Str = '';

        //将业务参数进行ascii排序
        $ascii_str = self::ASCII($param);

        //筛选参数
        foreach ($enc as $k => $v) {
            switch ($k) {
                case "md5":
                    foreach ($v as $md5Key => $md5Value) {
                        if (isset($param[$md5Value])) {
                            $md5Str .= $param[$md5Value];
                        }
                    }
                    break;
                case "sha1":
                    foreach ($v as $sha1Key => $sha1Value) {
                        if (isset($param[$sha1Value])) {
                            $sha1Str .= $param[$sha1Value];
                        }
                    }
                    break;
            }
        }
        $md5_params = strtoupper(MD5($this->Fdd_Params['timestamp'] . $md5Str));

        if (isset($param['transaction_id'])) {//批量签署/手动签署时的MD5加密顺序不同于普通
            $md5_params = strtoupper(MD5($md5Str . $this->Fdd_Params['timestamp']));
        }

        $sha1_params = strtoupper(SHA1($this->Fdd_Params['app_secret'] . $sha1Str));

        $encrypt_str = strtoupper(SHA1($this->Fdd_Params['app_id'] . $md5_params . $sha1_params));

        if (isset($param['parameter_map'])) {//渲染模版时的加密不同于普通
            $encrypt_str = strtoupper(SHA1($this->Fdd_Params['app_id'] . $md5_params . $sha1_params . $param['parameter_map']));
        }

        $msg_digest = base64_encode($encrypt_str);

        return $msg_digest;
    }

    //Ascii码排序
    public static function ASCII($params = array())
    {
        if (!empty($params)) {
            $p = ksort($params);
            if ($p) {
                $str = '';
                foreach ($params as $val) {
                    $str .= $val;
                }
                return $str;
            }
        }
        return '参数错误';
    }

    /**
     * 模拟请求http函数
     * @param $url
     * @param string $data
     * @param string $type
     * @param string $res
     * @return mixed
     */
    public function https_request($url_suffix, $data = "", $type = "post", $res = "array")
    {

        $url = $this->Fdd_Params['api_url'] . $url_suffix; //拼接URL


        //1.初始化curl
        $curl = curl_init();
        //2.设置curl的参数
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        if ($type == "post") {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        //3.采集
        $output = curl_exec($curl);
        //4.关闭
        curl_close($curl);

        if ($res == "array") {
//            \Log::error($res);
            return json_decode($output, true);
        }

        return $output;
    }

}
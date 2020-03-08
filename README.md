# FaDaDa-Package

 引用
 ``` php
  composer update zhuobin/fadada
```

先在config/app.php添加
``` php
aliases => [
    'FaDaDa' => Zhuobin\FaDaDa\Src\FaDaDaFacade::class
]
```

生成配置文件
``` php
  php artisan fadada:init
```

设置好配置文件,文件路径config/
``` php
<?php
  return [
      //测试环境
      'testing' => [
          'app_id' => 'XXXXXX',
          'app_secret' => 'XXXXXX',
          'url' => 'XXXXXX'
      ],
      //正式环境
      'production' => [
          'app_id' => 'XXXXXX',
          'app_secret' => 'XXXXXX',
          'url' => 'XXXXXX'
      ]
  ];
>
```

配置好即可调用，方法调用示例：
``` php
  \FaDaDa::function_name($params);
```

若提示全局找不到\FaDaDa类,请运行以下指令
``` php
  php artisan ide-helper:generate
```
接口及传参
``` php
  //三要素验证接口
  $res = \FaDaDa::RealNameAuthOperator([
      'name' => '实名'，
      'phone' => '手机号'，
      'identity_num' => '身份证号码'
  ]);
  返回参数判断$res['code'],为1则通过，否则不通过
  
  //个人账号注册接口
  $res = \FaDaDa::getUserAccount([
      'open_id' => '推荐使用手机号做唯一标识来注册'
  ]);
  返回参数判断$res['code'],为1则通过，否则不通过,$res['data']会返回注册成功的customer_id，需要保存至数据库
  
  //上传合同模版接口
  $res = \FaDaDa::uploadContractTemplateCreate([
      'template_id' => '自定义合同模版编号'，
      'template_path' => '合同模版地址'
  ]);
  返回参数判断$res['code'],为1则上传成功，否则不通过
  
  //获取合同模版Key值接口
  $res = \FaDaDa::GetPdfTemplateKeys([
      'template_id' => '合同模版编号'
  ]);
  返回参数$res['data']里为该合同模版里所设置好所有的Key值
  
  //填充合同模版接口
  $res = \FaDaDa::FillTemplateKeys([
      'title' => '合同名字',
      'template_id' => '合同模版编号',
      'contract_id' => '自定义合同编号',
      'fill_data' =>  json_encode(['key1' => '填充值1', 'key2' => '填充值2'], JSON_UNESCAPED_UNICODE),
  ]);
  返回参数判断$res['code'],为1000则上传成功，
  $res['download_url']里会返回该合同的下载地址，
  $res['viewpdf_url']里会返回该合同的预览地址
  
  //获取合同模版Key值接口
  $res = \FaDaDa::GetPdfTemplateKeys([
      'template_id' => '合同模版编号'
  ]);
  返回参数$res['data']里为该合同模版里所设置好所有的Key值
  
  //获取个人实名地址接口
  \FaDaDa::getUserIdentificationUrl([
          'customer_ident_type' => '0',
          'verified_way' => '4',//实名认证套餐
          'page_modify' => '是否允许用户修改,1可修改 2不可修改'
          'customer_name' => '实名（非必传，传入将自动填充进去）',
          'customer_ident_no' => '身份证（非必传，传入将自动填充进去）',
          'mobile' => '手机号（非必传，传入将自动填充进去）',
          'notify_url' => '回调地址',
          'return_url' => '认证后跳转的地址',
          'customer_id' => '客户编号',
  ]);
  返回参数判断$res['code'],为1则获取个人实名地址成功，否则失败
  $res['data']里则是个人实名地址URL
```


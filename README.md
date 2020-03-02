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
  
```


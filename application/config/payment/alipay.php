<?php


//↓↓↓↓↓↓↓↓↓↓请在这里配置您的基本信息↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
//合作身份者id，以2088开头的16位纯数字
/*$alipay_config['partner'] = '';

//安全检验码，以数字和字母组成的32位字符
//如果签名方式设置为“MD5”时，请设置该参数
$alipay_config['key'] = '';

//商户的私钥（后缀是.pen）文件相对路径
//如果签名方式设置为“0001”时，请设置该参数
$alipay_config['private_key_path'] = 'key/rsa_private_key.pem';

//支付宝公钥（后缀是.pen）文件相对路径
//如果签名方式设置为“0001”时，请设置该参数
$alipay_config['ali_public_key_path'] = 'key/alipay_public_key.pem';

//↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑

//签名方式 不需修改
$alipay_config['sign_type'] = '0001';

//字符编码格式 目前支持 gbk 或 utf-8
$alipay_config['input_charset'] = 'utf-8';

//ca证书路径地址，用于curl中ssl校验
//请保证cacert.pem文件在当前文件夹目录中
$alipay_config['cacert'] = getcwd() . '\\cacert.pem';

//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
$alipay_config['transport'] = 'http';*/

$_alipay_dir = APPPATH . '/libraries/payment';
return array(
    //商家帐号
    'seller_mail' => '',
    //合作身份者id，以2088开头的16位纯数字
    'partner' => '',
    //安全检验码，以数字和字母组成的32位字符
    'key' => '',
    //商户的私钥（后缀是.pem）文件相对路径
    'private_key_path' => $_alipay_dir . '/key/rsa_private_key.pem',
    //支付宝公钥（后缀是.pen）文件相对路径
    'ali_public_key_path' => $_alipay_dir . '/key/alipay_public_key.pem',
    //签名方式 不需修改
    'sign_type' => '0001',
    //字符编码格式 目前支持 gbk 或 utf-8
    'input_charset' => 'utf-8',
    //ca证书路径地址，用于curl中ssl校验,请保证cacert.pem文件在当前文件夹目录中
    'cacert' => $_alipay_dir . '/cacert.pem',
    //访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
    'transport' => 'http',
);
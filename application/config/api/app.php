<?php
/**
 * 微信应用配置
 * 开发者ID
 */

return array(
    'url' => 'https://api.weixin.qq.com/cgi-bin/token',
    'grant_type' => 'client_credential',
    'appid' => 'wx8f7f91904d10aa54',
    'secret' => '7aba2b93d2203b807135826573ddbef1',
    'auth_code' => 'https://open.weixin.qq.com/connect/oauth2/authorize?',
    'auth_access' => 'https://api.weixin.qq.com/sns/oauth2/access_token?',
    'auth_refresh' => 'https://api.weixin.qq.com/sns/oauth2/refresh_token?',
);
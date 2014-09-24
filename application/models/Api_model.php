<?php

class Api_model extends App_model
{
    /**
     * 保存访问权限
     */
    public function saveAccess($access, $type = 0)
    {
        $now = time();
        $value = array(
            'token' => $access['access_token'],
            'type' => $type,
            'expire' => $now + $access['expires_in'] - 90,
            'create_time' => $now,
        );
        $this->db->delete('mhr_access', array('type' => 0));
        $return = $this->db->insert('mhr_access', $value);
        return $return;
    }

    /**
     * 获取基础访问令牌
     */
    public function getAccessToken()
    {
        $token = null;
        $now = time();
        $sql = "select token from mhr_access where isdel=0 and type=0 and  expire>$now limit 1";
        $query = $this->db->query($sql);
        if ($query->row()) {
            $token = $query->row()->token;
        }
        return $token;
    }

    /**
     * 获取微信用户ID
     */
    public function getOpenID()
    {
        $id = null;
        $token = CSession::get('_auth_refresh_token');
        if (!$token) {

        } else {

        }
    }

    /**
     * 授权码请求链接
     */
    public function authUrl($reUrl)
    {
        $config = CLoader::config('api/app');
        $action = $config['auth_code'];
        $reUrl = urlencode($reUrl);
        $appid = $config['appid'];
        $action .= "appid=$appid&redirect_uri=$reUrl&response_type=code&scope=snsapi_base&state=ok#wechat_redirect";
        return $action;
    }

    /**
     * 获取授权权限
     */
    public function authAccess($authCode)
    {
        $config = CLoader::config('api/app');
        $appid = $config['appid'];
        $secret = $config['secret'];
        $url = $config['auth_access'] . "appid=$appid&secret=$secret&code=$authCode&grant_type=authorization_code";
        $response = $this->request($url, '');
        return $response;
    }

    public function authRefresh($token)
    {
        $config = CLoader::config('api/app');
        $appid = $config['appid'];
        $url = $config['auth_refresh'] . "appid=$appid&grant_type=refresh_token&refresh_token=$token";
        $response = $this->request($url, '');
        return $response;
    }

    public function request($url, $param, $post = false)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, 0); // 过滤HTTP头
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);// 显示输出结果
        curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//SSL证书认证
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)'); // 模拟用户使用的浏览器
        if ($post == true) curl_setopt($curl, CURLOPT_POST, 1);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
}
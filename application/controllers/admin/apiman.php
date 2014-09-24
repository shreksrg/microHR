<?php

class ApiMan extends AdminController
{
    protected $_route;
    protected $_access_token = null;
    protected $_modelApi;

    public function __construct()
    {
        parent::__construct();
        $this->_modelApi = CModel::make('api_model', 'api_model');
    }

    /**
     * 编辑微信菜单
     */
    public function menu()
    {
        $errCode = 0;
        $errMsg = '';
        $config = CLoader::config('api/menu');
        $menu = $config['menu'];
        array_walk_recursive($menu, function (&$value, $key) {
            $value = urlencode($value);
        });
        $param = urldecode(json_encode($menu));
        if (REQUEST_METHOD == 'POST') {
            $token = $this->_modelApi->getAccessToken(); // 获取已申请的权限令牌
            if (!$token) $token = $this->apply_access();
            if ($token) {
                $url = $config['url'] . $token;
                $response = $this->request($url, $param, true);
                if (isset($response) && strlen($response) > 0) {
                    $response = json_decode($response, true);
                    $errCode = $response['errcode'];
                    $errMsg = $response['errmsg'];
                }
            }
            CAjax::show($errCode, $errMsg);
        } else {
            $data['content'] = $param;
            CView::show('admin/api/menu', $data);
        }
    }

    /**
     * 申请访问权限
     */
    public function apply_access()
    {
        $config = CLoader::config('api/app');
        if (!$config) {
            return false;
        }
        $param = $config;
        unset($param['url']);
        $response = $this->request($config['url'], $param);
        if (isset($response) && strlen($response) > 0) {
            $response = json_decode($response, true);
            if (isset($response['access_token'])) {
                $token = $response['access_token'];
                $return = $this->_modelApi->saveAccess($response);
                if ($return === true) return $token;
            }
        }
        return false;
    }

    protected function request($url, $param, $post = false)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, 0); // 过滤HTTP头
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);// 显示输出结果
        curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//SSL证书认证
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        if ($post === true) curl_setopt($curl, CURLOPT_POST, 1);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }


    protected function  validateForm()
    {
        $validator = FormValidation::make();
        $validator->set_rules('title', 'Title', 'required|xss_clean');
        $validator->set_rules('source', 'Source', 'required|numeric|xss_clean');
        $validator->set_rules('price', 'Price', 'required|numeric|xss_clean');
        $validator->set_rules('img', 'Img', 'required|max_length[512]|xss_clean');
        $validator->set_rules('status', 'Status', 'required|integer|xss_clean');
        $validator->set_rules('desc', 'Desc', 'required|xss_clean');
        return $validator;
    }

}
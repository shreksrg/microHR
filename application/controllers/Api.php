<?php


class Api extends FrontController
{
    const _TOKEN = 'TUlDUk9IUjIwMTQ';

    protected $_modelApi;

    public function __construct()
    {
        parent::__construct();
        $this->_modelApi = CModel::make('api_model');
    }

    public function index()
    {
        $this->valid();
    }

    protected function valid()
    {
        $responseStr = $this->input->get('echostr');
        if ($this->checkSignature()) {
            echo $responseStr;
            exit;
        }
    }

    public function responseMsg()
    {
        //get post data, May be due to the different environments
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        //extract post data
        if (!empty($postStr)) {
            /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
               the best way is to check the validity of xml by yourself */
            libxml_disable_entity_loader(true);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $keyword = trim($postObj->Content);
            $time = time();
            $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";
            if (!empty($keyword)) {
                $msgType = "text";
                $contentStr = "Welcome to wechat world!";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            } else {
                echo "Input something...";
            }

        } else {
            echo "";
            exit;
        }
    }

    private function checkSignature()
    {
        $signature = $this->input->get('signature');
        $timestamp = $this->input->get('timestamp');
        $nonce = $this->input->get('nonce');

        $tmpArr = array(self::_TOKEN, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 申请访问权限
     */
    public function apply_access()
    {
        $config = CLoader::config('api/app');
        if (!$config) {
            echo 'error configure';
            return false;
        }
        $param = $config;
        unset($param['url']);
        $response = $this->request($config['url'], $param);
        if (isset($response) && strlen($response) > 0) {
            $response = (array)json_decode($response);
            if (isset($response['access_token'])) {
                $return = $this->_modelApi->saveAccess($response);
                return $return;
            }
        }
        return false;
    }

    /**
     * 创建菜单
     */
    public function createMenu()
    {
        $token = $this->_modelApi->getAccessToken(); // 获取已申请的权限令牌
        if ($token) {
            $config = CLoader::config('api/menu');
            if ($config) {
                $config['url'] .= $token;
                $response = $this->request($config['url'], $config['menu'], true);
                if (isset($response) && strlen($response) > 0) {
                    $respVal = (array)json_decode($response);
                    if ($respVal['errcode'] == 0) return true;
                }
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
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)'); // 模拟用户使用的浏览器
        if ($post == true) curl_setopt($curl, CURLOPT_POST, 1);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public function auth()
    {
        $authCode = $this->input->get('code');
        if ($authCode) {
            $config = CLoader::config('api/app');
            $appid = $config['appid'];
            $secret = $config['secret'];
            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$secret&code=$authCode&grant_type=authorization_code";
            $response = $this->request($url, '');
            //file_put_contents('logs/auth_code', $response);
            $response = json_decode($response, true);
            CSession::set('_open_id', $response['openid']);
            echo $response['openid'];
        }
    }

    public function do_auth()
    {
        //CSession::drop('_open_id');
        if (!($openId = CSession::get('_open_id'))) {
            $config = CLoader::config('api/app');
            $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?';
            $appid = $config['appid'];
            $reUrl = urlencode('http://211.152.55.100/api/auth');
            $url .= "appid=$appid&redirect_uri=$reUrl&response_type=code&scope=snsapi_base&state=ok#wechat_redirect";
            CView::show('code', array('action' => $url));
        } else
            echo $openId;
    }

    public function run()
    {
        $config = CLoader::config('api/menu');
        $menu = $config['menu'];
        array_walk_recursive($menu, function (&$value, $key) {
            $value = urlencode($value);
        });
        $param = urldecode(json_encode($menu));
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token=jyxdTKS2nxaUqBJmTqD-K2pCUFRwrBW9pTzSOTipJhxNO4zEp1gARZ8FI3xqDxxp2zcqmkk2qjwqfCI9eKx5aA';
        $response = $this->request($url, $param, true);
        var_dump($response);
    }

    public function test()
    {
        echo APP_URL . '/' . $this->uri->uri_string();
    }


}
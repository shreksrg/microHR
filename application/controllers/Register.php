<?php

class Register extends FrontController
{
    /**
     * @var 登记模型
     */
    protected $_modelRegister;
    protected $_modelApi;

    /**
     * @var 登记项目
     */
    protected $_regItem = array('gender', 'mobile', 'academy', 'major');

    public function __construct()
    {
        parent::__construct();
        $this->_modelRegister = CModel::make('register_model');
    }

    /**
     * 用户身份验证
     */
    public function _authentication()
    {
        if ($this->_user->isGuest) {
            $modelLogin = CModel::make('login_model');
            $return = $modelLogin->authLogin($this->_user); //申请授权并登录
            if ($return !== true) {
                CAjax::result($return);
                exit(0);
            }
        }
    }

    public function index()
    {
        if (REQUEST_METHOD == 'POST') {
            $return = false;
            $post = $this->input->post();
            $this->checkSubmit($post);

            CSession::set('_register_post', $post);
            $modelApi = CModel::make('api_model');
            if (!($token = CSession::get('_auth_refresh_token'))) {
                $this->authSubmit($modelApi);
            } else {
                $err = array('code' => 1001, 'content' => '授权验证错误');
                $access = $modelApi->authRefresh($token);
                if (isset($access['access_token'])) {
                    $post['wxid'] = $access['openid'];
                    $return = $this->_modelRegister->save($post);
                    if ($return === true) {
                        CView::show('Register/result');
                    } else {
                        $err = array('code' => 1002, 'content' => '注册失败:');
                    }
                } elseif (isset($access['errcode'])) {
                    $this->authSubmit($modelApi);
                    return false;
                }
                CView::show('message/error', $err);
            }

        } else {
            $_token = UUID::fast_uuid(6);
            CSession::set('_register_token', $_token);
            CView::show('register', array('token' => $_token));
        }
    }

    /**
     * 授权提交注册
     */
    public function authSubmit($modelApi = null)
    {
        $post = CSession::get('_register_post');
        if ($post) {
            $reUrl = urlencode(APP_URL . '/register/save');
            $action = $modelApi->authUrl($reUrl);
            CView::show('code', array('action' => $action));
        } else CView::show('message/error', array('code' => 1000, 'content' => '注册请求过期'));
    }

    /**
     * 检查注册提交表单
     */
    public function checkSubmit($data)
    {
        $err = array();
        if ($this->validateForm($data) !== true) {
            $err = array('code' => '1001', 'content' => '注册数据异常');
        } else {
            $token = CSession::get('_register_token');
            if (!$token || $data['token'] != $token) {
                $err = array('code' => '1001', 'content' => '表单填写不正确');
            }
        }
        if ($err) {
            CView::show('message/error', $err);
            exit(0);
        }
    }

    /**
     * 保存注册
     */
    public function save()
    {
        $errCode = 1001;
        $content = '授权失效';
        $post = CSession::get('_register_post');
        $this->checkSubmit($post);

        $authCode = $this->input->get('code');
        if ($authCode) {
            $modelApi = CModel::make('api_model');
            $access = $modelApi->authAccess($authCode);
            if (isset($access['access_token'])) {
                CSession::set('_auth_refresh_token', $access['refresh_token']);
                $post['wxid'] = $access['openid'];
                $return = $this->_modelRegister->save($post);
                CSession::set('_register_token', null);
                if ($return === true) {
                    CView::show('register/result');
                    return true;
                } else {
                    $errCode = 1000;
                    $content = '注册失败';
                }
            }
        }
        CView::show('message/error', array('code' => $errCode, 'content' => $content));
    }

    /**
     * 验证表单
     */
    protected function  validateForm()
    {
        $validator = FormValidation::make();
        $validator->set_rules('nickname', 'Nickname', 'required|xss_clean');
        $validator->set_rules('gender', 'Gender', 'required|integer|xss_clean');
        $validator->set_rules('mobile', 'Mobile', 'required|integer|max_length[13]|numeric|xss_clean');
        $validator->set_rules('academy', 'Academy', 'required|xss_clean');
        $validator->set_rules('major', 'Major', 'required|xss_clean');
        $validator->set_rules('edu', 'Edu', 'required|integer|xss_clean');
        $validator->set_rules('token', 'Token', 'required|xss_clean');
        return $validator->run() === true;
    }


    protected function doRegister($data)
    {
        $return = $this->_modelRegister->save($data);
        return $return;
    }


    /**
     * 注册性别
     */
    protected function regGender()
    {
        if (REQUEST_METHOD == 'POST') {
            $gender = (int)$this->input->post('gender');
            $this->setSession('gender', $gender);
            CAjax::show(0, 'successful');
        } else {
            CView::show('register/reg_gender');
        }
    }

    /**
     * 注册手机
     */
    protected function regMobile()
    {
        if (REQUEST_METHOD == 'POST') {
            $mobile = (int)$this->input->post('mobile');
            $this->setSession('mobile', $mobile);
            CAjax::show(0, 'successful');
        } else {
            CView::show('register/reg_mobile');
        }
    }

    /**
     * 注册院校专业
     */
    protected function regMajor()
    {
        if (REQUEST_METHOD == 'POST') {
            $academy = $this->input->post('academy', true);
            $major = $this->input->post('major', true);
            $this->setSession('academy', $academy);
            $this->setSession('major', $major);
            //保存注册
            $return = $this->regSave();
            CAjax::result($return);
        } else {
            CView::show('register/reg_gender');
        }
    }

    /**
     * 保存注册
     */
    protected function regSave()
    {
        $data = array();
        //检查登记步骤
        foreach ($this->_regItem as $item) {
            if (!isset($regArr[$item]) || strlen($regArr[$item]) <= 0) {
                return false;
            }
            $data[$item] = $this->getSession($item);
        }
        //写入注册数据
        $return = $this->_modelRegister->save($data);
        return $return;
    }
}
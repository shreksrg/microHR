<?php

class Register extends FrontController
{
    /**
     * @var 登记模型
     */
    protected $_modelRegister;
    protected $_modelApi;

    /**
     * @var 登记项
     */
    protected $_regItem = array('gender', 'mobile', 'academy', 'major');

    public function __construct()
    {

        parent::__construct();
        $this->_modelRegister = CModel::make('register_model');
        //$this->_user->logout();
    }

    /**
     * 授权验证
     */
    public function _authentication()
    {
        $filter = array('index');
        if (in_array(APP_METHOD, $filter)) return false;
        if ($this->_user->isGuest) {
            CAjax::fail();
            exit;
        }
    }

    public function index()
    {
        echo urlencode('http://211.152.55.100/microhr/index.php/login/auth');
        $action = $this->input->get('action');
        if ($action == 'append') {
            $this->append();
        } else {
            $_token = UUID::fast_uuid(6);
            CSession::set('_register_token', $_token);
            echo (int)$this->_user->id;
            CView::show('register/form', array('token' => $_token));
        }
    }

    protected function append()
    {
        $postData = $this->input->post();
        $this->checkSubmit($postData);
        $postData['wxid'] = $this->_user->id;
        $return = $this->_modelRegister->save($postData);
        if ($return === true) {
            CSession::drop('_register_token');
        }
        CAjax::result($return);
        exit;
    }

    /**
     * 检查注册提交表单
     */
    protected function checkSubmit($data)
    {
        $err = array();
        if ($this->validateForm() !== true) {
            $err = array('code' => '1001', 'content' => '提交数据异常');
        } else {
            $token = CSession::get('_register_token');
            if (!$token || $data['token'] != $token) {
                $err = array('code' => '1001', 'content' => '请求已过期');
            }
        }
        if ($err) {
            CAjax::show($err['code'], $err['content']);
            exit(0);
        }
    }

    /**
     * 验证表单
     */
    protected function  validateForm()
    {
        $validator = FormValidation::make();
        $validator->set_rules('nickname', 'Nickname', 'required|xss_clean');
        $validator->set_rules('gender', 'Gender', 'required|integer|xss_clean');
        $validator->set_rules('mobile', 'Mobile', 'required|numeric|xss_clean');
        $validator->set_rules('academy', 'Academy', 'required|xss_clean');
        $validator->set_rules('major', 'Major', 'required|xss_clean');
        $validator->set_rules('edu', 'Edu', 'required|integer|xss_clean');
        $validator->set_rules('token', 'Token', 'required|xss_clean');
        return $validator->run() === true;
    }


}
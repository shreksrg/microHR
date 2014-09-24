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
        $action = $this->input->get('action');
        if ($action == 'append') {
            $this->append();
        } else {
            $_token = UUID::fast_uuid(6);
            CSession::set('_register_token', $_token);
            CView::show('register/form', array('token' => $_token));
        }
    }

    protected function append()
    {
        $post = $this->input->post();
        if (!$post) $post = CSession::get('_register_post');
        $this->checkSubmit($post);
        $modelApi = CModel::make('api_model');
        $post['wxid'] = $this->_user->id;
        $return = $this->_modelRegister->save($post);
        if ($return === true) {
            CSession::drop('_register_token');
            CView::show('register/result');
        } else {
            $err = array('code' => 1002, 'content' => '注册失败');
            CView::show('message/error', $err);
        }
    }

    /**
     * 检查注册提交表单
     */
    protected  function checkSubmit($data)
    {
        $err = array();
        if ($this->validateForm($data) !== true) {
            $err = array('code' => '1001', 'content' => '提交数据异常');
        } else {
            $token = CSession::get('_register_token');
            if (!$token || $data['token'] != $token) {
                $err = array('code' => '1001', 'content' => '请求已过期');
            }
        }
        if ($err) {
            CView::show('message/error', $err);
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
        $validator->set_rules('mobile', 'Mobile', 'required|integer|max_length[13]|numeric|xss_clean');
        $validator->set_rules('academy', 'Academy', 'required|xss_clean');
        $validator->set_rules('major', 'Major', 'required|xss_clean');
        $validator->set_rules('edu', 'Edu', 'required|integer|xss_clean');
        $validator->set_rules('token', 'Token', 'required|xss_clean');
        return $validator->run() === true;
    }


}
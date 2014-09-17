<?php

class SysMan extends AdminController
{

    protected $_route;

    public function __construct()
    {
        parent::__construct();
        $this->_modelSys = CModel::make('admin/sysman_model', 'sysman_model');
        $this->_route = $this->input->get('r', true);
    }

    public function index()
    {
        if ($this->_route == 'admin') {
            CView::show('admin/user/admin_index');
        } else {
            CView::show('admin/user/index');
        }
    }


    /**
     * ajax用户列表
     */
    public function users()
    {
        $page = (int)$this->input->get('page');
        $rows = (int)$this->input->get('rows');
        $list = $this->_modelSys->getUsers($page, $rows);
        echo json_encode($list);
    }

    /**
     * 新增管理员
     */
    public function append()
    {
        if (REQUEST_METHOD == 'POST') {
            $data = $this->input->post();

            // 表单输入验证
            /* $validator = $this->validateForm();
             if ($validator->run() == false)
                 CAjax::show('1000', '表单输入值不合法,请检查');*/
            $errCode = 0;
            $reVal = false;
            $repArr = array($errCode, 'successful');
            if ($this->_route == 'admin') {
                $reVal = $this->_modelSys->newUser($data);
            }

            if ($reVal !== true) {
                $repArr[0] = $this->_modelSys->errCode;
                $repArr[1] = 'fail';
                if ($repArr[0] == 1001) $repArr[1] = '用户名已经注册!';
            }
            CAjax::show($repArr[0], $repArr[1]);
        } else {
            if ($this->_route == 'admin') {
                CView::show('admin/user/admin_edit', array('t' => 'append', 'user' => null));
            }
        }
    }

    /**
     * 编辑
     */
    public function edit()
    {
        if (REQUEST_METHOD == 'POST') {
            $data = $this->input->post();
            $reVal = true;
            if ($this->_route == 'admin') {
                $data['user'] = $this->_modelSys->editUser($data);
                CView::show('admin/user/admin_edit', $data);
            }

            if ($this->_route == 'password') {
                $id = (int)$this->input->get('id');
                $reVal = $this->_modelSys->setPassword($id, $data['password']);
            }

            $repArr = array('0', 'successful');
            if ($reVal !== true) $repArr = array('1001', 'fail');
            CAjax::show($repArr[0], $repArr[1]);
        } else {
            if ($this->_route == 'admin') {
                $id = (int)$this->input->get('id');
                $data['t'] = 'edit';
                $data['user'] = $this->_modelSys->getUser($id);
                CView::show('admin/user/admin_edit', $data);
            }
        }
    }

    /**
     * 删除用户
     */
    public function drop()
    {
        $id = $this->input->post('id');
        $return = $this->_modelSys->deleteUser($id);
        $repArr = array('0', 'successful');
        if ($return !== true) $repArr = array('1001', 'fail');
        CAjax::show($repArr[0], $repArr[1]);
    }

    /**
     * 编辑密码
     */
    public function  password()
    {
        $id = $this->input->get('id');
        $password = $this->input->post('password');
        $return = $this->_modelSys->setPassword($id, $password);
        $repArr = array('0', 'successful');
        if ($return !== true) $repArr = array('1001', 'fail');
        CAjax::show($repArr[0], $repArr[1]);
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
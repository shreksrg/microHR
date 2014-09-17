<?php

/**
 * 注册登记管理控制器
 */
class RegisterMan extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->_modelRegister = CModel::make('admin/registerman_model', 'registerman_model');
    }

    public function index()
    {
        CView::show('admin/register/index');
    }

    /**
     * 获取登记者列表
     */
    public function registrant()
    {
        $page = (int)$this->input->get('page');
        $rows = (int)$this->input->get('rows');
        $criteria = $this->input->get();
        $list = $this->_modelRegister->getRegistrant($page, $rows, $criteria);
        echo json_encode($list);
    }

    /**
     * 新增注册
     */
    public function append()
    {
        if (REQUEST_METHOD == 'POST') {
            $data = $this->input->post();

            // 表单输入验证
            $validator = $this->validateForm();
            if ($validator->run() == false)
                CAjax::show('1000', '表单输入值不合法,请检查');

            $code = 0;
            $message = 'successful';
            $newId = $this->_modelRegister->append($data);
            if ($newId <= 0) {
                $code = 1000;
                $message = 'failure';
            }
            CAjax::show($code, $message);
        } else {
            CView::show('admin/register/new');
        }
    }

    /**
     * 编辑
     */
    public function edit()
    {
        if (REQUEST_METHOD == 'POST') {
            $data = $this->input->post();
            // 表单输入验证
            $validator = $this->validateForm();
            if ($validator->run() == false)
                CAjax::show('1000', '表单输入值不合法,请检查');
            $reVal = $this->_modelRegister->edit($data);
            $repArr = array('0', 'successful');
            if ($reVal !== true) $repArr = array('1001', 'fail');
            CAjax::show($repArr[0], $repArr[1]);
        } else {
            $id = $this->input->get('id');
            $row = $this->_modelRegister->getRow($id);
            $data['row'] = (array)$row;
            CView::show('admin/register/edit', $data);
        }
    }

    /**
     * 编辑商品
     */
    public function drop()
    {
        $id = $this->input->post('id');
        $return = $this->_modelRegister->drop($id);
        $repArr = array('0', 'successful');
        if ($return !== true) $repArr = array('1001', 'fail');
        CAjax::show($repArr[0], $repArr[1]);
    }

    protected function  validateForm()
    {
        $validator = FormValidation::make();
        $validator->set_rules('nickname', 'Nickname', 'required|xss_clean');
        $validator->set_rules('wxid', 'Wxid', 'required|xss_clean');
        $validator->set_rules('gender', 'Gender', 'required|integer|xss_clean');
        $validator->set_rules('mobile', 'Mobile', 'required|integer|max_length[13]|numeric|xss_clean');
        $validator->set_rules('academy', 'Academy', 'required|xss_clean');
        $validator->set_rules('major', 'Major', 'required|xss_clean');
        $validator->set_rules('status', 'Status', 'integer|xss_clean');
        return $validator;
    }
}
<?php

/**
 * 故事管理控制器
 */
class StoryMan extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->_modelstory = CModel::make('admin/storyman_model', 'storyman_model');
    }

    public function index()
    {
        CView::show('admin/story/index');
    }

    /**
     * 获取故事列表
     */
    public function stories()
    {
        $page = (int)$this->input->get('page');
        $rows = (int)$this->input->get('rows');
        $criteria = $this->input->get();
        $list = $this->_modelstory->getStories($page, $rows, $criteria);
        echo json_encode($list);
    }


    /**
     * 新增故事
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
            $return = $this->_modelstory->append($data);
            if ($return !== true) {
                $code = 1000;
                $message = 'failure';
            }
            CAjax::show($code, $message);
        } else {
            $data = array('t' => 'append', 'row' => null);
            CView::show('admin/story/edit', $data);
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
            $reVal = $this->_modelstory->edit($data);
            $repArr = array('0', 'successful');
            if ($reVal !== true) $repArr = array('1001', 'fail');
            CAjax::show($repArr[0], $repArr[1]);
        } else {
            $id = $this->input->get('id');
            $row = $this->_modelstory->getRow($id);
            $data = array('t' => 'edit', 'row' => (array)$row);
            CView::show('admin/story/edit', $data);
        }
    }

    /**
     * 审核故事
     */
    public function audit()
    {
        $id = $this->input->post('id');
        $status = (int)$this->input->post('status');

        $return = $this->_modelstory->audit($id, $status);
        $repArr = array('0', 'successful');
        if ($return !== true) $repArr = array('1001', 'fail');
        CAjax::show($repArr[0], $repArr[1]);
    }

    /**
     * 删除
     */
    public function drop()
    {
        $id = $this->input->post('id');
        $return = $this->_modelstory->drop($id);
        $repArr = array('0', 'successful');
        if ($return !== true) $repArr = array('1001', 'fail');
        CAjax::show($repArr[0], $repArr[1]);
    }

    /**
     * 表单验证
     */
    protected function  validateForm()
    {
        $validator = FormValidation::make();
        $validator->set_rules('register_id', 'Register_id', 'required|integer|xss_clean');
        $validator->set_rules('wxid', 'Wxid', 'required|xss_clean');
        $validator->set_rules('flowers', 'Flowers', 'integer|xss_clean');
        $validator->set_rules('eggs', 'Eggs', 'integer|xss_clean');
        $validator->set_rules('grade', 'Grade', 'numeric|xss_clean');
        $validator->set_rules('status', 'Status', 'integer|xss_clean');
        $validator->set_rules('digest', 'Digest', 'xss_clean');
        $validator->set_rules('content', 'content', 'required|xss_clean');
        return $validator;
    }

    /**
     * 响应返回登记列表
     */
    public function register()
    {
        CView::show('admin/story/register');
    }
}
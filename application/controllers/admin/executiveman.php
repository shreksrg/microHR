<?php

/**
 * 高管管理控制器
 */
class ExecutiveMan extends AdminController
{
    protected $_modelMan;

    public function __construct()
    {
        parent::__construct();
        $this->_modelMan = CModel::make('admin/executive_model', 'executiveman_model');
    }

    public function index()
    {
        CView::show('admin/executive/index');
    }

    /**
     * 列表
     */
    public function executives()
    {
        $page = (int)$this->input->get('page');
        $rows = (int)$this->input->get('rows');
        $criteria = $this->input->get();
        $list = $this->_modelMan->getRows($page, $rows, $criteria);
        echo json_encode($list);
    }


    /**
     * 新增高管
     */
    public function append()
    {
        if (REQUEST_METHOD == 'POST') {
            $data = $this->input->post();

            // 表单输入验证
            $validator = $this->validateForm();
            if ($validator->run() == false)
                CAjax::show('1000', '表单输入值不合法,请检查');
            $return = $this->_modelMan->append($data);
            CAjax::result($return);
        } else {
            $data = array('t' => 'append', 'row' => null);
            CView::show('admin/executive/edit', $data);
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
            CAjax::result($reVal);

        } else {
            $id = $this->input->get('id');
            $row = $this->_modelMan->getRow($id);
            $data = array('t' => 'edit', 'row' => (array)$row);
            CView::show('admin/executive/edit', $data);
        }
    }

    /**
     * 审核故事
     */
    public function audit()
    {
        $id = $this->input->post('id');
        $status = (int)$this->input->post('status');
        $return = $this->_modelMan->audit($id, $status);
        CAjax::result($return);
    }

    /**
     * 删除
     */
    public function drop()
    {
        $id = $this->input->post('id');
        $return = $this->_modelMan->drop($id);
        CAjax::result($return);
    }

    /**
     * 表单验证
     */
    protected function  validateForm()
    {
        $validator = FormValidation::make();
        $validator->set_rules('name', 'Name', 'required|xss_clean');
        $validator->set_rules('title', 'Title', 'required|xss_clean');
        $validator->set_rules('digest', 'Digest', 'required|xss_clean');
        $validator->set_rules('content', 'Content', 'required|xss_clean');
        $validator->set_rules('status', 'Status', 'integer|xss_clean');
        return $validator;
    }

    /**
     * 响应返回登记列表
     */
    public function register()
    {
        CView::show('admin/executive/register');
    }
}
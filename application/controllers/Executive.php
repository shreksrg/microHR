<?php

class Executive extends FrontController
{
    protected $_modelMan;

    public function __construct()
    {
        parent::__construct();
        $this->_modelMan = CModel::make('executive_model');
    }

    public function _authentication()
    {
        return true;
    }

    /**
     * 高管列表
     */
    public function index()
    {
        $offset = 10;
        if (REQUEST_METHOD == 'GET') {
            $data['rows'] = $this->_modelMan->getRows(0, $offset);
            CView::show('executive/index', $data);
        } else {
            $total = (int)$this->input->post('total');
            $rows = $this->_modelMan->getRows($total, $offset);
            CAjax::show(0, 'successful', $rows);
        }
    }

    /**
     * 高管详细
     */
    public function show()
    {
        $id = (int)$this->input->get('id');
        if ($id > 0) {
            $data['detail'] = $this->_modelMan->getRow($id);
            CView::show('executive/detail', $data);
            return true;
        }
    }

    /**
     * 点赞高管
     */
    public function appraise()
    {
        $return = false;
        $id = (int)$this->input->get('id');
        if ($id > 0) {
            $wxid = $this->_user->id;
            $wxid = 'asadfa434';
            $row = $this->_modelMan->getRow($id);
            if (!$row) CAjax::show(1001, 'no record');
            $log = $this->_modelMan->getLog($wxid, $id);
            if ($log) CAjax::show(1008, 'had been appraised');
            $return = $this->_modelMan->addLog($wxid, $id);
            if ($return) $return = $this->_modelMan->appraise($id);
        }
        CAjax::result($return);
    }
}

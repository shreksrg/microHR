<?php


class Faq extends FrontController
{
    protected $_modelFAQ;

    public function __construct()
    {
        parent::__construct();
        $this->_modelFAQ = CModel::make('faq_model');
    }

    public function _authentication()
    {
        return false;
    }

    /**
     * QA列表
     */
    public function index()
    {
        $offset = 10;
        if (REQUEST_METHOD == 'GET') {
            $data['rows'] = $this->_modelFAQ->getRows(0, $offset);
            CView::show('faq/index', $data);
        } else {
            $total = (int)$this->input->post('total');
            $rows = $this->_modelFAQ->getRows($total, $offset);
            CAjax::show(0, 'successful', $rows);
        }
    }
}
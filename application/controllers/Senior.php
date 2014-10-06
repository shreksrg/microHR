<?php


class Senior extends FrontController
{
    protected $_modelSenior;

    public function __construct()
    {
        parent::__construct();
        //  $this->_modelSenior = CModel::make('senior_model');
    }

    public function _authentication()
    {
        return true;
    }

    public function index()
    {
        CView::show('senior/index');
    }

    public function show()
    {
        CView::show('senior/detail');
    }
}
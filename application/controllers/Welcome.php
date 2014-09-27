<?php


class Welcome extends FrontController
{

    public function _authentication()
    {
        return false;
    }

    public function index()
    {
        $this->load->model('login_model');
        CView::show('index');
    }

    public function navigation()
    {
        CView::show('index');
    }
}
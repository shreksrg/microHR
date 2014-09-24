<?php


class Welcome extends FrontController
{

    public function _authentication()
    {
        return false;
    }

    public function index()
    {
        $this->input->get();
        $this->load->model('login_model');
        CView::show('index');
    }
}
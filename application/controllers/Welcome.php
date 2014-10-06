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

    /**
     * 招聘职位
     */
    public function position()
    {
        CView::show('position');
    }

    /**
     * 招聘行程
     */
    public function schedule()
    {
        CView::show('schedule');
    }

    /**
     * 招聘流程
     */
    public function process()
    {
        CView::show('process');
    }

    /**
     * 投递简历
     */
    public function post()
    {
        CView::show('resume');
    }


}
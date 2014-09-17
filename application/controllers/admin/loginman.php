<?php

class loginMan extends AdminController
{
    public function index()
    {
        if (REQUEST_METHOD == 'POST') {
            $return = $this->login(); //用户登录
            $repArr = array(-1, 'fail');
            if ($return === true)
                $repArr = array(0, 'successful');
            CAjax::show($repArr[0], $repArr[1]);
        } else {
            CView::show('admin/login');
        }
    }

    protected function _authentication()
    {
        return true;
    }

    /**
     * 管理员登录
     */
    protected function login()
    {
        $username = $this->input->post('username', true);
        $password = $this->input->post('password', true);

        $this->_user->username = trim($username);
        $this->_user->password = $password;

        $modLogin = CModel::make('admin/loginman_model', 'loginman_model');
        $boolean = $modLogin->authenticate($this->_user);
        return ($boolean === true && $modLogin->save());
    }

    /**
     * 用户登出
     */
    public function logout()
    {
        $this->_user->logout();
        CAjax::show(0, 'successful');
    }
}
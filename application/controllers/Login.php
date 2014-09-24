<?php


class Login extends FrontController
{
    public function index()
    {
        $reUrl = $this->input->get('redirect');
        $modelApi = CModel::make('api_model');
        $reUrl = APP_URL . '/login/auth?toUrl=' . $reUrl;
        $reqUrl = $modelApi->authUrl($reUrl);
        CView::show('auth', array('reqUrl' => $reqUrl));
    }

    /**
     * 用户登出
     */
    public function logout()
    {
        $responseArg = array('code' => 0, 'message' => 'logout complete', 'data' => null);
        $this->_user->logout();
        header('location:' . SITE_URL);
        return false;
        echo json_encode($responseArg);
    }


}
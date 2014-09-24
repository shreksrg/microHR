<?php


class Stories extends FrontController
{
    protected $_modelStory;

    public function __construct()
    {
        $this->_modelStory = CModel::get('story_model');
    }


    public function _authentication()
    {

        return true;
    }


    /**
     *故事列表
     */
    public function index()
    {
        $offset = 10;
        if (REQUEST_METHOD == 'GET') {
            $data['rows'] = $this->_modelStory->getRows(0, $offset);
            CView::show('story/index', $data);
        } else {
            $total = (int)$this->input->post('total');
            $rows = $this->_modelStory->getRows($total, $offset);
            CAjax::show(0, 'successful', $rows);
        }
    }

    /**
     * 新增故事
     */
    public function append()
    {
        $sessionKey = '_story_token_new';


        //获取用户微信ID
        $modelLogin = CModel::make('login_model');
        $openId = $modelLogin->getOpenID();
        if (!$openId) CView::show('message/error');

        //检查该用户微信ID是否已经注册
        $modelReg = CModel::make('register_model');
        $rowReg = $modelReg->getRow(array('wxid' => $openId), 'create_time', 1);
        if (!$rowReg) {
            header("location:" . APP_URL . '/register');
            return false;
        }

        if (REQUEST_METHOD == 'POST') {
            $return = false;
            $post = $this->input->post();
            $this->checkSubmit($post);
            CSession::set('_story_post', $post);
            $modelApi = CModel::make('api_model');
            if (!($token = CSession::get('_auth_refresh_token'))) {
                $this->authSubmit($modelApi);
            } else {
                $err = array('code' => 1001, 'content' => '授权验证错误');
                $access = $modelApi->authRefresh($token);
                if (isset($access['access_token'])) {
                    $post['wxid'] = $access['openid'];
                    $return = $this->_modelRegister->save($post);
                    if ($return === true) {
                        CView::show('Register/result');
                    } else {
                        $err = array('code' => 1002, 'content' => '注册失败:');
                    }
                } elseif (isset($access['errcode'])) {
                    $this->authSubmit($modelApi);
                    return false;
                }
                CView::show('message/error', $err);
            }

            $content = $this->input->post('content', true);
            $token = $this->input->post('token');
            $show['view'] = 'message/error';
            $show['message'] = array('code' => -1, 'content' => '故事提交失败');
            if ($token && $_SESSION[$sessionKey] === $token && $content) {
                $return = $this->_modelStory->append($this->_user->id, $content);
                if ($return === true) {
                    $show['view'] = 'message/info';
                    $show['message'] = array('code' => 0, 'content' => '故事提交成功');
                }
                unset($_SESSION[$sessionKey]);
            }
            CView::show($show['view'], $show['message']);
        } else {
            $token = UUID::fast_uuid();
            CSession::set('_story_token', $token);
            CView::show('story/form', array('token' => $token));
        }
    }

    /**
     * 检查故事提交
     */
    public function checkSubmit($data)
    {
        $err = array();
        if ($this->validateForm($data) !== true) {
            $err = array('code' => '1001', 'content' => '注册数据异常');
        } else {
            $token = CSession::get('_story_token');
            if (!$token || $data['token'] != $token) {
                $err = array('code' => '1001', 'content' => '表单填写不正确');
            }
        }
        if ($err) {
            CView::show('message/error', $err);
            exit(0);
        }
    }

    /**
     * 授权提交注册
     */
    public function authSubmit($modelApi = null)
    {
        $post = CSession::get('_register_post');
        if ($post) {
            $reUrl = urlencode(APP_URL . '/stories/save');
            $action = $modelApi->authUrl($reUrl);
            CView::show('code', array('action' => $action));
        } else CView::show('message/error', array('code' => 1000, 'content' => '注册请求过期'));
    }

    /**
     * 保存故事
     */
    public function save()
    {
        $errCode = 1001;
        $content = '授权失效';
        $post = CSession::get('_story_post');
        $this->checkSubmit($post);

        $authCode = $this->input->get('code');
        if ($authCode) {
            $modelApi = CModel::make('api_model');
            $access = $modelApi->authAccess($authCode);
            if (isset($access['access_token'])) {
                CSession::set('_auth_refresh_token', $access['refresh_token']);
                $post['wxid'] = $access['openid'];
                $return = $this->_modelStory->save($post);
                CSession::set('_story_token', null);
                if ($return === true) {
                    CView::show('story/result');
                    return true;
                } else {
                    $errCode = 1000;
                    $content = '提交失败';
                }
            }
        }
        CView::show('message/error', array('code' => $errCode, 'content' => $content));
    }


    /**
     * 故事评价：用鲜花或鸡蛋表达
     */
    public function appraise()
    {
        $id = (int)$this->input->get('id');
        $type = (int)$this->input->get('type');
        $return = $this->_modelStory->appraise($id, $type);
        CAjax::result($return);
    }


    /**
     * 验证表单
     */
    protected function  validateForm()
    {
        $validator = FormValidation::make();
        $validator->set_rules('content', 'Content', 'required|xss_clean');
        $validator->set_rules('token', 'Token', 'required|xss_clean');
        return $validator->run() === true;
    }


}
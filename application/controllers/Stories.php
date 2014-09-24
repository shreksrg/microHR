<?php


class Stories extends FrontController
{
    protected $_modelStory;

    public function __construct()
    {
        parent::__construct();
        $this->_modelStory = CModel::get('story_model');
    }

    public function _authentication()
    {
        if ($this->_user->isGuest) {
            $action = $this->input->get('action');
            if (REQUEST_METHOD == 'POST' && $action == 'append') {
                $post = $this->input->post();
                CSession::set('_story_post', $post);
            }
            parent::_authentication();
        }
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
        $action = $this->input->get('action');
        if ($action == 'append') {
            $post = $this->input->post();
            if (!$post) $post = CSession::get('_story_post');
            $this->checkSubmit($post);
            $modelApi = CModel::make('api_model');
            $post['wxid'] = $this->_user->id;
            $return = $this->_modelStory->append($post);
            if ($return === true) {
                CSession::drop('_story_token');
                CView::show('story/result');
            } else {
                $err = array('code' => 1002, 'content' => '提交失败');
                CView::show('message/error', $err);
            }
        } else {
            $_token = UUID::fast_uuid(6);
            CSession::set('_story_token', $_token);
            CView::show('story/form', array('token' => $_token));
        }
    }

    /**
     * 检查故事提交
     */
    public function checkSubmit($data)
    {
        $err = array();
        if ($this->validateForm($data) !== true) {
            $err = array('code' => '1001', 'content' => '提交数据异常');
        } else {
            $token = CSession::get('_story_token');
            if (!$token || $data['token'] != $token) {
                $err = array('code' => '1001', 'content' => '请求已过期');
            }
        }
        if ($err) {
            CView::show('message/error', $err);
            exit(0);
        }
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
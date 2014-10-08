<?php


class Stories extends FrontController
{
    protected $_modelStory;

    public function __construct()
    {
        parent::__construct();
        $this->_modelStory = CModel::make('story_model');

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
           // echo 'ok';
            CView::show('story/index', $data);
        } else {
            $total = (int)$this->input->post('total');
            $rows = $this->_modelStory->getRows($total, $offset);
            CAjax::show(0, 'successful', $rows);
        }
    }

    /**
     *故事详细
     */
    public function show()
    {
        $id = (int)$this->input->get('id');
        if ($id > 0) {
            $data['detail'] = $this->_modelStory->getRow($id);
            CView::show('story/detail', $data);
        }
    }

    /**
     *
     */
    public function comment()
    {
        $route = $this->input->get('r');
        if ($route == 'save') {
            //增加评论
            $postData = $this->input->post();
            $storyId = (int)$this->input->post('id');
            if ($this->validateForm($postData) !== true || $storyId <= 0) {
                CAjax::show(1001, 'Invalid post data');
                exit(0);
            }
            $postData['wxid'] = $this->_user->id;
            $return = $this->_modelStory->appendComment($postData);
            if ($return === true) {
                $this->_modelStory->counter($storyId, 'comment'); //更新故事评论统计数
                CSession::drop('_comment_token');
            }
            CAjax::result($return);
        } else {
            $storyId = (int)$this->input->get('id');
            $_token = UUID::randString(18);
            CSession::set('_comment_token', $_token);
            CView::show('story/comment', array('token' => $_token, 'storyId' => $storyId));
        }
    }

    /**
     * 新增故事
     */
    public function append()
    {
        $action = $this->input->get('action');
        if ($action == 'save') {
            $post = $this->input->post();
            $this->checkSubmit($post);
            $modelApi = CModel::make('api_model');
            $post['wxid'] = $this->_user->id;
            $return = $this->_modelStory->append($post);
            if ($return === true) {
                CSession::drop('_story_token');
            }
            CAjax::result($return);
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
            CAjax::show($err['code'], $err['content']);
            exit(0);
        }
    }

    /**
     * 故事评价：用鲜花或鸡蛋表达
     */
    public function appraise()
    {
        $id = (int)$this->input->get('id');
        $type = (int)$this->input->get('t');

        //检查是否已经点赞
        if ($type == 1) {
            $wxid = $this->_user->id;
            //$wxid = 'asadfa434';
            $row = $this->_modelStory->getLog($wxid, $id, $type);
            if ($row) CAjax::show(1008, 'had been favorite');
            else {
                $return = $this->_modelStory->appendLog($wxid, $id, $type);
                if (!$return) CAjax::result($return);
            }
        }

        $return = $this->_modelStory->appraise($id, $type);
        CAjax::result($return);
    }

    /**
     * 验证表单
     */
    protected function validateForm()
    {
        $validator = FormValidation::make();
        $validator->set_rules('content', 'Content', 'required|xss_clean');
        $validator->set_rules('token', 'Token', 'required|xss_clean');
        return $validator->run() === true;
    }


}
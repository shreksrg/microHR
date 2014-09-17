<?php


class Stories extends FrontController
{
    protected $_modelStory;

    public function __construct()
    {
        $this->_modelStory = CModel::get('story_model');
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
        if (REQUEST_METHOD == 'POST') {
            $content = $this->input->post('content');
            if (strlen($content) <= 0) {
                return false;
            }
            $return = $this->_modelStory->append($this->_user->id, $content);
            $show['view'] = 'message/error';
            $show['message'] = array('code' => -1, 'content' => '故事提交失败');
            if ($return === true) {
                $show['view'] = 'message/info';
                $show['message'] = array('code' => 0, 'content' => '故事提交成功');
            }
            CView::show($show['view'], $show['message']);
        } else {
            CView::show('story/form');
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
}
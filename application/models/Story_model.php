<?php

/**
 * 故事模型
 */
class Story_model extends App_model
{
    public function genStory($id)
    {
        $sql = "select * from mhr_story where isdel=0 and id=$id";
        $query = $this->db->query($sql);
        new Story($id, $query->row());
    }

    /**
     *
     */
    public function getRows($start, $offset, $args = null)
    {
        $sql = "SELECT id,title,digest,flowers,comments,grade,create_time FROM mhr_story where isdel=0 and status=1 order by grade desc,create_time desc limit $start,$offset";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getRow($id)
    {
        $detail = array();
        //故事详细
        $sql = "select s1.id,s1.title,s1.digest,s1.flowers,s1.comments,s1.create_time,s2.content from mhr_story s1
                  inner join mhr_story_content s2 on s1.id=s2.story_id
                  where s1.isdel=0 and s1.status=1 and  s1.id=$id";
        $query = $this->db->query($sql);
        if ($query->row()) {
            $detail['info'] = $query->row_array();
            //获取评论
            $detail['comments'] = $this->getComments($id, array('start' => 0, 'offset' => 6));
        }
        return $detail;
    }

    /**
     * 故事评论
     */
    public function getComments($id, $limit)
    {
        $start = $limit['start'];
        $offset = $limit['offset'];
        $sql = "select * from mhr_story_comment where isdel=0 and story_id=$id limit $start,$offset";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /**
     * 增加故事评论
     */
    public function appendComment($data)
    {
        $return = false;
        $wxid = $data['wxid'];
        $storyId = $data['id'];
        $query = $this->db->query("select id from mhr_story where isdel=0 and status=1 and id=$storyId limit 1");
        if (!$query->row()) return false;
        $query = $this->db->query("select id,nickname from mhr_register where isdel=0 and status=1 and wxid='$wxid' limit 1");
        if (!$query->row()) return false;
        $nickname = $query->row()->nickname;
        $now = time();
        $value = array(
            'wxid' => $wxid,
            'story_id' => $storyId,
            'nickname' => $nickname,
            'content' => $data['content'],
            'create_time' => $now,
            'update_time' => $now,
        );
        $return = $this->db->insert('mhr_story_comment', $value);
        return $return;
    }

    /**
     * 新增故事
     */
    public function append($data)
    {
        $return = false;
        $wxid = $data['wxid'];
        $query = $this->db->query("select id from mhr_register where isdel=0 and  wxid='$wxid' limit 1");
        if ($query->row()) {
            $regId = $query->row()->id;
            $content = $data['content'];
            $now = time();
            $value = array(
                'register_id' => $regId,
                'wxid' => $wxid,
                'digest' => mb_substr($content, 32),
                'create_time' => $now,
                'update_time' => $now,
            );
            $return = $this->db->insert('mhr_story', $value);
            if ($return == true) {
                $value = array(
                    'story_id' => $this->db->insert_id(),
                    'content' => $content,
                    'update_time' => $now,
                );
                $return = $this->db->insert('mhr_story_content', $value);
            }
        }
        return $return;
    }

    /**
     * 故事评价
     */
    public function appraise($id, $type)
    {
        $return = false;
        $tNum = '';
        $typeArr = array(0 => 'eggs', 1 => 'flowers');
        if (isset($typeArr[$type]) && strlen($typeArr[$type]) > 0) {
            $tn = $typeArr[$type];
            $now = time();
            $sql = "update mhr_story set $tn=$tn+1,update_time=$now where isdel=0 and status=1 and id=$id";
            $return = $this->db->query($sql);
        }
        return $return;
    }

    /**
     * 更新故事统计数
     */
    public function counter($id, $type, $num = 1)
    {
        $now = time();
        $return = false;
        if ($type == 'comment') {
            $sql = "update mhr_story set comments=comments+$num,update_time=$now where isdel=0 and status=1 and id=$id";
            $return = $this->db->query($sql);
        }
        return $return;
    }


    public function getLog($wxid, $storyId, $type)
    {
        $query = $this->db->query("select id from mhr_story_log where isdel=0 and wxid='$wxid' and type=$type and story_id=$storyId limit 1");
        return $query->row();
    }

    public function appendLog($wxid, $storyId, $type)
    {
        $value = array(
            'wxid' => $wxid,
            'story_id' => $storyId,
            'type' => $type,
            'create_time' => time(),
        );
        $return = $this->db->insert('mhr_story_log', $value);
        return $return;
    }
}


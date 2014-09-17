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
        $sql = "SELECT id,digest,flowers,eggs,grade,create_time FROM mhr_story where isdel=0 and status=1 order by grade desc,create_time desc limit $start,$offset";
        $query = $this->db->query($sql);
        if ($query->row()) {
            return $query->result_array();
        }
        return null;
    }

    /**
     * 新增故事
     */
    public function append($openId, $data)
    {
        $return = false;
        $modelReg = CModel::make('register_model');
        $regRow = $modelReg->getRowByWId($openId);
        if ($regRow) {
            $content = $data['content'];
            $now = time();
            $value = array(
                'register_id' => $regRow->id,
                'wxid' => $openId,
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
        if ($type == 0) $tNum = 'eggs';
        if ($type == 1) $tNum = 'flowers';
        if ($tNum !== '') {
            $now = time();
            $sql = "update mhr_story set type=type+1,update_time=$now where isdel=0 and status=1 and id=$id";
            $return = $this->db->query($sql);
        }
        return $return;
    }
}


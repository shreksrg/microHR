<?php
/**
 * 微信应用配置
 * 菜单配置
 */

return array(
    'url' => 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token=',
    'menu' => array(
        'button' => array(
            array(
                'name' => '海亮招聘',
                'sub_button' => array(
                    array('type' => 'view', 'name' => '校园招聘', 'url' => 'http://211.152.55.100/microhr/'),
                    array('type' => 'view', 'name' => '社会招聘', 'url' => 'http://211.152.55.100/microhr/'),
                    array('type' => 'view', 'name' => '微注册', 'url' => 'http://211.152.55.100/microhr/index.php/register'),
                    array('type' => 'view', 'name' => 'Q&A', 'url' => 'http://211.152.55.100/microhr/'),
                )
            ),
            array(
                'name' => '精彩互动',
                'sub_button' => array(
                    array('type' => 'view', 'name' => '求职故事', 'url' => 'http://211.152.55.100/microhr/index.php/stories'),
                    array('type' => 'view', 'name' => '直面高管', 'url' => 'http://211.152.55.100/microhr/index.php/executive'),
                )
            ),
            array(
                'name' => '@海亮',
                'sub_button' => array(
                    array('type' => 'view', 'name' => '动态信息', 'url' => 'http://211.152.55.100/microhr/'),
                    array('type' => 'view', 'name' => '关于海亮', 'url' => 'http://211.152.55.100/microhr/'),
                )
            ),
        ),
    ),
);
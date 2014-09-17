<?php

class CAjax extends CCApplication
{
    static public function show($code, $message, $data = null, $return = false)
    {
        $responseData = array('code' => $code, 'message' => $message, 'data' => $data);
        $json = json_encode($responseData);
        if ($return == false) {
            echo $json;
            exit(0);
        } else return $json;
    }

    static public function success($code = 0, $message = 'successful')
    {
        self::show($code, $message);
    }

    static public function fail($code = -1, $message = 'fail')
    {
        self::show($code, $message);
    }

    
    static public function result($boolean)
    {
        $boolean === true ? CAjax::success() : CAjax::fail();
    }
}
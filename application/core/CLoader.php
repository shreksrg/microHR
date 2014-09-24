<?php

class CLoader extends CCApplication
{
    static public function config($file)
    {
        $config = null;
        $filePath = APPPATH . 'config/' . $file . '.php';
        if (file_exists($filePath))
            $config = require($filePath);
        else {
            $filePath = $file . '.php';
            if (file_exists($filePath)) $config = require($filePath);
        }
        return $config;
    }
}
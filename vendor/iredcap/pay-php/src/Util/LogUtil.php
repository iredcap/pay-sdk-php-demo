<?php
/**
 *  +----------------------------------------------------------------------
 *  | 草帽支付系统 [ WE CAN DO IT JUST THINK ]
 *  +----------------------------------------------------------------------
 *  | Copyright (c) 2018 http://www.iredcap.cn All rights reserved.
 *  +----------------------------------------------------------------------
 *  | Licensed ( https://www.apache.org/licenses/LICENSE-2.0 )
 *  +----------------------------------------------------------------------
 *  | Author: Brian Waring <BrianWaring98@gmail.com>
 *  +----------------------------------------------------------------------
 */
namespace IredCap\Pay\Util;

date_default_timezone_set('PRC');

class LogUtil
{
    private $level = 15;

    private static $instance = null;

    private function __construct(){}

    private function __clone(){}

    private static function Init($level = 15)
    {
        if(!self::$instance instanceof self)
        {
            self::$instance = new self();
            self::$instance->__setLevel($level);
        }
        return self::$instance;
    }

    private function __setLevel($level)
    {
        $this->level = $level;
    }

    public static function DEBUG($msg,$level = 15)
    {
        self::Init($level)->write(1, $msg);
    }

    public static function WARN($msg,$level = 15)
    {
        self::Init($level)->write(1, $msg);
    }

    public static function ERROR($msg,$level = 15)
    {
        $debugInfo = debug_backtrace();
        $stack = "\n[";
        foreach($debugInfo as $key => $val){
            if(array_key_exists("file", $val)){
                $stack .= "File:" . $val["file"] .',';
            }
            if(array_key_exists("line", $val)){
                $stack .= "In line:" . $val["line"].',';
            }
            if(array_key_exists("function", $val)){
                $stack .= "At function:" . $val["function"];
            }
        }
        $stack .= "]";
        self::Init($level)->write(8, $stack . $msg);
    }

    public static function INFO($msg,$level = 15)
    {
        self::Init($level)->write(2, $msg);
    }

    private function getLevelStr($level)
    {
        switch ($level)
        {
            case 1:
                return 'DEBUG';
                break;
            case 2:
                return 'INFO';
                break;
            case 4:
                return 'WARN';
                break;
            case 8:
                return 'ERROR';
                break;
            default:

        }
    }

    //写入日志
    protected function write($level,$message)
    {
        if (is_array($message)){
            $message = json_encode($message);
        }
        if(($level & $this->level) == $level )
        {
            $msg = "---------------------------------------------------------------\n";
            $msg .= '['.date('Y-m-d H:i:s').']['.$this->getLevelStr($level).'] '. $message ."\n";
            //创建文件夹
            $file_path = date('Ym');
            !file_exists($file_path) && @mkdir($file_path, 0777, true);
            $fileObj = fopen($file_path . DIRECTORY_SEPARATOR
                . date('d') . '_' . $this->getLevelStr($level) . '.log' ,'a');
            fwrite($fileObj, $msg, 4096);
        }
    }
}

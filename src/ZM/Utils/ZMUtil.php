<?php


namespace ZM\Utils;


use Co;
use framework\Console;
use Framework\ZMBuf;

class ZMUtil
{
    /**
     * 检查workerStart是否运行结束
     */
    public static function checkWait() {
        if(ZMBuf::isset("wait_start")) {
            ZMBuf::append("wait_start", Co::getCid());
            Co::suspend();
        }
    }

    public static function stop() {
        Console::info(Console::setColor("Stopping server...", "red"));
        foreach (ZMBuf::$server->connections as $v) {
            ZMBuf::$server->close($v);
        }
        DataProvider::saveBuffer();
        ZMBuf::$server->shutdown();
        ZMBuf::$server->stop();
    }

    public static function getHttpCodePage(int $http_code) {
        if(isset(ZMBuf::globals("http_default_code_page")[$http_code])) {
            return Co::readFile(DataProvider::getResourceFolder()."html/".ZMBuf::globals("http_default_code_page")[$http_code]);
        } else return null;
    }

    public static function reload() {
        Console::info(Console::setColor("Reloading server...", "gold"));
        foreach (ZMBuf::$server->connections as $v) {
            ZMBuf::$server->close($v);
        }
        DataProvider::saveBuffer();
        ZMBuf::$server->reload();
    }

    /**
     * 解析CQ码
     * @param $msg
     * @return array|null
     * 0123456
     * [CQ:at]
     */
    static function getCQ($msg) {
        if (($start = mb_strpos($msg, '[')) === false) return null;
        if (($end = mb_strpos($msg, ']')) === false) return null;
        $msg = mb_substr($msg, $start + 1, $end - $start - 1);
        if (mb_substr($msg, 0, 3) != "CQ:") return null;
        $msg = mb_substr($msg, 3);
        $msg2 = explode(",", $msg);
        $type = array_shift($msg2);
        $array = [];
        foreach ($msg2 as $k => $v) {
            $ss = explode("=", $v);
            $sk = array_shift($ss);
            $array[$sk] = implode("=", $ss);
        }
        return ["type" => $type, "params" => $array, "start" => $start, "end" => $end];
    }
}
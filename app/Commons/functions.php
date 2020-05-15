<?php

/**
 * 自定义公共函数库
 */

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;



/**
 * 添加日志文件
 * @param string $fileName 文件名
 * @param string $msg 信息
 * @param array $data 数据
 * @param string $level 日志级别
 * @param string $mode 日志通道  single:单个   daily:每日
 */
function customLog($fileName, $msg, $data = [], $level = 'info', $mode = 'daily')
{
    $logger = new Logger('custom');
    $formatter = new LineFormatter(null, 'Y-m-d H:i:s');
    if($mode == 'single') {
        $path = 'logs/'.$fileName.'.log';
    }else {
        $path = 'logs/'.$fileName.'-'.date('Y-m-d').'.log';
    }
    $stream = new StreamHandler(storage_path($path));
    $stream->setFormatter($formatter);
    $logger->pushHandler($stream);
    if(empty($data)) {
        $logger->$level($msg);
    }else {
        $logger->$level($msg, $data);
    }
}


/**
 * md5签名
 * @param array $params
 * @param string $key
 * @param string $keyname
 * @param bool $is_capital
 * @return string
 */
function md5_sign(array $params, string $key, $keyname = 'key', $is_capital = false)
{
    $params = array_filter($params);
    ksort($params);
    $params = urldecode(http_build_query($params));
    $str = $params.'&'.$keyname.'='.$key;
    if($is_capital) {
        $sign = strtoupper(md5($str));
    } else {
        $sign = strtolower(md5($str));
    }

    return $sign;
}


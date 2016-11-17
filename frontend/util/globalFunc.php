<?php

date_default_timezone_set('PRC');
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
defined('BASE_PATH') or define('BASE_PATH', dirname(dirname(dirname(__FILE__))));
defined('TIMESTAMP') or define('TIMESTAMP', $_SERVER['REQUEST_TIME']);
defined('DATETIME') or define('DATETIME', date('Y-m-d H:i:s', TIMESTAMP));

/**
 * 日志记录
 * 
 * @param type $file
 * @param type $msg
 */
function logs($file, $msg) {
    $file = BASE_PATH . '/logs/' . date('Y-m-d') . '_' . $file . '.log';
    error_log(date('Y-m-d H:i:s') . ' ' . $msg . "\n", 3, $file);
}

/**
 * 删除目录及其下文件或文件夹
 * 
 * @param type $path
 * @param type $del_self
 */
function deleteDir($path, $del_self = false) {
    $files = glob($path . '/*');
    foreach ($files as $file_path) {
        if (is_file($file_path)) {
            unlink($file_path);
        } else {
            deleteDir($file_path);
            rmdir($file_path);
        }
    }

    if ($del_self) {
        rmdir($path);
    }
}

/**
 * http post 请求
 * 
 * @param type $url
 * @param type $postdata
 * @param type $options
 * @return type
 */
function curl_post($url = '', $postdata = '', $options = array()) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    if (!empty($options)) {
        curl_setopt_array($ch, $options);
    }
    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}

/**
 * curl get 请求
 * 
 * @param type $url
 * @param type $options
 * @return type
 */
function curl_get($url = '', $options = array()) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    if (!empty($options)) {
        curl_setopt_array($ch, $options);
    }
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

/**
 * 可穿透取访问客户端ip
 * @return string
 */
function getClientUserIp() {
    $unknown = 'unknown';
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], $unknown)) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], $unknown)) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    /*
      处理多层代理的情况
      或者使用正则方式：$ip = preg_match("/[\d\.]{7,15}/", $ip, $matches) ? $matches[0] : $unknown;
     */
    if (false !== strpos($ip, ','))
        $ip = reset(explode(',', $ip));
    return $ip;
}

/**
 * 解析XML格式的字符串
 *
 * @param string $str
 * @return 解析正确就返回解析结果,否则返回false,说明字符串不是XML格式
 */
function xml_parser($str) {
    $xml_parser = xml_parser_create();
    if (!xml_parse($xml_parser, $str, true)) {
        xml_parser_free($xml_parser);
        return false;
    } else {
        return (json_decode(json_encode(simplexml_load_string($str)), true));
    }
}

/**
 * 通过ip取地址
 * 
 * @param type $ip
 * @return type
 */
function getAddressFromIp($ip = '') {
    Yii::import('webroot.protected.extensions.ip.IP');

    $address = IP::find($ip);
    $address = is_array($address) ? implode(' ', $address) : '';
    return empty($address) ? '' : $address;
}

/**
 * 数组转化为xml字符串
 * 
 * @param type $arr
 * @param type $level
 * @return string
 */
function arrToXmlStr($arr, $level = 0) {
    $xml = '';
    if ($level == 0) {
        $xml .= '<xml>' . "\n";
    }
    foreach ($arr as $key => $val) {
        $key = is_integer($key) ? 'item' : $key;
        if (!is_array($val)) {
            $xml .= is_integer($val) ? '<' . $key . '>' . $val . '</' . $key . '>' . "\n" : '<' . $key . '><![CDATA[' . $val . ']]></' . $key . '>' . "\n";
        } else {
            $xml .= '<' . $key . '>' . "\n";
            $xml .= arrToXmlStr($val, $level + 1);
            $xml .= '</' . $key . '>' . "\n";
        }
    }

    if ($level == 0) {
        $xml .= '</xml>';
    }
    return $xml;
}

/** Json数据格式化
 * @param  Mixed  $data   数据
 * @param  String $indent 缩进字符，默认4个空格
 * @return JSON
 */
function jsonFormat($data, $indent = null) {

    // 对数组中每个元素递归进行urlencode操作，保护中文字符
    array_walk_recursive($data, 'jsonFormatProtect');

    // json encode
    $data = json_encode($data);

    // 将urlencode的内容进行urldecode
    $data = urldecode($data);

    // 缩进处理
    $ret = '';
    $pos = 0;
    $length = strlen($data);
    $indent = isset($indent) ? $indent : '    ';
    $newline = "\n";
    $prevchar = '';
    $outofquotes = true;

    for ($i = 0; $i <= $length; $i++) {

        $char = substr($data, $i, 1);

        if ($char == '"' && $prevchar != '\\') {
            $outofquotes = !$outofquotes;
        } elseif (($char == '}' || $char == ']') && $outofquotes) {
            $ret .= $newline;
            $pos --;
            for ($j = 0; $j < $pos; $j++) {
                $ret .= $indent;
            }
        }

        $ret .= $char;

        if (($char == ',' || $char == '{' || $char == '[') && $outofquotes) {
            $ret .= $newline;
            if ($char == '{' || $char == '[') {
                $pos ++;
            }

            for ($j = 0; $j < $pos; $j++) {
                $ret .= $indent;
            }
        }

        $prevchar = $char;
    }

    return $ret;
}

/** 将数组元素进行urlencode
 * @param String $val
 */
function jsonFormatProtect(&$val) {
    if ($val !== true && $val !== false && $val !== null) {
        $val = urlencode($val);
    }
}

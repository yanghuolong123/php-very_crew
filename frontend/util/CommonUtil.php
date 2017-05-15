<?php

namespace app\util;

use Yii;
use yii\helpers\Url;

class CommonUtil {

    /**
     * 是否移动端访问访问
     *
     * @return bool
     */
    public static function isMobile() {
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
            return true;
        }
        // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset($_SERVER['HTTP_VIA'])) {
            // 找不到为flase,否则为true
            return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
        }
        // 脑残法，判断手机发送的客户端标志,兼容性有待提高
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $clientkeywords = array('nokia',
                'sony',
                'ericsson',
                'mot',
                'samsung',
                'htc',
                'sgh',
                'lg',
                'sharp',
                'sie-',
                'philips',
                'panasonic',
                'alcatel',
                'lenovo',
                'iphone',
                'ipod',
                'blackberry',
                'meizu',
                'android',
                'netfront',
                'symbian',
                'ucweb',
                'windowsce',
                'palm',
                'operamini',
                'operamobi',
                'openwave',
                'nexusone',
                'cldc',
                'midp',
                'wap',
                'mobile'
            );
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
                return true;
            }
        }
        // 协议法，因为有可能不准确，放到最后判断
        if (isset($_SERVER['HTTP_ACCEPT'])) {
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
                return true;
            }
        }
        return false;
    }

    /**
     * 截取字符串 (中英文)
     * enterception String include the chinese and english
     * Enter description here ...
     * @param String $string	截取的字串
     * @param int $length		截取长度
     * @param String $dot		超出长度时缺省符合
     */
    public static function cutstr($string, $length, $dot = '...') {
        $charset = Yii::$app->charset;  //'utf-8';
        if (strlen($string) <= $length) {
            return $string;
        }

        $string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array('&', '"', '<', '>'), $string);

        $strcut = '';
        if (strtolower($charset) == 'utf-8') {

            $n = $tn = $noc = 0;
            while ($n < strlen($string)) {

                $t = ord($string[$n]);
                if ($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
                    $tn = 1;
                    $n++;
                    $noc++;
                } elseif (194 <= $t && $t <= 223) {
                    $tn = 2;
                    $n += 2;
                    $noc += 2;
                } elseif (224 <= $t && $t <= 239) {
                    $tn = 3;
                    $n += 3;
                    $noc += 2;
                } elseif (240 <= $t && $t <= 247) {
                    $tn = 4;
                    $n += 4;
                    $noc += 2;
                } elseif (248 <= $t && $t <= 251) {
                    $tn = 5;
                    $n += 5;
                    $noc += 2;
                } elseif ($t == 252 || $t == 253) {
                    $tn = 6;
                    $n += 6;
                    $noc += 2;
                } else {
                    $n++;
                }

                if ($noc >= $length) {
                    break;
                }
            }
            if ($noc > $length) {
                $n -= $tn;
            }

            $strcut = substr($string, 0, $n);
        } else {
            for ($i = 0; $i < $length; $i++) {
                $strcut .= ord($string[$i]) > 127 ? $string[$i] . $string[++$i] : $string[$i];
            }
        }

        $strcut = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);

        return $strcut . $dot;
    }

    public static function cropImg($src, $dst, $width, $height, $mode) {
        $ic = new \app\util\ImageCrop($src, $dst);
        $ic->Crop($width, $height, $mode);
        $ic->SaveImage();
        //$ic->SaveAlpha(); //将补白变成透明像素保存
        $ic->destory();
    }

    public static function cropImgLink($src = '', $width = 330, $height = 220, $mode = 1, $static = true) {
        $pathInfo = pathinfo($src);
        $file = md5(base64_encode($src) . $width . $height . $mode) . '.' . $pathInfo['extension'];
//        if ($static) {
//            return '/assets/' . $file . '?src=' . base64_encode($src) . '&width=' . $width . '&height=' . $height . '&mode=' . $mode;
//        }
        return Url::to(['home/crop-img', 'src' => base64_encode($src), 'width' => $width, 'height' => $height, 'mode' => $mode]);
    }

    public static function video_info($file, $ffmpeg = '/home/work/tool/ffmpeg/ffmpeg') {
        if (!file_exists($ffmpeg)) {
            $ffmpeg = '/var/work/tool/ffmpeg/ffmpeg';
        }
        ob_start();
        passthru(sprintf($ffmpeg . ' -i "%s" 2>&1', $file));
        $info = ob_get_contents();
        ob_end_clean();
        // 通过使用输出缓冲，获取到ffmpeg所有输出的内容。
        $ret = array();
        // Duration: 01:24:12.73, start: 0.000000, bitrate: 456 kb/s
        if (preg_match("/Duration: (.*?), start: (.*?), bitrate: (\d*) kb\/s/", $info, $match)) {
            $ret['duration'] = $match[1]; // 提取出播放时间
            $da = explode(':', $match[1]);
            $ret['seconds'] = $da[0] * 3600 + $da[1] * 60 + $da[2]; // 转换为秒
            $ret['start'] = $match[2]; // 开始时间
            $ret['bitrate'] = $match[3]; // bitrate 码率 单位 kb
        }

        // Stream #0.1: Video: rv40, yuv420p, 512x384, 355 kb/s, 12.05 fps, 12 tbr, 1k tbn, 12 tbc
        if (preg_match("/Video: (.*?), (.*?), (.*?)[,\s]/", $info, $match)) {
            $ret['vcodec'] = $match[1]; // 编码格式
            $ret['vformat'] = $match[2]; // 视频格式 
            $ret['resolution'] = $match[3]; // 分辨率
            $a = explode('x', $match[3]);
            $ret['width'] = $a[0];
            $ret['height'] = $a[1];
        }

        // Stream #0.0: Audio: cook, 44100 Hz, stereo, s16, 96 kb/s
        if (preg_match("/Audio: (\w*), (\d*) Hz/", $info, $match)) {
            $ret['acodec'] = $match[1];       // 音频编码
            $ret['asamplerate'] = $match[2];  // 音频采样频率
        }

        if (isset($ret['seconds']) && isset($ret['start'])) {
            $ret['play_time'] = $ret['seconds'] + $ret['start']; // 实际播放时间
        }

        $ret['size'] = filesize($file); // 文件大小
        return $ret;
    }

    public static function getFileExtension($file) {
        return pathinfo($file, PATHINFO_EXTENSION);
    }

    /**
     * 删除目录及其下文件或文件夹
     * 
     * @param type $path
     * @param type $del_self
     */
    public static function deleteDir($path, $del_self = false) {
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
     * 验证$_GET参数是否存在
     * 
     * @param type $params
     * @return type
     */
    public static function validParams($params = array()) {
        $paramArr = array();
        foreach ($params as $param) {
            $paramArr[] = isset($_GET[$param]) ? $_GET[$param] : '';
        }

        return $paramArr;
    }

}

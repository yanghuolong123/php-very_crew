<?php

namespace app\util;

class LogUtil {

    /**
     * 日志记录
     * 
     * @param type $file
     * @param type $msg
     */
    public static function logs($file, $msg) {
        $file = BASE_PATH . '/logs/' . $file . '_' . date('Y-m-d') . '.log';
        error_log(date('Y-m-d H:i:s') . ' ' . $msg . "\n", 3, $file);
    }

}

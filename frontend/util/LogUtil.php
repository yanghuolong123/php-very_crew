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
        $file = BASE_PATH . '/logs/' . date('Y-m-d') . '_' . $file . '.log';
        error_log(date('Y-m-d H:i:s') . ' ' . $msg . "\n", 3, $file);
    }

}

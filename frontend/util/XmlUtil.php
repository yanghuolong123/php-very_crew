<?php

namespace app\util;

class XmlUtil {

    /**
     * 解析XML格式的字符串
     *
     * @param string $str
     * @return 解析正确就返回解析结果,否则返回false,说明字符串不是XML格式
     */
    public static function xml_parser($str) {
        $xml_parser = xml_parser_create();
        if (!xml_parse($xml_parser, $str, true)) {
            xml_parser_free($xml_parser);
            return false;
        } else {
            return (json_decode(json_encode(simplexml_load_string($str)), true));
        }
    }

    /**
     * 数组转化为xml字符串
     * 
     * @param type $arr
     * @param type $level
     * @return string
     */
    public static function arrToXmlStr($arr, $level = 0) {
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

}

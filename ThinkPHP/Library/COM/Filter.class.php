<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2012 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------
namespace COM;

class Filter{

/**
    * 函数功能:过滤特殊字符
    * 
    *    @param string $content    需过滤内容
    *    @return string
    */
function filterSpecial($content)
{
    $search = array (
             "'<script[^>]*?>.*?</script>'si",    // 去掉 javascript
                     //"'([\r\n\s])'",                     // 去掉空白字符
                     "'(\')'",                 // 替换英文'为中文’
                    );                     
  
    $replace = array (
             "",
                      " ",
                      "’",
                      );
    return preg_replace ($search, $replace, $content);
}

/**
    * 函数功能:过滤HTML标记
    * 
    *    @param string $content    需过滤内容
    *    @return string
    */
function filterHtml($content)
{
    $search = array (
           "'<script[^>]*?>.*?</script>'si",    // 去掉 javascript
                   "'<[\/\!]*?[^<>]*?>'si",             // 去掉 HTML 标记
                   //"'([\r\n\s])'" ,                    // 去掉空白字符
                   "'(\')'"                          // 替换英文'为中文’
            );                        
    $replace = array (
           "",
                    "",
                    "",
                    "’"
                     );
    return preg_replace ($search, $replace, $content);
}

/**
    * 函数功能:检查id是否正确
    * 
    *    @param string $id    id
    *    @return string||false;
    */
function checkId32($id)
{
if(preg_match("/^[0-9A-Fa-f]{32}$/",$id))
    return $id;
else
    return false;
}

function Sqlfilter($CheckString="")
    {
     $search = array ("'<script[^>]*?>.*?</script>'si",    // 去掉 javascript
                    "'[\r\n]|[\s]+'",                   // 去掉空白字符
                    "'&(lt|#60);'i",
                    "'\''",
                    "'\"'",
                    "'&(gt|#62);'i","'[<]|[>]'","'\\\'");
     $replace = array ("");
     return preg_replace($search, $replace,$CheckString);
    }
    //过滤内容字段
    function SqlFilterContent($CheckString="")
    {
     $search = array ("'<script[^>]*?>.*?</script>'si",    // 去掉 javascript
                    "'\''", "'&(lt|#60);'i","'&(gt|#62);'i","'delete'i","'update'i",
                    "'into'i","'where'i","'set'i","'sele'i","'insert'i","'[\r\n]|[\s]+'",
                    "'from'i","'value'i","'exe'i","'localgroup'i","'chr'i",
                    "'truncate'i","'sysobjects'i","'syscolumns'i","'master'i","'/add'i",
                    "'cmdshell'i","'drop'i","'\\\'");
     $replace = array ("");
     return preg_replace($search,$replace,$CheckString);
    }
//过滤标题字段
function SqlfilterTitle($CheckString="")
    {
     $search = array ("'<script[^>]*?>.*?</script>'si",    // 去掉 javascript
        "'[\r\n]|[\s]+'",                   // 去掉空白字符
        "'&(lt|#60);'i","'\''",
        "'&(gt|#62);'i","'[<]|[>]'","'delete'i","'update'i","'sele'i","'insert'i",
        "'into'i","'where'i","'set'i"
        ,"'from'i","'script'i","'value'i","'exe'i","'localgroup'i","'chr'i",
        "'truncate'i","'sysobjects'i","'syscolumns'i","'master'i","'/add'i","'cmdshell'i"
        ,"'drop'i","'\\\'");
     $replace = array ("");
     return preg_replace($search, $replace,$CheckString);
    }

}
?> 
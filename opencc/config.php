<?php

if(basename($_SERVER['REQUEST_URI']) == basename(__FILE__)){
    JumpToIndex('先访问index.php');
}

define('I',DIRECTORY_SEPARATOR);

//opencc根目录
define('OPENCC',"D:".I."opencc-1.0.4");

//opencc.exe路径
define('OPENCC_EXE',OPENCC.I."bin".I."opencc");

//opencc配置文件路径
define('OPENCC_CONFIG_DIR',OPENCC.I."share".I."opencc");

//当前脚本目录
define('PATH',dirname(__FILE__));

//临时存放上传文件的目录
define('TEMP_FILE_DIR',PATH.I.'upload');

//转换后的目录
define('OUTPUT_FILE_DIR',PATH.I.'output');

//读取opencc配置文件
$config = scandir(OPENCC_CONFIG_DIR);
$config = array_filter($config,function ($file){
    $file_exp = explode('.',$file);
    $ext = array_pop($file_exp);
    if($ext == 'json'){
        return OPENCC_CONFIG_DIR.I.$file;
    }
});


function JumpToIndex($msg=''){
    header("Refresh:1;url=".dirname($_SERVER['REQUEST_URI']).I."index.php");
    echo $msg."<br>";
    for($i=3;$i>0;$i--){
        echo $i."秒后跳转<br>";
        ob_flush();
        flush();
        sleep(1);
    }
    echo "正在跳转...";
    exit();
}
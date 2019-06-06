<?php

require_once 'config.php';

if(empty($_POST['submit'])){
    JumpToIndex('先访问index.php');
}

$config = $_POST['config'];
$files = $_FILES['file'];

if(empty($config)){
    JumpToIndex('未选择配置');
}

if(empty($files['name'])){
    JumpToIndex('未选择文件');
}

if(!is_dir(TEMP_FILE_DIR)){
    mkdir(TEMP_FILE_DIR);
}
if(!is_dir(OUTPUT_FILE_DIR)){
    mkdir(OUTPUT_FILE_DIR);
}

$error = array();
foreach ($files['tmp_name'] as $key=>$value) {
    $input_file = TEMP_FILE_DIR . I . $files['name'][$key];
    $output_file = OUTPUT_FILE_DIR . I . $files['name'][$key];
    $file_content = file_get_contents($value);
    $encoding = mb_detect_encoding($file_content,"UTF-8, GBK");
    if($encoding != 'UTF-8'){
        $file_content = iconv($encoding,'UTF-8//IGNORE',$file_content);
    }
    file_put_contents($input_file,$file_content);
    //组装命令
    $command = OPENCC_EXE . " -i " . $input_file . " -o " . $output_file . " -c " . $config;
    exec($command,$error[$key]);

    if(empty($error[$key])){
        $exec_file[] = $output_file;
    }else{
        array_unshift($error[$key],$command);
    }
    //echo $command . "<br>";
}

//创建压缩文件
$zip = new ZipArchive();
$res = $zip->open(OUTPUT_ZIP,ZipArchive::CREATE);
if($res !== TRUE) exit($res);
foreach ($exec_file as $file){
    $zip->addFile($file,basename($file));
}

//有错误记录错误信息
if(!empty($error)){
    $error_content = implode("\r\n",array_map(function ($value){
        return implode("\r\n",$value);
    },$error));
    file_put_contents(ERROR_FILE,$error_content);
    $zip->addFile(ERROR_FILE,basename(ERROR_FILE));
}

//关闭文件
$zip->close();

//删除临时文件
RemoveDir(TEMP_FILE_DIR);
RemoveDir(OUTPUT_FILE_DIR);

//输出文件
header("Content-type:application/octet-stream");
header("Accept-Ranges:bytes");
header("Accept-Length:".filesize(OUTPUT_ZIP));
header("Content-Disposition: attachment; filename=".basename(OUTPUT_ZIP));
readfile(OUTPUT_ZIP);

//删除压缩包
RemoveDir(OUTPUT_ZIP);
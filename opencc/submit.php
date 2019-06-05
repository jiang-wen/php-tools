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

foreach ($files['tmp_name'] as $key=>$value) {
    $filename = TEMP_FILE_DIR . I . $files['name'][$key];
    $output_file = OUTPUT_FILE_DIR . I . $files['name'][$key];
    move_uploaded_file($value, $filename);
    $command = OPENCC_EXE . " -i " . $filename . " -o " . $output_file . " -c " . $config;
    $result = exec($command);
    echo $command . "<br>";
}

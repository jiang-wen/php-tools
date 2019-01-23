<?php
//此脚本用于b站下载视频的整理


set_time_limit(0); // 执行时间为无限制，php默认执行时间是30秒
ignore_user_abort(true); //即使Client断开(如关掉浏览器)，PHP脚本也可以继续执行. 
 
//课程根目录
$originDir = "E:/18090969/";
//目标目录
$targetDir = "E:/";

show( "<p>开始处理:$originDir</p>");

//获取课程名称
$json = file_get_contents($originDir."1/entry.json");
$arr = json_decode($json,true);
$courseTitle = $arr['title'];
show( "<p>课程：$courseTitle</p>");

//建立课程文件夹
$courseDir = $targetDir.$courseTitle;
$gbk_courseDir = iconv('UTF-8','GBK',$courseDir);
if(!file_exists($gbk_courseDir) || !is_dir($gbk_courseDir)){
	mkdir($gbk_courseDir);
}
//扫描课程小节数
$originDirPart = scandir($originDir);
$courseCount = count($originDirPart) - 2;
show("<p>共{$courseCount}章节</p>");
for($i=1;$i<=$courseCount;$i++){
	
	//获取小节名称及分段
	$partJson = file_get_contents($originDir.$i."/entry.json");
	$partArr = json_decode($partJson,true);
	$partName =  $partArr['page_data']['part'];
	$partFullDir = $courseDir."/".$partName;
	$gbk_partFullDir = iconv("UTF-8","GBK",$partFullDir);
	if(!file_exists($gbk_partFullDir) || !is_dir($gbk_partFullDir)){
		mkdir($gbk_partFullDir);
	}
	$middleDirName = $originDir.$i.'/'.$partArr['type_tag'].'/';
	
	$partConfig = json_decode(file_get_contents($middleDirName.'index.json'),true);
	$segCount = count($partConfig['segment_list']);
	show("<p>第{$i}章共{$segCount}段：$partName ");
	//开始复制小节视频各段
	for($j=0;$j<$segCount;$j++){
		show(" $j.flv ");
		copy($middleDirName.$j.".blv",$gbk_partFullDir."/".$j.".flv");
	}
	show(" <strong>OK</strong> </p>");

}
show("<p>执行完毕</p>");

function show($str){
	echo $str;
	ob_flush();//把数据从PHP的缓冲（buffer）中释放出来。
    flush(); //把不在缓冲（buffer）中的或者说是被释放出来的数据发送到浏览器。
}
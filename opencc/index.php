<?php require_once 'config.php';?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <title>简繁体转换（文件）</title>
    <meta charset="utf-8" />
</head>
<body>


<form method="post" enctype="multipart/form-data" action="./submit.php">
    <table>
        <tr>
            <td>文件</td>
            <td><input type="file" multiple name="file[]" ></td>
        </tr>
        <tr>
            <td>opencc配置</td>
            <td>
                <select name="config">
                    <?php foreach ($config as $v):?>
                    <option value="<?php echo OPENCC_CONFIG_DIR.I.$v ?>"><?php echo $v?></option>
                    <?php endforeach;?>
                </select>
            </td>
        </tr>
        <tr>
            <td><input type="submit" name="submit" value="开始转换"></td>
            <td>&ensp;</td>
        </tr>
    </table>
</form>

</body>
</html>







<?php


//$opencc = "D:/opencc-1.0.4/bin/opencc ";
//
//$in_dir = "D:/phpStudy/WWW/market2.x7sy.com/application/controllers/";
//$dir = scandir($in_dir);
//$out_dir = "D:/market2_web_x7sy/";
//
//$config = "D:/opencc-1.0.4/share/opencc/s2t.json";
//$out = "D:/test.txt";
//@unlink($in_dir);
//$arr = array_map(function($val) use($opencc,$in_dir,$out_dir,$config){
//	if(!is_dir($in_dir.$val)){
//
//		return "opencc -i {$in_dir}{$val} -o {$out_dir}{$val} -c {$config} ";
//	}
//
//},$dir);
//
//file_put_contents($out,implode("\r\n",$arr));
//echo "执行完毕";
?>
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

<ul>
    <li>s2t.json 简体到繁体</li>
    <li>t2s.json 繁体到简体</li>
    <li>s2tw.json 简体到台湾正体</li>
    <li>tw2s.json 台湾正体到简体</li>
    <li>s2hk.json 简体到香港繁体（香港小学学习字词表标准）</li>
    <li>hk2s.json 香港繁体（香港小学学习字词表标准）到简体</li>
    <li>s2twp.json 简体到繁体（台湾正体标准）并转换为台湾常用词汇</li>
    <li>tw2sp.json 繁体（台湾正体标准）到简体并转换为中国大陆常用词汇</li>
</ul>
</body>
</html>


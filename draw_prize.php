<?php

ini_set('memory_limit','1024M');
//每 n 次抽中一次
$rate = 1000;

$prize = array(
	1=>array('id'=>1,'name'=>'华为 P30 Pro','num'=>100),
	2=>array('id'=>2,'name'=>'华为 MateBook X Pro','num'=>50),
	3=>array('id'=>3,'name'=>'荣耀 Nova 3','num'=>200),
);

//模拟抽奖次数
$time = 1000000;

for($i=0;$i<$time;$i++){
    $result = getResult($prize,$rate);
    $result_arr[$result['id']][] = $result;
}
ksort($result_arr);
//统计结果
echo "每".$rate."次中一次，总次数：".$time."<br>";
echo "<table border='1' style='text-align: center;'>";
echo "<tr><th width='200'>奖品</th><th width='100'>次数</th><th width='100'>概率</th></tr>";
foreach ($result_arr as $value){
    $result_rate = count($value)/$time * 100 . "%";
    echo "<tr><td>".$value[0]['name']."</td><td>".count($value)."次</td> <td>".$result_rate."</td></tr>";
}
echo "</table>";

//抽奖
function getResult($prize,$rate){
    $num_arr = array_column($prize,'num');
    array_multisort($num_arr,$prize);
    $total_num = array_sum($num_arr);
    $prize_dump = $total_num*$rate;
    $prize[] = array('id'=>0,'name'=>'谢谢参与','num'=>$prize_dump);

    foreach ($prize as $value){
        $rand = mt_rand(0,$prize_dump);
        if($rand < $value['num']){
            return $value;
        }else{
            $prize_dump -= $value['num'];
        }
    }

}
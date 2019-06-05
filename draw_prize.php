<?php

ini_set('memory_limit','1024M');
//每 n 次抽中一次
$rate = 1000;

$prize = array(
	1=>array('id'=>1,'name'=>'平台币3个','num'=>100),
	2=>array('id'=>2,'name'=>'小7虎1只','num'=>50),
	3=>array('id'=>3,'name'=>'代金券1张','num'=>200),
);

//模拟抽奖次数
$time = 10000;

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
    //奖品数量数组
    $num_arr = array_column($prize,'num');
    //将奖品数组按奖品数量排序
    array_multisort($num_arr,$prize);
    //奖品总数量
    $total_num = array_sum($num_arr);
    //抽奖区间总长度，每10人抽中一次 ， 那 就是  10 * 奖品总数量
    $prize_dump = $total_num*$rate;

    //未中奖的，放到函数外面比较好
    $prize[] = array('id'=>0,'name'=>'谢谢参与','num'=>$prize_dump);

    foreach ($prize as $value){
        //随机取数
        $rand = mt_rand(0,$prize_dump);

        if($rand < $value['num']){
            return $value;
        }else{
            $prize_dump -= $value['num'];
        }
    }

}
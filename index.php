<?php 

$ad_ddos_query=10; // количество запросов в секунду для обнаружения DDOS атаки 
$ad_check_file='check.txt'; // файл для записи текущего состояния во время мониторинга 
$ad_temp_file='all_ip.txt'; // временный файл 
$ad_black_file='black_ip.txt'; // будут заносится ip машин зомби 
$ad_white_file='white_ip.txt'; // заносятся ip посетителей 
$ad_dir='anti_ddos'; // каталог со скриптами 
$ad_num_query=0; // текущее количество запросов в секунду из файла $check_file 
$ad_sec_query=0; // секунда из файла $check_file 
$ad_end_defense=0; // время окончание защиты из файла $check_file 
$ad_sec=date("s"); // текущая секунда 
$ad_date=date("mdHis"); // текущее время 
$ad_defense_time=10000; // при обнаружении ddos атаки время в секундах на которое прекращается мониторинг 



if(!file_exists("{$ad_dir}/{$ad_check_file}") or !file_exists("{$ad_dir}/{$ad_temp_file}") or !file_exists("{$ad_dir}/{$ad_black_file}") or !file_exists("{$ad_dir}/{$ad_white_file}") or !file_exists("{$ad_dir}/anti_ddos.php")){ 
die("Не хватает файлов."); 
} 

require("{$ad_dir}/{$ad_check_file}"); 

if ($ad_end_defense and $ad_end_defense>$ad_date){ 
require("/anti_ddos/index.php");
} else { 
if($ad_sec==$ad_sec_query){ 
$ad_num_query++; 
} else { 
$ad_num_query='1'; 
} 

if ($ad_num_query>=$ad_ddos_query){ 
$ad_file=fopen("{$ad_dir}/{$ad_check_file}","w"); 
$ad_end_defense=$ad_date+$ad_defense_time; 
$ad_string='<?php $ad_end_defense='.$ad_end_defense.'; ?>'; 
fputs($ad_file,$ad_string); 
fclose($ad_fp); 
} else { 
$ad_file=fopen("{$ad_dir}/{$ad_check_file}","w"); 
$ad_string='<?php $ad_num_query='.$ad_num_query.'; $ad_sec_query='.$ad_sec.'; ?>'; 
fputs($ad_file,$ad_string); 
fclose($ad_fp); 
} 
} 
?> 

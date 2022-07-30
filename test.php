<?php 


$json_string   = '{"a":1,"b":2,"c":3,"d":4,"e":5}';

$my_array_data = json_decode($json_string, TRUE);

// [{"dokumentasi":"487624553_deaaprixal.png"},{"dokumentasi":"487624553_Screenshot 2022-07-23 205445.png"},{"dokumentasi":"487624553_pexels-photo-210243.jpeg"}]
foreach($my_array_data as $i => $info)
{
  if($info == 1 || $info == 2)
  {
    unset($my_array_data[$i]);
  }
}

print_r($my_array_data);

// print_r($my_array_data);
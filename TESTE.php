<?php
$str = 'seg-TERC-QUARTA-';
$array = (explode('-', $str, -1));
for ($index = 0; $index < count($array); $index++) {
    echo $array[$index];
}
//echo $teste;
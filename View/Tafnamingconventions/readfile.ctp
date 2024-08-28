<?php

$this->layout = 'ajax';

foreach ($output_array as $key => $value) {
    echo $key."=".$output_array[$key]."<br>";
}
?>

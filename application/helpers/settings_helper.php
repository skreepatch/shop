<?php


function setting_item($name){
    
    $s = new Setting();
    $s->where('name', $name)->get();
    return $s->value;
}

?>

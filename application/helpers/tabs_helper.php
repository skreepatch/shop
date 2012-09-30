<?php



function getTabs($tabs = NULL){
    $_result = '<ul class="tabs">';
    for($i=0; $i<count($tabs);$i++){
        $_class = '';
        if($i == 0){
            $_class .= ' first';
        } else if($i == count($tabs)){
            $_class .= ' last';
        }
        if(isset($tabs[$i]['class'])){
            $_class .= ' '.$tabs[$i]['class'];
        }
        if(current_url() == site_url($tabs[$i]['href'])){
            $_class .= ' active';
        }
        $_tab = '<li class="tab '.$_class.'"><a href="' . site_url($tabs[$i]['href']) . '">' . $tabs[$i]['text'] . '</a></li>';
        $_result .= $_tab;
    }
    $_result .= '</ul>';
    return $_result;
}

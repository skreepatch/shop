<?php

function checkPermission($meth) {

    $where = explode('::', $meth);
    $p = new Permission();
    $p->where(array('controller' => strtolower($where[0]), 'method' => $where[1]))->get();

    $groups = $p->group->get();

    $results = array();
    foreach ($groups as $g){
        array_push($results, $g->id);
    }

    return $results;
}

function checkLink($params){
    $showlink = FALSE;
    $p = new Permission();
    $p->where('url', $params['link'])->get();

    $groups = $p->group->get();

    foreach ($groups as $g){
	if($params['group'] == $g->id){
	    
	  $showlink = '<a href="'.site_url($params['link'].'/'.join('/', $params['segments'])).'" title="'.$params['label'].'">'.$params['label'].'</a>';
	    break;
	} else {
	    $showlink = '';
	}
        
    }
    echo $showlink;
}

function checkMenuitem($link, $group_id){
    $show = FALSE;
    $p = new Permission();
    $p->where('url', $link)->get();
    $groups = $p->group->get();

    foreach($groups as $g){
	if($group_id == $g->id){
	  $show = TRUE;
	} 
    }
    return $show;
    
}

?>

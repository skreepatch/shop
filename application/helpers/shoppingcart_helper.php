<?php


function listAddons($ordering = NULL, $language){
    if($ordering == NULL){
        return FALSE;
    }
    
       
    $addons_feed = '';
    $adopts = $ordering->addonopt->get();
    foreach ($adopts as $adopt){
	$adopt->dbtranslate($language);
	if($adopt->name != 'ללא'){
        $adopt->addon->get();
	$adopt->addon->dbtranslate($language);
        $_addon_name = $adopt->addon->addon_label;
        $addons_feed .= ' + '.$_addon_name.' '.$adopt->name;
	}
    }
    return $addons_feed;
    
    
}
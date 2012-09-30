<?php

function getFilters($filters = array(), $continue = FALSE, $post = FALSE, $prefilter = FALSE, $l) {
    if (isset($filters['last_filter_model'])) {
        $last_filter = new $filters['last_filter_model']();
        $last_filter->get_by_id($post['last_filter_id']);
    } else {
        $last_filter = FALSE;
    }

    echo '<div class="filters_reset"><a href="#" title="' . lang('reset_filters') . '">' . lang('reset_filters') . '</a></div>';

    for ($i = 0; $i < count($filters); $i++) {

        $css_class = '';
        if ($i == 0 || ($i + 1) % 3 == 1) {
            $css_class = 'first';
        } else if (($i + 1) % 3 == 0) {
            $css_class = 'last';
        }

        $_lower = strtolower($filters[$i]);
        echo '<div class="track_filter ' . $css_class . '">';

        echo form_label(lang('filter_by_' . $_lower) . ': ', $_lower . '_id');
        echo '<select id="' . $_lower . '" name="' . $_lower . '_id">';
        echo '<option value="0">' . lang('choose_' . $_lower) . '</option>';

        $f = new $filters[$i]();

        if ($prefilter) {
            foreach ($post as $rel => $relid) {
                if (!isset($filters[$rel]) && $_lower != $rel) {
                    $f->where_in_related($rel, 'id', $relid);
                    $last_filter = new $rel();
                    $last_filter->get_by_id($post[$rel]);
                }
            }
        }

        if ($i > 0 && $continue == TRUE && $last_filter != FALSE) {
            $f->where_in_related($last_filter->model, $last_filter)->get();
            if (isset($post[$_lower])) {
                $last_filter = new $filters[$i]();
                $last_filter->get_by_id($post[$_lower]);
            }
        } else {
            $f->get();

            if (isset($post[strtolower($filters[0])])) {
                $last_filter = new $filters[0]();
                $last_filter->get_by_id($post[strtolower($filters[0])]);
            }
        }

        foreach ($f as $fl) {
            $fl->dbtranslate($l);
            if (isset($post[$_lower]) && $post[$_lower] == $fl->id) {
                echo '<option value="' . $fl->id . '" selected="selected">' . $fl->name . '</option>';
            } else {
                echo '<option value="' . $fl->id . '">' . $fl->name . '</option>';
            }
        }
        echo '</select>';
        echo '</div>';
    }
}

function approveBulkDelete(){
    echo form_open('admin/deleter/delete', 'id="clone_selectors"', 'POST');
    echo lang('realy_delete');
    echo form_submit('', lang('delete'), 'id="submit_clone"');
    echo form_close();
}

function getSelectors($model = NULL, $l = 'hebrew') {
    $selectors = array('Product', 'Track', 'Printtype', 'Size', 'Papertype', 'Foldpage');

    if ($model == 'addonopt') {
        echo form_open('admin/cloner/cloneAddonopts', 'id="clone_selectors"', 'POST');
    } else {
        echo form_open('admin/cloner/save', 'id="clone_selectors"', 'POST');
    }

    echo form_fieldset(lang('clonning'), array('class' => 'grey_border'));

    echo form_fieldset();
    if ($model == 'addon') {
        echo form_fieldset();
        echo form_label(lang('toproduct'), 'product', array('class' => 'inline_label'));
        echo '<select name="product" id="products" class="clone_selector">';
        echo '<option>' . lang('choose_product') . '</option>';
        $sel = new Product();
        $sel->get();
        foreach ($sel as $s) {
            $s->dbtranslate($l);
            echo '<option value="' . $s->id . '">' . $s->name . '</option>';
        }
        echo '</select>';
        echo form_fieldset_close();
    } else {

        //echo form_checkbox('clone', '1');
        if ($model != 'addonopt' && $model != 'addon') {
            echo form_label(lang('copy_tree'), 'copy_tree');
            echo '<input type="checkbox" name="clone_tree" id="clone_tree" />';
        }
        echo form_fieldset_close();
        foreach ($selectors as $selector) {
            if ($selector == ucfirst($model)) {
                break;
            }
            echo form_fieldset();
            echo form_label(lang('to' . strtolower($selector)), strtolower($selector), array('class' => 'inline_label'));
            echo '<select name="' . strtolower($selector) . '" id="' . strtolower($selector) . 's" class="clone_selector">';
            $sel = new $selector();
            if ($model == 'addonopt' && $selector == 'Product') {
                $sel->where('id', $_POST['product'])->get();
            } else if ($model == 'addonopt') {
                $sel->where_in_related('product', 'id', $_POST['product'])->get();
            } else {
                $sel->get();
                echo '<option>' . lang('choose_' . strtolower($selector)) . '</option>';
            }
            foreach ($sel as $s) {
                $s->dbtranslate($l);
                echo '<option value="' . $s->id . '">' . $s->name . '</option>';
            }
            echo '</select>';
            echo form_fieldset_close();
        }
    }
    echo form_fieldset_close();

    echo form_submit('', lang('clone'), 'id="submit_clone"');
    echo form_close();
}

function getPrivateTracks($css_class, $l) {
    $tr = new Track();
    $tr->where('tracktype_id', 2)->get();
    echo '<div class="track_filter ' . $css_class . '">';
    echo form_label(lang('filter_by_track') . ': ', 'track_id');
    echo '<select id="track" name="track_id">';
    echo '<option value="0">' . lang('choose_track') . '</option>';
    foreach ($tr as $track) {
        $track->dbtranslate($l);
        echo '<option value="'.$track->id.'">' . $track->name . '</option>';
    }
    echo '</select></div>';
}


function getCollectCities($css_class, $l){
    
    $c = new City();
    $c->get();
    
    echo '<div class="collect_cities ' . $css_class . '">';
    echo form_label(lang('choose_city') . ': ', 'track_id');
    echo '<select id="city" name="city_id">';
    echo '<option value="0">' . lang('choose_city') . '</option>';
    foreach ($c as $city) {
        $city->dbtranslate($l);
	$sel = $city->default ? 'selected="selected"' : '';
        echo '<option value="'.$city->id.'" '.$sel.'>' . $city->name . '</option>';
    }
    echo '</select></div>';
    
}

function getCollectPoints($css_class, $l){
    
    $sc = new Selfcollect();
    $sc->get();
    
    echo '<div class="collects ' . $css_class . '">';
    echo form_label(lang('choose_selfcollect') . ': ', 'selfcollect_id');
    echo '<select id="selcollect" name="selfcollect_id">';
    foreach ($sc as $s) {
        $s->dbtranslate($l);
	$sel = $s->default ? 'selected="selected"' : '';
        echo '<option value="'.$s->id.'" '.$sel.'>' . $s->city->{'name_'.$l} . ' - ' . $s->short_desc . '</option>';
    }
    echo '</select></div>';
    
}

?>

<div class="cont_heading">
    <h2><?= $title .': '.$related['product']->{'name_'.$this->language}.' - '.$related['track']->{'name_'.$this->language}.' - '.$related['printtype']->{'name_'.$this->language}.' - '.$related['size']->{'name_'.$this->language}.' - '.$related['papertype']->{'name_'.$this->language}.' - '.$related['foldpage']->{'name_'.$this->language} ?></h2>
</div>


<?php echo form_open('admin/addons/saveprices');?>
<?php foreach($options as $option):

    //echo form_fieldset($option->name, array('class'=>'grey_border'));
echo '<fieldset class="grey_border"><legend>'.$option->name.' <a href="#" class="copy">'.lang('copy_action').'</a><a href="#" class="copy">'.lang('copy_action').'</a></legend>';
    echo form_hidden('addonopt_id['.$option->id.']', $option->id);
    ?>



<table class="resluts">
    <thead>
    <th><?=lang('id')?></th>
    <th><?=lang('quantity')?></th>
    <th><?=lang('cost')?></th>
    <th><?=lang('price')?></th>
    </thead>
<?php
$odd = FALSE;

        foreach($prices as $key => $price){
            $addonprice = new Addonprice();
            $addonprice->where(array('pricerow_id'=>$price->id, 'addonopt_id' => $option->id))->get();

            $ap_value = $addonprice ? $addonprice : '';

            $odd = !$odd;
            echo '<tr class="' . ($odd ? "odd" : "even") . '">
                    <td id="row_num">'.($key+1).
                        '<input type="hidden" name="pricerow_id['.$option->id.']['.$price->id.']" value="' . $price->id . '"/>
                        <input type="hidden" name="id['.$option->id.']['.$price->id.']" value="' . $ap_value->id . '"/>
                    </td>
                    <td>' . $price->quantity . '</td>
                    <td><input type="text" name="cost['.$option->id.']['.$price->id.']" value="'. $ap_value->cost .'"/></td>
                    <td><input type="text" name="price['.$option->id.']['.$price->id.']" value="'. $ap_value->price .'"/></td>
                </tr>';
        }
?>
</table>




<?php
echo form_fieldset_close();
endforeach;

echo form_submit('', lang('save'));
echo form_close();


?>
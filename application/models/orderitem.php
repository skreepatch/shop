<?php

class Orderitem extends DataMapper {
    
    var $has_one = array('order', 'product');
}

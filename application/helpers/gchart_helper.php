<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* CodeIgniter
*
* An open source application development framework for PHP 4.3.2 or newer
*
* @package      CodeIgniter
* @author       Rick Ellis
* @copyright    Copyright (c) 2006, EllisLab, Inc.
* @license      http://www.codeigniter.com/user_guide/license.html
* @link         http://www.codeigniter.com
* @since        Version 1.0
* @filesource
*/

/**
* CodeIgniter gChart Helper
*
* @package      CodeIgniter
* @subpackage   Helpers
* @category     Helpers
* @author       Isaac Vetter
*/

/**
* ExtendedEncode
*
*  Encodes an array of values using the extended encoding:
*     http://code.google.com/apis/chart/#extended_values
* @access  public
* @param   array
* @param   referencedstring
* @return  string
*/
function extendedencode($data, &$maxvalue='notspecified')
{
    $grid = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I',
        'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W',
        'X', 'Y', 'Z', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k',
        'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y',
        'z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '-', '.');

    // try to find reasonable maximum value
    if(is_numeric($maxvalue)){
        // assume below manipulations are better than what caller is doing
        $max = ceil($maxvalue);
    } else {
        $max = ceil(max($data));
    }
    $precision = strlen($max) - 1;
    $maxvalue = ceil($max/pow(10,$precision));
    $maxvalue = $maxvalue * pow(10, $precision);

    $multiplier = (float)(count($grid) * count($grid)) / $maxvalue;

    $ret = '';
    for($i=0;$i<count($data);$i++){
        if(!is_numeric($data[$i])){
            $ret .= '__';
        } else {
            $datum = $data[$i] * $multiplier;
            $x = (int)($datum / count($grid));
            $y = $datum % 64;
            $ret .= $grid[$x].$grid[$y];
        }
    }
    return $ret;
}
?> 
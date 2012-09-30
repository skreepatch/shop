<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * currency
 *
 * @author Simon Emms <simon@simonemms.com>
 */
class currency extends CI_Model {
    /* Table details */
    protected $_rowId = 'currencyId';
    protected $_table = 'currency';

    /**
     * Create Table SQL
     * 
     * This is for a MySQL table. If you use a different
     * database to MySQL, you will need to ammend this.
     */
    protected $_sql = "CREATE TABLE `currency` (
      `currencyId` int(11) NOT NULL AUTO_INCREMENT,
      `currency` varchar(3) NOT NULL DEFAULT '',
      `base` varchar(3) NOT NULL DEFAULT '',
      `rate` decimal(10,5) NOT NULL DEFAULT '0.00000',
      `date` date NOT NULL DEFAULT '0000-00-00',
      `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
      `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`currencyId`)
    ) ENGINE=MyISAM DEFAULT CHARSET=latin1;";




    const base = 'EUR';
    const invalid_currency = '~1';
    const invalid_date = '~2';
    const invalid_user = '~3';

    protected $_arrErrors;
    protected $_objXML;


    /* The currency symbols */
    protected $_arrSymbols = array(
        'aud' => array(
            'symbol' => '&#36;',
            'position' => 'before',
        ),
        'bgn' => array(
            'symbol' => '',
            'position' => '',
        ),
        'brl' => array(
            'symbol' => 'R&#36;',
            'position' => 'before',
        ),
        'cad' => array(
            'symbol' => '&#36;',
            'position' => 'before',
        ),
        'chf' => array(
            'symbol' => '&#8355;',
            'position' => 'after_space',
        ),
        'cny' => array(
            'symbol' => '&yen;',
            'position' => 'before',
        ),
        'czk' => array(
            'symbol' => '',
            'position' => '',
        ),
        'dkk' => array(
            'symbol' => 'kr',
            'position' => 'before_space',
        ),
        'eur' => array(
            'symbol' => '&euro;',
            'position' => 'before',
        ),
        'gbp' => array(
            'symbol' => '&pound;',
            'position' => 'before',
        ),
        'hkd' => array(
            'symbol' => '&#36;',
            'position' => 'before',
        ),
        'hrk' => array(
            'symbol' => 'kn',
            'position' => 'after_space',
        ),
        'huf' => array(
            'symbol' => 'Ft',
            'position' => 'after_space',
        ),
        'idr' => array(
            'symbol' => 'Rp',
            'position' => 'before_space',
        ),
        'ils' => array(
            'symbol' => '&#8362;',
            'position' => '',
        ),
        'inr' => array(
            'symbol' => '&#2352;',
            'position' => 'after_space',
        ),
        'jpy' => array(
            'symbol' => '&yen;',
            'position' => 'before',
        ),
        'krw' => array(
            'symbol' => '&#8361;',
            'position' => 'before',
        ),
        'ltl' => array(
            'symbol' => 'Lt',
            'position' => 'after_space',
        ),
        'lvl' => array(
            'symbol' => 'Ls',
            'position' => 'before_space',
        ),
        'mxn' => array(
            'symbol' => '&#36;',
            'position' => 'before',
        ),
        'myr' => array(
            'symbol' => 'RM',
            'position' => 'after_space',
        ),
        'nok' => array(
            'symbol' => 'kr',
            'position' => 'after_space',
        ),
        'nzd' => array(
            'symbol' => '&#36;',
            'position' => 'before',
        ),
        'php' => array(
            'symbol' => 'P',
            'position' => 'before',
        ),
        'pln' => array(
            'symbol' => 'zl',
            'position' => 'after_space',
        ),
        'ron' => array(
            'symbol' => '',
            'position' => '',
        ),
        'rub' => array(
            'symbol' => 'P',
            'position' => 'after_space',
        ),
        'sek' => array(
            'symbol' => 'kr',
            'position' => 'after_space',
        ),
        'sgd' => array(
            'symbol' => '&#36;',
            'position' => 'before',
        ),
        'thb' => array(
            'symbol' => 'B',
            'position' => 'after_space',
        ),
        'try' => array(
            'symbol' => 'TL',
            'position' => 'after_space',
        ),
        'usd' => array(
            'symbol' => '&#36;',
            'position' => 'before',
        ),
        'zar' => array(
            'symbol' => 'R',
            'position' => 'before',
        ),
    );
    
    
    
    
    
    
    /**
     * Construct
     * 
     * Ensures that the data table exists 
     */
    public function __construct() {
        parent::__construct();
        
        /* Load the language */
        $this->load->language('currency');
        
        /* Make sure the table exists */
        if($this->db->table_exists($this->_table) === false) {
            $arrQuery = preg_split('/;(\n|$)/', $this->_sql);
            if(count($arrQuery) > 0) {
                foreach($arrQuery as $query) {
                    $this->db->simple_query($query);
                }
            }
            
            /* Import the data the first time */
            $this->import(false);
        }
    }






    /**
     * Save XML
     *
     * Takes the XML array from the feed, parses it
     * into a usable format and saves new fields to the
     * database.
     *
     * Returns a count of number of items inserted.
     * 
     * @param array $arrXML
     * @return int
     */
    protected function _save_xml($arrXML) {
        /* First two nodes aren't needed */
        $arrXML = current(current($arrXML));
        $arrData = array();
        $attr = '@attributes';

        /* Put the XML array into a useable format */
        if(count($arrXML) > 0) {
            foreach($arrXML as $xml) {
                if(array_key_exists($attr, $xml) && array_key_exists('time', $xml[$attr])) {
                    $date = $xml[$attr]['time'];
                    unset($xml[$attr]);

                    $xml = current($xml);
                    if(count($xml) > 0) {
                        foreach($xml as $data) {
                            if(array_key_exists($attr, $data)) {
                                $data = $data[$attr];
                                if(array_key_exists('currency', $data) && array_key_exists('rate', $data)){
                                    $data['base'] = self::base;
                                    $data['date'] = $date;
                                    $arrData[$date][] = $data;
                                }
                            }
                        }
                    }
                }
            }
        }


        /* Check we've got data in the array then put it in */
        $i = 0;
        $arrInsert = array();
        if(count($arrData) > 0) {
            foreach($arrData as $data) {
                foreach($data as $currency) {
                    $this->db->select()
                        ->where('currency', $currency['currency'])
                        ->where('date', $currency['date']);
                    
                    $objDb = $this->db->get($this->_table);

                    /* Check it's not already been set */
                    if($objDb->num_rows() == '0') {
                        /* Add the created timestamp and add to the insert array */
                        $currency['created'] = date('Y-m-d H:i:s');
                        $arrInsert[] = $currency;
                        $i++;
                    }
                }
            }
        }
        
        /* Get the count */
        $count = count($arrInsert);
        
        /* Insert the data in the DB */
        if($count > 0) { $this->db->insert_batch($this->_table, $arrInsert); }

        /* Return the number of items we've added */
        return $count;
    }






    /**
     * Convert
     *
     * Does the actual phsyical currency conversion.
     *
     * @param string $from
     * @param string $to
     * @param string $value
     * @param string $date
     * @return array
     */
    function convert($from, $to, $value = '1', $date = false) {
        /* Validate the $from */
        if($from !== false) { $from = strtoupper($from); }
        else { $from = self::base; }

        /* Validate the $to */
        if($to !== false) { $to = strtoupper($to); }
        else { $to = self::base; }

        /* Check it's a valid figure passed - set to 1 if not*/
        if(!is_numeric($value)) { $value = 1; }
        
        /* Check the requested date - assume today if not set */
        if($date === false) { $date = date('Y-m-d'); }

        /* Validate the currency */
        $valid = $this->_valid_currency($from, $to);
        
        if($valid === true) {

            /* Get the data */
            $arrRates = array(
                'from' => $from,
                'to' => $to,
            );

            /* Find the max date of both currencies */
            foreach($arrRates as $currency) {
                if(strtoupper($currency) == strtoupper(self::base)) {
                    /* Base currency - max date is today */
                    $max_date = date('Y-m-d');
                } else {
                    $this->db->select_max('date', 'max_date')
                        ->where('date <=', $date)
                        ->where('currency', $currency);
                    
                    $objDb = $this->db->get($this->_table);
                    if($objDb->num_rows() > 0) {
                        $max_date = current($objDb->row_array());
                    } else {
                        /* No max date - shouldn't ever get here */
                        $max_date = null;
                    }
                }
                if($max_date < $date) { $date = $max_date; }
            }


            /* Find the exchange rates */
            foreach($arrRates as $key => $currency) {
                if(strtoupper($currency) == strtoupper(self::base)) {
                    $arrRates[$key] = '1';
                } else {
                    $this->db->select('rate')
                        ->select('date')
                        ->where(array(
                            'currency' => $currency,
                            /* There might not actually be a figure on the requested date */
                            'date <=' => $date,
                        ))
                        ->order_by('date', 'DESC')
                        ->limit(1);
                    
                    $objDb = $this->db->get($this->_table);
                    $arrRate = $objDb->row_array();
                    $rate = $arrRate['rate'];
                    $date = $arrRate['date'];
                    if($rate !== false) {
                        $arrRates[$key] = $rate;
                    } else {
                        $this->setError(self::invalid_date);
                        return;
                    }
                }
            }

            /* We have a figure */
            $rate = $arrRates['to'] / $arrRates['from'];
            $amount = $rate * $value;

            /* Put it into an array for easy outputting */
            $arrConvert = array(
                'from' => $from,
                'to' => $to,
                'date' => $date,
                'rate' => $rate,
                'reverse_rate' => 1 / $rate,
                'from_amount' => number_format($value, 2, '.', ''), /* Put it to 2 DP without thousand separators */
                'to_amount' => number_format($amount, 2, '.', ''), /* Ditto */
            );
            return $arrConvert;
        } else {
            /* Invalid currency */
            return false;
        }
    }





    /**
     * Valid Currency
     *
     * Checks that the currency codes are valid
     * 
     * @param string $from
     * @param string $to
     */
    function _valid_currency($from, $to) {
        $arrCurrency = array(
            'from' => $from,
            'to' => $to,
        );

        foreach($arrCurrency as $currency) {
            $valid = $this->is_currency($currency);

            /* If invalid, output the error */
            if($valid === false) {
                $this->setError(self::invalid_currency);
                return false;
            }
        }
        return true;
    }
    
    
    
    
    
    /**
     * Import
     * 
     * This imports the data to the table.  This
     * should be done by cronjob, but can also be
     * set to be done silently.
     * 
     * @param bool $display
     * @return int
     */
    public function import($display = true) {
        
        /* Load the config */
        $this->load->config('currency');

        $xml = $this->config->item('currency_url');
        
        /* Fetch the XML */
        $this->_objXML = new SimpleXMLElement($xml, null, true);
        $arrXML = $this->_xml_to_array();

        $inserted = $this->_save_xml($arrXML);

        /** Display data **/
        if($display) {
            echo "=============\nData imported\n=============\n\n";
            echo number_format($inserted).' item';
            echo $inserted == 1 ? null : 's';
            echo " inserted";
            exit;
        } else {
            return $inserted;
        }
    }
    





    /**
     * Is Currency
     *
     * Is it a currency
     *
     * @param string $currency
     * @return bool
     */
    public function is_currency($currency) {
        $currency = strtoupper($currency);
        
        if($currency != strtoupper(self::base)) {
            $this->db->select()
                ->where('currency', $currency);
            
            $objDb = $this->db->get($this->_table);
            
            $valid = (bool) $objDb->num_rows();

            return $valid;
        } else {
            return true;
        }

        return false;
        
    }




    /**
     * Set Error
     *
     * Sets an error message
     * 
     * @param string $code
     */
    private function setError($code = false) {
        switch($code) {
            case self::invalid_currency:
                $message = 'Please check the currency codes given';
                break;

            case self::invalid_date:
                $message = 'This is not a valid date';
                break;

            default:
                $message = 'There has been a general error';
                break;
        }
        $this->_arrErrors[] = $message;
    }






    /**
     * Get Currencies
     *
     * Gets a list of currencies with their name.
     *
     * @param bool $select
     * @return array
     */
    public function get_currencies() {
        /* Get the currencies from the database */
        $this->db->select('currency')
            ->group_by('currency');
        $objDb = $this->db->get($this->_table);
        
        $arrList = array();
        if($objDb->num_rows() > 0) {
            foreach($objDb->result_array() as $result) {
                $arrList[] = $result['currency'];
            }
        }

        /* Add in the base currency */
        $arrList[] = self::base;

        $arrCurrency = array();
        foreach($arrList as $key => $currency) {
            $name = $this->lang->line('currency_'.strtolower($currency));
            $arrCurrency[$currency] = $name;
        }

        /* Alphabetise the list */
        asort($arrCurrency);

        return $arrCurrency;
    }






    /**
     * Fetch Symbol
     *
     * Fetches the currency symbol for the available
     * currencies
     * 
     * @param string $code
     * @param bool $regex_string
     * @return string/array
     */
    public function fetch_symbol($code, $value = null, $number_format = true) {
        /* Empty string by default */
        $symbol = '';
        $code = strtolower($code);
        if(array_key_exists($code, $this->_arrSymbols) && array_key_exists('symbol', $this->_arrSymbols[$code])) {
            $symbol = $this->_arrSymbols[$code]['symbol'];

            /* Add in the value */
            /* The available positions */
            $arrPosition = array(
                'before', 'before_space', 'after', 'after_space',
            );

            /* Get the position */
            $position = array_key_exists('position', $this->_arrSymbols[$code]) && in_array($this->_arrSymbols[$code]['position'], $arrPosition) ? $this->_arrSymbols[$code]['position'] : 'before';

            if(is_null($value)) {

                return array(
                    'position' => $position,
                    'symbol' => $symbol,
                );

            } else {

                /* Format as a decimal currency */
                if($number_format) { $value = number_format($value, 2); }

                /* Add a class around the symbol */
                $symbol = '<span class="currency_symbol currency_'.$code.'">'.$symbol.'</span>';

                /* Put the symbol and value in a string */
                switch($position) {
                    case 'before_space':
                        /* Symbol before value and space */
                        $return = "{$symbol} {$value}";
                        break;

                    case 'after':
                        /* Symbol after value */
                        $return = "{$value}{$symbol}";
                        break;

                    case 'after_space':
                        /* Symbol after value and space */
                        $return = "{$value} {$symbol}";
                        break;

                    default:
                        /* Symbol before value */
                        $return = "{$symbol}{$value}";
                        break;
                }

                /* Remove any excess whitespace */
                $return = trim($return);

                /* Return the symbol & value */
                return $return;

            }
        }
        /* Return just the symbol */
        return $symbol;
    }
    
    
    
    
    
    
    
    
    
    
    
    /**
     * XML To Array
     *
     * Converts an XML feed to a PHP array
     *
     * @param mixed $arrObjData
     * @param array $arrSkipIndices
     * @return array
     */
    protected function _xml_to_array($arrObjData = false, $arrSkipIndices = array()) {
        if($arrObjData === false) { $arrObjData = $this->_objXML; }

        $arrData = array();

        /* if input is object, convert into array */
        if(is_object($arrObjData)) {
            $arrObjData = get_object_vars($arrObjData);
        }

        if(is_array($arrObjData)) {
            foreach($arrObjData as $index => $value) {
                if(is_object($value) || is_array($value)) {
                    $value = $this->_xml_to_array($value, $arrSkipIndices); /* recursive call */
                }
                if(in_array($index, $arrSkipIndices)) {
                    continue;
                }
                $arrData[$index] = $value;
            }
        }
        return $arrData;
    }

    

}
?>
<?php

namespace App\utils;
use Exception;

/*
 * slouží k přípravě polí ke vložení do IN termu v DB dotazu, kde je riziko SQL útoku
 * vytvoří to string s tokeny s daným prefixem a asoc. pole s daty pro prepared statements
 */
class Protected_in {
    protected $prefixes = array();
    protected $data = array();
    
    // $data je prostý 1D array
    public function add_array(string $prefix, array $data) {
        if (count($data) == 0) {
            throw new Exception('Pole pro IN nemuze byt prazdne');
        }
        if (!isset($this->prefixes[$prefix])) {
            $c = 0;
            $this->prefixes[$prefix] = 0;
        }
        else {
            $c = $this->prefixes[$prefix];
        }
        
        foreach ($data as $val) {
            $this->data[":{$prefix}{$c}"] = $val;
            $c++;
            $this->prefixes[$prefix]++;            
        }
    }
    
    public function get_tokens(string $prefix) {
        if (!isset($this->prefixes[$prefix])) {
            throw new Exception("Prefix {$prefix} nenalezen");
        }
        else {
            $tokens = array();
            for ($c = 0; $c < $this->prefixes[$prefix]; $c++) {
                $tokens[] = ":{$prefix}{$c}";
            }
            return implode(',', $tokens);
        }
    }
    
    public function get_data() {
        return $this->data;        
    }    
}

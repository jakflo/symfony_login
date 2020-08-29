<?php

namespace App\utils;

class ArrayTools {
    public function searchValue(array $input, $value, string $columnName) {
        $result = array();
        foreach ($input as $row) {
            if (isset($row[$columnName]) and $row[$columnName] == $value) {
                $result[] = $row;
            }
        }
        return $result;
    }
    
}

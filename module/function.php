<?php declare(strict_types=1);
     
      require_once __DIR__ . "/Database/Database.php";

    
    function del_spaces(string $string): string {
        return preg_replace("[ ]", "", $string);;
    }


    function sanitize($input) {
        return htmlentities(trim($input));
    }


    function strip_unset(array $input): array {
        foreach ($input as $col => $value) {
            if (isset($value))
                continue;
            unset($input[$col]);
        }
        return $input;
    }


    //not quite satisfied with this solution but it's the only one I could come up with at the time.
    //Web developpement is still new to me...
    function format_col_pdo(array $input): string {

        $input         = array_keys($input);
        $formated_keys = "";
        $x             = 0;

        foreach ($input as $col) {
            $formated_keys  .= "`$col`";

            if ($x < count($input)-1)
                $formated_keys .= ", ";
            $x++;
        }
        
         return $formated_keys;
    }

    
    function format_values_pdo(array $input): string {

        $values          = array_values($input);
        $formated_values = "";
        $x               = 0;
        
        foreach ($values as $cont) {
            if (gettype($cont) == "string") 
                $formated_values .= "\"$cont\"";
            elseif (gettype($cont) == "integer" || gettype($cont) == "double")
                $formated_values .= "$cont";

            if ($x < count($values)-1)
                $formated_values .= ", ";
            
            $x++;
        }
        
        return $formated_values;
    }


    //nested loops are O(n^2), I should find another alternative if possible. (one that is better than formating the columns and value separately that is...)
    //For now I'll keep using format_col_pdo and format_value_pdo even if I'm not quite satisfied with them.
    //Since tables are unlikely to have more than 1000 columns it shouldn't be that bad, but what if many requests are made at once?
   /* 
    function format_pdo(array $input): array {

        $input = [array_keys($input), array_values($input)];
        $output = [];
    
        
        for($y = 0; $y < 2; $y++) {
            
            $formatted_string = "";
            
            for($u = 0; $u < count($input[$y]); $u++) {
    
                $formatted_string .= $input[$y][$u];
    
                if($u != count($input[$y]) - 1)
                    $formatted_string .= ", ";
            }
    
            $output[$y] = $formatted_string;
        }
    
        return $output;
    }
    */

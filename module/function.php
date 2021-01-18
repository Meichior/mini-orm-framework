<?php declare(strict_types=1);

    function sanitize($input) {

        return htmlentities(trim($input));
    }

    function strip_unset(array $input): array {

        foreach($input as $col => $value) {

            if(isset($value))
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

        foreach($input as $col) {
    
            $formated_keys  .= "`$col`";

            if($x < count($input)-1)
                $formated_keys .= ", ";
            
            $x++;
        }
        
        return $formated_keys;
    }

    
    function format_values_pdo(array $input): string {

        $values          = array_values($input);
        $formated_values = "";
        $x               = 0;
        
        foreach($values as $cont) {
            
            if(gettype($cont) == "string") 
                $formated_values .= "\"$cont\"";
            elseif(gettype($cont) == "integer" || gettype($cont) == "double")
                $formated_values .= "$cont";


            if($x < count($values)-1)
                $formated_values .= ", ";
            
            $x++;
        }
        
        return $formated_values;
    }


   

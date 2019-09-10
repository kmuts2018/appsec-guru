<?php
function plotTree($arr, $indent=0, $mother_run=true){
    if ($mother_run) {
        // the beginning of plotTree. We're at rootlevel
        echo "start\n";
    }

    foreach ($arr as $k=>$v){
        // skip the baseval thingy. Not a real node.
        if ($k == "__base_val") continue;
        // determine the real value of this node.
        $show_val = (is_array($v) ? $v["__base_val"] : $v);
        // show the indents
        echo str_repeat("  ", $indent);
        if ($indent == 0) {
            // this is a root node. no parents
            echo "O ";
        } elseif (is_array($v)){
            // this is a normal node. parents and children
            echo "+ ";
        } else {
            // this is a leaf node. no children
            echo "- ";
        }

        // show the actual node
        echo $k . " (" . $show_val. ")" . "\n";
        if (is_array($v)) {
            // this is what makes it recursive, rerun for childs
            plotTree($v, ($indent+1), false);
        }
    }

    if ($mother_run) {
        echo "end\n";
    }
}



function array2table($array, $recursive = false, $null = '&nbsp;')
{
    // Sanity check
    if (empty($array) || !is_array($array)) {
        return false;
    }

    if (!isset($array[0]) || !is_array($array[0])) {
        $array = array($array);
    }

    // Start the table
    $table = "<table>\n";

    // The header
    $table .= "\t<tr>";
    // Take the keys from the first row as the headings
    foreach (array_keys($array[0]) as $heading) {
        $table .= '<th>' . $heading . '</th>';
    }
    $table .= "</tr>\n";

    // The body
    foreach ($array as $row) {
        $table .= "\t<tr>" ;
        foreach ($row as $cell) {
            $table .= '<td>';

            // Cast objects
            if (is_object($cell)) { $cell = (array) $cell; }
            
            if ($recursive === true && is_array($cell) && !empty($cell)) {
                // Recursive mode
                $table .= "\n" . array2table($cell, true, true) . "\n";
            } else {
                $table .= (strlen($cell) > 0) ?
                    htmlspecialchars((string) $cell) :
                    $null;
            }

            $table .= '</td>';
        }

        $table .= "</tr>\n";
    }

    $table .= '</table>';
    return $table;
}



?>
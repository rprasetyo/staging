<?php
/**
 * Dump helper. Functions to dump variables to the screen, in a nicley formatted manner.
 * @author Joost van Veen
 * @version 1.0
 */
if (!function_exists('wc_dump')) {
    function wc_dump($var, $label = 'Dump', $type = 'print_r', $echo = TRUE)
    {
        // Store dump in variable 
        ob_start();
        
        if ( $type == 'print_r' ) {
            print_r($var);
        } else if( $type == 'var_export' ) {
            var_export($var);
        } else {
            var_dump($var);
        }

        $output = ob_get_clean();
        
        // Add formatting
        $output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
        $output = '<pre style="background: #FFFEEF; color: #000; border: 1px dotted #000; padding: 10px; margin: 10px 0; text-align: left; position: relative; z-index: 9999; font-size: 14px;">' . $label . ' => ' . $output . '</pre>';
        
        // Output
        if ($echo == TRUE) {
            echo $output;
        }
        else {
            return $output;
        }
    }
}
if (!function_exists('wc_dump_exit')) {
    function wc_dump_exit($var, $label = 'Dump', $type = 'print_r', $echo = TRUE) {
        wc_dump($var, $label, $echo);
        exit;
    }
}

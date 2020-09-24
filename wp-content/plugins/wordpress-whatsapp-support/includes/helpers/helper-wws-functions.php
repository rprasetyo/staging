<?php

if ( ! function_exists( 'wws_selected_timezone' ) ) {

    /**
     * Return selected WordPress time zone by admin
     * @since 1.4
     */
    function wws_selected_timezone() {

        return ( get_option('timezone_string') ) ? get_option('timezone_string') : 'Know here';

    }

}


if ( ! function_exists( 'wws_multi_account_availablity' ) ) {


  function wws_multi_account_availablity( $day = array(), $start_time, $end_time ) {

    $current_day = strtolower(current_time('D'));
    $current_time = (int)current_time('Hi');

    if ( ! in_array( $current_day, $day ) ) {
      return false;
    }

    if ( $current_time < $start_time ) {
      return false;
    }

    if ( $current_time > $end_time ) {
      return false;
    }
    
    return true;

  }

}

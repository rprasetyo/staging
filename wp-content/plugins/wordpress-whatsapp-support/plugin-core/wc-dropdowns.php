<?php

/**
 * Display page dropdown
 * @author Sonu Kaushal
 * @package WeCreativez/Plugin-core
 * @since 1.0
 */
if ( ! function_exists( 'wecreativez_dropdown_pages' ) ) {

    function wecreativez_dropdown_pages( $args = '' ) {

        // set default values
        $defaults = array(
            'depth'                     => 0,
            'child_of'                  => 0,
            'selected'                  => '',
            'echo'                      => 1,
            'name'                      => 'page_id',
            'id'                        => '',
            'class'                     => '',
            'show_option_none'          => '',
            'show_otion_all'            => '',
            'value_field'               => 'ID',
            'multiple'                  => false,
        );
        
        // Merge user defined arguments into defaults array.
        $r = wp_parse_args( $args, $defaults );

        // get all the pages
        $pages = get_pages();

        //  initialize output
        $output = '';

        if ( $pages ) {
            
            $class = " class='wecreativez-multi-select regular-text " . esc_attr( $r['class'] ) . "'";

            $multiple = ( $r['multiple'] == true ) ? "multiple" : "";

            $output .= '<select name="' . esc_attr( $r['name'] ) . '" ' . $class . ' id="' . esc_attr( $r['id'] ) . '" ' . $multiple . '>';

            foreach ( $pages as $page ) {

                //  for multiple select
                if ( $r['multiple'] == true ) {

                    if ( in_array( $page->ID, (array) $r['selected'] ) )
                        $output .= '<option value="' . $page->ID . '" selected>' . $page->post_title . '</option>';
                    else 
                        $output .= '<option value="' . $page->ID . '">' . $page->post_title . '</option>';

                //  for simple select
                } else {

                    if ( $page->ID == $r['selected'] )
                        $output .= '<option value="' . $page->ID . '" selected>' . $page->post_title . '</option>';
                    else 
                        $output .= '<option value="' . $page->ID . '">' . $page->post_title . '</option>';

                }

            }

            $output .= "</select>";
            
        }

        $html = apply_filters( 'wecreativez_dropdown_pages', $output, $r, $pages );
         
        if ( $r['echo'] ) {
            echo $html;
        }
        return $html;

    }

}
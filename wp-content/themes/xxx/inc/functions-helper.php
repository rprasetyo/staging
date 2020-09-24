<?php

if ( ! function_exists( 'greenmart_tbay_body_classes' ) ) {
	function greenmart_tbay_body_classes( $classes ) {
		global $post;
		if ( is_page() && is_object($post) ) {
			$class = get_post_meta( $post->ID, 'tbay_page_extra_class', true );
			if ( !empty($class) ) {
				$classes[] = trim($class);
			}
		}
		if ( greenmart_tbay_get_config('preload') ) {
			$classes[] = 'tbay-body-loader';
		}

		if ( greenmart_tbay_is_home_page() ) {
			$classes[] = 'tbay-homepage';
		}

		if ( !(defined('GREENMART_WOOCOMMERCE_ACTIVED') && GREENMART_WOOCOMMERCE_ACTIVED) ) {
			$classes[] = 'tb-no-shop';
		}

		if( !(defined('GREENMART_TBAY_FRAMEWORK_ACTIVED') && GREENMART_TBAY_FRAMEWORK_ACTIVED) ) {
			$classes[] = 'tb-no-framework';
		}

		return $classes;
	}
	add_filter( 'body_class', 'greenmart_tbay_body_classes' );
}

if ( ! function_exists( 'greenmart_tbay_get_shortcode_regex' ) ) {
	function greenmart_tbay_get_shortcode_regex( $tagregexp = '' ) {
		// WARNING! Do not change this regex without changing do_shortcode_tag() and strip_shortcode_tag()
		// Also, see shortcode_unautop() and shortcode.js.
		return
			'\\['                                // Opening bracket
			. '(\\[?)'                           // 1: Optional second opening bracket for escaping shortcodes: [[tag]]
			. "($tagregexp)"                     // 2: Shortcode name
			. '(?![\\w-])'                       // Not followed by word character or hyphen
			. '('                                // 3: Unroll the loop: Inside the opening shortcode tag
			. '[^\\]\\/]*'                   // Not a closing bracket or forward slash
			. '(?:'
			. '\\/(?!\\])'               // A forward slash not followed by a closing bracket
			. '[^\\]\\/]*'               // Not a closing bracket or forward slash
			. ')*?'
			. ')'
			. '(?:'
			. '(\\/)'                        // 4: Self closing tag ...
			. '\\]'                          // ... and closing bracket
			. '|'
			. '\\]'                          // Closing bracket
			. '(?:'
			. '('                        // 5: Unroll the loop: Optionally, anything between the opening and closing shortcode tags
			. '[^\\[]*+'             // Not an opening bracket
			. '(?:'
			. '\\[(?!\\/\\2\\])' // An opening bracket not followed by the closing shortcode tag
			. '[^\\[]*+'         // Not an opening bracket
			. ')*+'
			. ')'
			. '\\[\\/\\2\\]'             // Closing shortcode tag
			. ')?'
			. ')'
			. '(\\]?)';                          // 6: Optional second closing brocket for escaping shortcodes: [[tag]]
	}
}

if ( ! function_exists( 'greenmart_tbay_tagregexp' ) ) {
	function greenmart_tbay_tagregexp() {
		return apply_filters( 'greenmart_tbay_custom_tagregexp', 'video|audio|playlist|video-playlist|embed|greenmart_tbay_media' );
	}
}

if ( !function_exists('greenmart_tbay_class_container_vc') ) {
	function greenmart_tbay_class_container_vc($class, $isfullwidth, $post_type) {
		global $post;
		$isfullwidth = false;
		if ( $post_type == 'tbay_megamenu' ) {
			$isfullwidth = false;
		} elseif ( $post_type == 'tbay_footer' ) {
			$isfullwidth = false;
		} else {
			if ( is_page() ) {
				$isfullwidth  = get_post_meta( $post->ID, 'tbay_page_fullwidth', true );
				if ( $isfullwidth == 'no' ) {
					$isfullwidth = false;
				} else {
					$isfullwidth = true;
				}
			} elseif ( is_woocommerce() ) {
				if ( is_singular('product') ) {
					$isfullwidth  = greenmart_tbay_get_config( 'product_single_fullwidth', false );
				} else {
					$isfullwidth  = greenmart_tbay_get_config( 'product_archive_fullwidth', false );
				}
			} else {
				if ( is_singular('post') ) {
					$isfullwidth  = greenmart_tbay_get_config( 'post_single_fullwidth', false );
				} else {
					$isfullwidth  = greenmart_tbay_get_config( 'post_archive_fullwidth', false );
				}
			}
		}

		if ( $isfullwidth ) {
			return 'tbay-'.$class;
		}
		return $class;
	}
}
add_filter( 'greenmart_tbay_class_container_vc', 'greenmart_tbay_class_container_vc', 1, 3);


if ( !function_exists('greenmart_tbay_get_themes') ) {
	function greenmart_tbay_get_themes() {
		$themes = array();
		$path   = get_template_directory() . '/css/skins/';
		
		if ( is_dir($path) ) {
			$folders = scandir($path);
			$excludes = array('.', '..', '.svn');
			foreach ($folders as $folder) {
				if ( !in_array( $folder, $excludes ) && is_dir($path . $folder) ) {
					$theme = array(
				        $folder => array( 
	                        'title' => $folder,
	                        'alt'   => $folder,
	                        'img'   => get_template_directory_uri() . '/inc/assets/images/active_theme/'.$folder.'.jpg'
	                    ),
	                );  
	                $themes = array_merge($themes,$theme);
				}
			}
		}
		return $themes;

	}
}

if ( !function_exists('greenmart_tbay_get_theme') ) {
	function greenmart_tbay_get_theme() {
		return greenmart_tbay_get_global_config('active_theme','organic');

	}
}

if ( !function_exists('greenmart_tbay_get_part_theme') ) {
	function greenmart_tbay_get_part_theme() {
		$active_theme  = greenmart_tbay_get_global_config('active_theme','organic');
		$active_theme  = 'themes/'.$active_theme;

		return $active_theme;

	}
}

if ( !function_exists('greenmart_tbay_get_header_layouts') ) {
	function greenmart_tbay_get_header_layouts() {
		$headers = array();
		$current_theme = greenmart_tbay_get_theme();

		if( $current_theme != 'organic' ) {
			$files = glob( get_template_directory() . '/headers/themes/'.$current_theme.'/*.php' );
		} else {
			$files = glob( get_template_directory() . '/headers/*.php' );
		}

		usort($files, function ($a, $b) {
		    $aIsDir = is_dir($a);
		    $bIsDir = is_dir($b);
		    if ($aIsDir === $bIsDir)
		        return strnatcasecmp($a, $b);
		    elseif ($aIsDir && !$bIsDir)
		        return -1;
		    elseif (!$aIsDir && $bIsDir)
		        return 1;
		});

	    if ( !empty( $files ) ) { 
	        foreach ( $files as $file ) {
	        	$header = str_replace( '.php', '', basename($file) );
	            $headers[$header] = $current_theme.'-'.$header;
	        }
	    }

		return $headers;
	}
}

if ( !function_exists('greenmart_tbay_get_header_layout') ) {
	function greenmart_tbay_get_header_layout() {
		global $post;

		if ( defined('GREENMART_WOOCOMMERCE_ACTIVED') && GREENMART_WOOCOMMERCE_ACTIVED && is_shop() ) {
			return greenmart_tbay_page_header_layout();
		}


		if ( is_page() && is_object($post) && isset($post->ID) ) {
			return greenmart_tbay_page_header_layout();
		}
		return greenmart_tbay_get_config('header_type');
	}
	add_filter( 'greenmart_tbay_get_header_layout', 'greenmart_tbay_get_header_layout' );
}

if ( !function_exists('greenmart_tbay_get_footer_layouts') ) {
	function greenmart_tbay_get_footer_layouts() {
		$footers = array( '' => esc_html__('Default', 'greenmart'));
		$args = array(
			'posts_per_page'   => -1,
			'offset'           => 0,
			'orderby'          => 'date',
			'order'            => 'DESC',
			'post_type'        => 'tbay_footer',
			'post_status'      => 'publish',
			'suppress_filters' => true 
		);
		$posts = get_posts( $args );
		foreach ( $posts as $post ) {
			$footers[$post->post_name] = $post->post_title;
		}
		return $footers;
	}
}

if ( !function_exists('greenmart_tbay_get_footer_layout') ) {
	function greenmart_tbay_get_footer_layout() {
		if ( is_page() ) {
			global $post;
			$footer = '';
			if ( is_object($post) && isset($post->ID) ) {
				$footer = get_post_meta( $post->ID, 'tbay_page_footer_type', true );
				if ( $footer == 'global' ||  $footer == '') {
					return greenmart_tbay_get_config('footer_type', '');
				}
			}
			return $footer;
		} else if ( defined('GREENMART_WOOCOMMERCE_ACTIVED') && GREENMART_WOOCOMMERCE_ACTIVED && is_shop() ) {

			$post_id = wc_get_page_id('shop');
			if ( isset($post_id) ) {
				$footer = get_post_meta( $post_id, 'tbay_page_footer_type', true );
				if ( $footer == 'global' ||  $footer == '') {
					return greenmart_tbay_get_config('footer_type', '');
				}
			}
			return $footer;
		}

		return greenmart_tbay_get_config('footer_type', '');
	}
	add_filter('greenmart_tbay_get_footer_layout', 'greenmart_tbay_get_footer_layout');
}


if ( !function_exists('greenmart_tbay_page_content_class') ) {
	function greenmart_tbay_page_content_class( $class ) {
		global $post;
		$fullwidth = get_post_meta( $post->ID, 'tbay_page_fullwidth', true );
		if ( !$fullwidth || $fullwidth == 'no' ) {
			return $class;
		}
		return 'container-fluid';
	}
}
add_filter( 'greenmart_tbay_page_content_class', 'greenmart_tbay_page_content_class', 1 , 1  );

if ( !function_exists('greenmart_tbay_get_page_layout_configs') ) {
	function greenmart_tbay_get_page_layout_configs() {
		global $post;
		if( isset($post->ID) ) {
			$left = get_post_meta( $post->ID, 'tbay_page_left_sidebar', true );
			$right = get_post_meta( $post->ID, 'tbay_page_right_sidebar', true );

			switch ( get_post_meta( $post->ID, 'tbay_page_layout', true ) ) {
				case 'left-main':
					$configs['left'] = array( 'sidebar' => $left, 'class' => 'col-xs-12 col-md-12 col-lg-3'  );
					$configs['main'] = array( 'class' => 'col-xs-12 col-md-12 col-lg-9' );
					break;
				case 'main-right':
					$configs['right'] = array( 'sidebar' => $right,  'class' => 'col-xs-12 col-md-12 col-lg-3' ); 
					$configs['main'] = array( 'class' => 'col-xs-12 col-md-12 col-lg-9' );
					break;
				case 'main':
					$configs['main'] = array( 'class' => 'clearfix' );
					break;
				case 'left-main-right':
					$configs['left'] = array( 'sidebar' => $left,  'class' => 'col-xs-12 col-md-12 col-lg-3'  );
					$configs['right'] = array( 'sidebar' => $right, 'class' => 'col-xs-12 col-md-12 col-lg-3' ); 
					$configs['main'] = array( 'class' => 'col-xs-12 col-md-12 col-lg-6' );
					break;
				default:
					$configs['main'] = array( 'class' => 'col-xs-12 col-md-12' );
					break;
			}

			return $configs; 
		}
	}
}

if ( !function_exists('greenmart_tbay_page_header_layout') ) {
	function greenmart_tbay_page_header_layout() {
		global $post;

		if ( is_object($post) && isset($post->ID) ) $post_id = $post->ID;
		
		if ( defined('GREENMART_WOOCOMMERCE_ACTIVED') && GREENMART_WOOCOMMERCE_ACTIVED  && is_shop() ) {
			$post_id = wc_get_page_id('shop');
		}

		$header = get_post_meta( $post_id, 'tbay_page_header_type', true );
		if ( $header == 'global' || $header == '' ) {
			return greenmart_tbay_get_config('header_type');
		}
		return $header;
	}
}

if ( ! function_exists( 'greenmart_tbay_get_first_url_from_string' ) ) {
	function greenmart_tbay_get_first_url_from_string( $string ) {
		$pattern = "/^\b(?:(?:https?|ftp):\/\/)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";
		preg_match( $pattern, $string, $link );

		return ( ! empty( $link[0] ) ) ? $link[0] : false;
	}
}

if ( !function_exists( 'greenmart_tbay_get_link_attributes' ) ) {
	function greenmart_tbay_get_link_attributes( $string ) {
		preg_match( '/<a href="(.*?)">/i', $string, $atts );

		return ( ! empty( $atts[1] ) ) ? $atts[1] : '';
	}
}

if ( !function_exists( 'greenmart_tbay_post_media' ) ) {
	function greenmart_tbay_post_media( $content ) {
		$is_video = ( get_post_format() == 'video' ) ? true : false;
		$media = greenmart_tbay_get_first_url_from_string( $content );
		if ( ! empty( $media ) ) {
			global $wp_embed;
			$content = do_shortcode( $wp_embed->run_shortcode( '[embed]' . $media . '[/embed]' ) );
		} else {
			$pattern = greenmart_tbay_get_shortcode_regex( greenmart_tbay_tagregexp() );
			preg_match( '/' . $pattern . '/s', $content, $media );
			if ( ! empty( $media[2] ) ) {
				if ( $media[2] == 'embed' ) {
					global $wp_embed;
					$content = do_shortcode( $wp_embed->run_shortcode( $media[0] ) );
				} else {
					$content = do_shortcode( $media[0] );
				}
			}
		}
		if ( ! empty( $media ) ) {
			$output = '<div class="entry-media">';
			$output .= ( $is_video ) ? '<div class="pro-fluid"><div class="pro-fluid-inner">' : '';
			$output .= $content;
			$output .= ( $is_video ) ? '</div></div>' : '';
			$output .= '</div>';

			return $output;
		}

		return false;
	}
}

if ( !function_exists( 'greenmart_tbay_post_gallery' ) ) {
	function greenmart_tbay_post_gallery( $content ) {
		$pattern = greenmart_tbay_get_shortcode_regex( 'gallery' );
		preg_match( '/' . $pattern . '/s', $content, $media );
		if ( ! empty( $media[2] )  ) {
			return '<div class="entry-gallery">' . do_shortcode( $media[0] ) . '<hr class="pro-clear" /></div>';
		}

		return false;
	}
}

if ( !function_exists( 'greenmart_tbay_random_key' ) ) {
    function greenmart_tbay_random_key($length = 5) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $return = '';
        for ($i = 0; $i < $length; $i++) {
            $return .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $return;
    }
}

if ( !function_exists('greenmart_tbay_substring') ) {
    function greenmart_tbay_substring($string, $limit, $afterlimit = '[...]') {
        if ( empty($string) ) {
        	return $string;
        }
       	$string = explode(' ', strip_tags( $string ), $limit);

        if (count($string) >= $limit) {
            array_pop($string);
            $string = implode(" ", $string) .' '. $afterlimit;
        } else {
            $string = implode(" ", $string);
        }
        $string = preg_replace('`[[^]]*]`','',$string);
        return strip_shortcodes( $string );
    }
}

if ( !function_exists('greenmart_tbay_subschars') ) {
    function greenmart_tbay_subschars($string, $limit, $afterlimit='...'){

	    if(strlen($string) > $limit){
	        $string = substr($string, 0, $limit);
	    }else{
	        $afterlimit = '';
	    }
	    return $string . $afterlimit;
	}
}


/*testimonials*/
if ( !function_exists('greenmart_tbay_get_page_templates_parts') ) {
	function greenmart_tbay_get_page_templates_parts($slug = 'logo', $name = null) {
		$active_theme = greenmart_tbay_get_theme();

		if( $active_theme != 'organic') { 
			return get_template_part( 'page-templates/themes/'.$active_theme.'/parts/'.$slug.'',$name);
		} else {
			return get_template_part( 'page-templates/parts/'.$slug.'',$name);
		}
	}
}

/*testimonials*/
if ( !function_exists('greenmart_tbay_get_testimonials_layouts') ) {
	function greenmart_tbay_get_testimonials_layouts() {
		$testimonials = array();
		$active_theme = greenmart_tbay_get_part_theme();
		$files = glob( get_template_directory() . '/vc_templates/testimonial/'.$active_theme.'/testimonial-*.php' );
	    if ( !empty( $files ) ) {
	        foreach ( $files as $file ) {
	        	$testi = str_replace( "testimonial-", '', str_replace( '.php', '', basename($file) ) );
	            $testimonials[$testi] = $testi;
	        }
	    }

		return $testimonials;
	}
}

/*Check in home page*/
if ( !function_exists('greenmart_tbay_is_home_page') ) {
	function greenmart_tbay_is_home_page() {
		$is_home = false;

		if( is_home() || is_front_page() || is_page( 'home-8' )  || is_page( 'home-7' )  || is_page( 'home-7-2' ) || is_page( 'home-1' ) || is_page( 'home-2' ) || is_page( 'home-3' ) || is_page( 'home-4' ) || is_page( 'home-5' ) || is_page( 'home-6' ) || is_page( 'home-7' ) || is_page( 'home-8' ) ) {
			$is_home = true;
		}

		return $is_home;
	}
}

if ( !function_exists('greenmart_gallery_atts') ) {

	add_filter( 'shortcode_atts_gallery', 'greenmart_gallery_atts', 10, 3 );
	
	/* Change attributes of wp gallery to modify image sizes for your needs */
	function greenmart_gallery_atts( $output, $pairs, $atts ) {

			
		if ( isset($atts['columns']) && $atts['columns'] == 1 ) {
			//if gallery has one column, use large size
			$output['size'] = 'full';
		} else if ( isset($atts['columns']) && $atts['columns'] >= 2 && $atts['columns'] <= 4 ) {
			//if gallery has between two and four columns, use medium size
			$output['size'] = 'full';
		} else {
			//if gallery has more than four columns, use thumbnail size
			$output['size'] = 'full';
		}
	
		return $output;
	
	}
}

if ( !function_exists('greenmart_tbay_share_js') ) {
	function greenmart_tbay_share_js() {
		 if ( greenmart_tbay_get_config('enable_code_share',false) && is_single()   ) {
		 			echo greenmart_tbay_get_config('code_share');
		 	}
	}
	add_action('wp_head', 'greenmart_tbay_share_js');
}

/*Get Preloader*/
if ( ! function_exists( 'greenmart_get_select_preloader' ) ) {
    function greenmart_get_select_preloader( ) {

    	$preloader_enable 	= greenmart_tbay_get_global_config('preload', false);

    	if( !$preloader_enable ) return;

    	$preloader 	= greenmart_tbay_get_global_config('select_preloader', 1);
    	$media 		= greenmart_tbay_get_global_config('media-preloader');

    	if( isset($preloader) ) {
	    	switch ($preloader) {
	    		case 'loader1': 
	    			?>
	                <div class="tbay-page-loader">
					  	<div id="loader"></div>
					  	<div class="loader-section section-left"></div>
					  	<div class="loader-section section-right"></div>
					</div>
	    			<?php
	    			break;    		

	    		case 'loader2':
	    			?>
					<div class="tbay-page-loader">
					    <div class="tbay-loader tbay-loader-two">
					    	<span></span>
					    	<span></span>
					    	<span></span>
					    	<span></span>
					    </div>
					</div>
	    			<?php
	    			break;    		
	    		case 'loader3':
	    			?>
					<div class="tbay-page-loader">
					    <div class="tbay-loader tbay-loader-three">
					    	<span></span>
					    	<span></span>
					    	<span></span>
					    	<span></span>
					    	<span></span>
					    </div>
					</div>
	    			<?php
	    			break;    		
	    		case 'loader4':
	    			?>
					<div class="tbay-page-loader">
					    <div class="tbay-loader tbay-loader-four"> <span class="spinner-cube spinner-cube1"></span> <span class="spinner-cube spinner-cube2"></span> <span class="spinner-cube spinner-cube3"></span> <span class="spinner-cube spinner-cube4"></span> <span class="spinner-cube spinner-cube5"></span> <span class="spinner-cube spinner-cube6"></span> <span class="spinner-cube spinner-cube7"></span> <span class="spinner-cube spinner-cube8"></span> <span class="spinner-cube spinner-cube9"></span> </div>
					</div>
	    			<?php
	    			break;    		
	    		case 'loader5':
	    			?>
					<div class="tbay-page-loader">
					    <div class="tbay-loader tbay-loader-five"> <span class="spinner-cube-1 spinner-cube"></span> <span class="spinner-cube-2 spinner-cube"></span> <span class="spinner-cube-4 spinner-cube"></span> <span class="spinner-cube-3 spinner-cube"></span> </div>
					</div>
	    			<?php
	    			break;    		
	    		case 'loader6':
	    			?>
					<div class="tbay-page-loader">
					    <div class="tbay-loader tbay-loader-six"> <span class=" spinner-cube-1 spinner-cube"></span> <span class=" spinner-cube-2 spinner-cube"></span> </div>
					</div>
	    			<?php
	    			break;

	    		case 'custom_image':
	    			?>
					<div class="tbay-page-loader loader-img">
						<?php if( isset($media['url']) && !empty($media['url']) ): ?>
					   		<img src="<?php echo esc_url($media['url']); ?>">
						<?php endif; ?>
					</div>
	    			<?php
	    			break;
	    			
	    		default:
	    			?>
	    			<div class="tbay-page-loader">
					  	<div id="loader"></div>
					  	<div class="loader-section section-left"></div>
					  	<div class="loader-section section-right"></div>
					</div>
	    			<?php
	    			break;
	    	}
	    }
    }
    add_action( 'wp_body_open', 'greenmart_get_select_preloader', 10 );
}

/*Hidden footer body class*/
if ( ! function_exists( 'greenmart_body_class_hidden_footer' ) ) {
  function greenmart_body_class_hidden_footer( $classes ) {

  		$mobile_footer 	= greenmart_tbay_get_config('mobile_footer',true);

  		$footer_icon 	= greenmart_tbay_get_config('mobile_footer_icon',true);

		if( isset($mobile_footer) && !$mobile_footer ) {
			$classes[] = 'mobile-hidden-footer';
		}

		if( isset($footer_icon) && !$footer_icon ) {
			$classes[] = 'mobile-hidden-footer-icon';

			if( isset($mobile_footer) && $mobile_footer ) {
				$classes[] = 'mobile-hideicon-enadesfooter';
			}
		} 
 

		return $classes;

  }
  add_filter( 'body_class', 'greenmart_body_class_hidden_footer',99 );
}

// Number of blog per row
if ( !function_exists('greenmart_tbay_blog_loop_columns') ) {
    function greenmart_tbay_blog_loop_columns($number) {

    		$sidebar_configs = greenmart_tbay_get_blog_layout_configs();

    		$columns 	= greenmart_tbay_get_config('blog_columns', 1);

        if( isset($_GET['blog_columns']) && is_numeric($_GET['blog_columns']) ) {
            $value = $_GET['blog_columns']; 
        } elseif( empty($columns) && isset($sidebar_configs['columns']) ) {
    			$value = 	$sidebar_configs['columns']; 
    		} else {
          $value = $columns;          
        }

        if ( in_array( $value, array(1, 2, 3, 4, 5, 6) ) ) {
            $number = $value;
        }
        return $number;
    }
}
add_filter( 'loop_blog_columns', 'greenmart_tbay_blog_loop_columns' );

/*Set excerpt show enable default*/
if ( ! function_exists( 'greenmart_tbay_edit_post_show_excerpt' ) ) {
	function greenmart_tbay_edit_post_show_excerpt() {
	  $user = wp_get_current_user();
	  $unchecked = get_user_meta( $user->ID, 'metaboxhidden_post', true );
	  if( is_array($unchecked) ) {
		$key = array_search( 'postexcerpt', $unchecked );
		if ( FALSE !== $key ) {
		   array_splice( $unchecked, $key, 1 );
		   update_user_meta( $user->ID, 'metaboxhidden_post', $unchecked );
		}
	  }
	}
	add_action( 'admin_init', 'greenmart_tbay_edit_post_show_excerpt', 10 );
}


if ( !function_exists('greenmart_tbay_menu_mobile_type') ) {
    function greenmart_tbay_menu_mobile_type() {
    	
        $option = greenmart_tbay_get_config('menu_mobile_type', 'smart_menu');
        $option = (isset($_GET['menu_mobile_type'])) ? $_GET['menu_mobile_type'] : $option;

        return $option;
    }
}
add_filter( 'greenmart_menu_mobile_option', 'greenmart_tbay_menu_mobile_type', 10, 3 );

if ( !function_exists('greenmart_tbay_get_attachment_image_loaded') ) {
	function greenmart_tbay_get_attachment_image_loaded($attachment_id, $size = 'thumbnail', $attr = '', $echo = true)  {

		$html = '';
		$image = wp_get_attachment_image_src($attachment_id, $size);
		if ( $image ) {
			list($src, $width, $height) = $image;
			$hwstring = image_hwstring($width, $height);
			$size_class = $size;
			if ( is_array( $size_class ) ) {
				$size_class = join( 'x', $size_class );
			}

			$src_blank = 'data:image/svg+xml;charset=utf-8,%3Csvg xmlns%3D&#039;http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg&#039; viewBox%3D&#039;0 0 '. $width .' '. $height .'&#039;%2F%3E';


			$attachment = get_post($attachment_id);
			$default_attr = array(
				'src'	=> $src_blank,
				'data-src'	=> $src,
				'class'	=> "attachment-$size_class size-$size_class",
				'alt'	=> trim( strip_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ) ),
			);

			if( !greenmart_tbay_get_global_config('enable_lazyloadimage',false) ) {
				$default_attr['src'] = $src;
				unset($default_attr['data-src']);
			}

			$attr = wp_parse_args( $attr, $default_attr );


			$attr = apply_filters( 'wp_get_attachment_image_attributes', $attr, $attachment, $size );

			if( greenmart_tbay_get_global_config('enable_lazyloadimage',false) ) {
				$attr['class'] = $attr['class']. ' unveil-image';
			}

			
			$attr = array_map( 'esc_attr', $attr );
			$html = rtrim("<img $hwstring");
			foreach ( $attr as $name => $value ) {
				$html .= " $name=" . '"' . $value . '"';
			}
			$html .= ' />';
		}

		if( $echo ) {
			echo trim($html);
		} else {
			return $html;
		}

	}
}


if ( !function_exists('greenmart_tbay_src_image_loaded') ) {
	function greenmart_tbay_src_image_loaded($src, $attr = '', $hwstring ='' , $echo = true)  {

		$src_blank = 'data:image/svg+xml;charset=utf-8,%3Csvg xmlns%3D&#039;http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg&#039; viewBox%3D&#039;0 0 600 400&#039;%2F%3E';



		$default_attr = array(
			'src'	=> $src_blank,
			'data-src'	=> $src,
			'class'	=> '',
		);

		if( !greenmart_tbay_get_global_config('enable_lazyloadimage',false) ) {
			$default_attr['src'] = $src;
			unset($default_attr['data-src']);
		}


		$attr = wp_parse_args( $attr, $default_attr );

		if( greenmart_tbay_get_global_config('enable_lazyloadimage',false) ) {
			$attr['class'] = $attr['class']. ' unveil-image';
		}

		$attr = array_map( 'esc_attr', $attr );
		$html = rtrim("<img $hwstring");
		foreach ( $attr as $name => $value ) {
			$html .= " $name=" . '"' . $value . '"';
		}
		$html .= ' />';

		if( $echo ) {
			echo trim($html);
		} else {
			return $html;
		}
		
	}
}

if ( !function_exists('greenmart_instagram_cache_time') ) {
	function greenmart_instagram_cache_time() {

		return MINUTE_IN_SECONDS * 15;

	}
	add_filter( 'null_instagram_cache_time', 'greenmart_instagram_cache_time', 10, 1 );
}
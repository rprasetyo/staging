<?php $thumbsize = isset($thumbsize) ? $thumbsize : 'medium';?>
<?php
  $post_category = "";
  $categories = get_the_category();
  $separator = ' | ';
  $output = '';
  if($categories){
    foreach($categories as $category) {
      $output .= '<a href="'.esc_url( get_category_link( $category->term_id ) ).'" title="' . esc_attr( sprintf( esc_html__( 'View all posts in %s', 'greenmart' ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
    }
  $post_category = trim($output, $separator);
  }      
?>
<div class="post-grid">
    <article class="post"> 
      <figure class="entry-thumb <?php echo  (!has_post_thumbnail() ? 'no-thumb' : ''); ?>">
          <a href="<?php the_permalink(); ?>" class="entry-image tbay-image-loaded">
              <?php
                  if ( defined('GREENMART_VISUALCOMPOSER_ACTIVED') && GREENMART_VISUALCOMPOSER_ACTIVED ) {
                      $thumbnail_id = get_post_thumbnail_id(get_the_ID());
                      echo greenmart_tbay_get_attachment_image_loaded($thumbnail_id, $thumbsize);
                  } else {
                      the_post_thumbnail();
                  }
              ?>
          </a>
      </figure>
      <div class="entry-content">
        <div class="meta-info">
          <span class="entry-view"><i class="<?php echo greenmart_get_icon('icon_view'); ?>" aria-hidden="true"></i><?php echo greenmart_get_post_views( get_the_ID(), esc_html__(' views', 'greenmart') ); ?></span>
          <span class="entry-date"><i class="<?php echo greenmart_get_icon('icon_date'); ?>" aria-hidden="true"></i><?php echo greenmart_time_link(); esc_html__('views', 'greenmart') ?></span>
        </div>
        <div class="entry-header">
        <?php
          if (get_the_title()) {
          ?>
            <h4 class="entry-title">
              <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h4>
          <?php
        }
        ?>
      </div>
      <?php
        if (! has_excerpt()) {
          echo "";
        } else {
          ?>
            <div class="entry-description"><?php echo greenmart_tbay_substring( get_the_excerpt(), 16, '...' ); ?></div>
          <?php
        }
      ?>
      <div class="readmore"><a href="<?php the_permalink(); ?>" title="<?php esc_html_e( 'Read more', 'greenmart' ); ?>"><?php esc_html_e( 'Read more', 'greenmart' ); ?></a></div>
    </div>
    </article>
    
</div>

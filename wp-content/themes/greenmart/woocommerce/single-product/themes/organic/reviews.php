<?php 

global $product;

?>
<div id="reviews"  class="widget-primary widget-reviews">
<div class="comments-content">
	<div class="reviews-summary">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 media reviews-col1">
				<h5><?php esc_html_e('Customer reviews', 'greenmart'); ?></h5>
				<div class="review-summary-total pull-left">
					<div class="review-summary-result">
						<strong><?php echo esc_html($average); ?></strong>
					</div>
					<?php printf( esc_html__( '%s ratings','greenmart'),$count )  ; ?>
				</div>	 
				<div class="media-body"><div class="review-summary-detal ">
					<?php foreach( array_reverse($counts) as $key => $value ):  $pc = ($count == 0 ? 0: ( ($value/$count)*100  ) );
						?>
						<div class="review-summery-item row">
							<div class="col-lg-1"></div>
							<?php $key = 5 - $key; ?>
							<div class="review-label col-lg-2"> <?php echo esc_html($key); ?> <?php esc_html_e('Star','greenmart'); ?></div> 
							<div class="col-lg-9">	
								<div class="progress">
								  <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr($pc);?>%;">
								    <?php echo round($pc,0);?>%
								  </div>
								</div>
							</div>	
					 

						</div>
					<?php endforeach; ?>
				</div></div>	

				<div id="comments" class="comments">
					<h5><?php
						if ( $count && wc_review_ratings_enabled() ) {
							/* translators: 1: reviews count 2: product name */
							$reviews_title = sprintf( esc_html( _n( '%1$s review for %2$s', '%1$s reviews for %2$s', $count, 'greenmart' ) ), esc_html( $count ), '<span>' . get_the_title() . '</span>' );
							echo apply_filters( 'woocommerce_reviews_title', $reviews_title, $count, $product ); // WPCS: XSS ok.
						} else {
							esc_html_e( 'Reviews', 'greenmart' );
						}
					?></h5>

					<?php if ( have_comments() ) : ?>

						<ul class="commentlist list-unstyled">
							<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
						</ul>

						<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
							echo '<nav class="woocommerce-pagination">';
							paginate_comments_links( apply_filters( 'woocommerce_comment_pagination_args', array(
								'prev_text' => '&larr;',
								'next_text' => '&rarr;',
								'type'      => 'list',
							) ) );
							echo '</nav>';
						endif; ?>

					<?php else : ?>

						<p class="woocommerce-noreviews"><?php esc_html_e( 'There are no reviews yet.', 'greenmart' ); ?></p>

					<?php endif; ?>
				</div>

			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 reviews-col2">


				<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>

					<h5><?php esc_html_e('Write a customer review','greenmart'); ?></h5>

					<div id="review_form_wrapper" class="review_form_wrapper">
						<div id="review_form">
							<?php
								$commenter = wp_get_current_commenter();

								$comment_form = array(
									'title_reply'          => have_comments() ? esc_html__( 'Add a review', 'greenmart' ) : esc_html__( 'Be the first to review', 'greenmart' ) . ' &ldquo;' . get_the_title() . '&rdquo;',
									'title_reply_to'       => esc_html__( 'Leave a Reply to %s', 'greenmart' ),
									'comment_notes_before' => '',
									'comment_notes_after'  => '',
									'fields'               => array(
										'author' => '<p class="comment-form-author form-group">' . '<span class="fa fa-user"></span>' .
										            '<input id="author" class="form-control" placeholder="'. esc_html('Name', 'greenmart') .'" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" /></p>',
										'email'  => '<p class="comment-form-email form-group"><span class="fa fa-envelope"></span>' .
										            '<input id="email" placeholder="'. esc_html('Email', 'greenmart') .'" class="form-control" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-required="true" /></p>',
									),
									'label_submit'  => esc_html__( 'Submit', 'greenmart' ),
									'logged_in_as'  => '',
									'comment_field' => ''
								);

								$account_page_url = wc_get_page_permalink( 'myaccount' );
								if ( $account_page_url ) {
		      						$comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a review.', 'greenmart' ), esc_url( $account_page_url ) ) . '</p>';
		      					}

								if ( wc_review_ratings_enabled() ) {
									$comment_form['comment_field'] = '<p class="comment-form-rating form-group clearfix">
									<label for="rating" class="control-label">' . esc_html__( 'Your Rating', 'greenmart' ) .'</label>
									<select name="rating" id="rating">
									<option value="">' . esc_html__( 'Rate&hellip;', 'greenmart' ) . '</option>
									<option value="5">' . esc_html__( 'Perfect', 'greenmart' ) . '</option>
									<option value="4">' . esc_html__( 'Good', 'greenmart' ) . '</option>
									<option value="3">' . esc_html__( 'Average', 'greenmart' ) . '</option>
									<option value="2">' . esc_html__( 'Not that bad', 'greenmart' ) . '</option>
									<option value="1">' . esc_html__( 'Very Poor', 'greenmart' ) . '</option>
									</select></p>';
								}


								$comment_form['comment_field'] .= '<p class="comment-form-comment form-group"><span class="fa fa-pencil"></span><textarea id="comment" placeholder="'. esc_html('Comment...', 'greenmart') .'"   class="form-control" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>';

								comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
							?>
						</div>
					</div>

				<?php else : ?>

					<h4 class="woocommerce-verification-required"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'greenmart' ); ?></h4>
				
				<?php endif; ?>


			</div>
		</div>
	</div>	


	<div class="clear"></div>
</div>
</div>
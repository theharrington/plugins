<script type="text/javascript">
	// jQuery(document).ready(function(e) {
    //     jQuery("body").on("click", ".fav-remove", function(e) {
    //         jQuery(this).html("<img src='http://www.theharrington.com/wp-content/plugins/wp-favorite-posts/img/loading.gif' style='width:20px;height:20px'>")
    //     });
    // });
</script>
<?php
    // variable declaration
    global $post;
    global $short_stay_properties;
    global $shortstay;
    $short_stay_properties = [58];
    $page_parent_ID = $post->post_parent;

    $wpfp_before = "";
    echo "<div class='wpfp-span'>";
    if (!empty($user)) {
        if (wpfp_is_user_favlist_public($user)) {
            $wpfp_before = "$user's Favorite Posts.";
        } else {
            $wpfp_before = "$user's list is not public.";
        }
    }

    if ($wpfp_before):
        echo '<div class="wpfp-page-before">'.$wpfp_before.'</div>';
    endif;

    if ($favorite_post_ids) {
		$favorite_post_ids = array_reverse($favorite_post_ids);
        $post_per_page = wpfp_get_option("post_per_page");
        $page = intval(get_query_var('paged'));

        $qry = array('post__in' => $favorite_post_ids, 'posts_per_page'=> $post_per_page, 'orderby' => 'post__in', 'paged' => $page);
        // custom post type support can easily be added with a line of code like below.
        $qry['post_type'] = array('post','properties');
        query_posts($qry);

        ?>
    <h4 class="">My current list</h4>
    <div class="fav-wrapper clearfix" >
        <?php while ( have_posts() ) : the_post();
            ini_set('log_errors',1);
            $post = get_post();
            error_log('dws:post:'. print_r($post, true));
        ?>
        <div class="row mt-4 mb-4 border clearfix">
        <div class=" col-sm-12 clearfix border-bottom pt-2 pb-2">
        
                <h2 class="clearfix"><a href='<?php echo get_permalink(); ?>' title='<?php echo get_the_title(); ?>'><?php echo get_the_title(); ?></a></h2>
                <div class="row">
                    <div class="col-sm-6"><a href="javascript:;" class="fav-remove" ><?php wpfp_saveforlater_favorite_link(get_the_ID()); ?></a></div>
                    <div class="col-sm-6 text-right"><a href="javascript:;" class="fav-remove" ><?php wpfp_remove_favorite_link(get_the_ID()); ?></a></div>
                </div>
                </div>
                <div class=" pt-2 pt-lg-3 col-sm-6 col-lg-3">
                <?= do_shortcode( '[favouritesGridGallery]' ); ?>
                </div>

                <div class=" fav-desc-wrapper pt-2 pt-lg-3 col-sm-6 col-lg-3">
                        <h5 class="pl-4 ">Description</h5>
                        <ul>
                            <!-- <?php //if (get_field('number_of_bedrooms')) { ?>
                                <li>
                                    <?php //if (get_field('number_of_bedrooms') == 1){
                                        //echo "One large bedroom"; 
                                    //} else {
                                        //the_field('number_of_bedrooms');
                                        //echo " large bedrooms";
                                    //} ?>
                                        </li>
                                    <?php //} ?> -->
                                    <?php if (get_field('bedrooms')) { ?>
                                        <li><?php the_field('bedrooms'); ?></li>
                                    <?php } ?>
                                    <?php if (get_field('bathrooms')) { ?>
                                        <li><?php the_field('bathrooms'); ?></li>
                                    <?php } ?>
                                    <?php if (get_field('max_ocupancy')) { ?>
                                        <li>Maximum occupancy: <?php the_field('max_ocupancy'); ?></li>
                                    <?php } ?>
                                    <?php if (get_field('floor_space')) { ?>
                                        <li><?php the_field('floor_space'); ?> sq ft</li>
                                    <?php } ?>
                                    <?php if (get_field('outside_space')) { ?>
                                        <li><?php the_field('outside_space'); ?></li>
                                    <?php } ?>
                                    <?php if (get_field('view')) { ?>
                                        <li>View: <?php the_field('view'); ?></li>
                                    <?php } ?>
                                </ul>
                        
                        <?php if(get_field('brochure_download')){?>
                            <a id= "brochure" href="<?php echo get_field('brochure_download');?>" class="btn btn-primary btn-dark ml-4 mb-2 mb-lg-3" target="_blank" title="Download Brochure">Brochure <span class="pdf-icon"></span></a>
                        <?php }//end if ?>
                </div>

                <div class=" fav-rates-wrapper pt-2 pt-lg-3 col-sm-12 col-lg-6">                
                    <?php //if (!in_array($page_parent_ID, $short_stay_properties)) {
                        echo '<h3 class="d-none d-print-block" style="text-align:center;">Rental Prices</h3>';
                                
                        $servicesAmount = get_field('bills_and_serviced_partial');
                    ?>
                    <?php $min_stay = get_field('minimum_stay', $post->post_parent); ?>
                    <?= do_shortcode( '[rentalTableData]' ); ?>
                    <?php // } ?>
                </div>
            </div>

        <?php endwhile; ?>
    </div> <!-- end of fav-wrapper -->
    <?php
        echo '<div class="navigation">';
            if(function_exists('wp_pagenavi')) { wp_pagenavi(); } else { ?>
            <div class="alignleft"><?php next_posts_link( __( '&larr; Previous Entries', 'buddypress' ) ) ?></div>
            <div class="alignright"><?php previous_posts_link( __( 'Next Entries &rarr;', 'buddypress' ) ) ?></div>
            <?php }
        echo '</div>';

        wp_reset_query();
    } else {
        $wpfp_options = wpfp_get_options();
        echo "<ul><li>";
        echo $wpfp_options['favorites_empty'];
        echo "</li></ul>";
    }

    echo '<p>'.wpfp_clear_list_link().'</p>';
    echo "</div>"; ?>

    <h4 class="border-top mt-4 pt-4">Saved for later</h4>
    <?php 
  
    if ($saved_post_ids) {
		$saved_post_ids = array_reverse($saved_post_ids);
        $post_per_page = wpfp_get_option("post_per_page");
        $page = intval(get_query_var('paged'));

        $qry = array('post__in' => $saved_post_ids, 'posts_per_page'=> $post_per_page, 'orderby' => 'post__in', 'paged' => $page);
        // custom post type support can easily be added with a line of code like below.
        $qry['post_type'] = array('post','properties');
        query_posts($qry); ?>

        <div class="fav-wrapper" >
            <?php while ( have_posts() ) : the_post();?>
                <div class="row mt-3 mb-3 border clearfix">
                <div class=" col-sm-12 clearfix border-bottom pt-2 pb-2">
                    <h2 class="clearfix"><a href='<?php echo get_permalink(); ?>' title='<?php echo get_the_title(); ?>'><?php echo get_the_title(); ?></a></h2>
                    <div class="row">
                        <div class="col-sm-6"><a href="javascript:;" class="fav-remove" ><?php wpfp_restore_favorite_link(get_the_ID()); ?></a></div>
                        <div class="col-sm-6 text-right"><a href="javascript:;" class="fav-remove" ><?php wpfp_trash_favorite_link(get_the_ID()); ?></a></div>
                    </div>
                </div>
                <div class=" col-sm-6 mt-3 col-lg-3">
                    <?= do_shortcode( '[favouritesGridGallery]' ); ?>
                </div>
                <div class=" fav-desc-wrapper col-sm-6 col-lg-3">
                    <h5 class="pl-4 pt-3">Description</h5>
                        <ul>
                            <!-- <?php //if (get_field('number_of_bedrooms')) { ?>
                            <li>
                                <?php //if (get_field('number_of_bedrooms') == 1){
                                    //echo "One large bedroom"; 
                                //} else {
                                    //the_field('number_of_bedrooms');
                                    //echo " large bedrooms";
                                //} ?>
                            </li> 
                            <?php //} ?>-->
                            <?php if (get_field('bedrooms')) { ?>
                                <li><?php the_field('bedrooms'); ?></li>
                            <?php } ?>
                            <?php if (get_field('bathrooms')) { ?>
                                <li><?php the_field('bathrooms'); ?> </li>
                            <?php } ?>
                            <?php if (get_field('max_ocupancy')) { ?>
                                <li>Maximum occupancy: <?php the_field('max_ocupancy'); ?></li>
                            <?php } ?>
                            <?php if (get_field('floor_space')) { ?>
                                <li><?php the_field('floor_space'); ?> sq ft.</li>
                            <?php } ?>
                            <?php if (get_field('outside_space')) { ?>
                                <li><?php the_field('outside_space'); ?></li>
                            <?php } ?>
                            <?php if (get_field('view')) { ?>
                                <li>View: <?php the_field('view'); ?></li>
                            <?php } ?>
                        </ul>
                                
                        <?php if(get_field('brochure_download')){?>
                            <a id= "brochure" href="<?php echo get_field('brochure_download');?>" class="btn btn-primary btn-dark  ml-4 mb-2 mb-ld-3" target="_blank" title="Download Brochure">Brochure <span class="pdf-icon"></span></a>
                        <?php }//end if ?>
                        </div>

                        <div class=" fav-rates-wrapper pt-3 col-sm-12 col-lg-6">
                            <?php //if (!in_array($page_parent_ID, $short_stay_properties)) {
                                echo '<h3 class="d-none d-print-block" style="text-align:center;">Rental Prices</h3>';
                                        
                                $servicesAmount = get_field('bills_and_serviced_partial');
                            ?>
                            <?php $min_stay = get_field('minimum_stay', $post->post_parent); ?>
                                <?= do_shortcode('[rentalTableData]'); ?>
                            <?php //} ?>
                        </div>
                </div>

                    <?php endwhile; ?>
        </div> <!-- end of fav-wrapper -->

        <?php echo '<div class="navigation">';
            if(function_exists('wp_pagenavi')) { wp_pagenavi(); } else { ?>
            <div class="alignleft"><?php next_posts_link( __( '&larr; Previous Entries', 'buddypress' ) ) ?></div>
            <div class="alignright"><?php previous_posts_link( __( 'Next Entries &rarr;', 'buddypress' ) ) ?></div>
            <?php }
        echo '</div>';

        wp_reset_query();
    } else {
        $wpfp_options = wpfp_get_options();
        echo "<ul class=' p-0 list-style-inside mb-3'><li class='nbvf'>";
        echo "Your saved apartments list is empty.";
        echo "</li></ul>";
    } 

    wpfp_cookie_warning();
    ?>

   

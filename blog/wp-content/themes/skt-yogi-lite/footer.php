<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package SKT Yogi
 */
?>
<div id="footer-wrapper">
    	<div class="container">
        
            <div class="cols-3 widget-column-1"> 
            
               <?php if ( get_theme_mod( 'about_title' ) !== "" ){  ?>
                <h5><?php echo esc_attr( get_theme_mod( 'about_title', __('About Yogi','skt-yogi-lite'))); ?></h5>              
			   <?php } ?> 
               
                <?php if ( get_theme_mod( 'about_description' ) !== "" ){  ?>
                <p><?php echo esc_attr( get_theme_mod( 'about_description', __('Consectetur, adipisci velit, sed quiaony on numquam eius incidunt, ut laboret dolore agnam aliquam quaeratine voluptatem. ut enim ad minima veniamting suscipit lab velit, sed quiaony on numquam eius. Consectetur, adipisci velit, sed quiaony on numquam eius modi tempora incidunt, ut laboret dolore agnam aliquam quaeratine voluptatem. ut enim ad minima veniamting suscipit lab velit.','skt-yogi-lite'))); ?></p>              
			   <?php } ?> 
                       	
             
            </div><!--end .col-3-->
			         
             
             <div class="cols-3 widget-column-2">  
                 <?php if ( get_theme_mod( 'recentpost_title' ) !== "" ){  ?>
                <h5><?php echo esc_attr( get_theme_mod( 'recentpost_title', __('Recent Posts','skt-yogi-lite'))); ?></h5>              
			   <?php } ?> 
                        	
				<?php $args = array( 'posts_per_page' => 2, 'post__not_in' => get_option('sticky_posts'), 'orderby' => 'date', 'order' => 'desc' );
                    query_posts( $args ); ?>
                    
                  <?php while ( have_posts() ) :  the_post(); ?>
                        <div class="recent-post">
                         <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
                         <a href="<?php the_permalink(); ?>"><h6><?php the_title(); ?></h6></a>                         
                         <?php echo skt_yogi_lite_content(12); ?>                         
                        </div>
                 <?php endwhile; ?>
                          	
              </div><!--end .col-3-->
                      
               <div class="cols-3 widget-column-3">
               
				   <?php if ( get_theme_mod( 'contact_title' ) !== "" ){  ?>
                    <h5><?php echo esc_attr( get_theme_mod( 'contact_title', __('Contact Info','skt-yogi-lite'))); ?></h5>              
                   <?php } ?>               
                  
                   <?php if ( get_theme_mod('contact_add') !== "") { ?>
                	<span class="mapicon"><?php echo esc_attr( get_theme_mod( 'contact_add', __('100 King St, Melbourne PIC 4000','skt-yogi-lite'))); ?></span>            
			  	   <?php } ?>
                   
                   <?php if ( get_theme_mod('contact_no') !== "") { ?>
               			<span class="phoneno"><?php echo esc_attr( get_theme_mod( 'contact_no', __('(0712) 456 9190','skt-yogi-lite'))); ?></span>              
			   		<?php } ?> 
                    
                    <?php if( get_theme_mod('contact_mail') !== ""){ ?>
          <a href="mailto:<?php echo sanitize_email(get_theme_mod('contact_mail','contact@company.com')); ?>"><span class="emailicon"><?php echo get_theme_mod('contact_mail','contact@company.com'); ?></span></a>			
		<?php } ?> 
                  
                  <div class="social-icons">
					<?php if ( get_theme_mod('fb_link') != "") { ?>
                    <a title="facebook" class="fb" target="_blank" href="<?php echo esc_url(get_theme_mod('fb_link','#facebook')); ?>"></a> 
                    <?php } else { ?>
                    <?php echo '<a href="#" target="_blank" class="fb" title="facebook"></a>'; } ?>
                    
                    <?php if ( get_theme_mod('twitt_link') != "") { ?>
                    <a title="twitter" class="tw" target="_blank" href="<?php echo esc_url(get_theme_mod('twitt_link','#twitter')); ?>"></a>
                    <?php } else { ?>
                    <?php echo '<a href="#" target="_blank" class="tw" title="twitter"></a>'; } ?> 
                    
                    <?php if ( get_theme_mod('gplus_link') != "") { ?>
                    <a title="google-plus" class="gp" target="_blank" href="<?php echo esc_url(get_theme_mod('gplus_link','#gplus')); ?>"></a>
                    <?php } else { ?>
                    <?php echo '<a href="#" target="_blank" class="gp" title="google-plus"></a>'; } ?>
                    
                    <?php if ( get_theme_mod('linked_link') != "") { ?> 
                    <a title="linkedin" class="in" target="_blank" href="<?php echo esc_url(get_theme_mod('linked_link','#linkedin')); ?>"></a>
                    <?php } else { ?>
                    <?php echo '<a href="#" target="_blank" class="in" title="linkedin"></a>'; } ?>
                  </div>  
                    
                </div><!--end .col-3-->
                
            <div class="clear"></div>
         </div><!--end .container-->
    </div><!--end .footer-->
<?php wp_footer(); ?>

</body>
</html>
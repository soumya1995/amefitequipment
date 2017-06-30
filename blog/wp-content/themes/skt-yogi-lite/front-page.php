<?php
/**
 * The template for displaying home page.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package SKT Yogi
 */

get_header(); ?>
<?php if ( is_front_page() && ! is_home() ) { ?>
<section id="wrapsecond" class="pagewrap2">
            	<div class="container">                                   
                      <?php for($p=1; $p<4; $p++) { ?>       
        	<?php if( get_theme_mod('page-column'.$p,false)) { ?>          
        		<?php $queryxxx = new WP_query('page_id='.get_theme_mod('page-column'.$p,true)); ?>				
						<?php while( $queryxxx->have_posts() ) : $queryxxx->the_post(); ?> 
                        <div class="listpages Box<?php echo $p; ?> <?php if($p % 3 == 0) { echo "last_column"; } ?>">                      
						<a href="<?php the_permalink(); ?>">
						  <?php the_post_thumbnail( array(85,85, true) );?>
                          <h3><?php the_title(); ?></h3>
                        </a>			 
                          <?php echo skt_yogi_lite_content(25); ?>
                     	  <a class="Morebutton" href="<?php the_permalink(); ?>"><?php echo esc_attr(__('Read More','skt-yogi-lite')); ?></a>                       
                        </div>
						<?php endwhile;
						wp_reset_query(); ?>
            <?php } else { ?>
					<div class="listpages Box<?php echo $p; ?> <?php if($p % 3 == 0) { echo "last_column"; } ?>">                       
                        <a href="#">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/about<?php echo $p; ?>.png" alt="" />
                        <h3><?php echo esc_attr(__('Yoga For Fitness','skt-yogi-lite')); ?> <?php echo $p; ?></h3>
                        </a>
                        <p><?php echo esc_attr(__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut ullamcorper dolor urna, sit amet rhoncus metus efficitur in. Quisque nec gravida mi.','skt-yogi-lite')); ?></p>
                          <a class="Morebutton" href="#"><?php echo esc_attr(__('Read More','skt-yogi-lite')); ?></a>
                      
                     </div>
			<?php }} ?>                     
             
              <div class="clear"></div>
            </div><!-- container -->
 </section><div class="clear"></div>

<section id="wrapfirst" class="pagewrap1">
        <div class="container">
                <?php 
		/*Home Section Content*/
		if( get_theme_mod('page-setting1')) { ?>
		<?php $queryvar = new WP_query('page_id='.get_theme_mod('page-setting1' ,true)); ?>
		<?php while( $queryvar->have_posts() ) : $queryvar->the_post();?> 		
         <?php the_post_thumbnail( array(570,380, true));?>
         <h1><?php the_title(); ?></h1>         
		 <?php the_content(); ?>
         <?php if(get_theme_mod('moreinfo_link', '#')) { ?>
          <a class="MoreLink" href="<?php echo esc_url( get_theme_mod('moreinfo_link',true)); ?>"><?php echo esc_attr('More Info','skt-yogi-lite'); ?></a>
          <?php } ?>
         <div class="clear"></div>
        <?php endwhile; } else { ?> 
        <img src="<?php echo get_template_directory_uri(); ?>/images/welcomeimage.jpg" alt=""/>     
       <h1><?php echo esc_attr(__('Welcome To Yogasana','skt-yogi-lite')); ?></h1>
       <p><?php echo esc_attr(__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut ut mauris et magna suscipit egestas eu eu ipsum. Phasellus hendrerit ac ex ut aliquam. Donec lacinia rutrum sem, et luctus urna egestas vitae. Cras consequat, ante sed pharetra accumsan, massa enim faucibus neque, ac scelerisque metus nisl fermentum tellus. <br /> <br />

Ut ut condimentum felis. Nulla quis nulla nulla. Donec placerat tincidunt ex. Nunc dictum enim arcu, id fermentum urna rhoncus ac. Morbi non tortor eget sem ultrices fringilla vel sit amet turpis. Quisque tincidunt, enim et aliquam ultrices, nunc odio ullamcorper sapien, ac accumsan arcu est in lectus. Pellentesque nisl libero, finibus et turpis a, mattis suscipit nibh. Etiam dignissim, odio a tincidunt molestie, est orci laoreet urna, vitae egestas dui mi eu quam. Morbi non dictum libero. Quisque non molestie dolor. Vestibulum maximus magna et luctus porta. Nulla facilisi.','skt-yogi-lite')); ?></p>
 <a class="MoreLink" href="#"><?php echo esc_attr(__('More Info','skt-yogi-lite')); ?></a> 
        <?php } ?>
        <div class="clear"></div>
         </div><!-- container -->
     </section><!-- #wrapfirst --> 
     <?php } ?>
<div class="container">
     <div class="page_content">
        <section class="site-main">
        	 <div class="blog-post">
					<?php
                    if ( have_posts() ) :
                        // Start the Loop.
                        while ( have_posts() ) : the_post();
                            /*
                             * Include the post format-specific template for the content. If you want to
                             * use this in a child theme, then include a file called called content-___.php
                             * (where ___ is the post format) and that will be used instead.
                             */
                            get_template_part( 'content', get_post_format() );
                    
                        endwhile;
                        // Previous/next post navigation.
                        skt_yogi_lite_pagination();
                    
                    else :
                        // If no content, include the "No posts found" template.
                         get_template_part( 'no-results', 'index' );
                    
                    endif;
                    ?>
                    </div><!-- blog-post -->
             </section>
      
        <?php get_sidebar();?>     
        <div class="clear"></div>
    </div><!-- site-aligner -->
</div><!-- content -->
<?php get_footer(); ?>
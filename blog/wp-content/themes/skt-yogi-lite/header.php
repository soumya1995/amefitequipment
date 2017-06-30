<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div class="container">
 *
 * @package SKT Yogi
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>

</head>

<body <?php body_class(''); ?>>
<div class="header"> 
		
			<?php if ( ! dynamic_sidebar( 'sidebar-header' ) ) : ?>
            <div class="headerfull">
         	   <div class="container">
                <div class="left">              
               <?php if ( get_theme_mod('contact_no') !== "") { ?>
          			<span class="phoneno"><?php echo esc_attr( get_theme_mod( 'contact_no', __('(0712) 456 9190','skt-yogi-lite'))); ?></span>        
			  <?php } ?>              
            
            <?php if( get_theme_mod('contact_mail') !== ""){ ?>
          <a href="mailto:<?php echo sanitize_email(get_theme_mod('contact_mail','contact@company.com')); ?>"><span class="emailicon"><?php echo get_theme_mod('contact_mail','contact@company.com'); ?></span></a>			
		<?php } ?>
            
            
            </div>
            <div class="right">
			<?php if( get_theme_mod('office_timing') !== "") { ?>
            <span class="office-time"><?php echo esc_attr( get_theme_mod('office_timing', __('Week days: 05:00 - 22:00 Saturday: 08:00 - 18:00 Sunday: Closed','skt-yogi-lite'))); ?></span>
            <?php } ?>
              </div>  
            <div class="clear"></div>          
          </div><!--end .container--> 
        </div><!--end .headerfull--> 
         <?php endif; // end sidebar widget area ?>	       
        <div class="header-inner">
                <div class="logo">
                        <a href="<?php echo esc_url( home_url('/') ); ?>">
                                <h1><?php bloginfo('name'); ?></h1>
                                <span class="tagline"><?php bloginfo( 'description' ); ?></span>                          
                        </a>                      
                 </div><!-- logo --> 
                 <div class="headerright">
                 
                    <div class="toggle">
                <a class="toggleMenu" href="#"><?php echo esc_attr('Menu','skt-yogi-lite'); ?></a>
                </div><!-- toggle -->
                <div class="nav">                  
                    <?php wp_nav_menu( array('theme_location' => 'primary')); ?>
                </div><!-- nav -->                     
                 <div class="clear"></div>
             </div><!-- .headerright -->
                 <div class="clear"></div>                 
   </div><!-- header-inner -->
</div><!-- header -->

<?php if ( is_front_page() && ! is_home() ) { ?>
<section id="home_slider">
        	<?php
			$sldimages = ''; 
			$sldimages = array(
						'1' => get_template_directory_uri().'/images/slides/slider1.jpg',
						'2' => get_template_directory_uri().'/images/slides/slider2.jpg',
						'3' => get_template_directory_uri().'/images/slides/slider3.jpg',
						'4' => get_template_directory_uri().'/images/slides/slider1.jpg',
						'5' => get_template_directory_uri().'/images/slides/slider2.jpg',								
			); ?>
            
        	<?php
			$slAr = array();
			$m = 0;
			for ($i=1; $i<6; $i++) {
				if ( get_theme_mod('slide_image'.$i, $sldimages[$i]) != "" ) {
					$imgSrc 	= get_theme_mod('slide_image'.$i, $sldimages[$i]);
					$imgTitle	= get_theme_mod('slide_title'.$i);
					$imgDesc	= get_theme_mod('slide_desc'.$i);
					$imgLink	= get_theme_mod('slide_link'.$i);
					if ( strlen($imgSrc) > 3 ) {
						$slAr[$m]['image_src'] = get_theme_mod('slide_image'.$i, $sldimages[$i]);
						$slAr[$m]['image_title'] = get_theme_mod('slide_title'.$i);
						$slAr[$m]['image_desc'] = get_theme_mod('slide_desc'.$i);
						$slAr[$m]['image_link'] = get_theme_mod('slide_link'.$i);
						$m++;
					}
				}
			}
			$slideno = array();
			if( $slAr > 0 ){
				$n = 0;?>
                <div class="slider-wrapper theme-default"><div id="slider" class="nivoSlider">
                <?php 
                foreach( $slAr as $sv ){
                    $n++; ?>
                    <img src="<?php echo esc_url($sv['image_src']); ?>" alt="<?php echo esc_attr($sv['image_title']);?>" title="<?php echo esc_attr('#slidecaption'.$n) ; ?>" />											<?php
                    $slideno[] = $n;
                }
                ?>
                </div><?php
				
				
                foreach( $slideno as $sln ){ ?>
                    <div id="slidecaption<?php echo $sln; ?>" class="nivo-html-caption">
                    <div class="slide_info">
                    <h2><?php echo esc_attr (get_theme_mod('slide_title'.$sln, __('Fight Stress & Find Serenity','skt-yogi-lite'))); ?></h2>                     
                    <p>
          <?php  echo esc_attr (get_theme_mod('slide_desc'.$sln, __('Quisque blandit dolor risus, sed dapibus dui facilisis sed. Donec eu porta elit. Aliquam porta sollicitudin ante, acntum orci mattis et. Phasellus ac nibh eleifend, sagittis purus nec, elementum massa. Quisque tincidunt sapien a sem porttitor, id convallis dolor','skt-yogi-lite'))); ?>
        </p>
        
        <a class="morelink" href="<?php echo esc_url(get_theme_mod('slide_link'.$sln,'#link'.$sln)); ?>">
        <?php echo esc_attr(__('Read More', 'skt-yogi-lite')); ?>
        </a> 
         
                    </div>
                    </div><?php 
                } ?>
                </div>
                <div class="clear"></div><?php 
			}
            ?>           
        </section>	<!--end #home_slider-->
	<?php } ?>
<?php
/**
 * The template for displaying front page pages.
 *
 */
get_header(); 
?>  
<div class="slider-container">
    <div class="slider-wrapper">
        <!--Start Slider Wrapper-->
        <div class="flexslider">
            <ul class="slides">
                <li>
                    <?php if (roadfighter_get_option('roadfighter_slideimage1') != '') { ?>
                        <a href="<?php if (roadfighter_get_option('roadfighter_Sliderlink1') != '') {
                        echo esc_url(roadfighter_get_option('roadfighter_Sliderlink1'));
                    } ?>" >
                            <img  src="<?php echo roadfighter_get_option('roadfighter_slideimage1'); ?>" alt="Slide Image 1"/></a>
                    <?php } else { ?>
                        <img  src="<?php echo get_template_directory_uri(); ?>/images/slider1.jpg" alt="Slide Image 1"/>
                            <?php } ?>
                    <div class="flex-caption-wrapper">
                        <div class="flex-caption">
                            <?php if (roadfighter_get_option('roadfighter_sliderheading1') != '') { ?>
                                <h1><a href="<?php if (roadfighter_get_option('roadfighter_Sliderlink1') != '') {
                                echo esc_url(roadfighter_get_option('roadfighter_Sliderlink1'));
                            } ?>"><?php echo stripslashes(roadfighter_get_option('roadfighter_sliderheading1')); ?></a></h1>
                                <?php } else { ?>
                                <h1><a href="#">Premium WordPress Themes with Single Click Installation</a></h1>
                            <?php } ?>
                            <?php if (roadfighter_get_option('roadfighter_sliderdes1') != '') { ?>
                                <p>					   
                                <?php echo stripslashes(roadfighter_get_option('roadfighter_sliderdes1')); ?>
                                </p>
                            <?php } else { ?>
                                <p><?php _e('Premium WordPress Themes with Single Click Installation, Just a Click and your website is ready for use.Premium WordPress Themes.','road-fighter'); ?> </p>
                            <?php } ?>
                            <?php if (roadfighter_get_option('roadfighter_slider_button1') != '') { ?>
                                <a class="slider-readmore" href="<?php if (roadfighter_get_option('roadfighter_Sliderlink1') != '') {
                                echo roadfighter_get_option('roadfighter_Sliderlink1');
                            } ?>"><span><?php echo stripslashes(roadfighter_get_option('roadfighter_slider_button1')); ?></span></a>
                            <?php } else { ?>
                                <a class="slider-readmore" href="<?php if (roadfighter_get_option('roadfighter_Sliderlink1') != '') {
                                echo roadfighter_get_option('roadfighter_Sliderlink1');
                            } ?>"><span><?php _e('Read More','road-fighter'); ?></span></a>
                        <?php } ?>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
</div>
</div>
<div class="clear"></div>
<div class="home_container">
    <div class="container_24">
        <div class="grid_24">
            <div class="home-content">
                <div class="page_info">
                    <?php if (roadfighter_get_option('roadfighter_page_main_heading') != '') { ?>
                        <h1><?php echo stripslashes(roadfighter_get_option('roadfighter_page_main_heading')); ?></h1>
                        <?php } else { ?>
                        <h1><?php _e('Premium WordPress Themes with Single Click Installation.','road-fighter'); ?></h1>
                        <?php } ?>
                        <?php if (roadfighter_get_option('roadfighter_page_sub_heading') != '') { ?>
                        <h3><?php echo stripslashes(roadfighter_get_option('roadfighter_page_sub_heading')); ?></h3>
                                <?php } else { ?>
                        <h3><?php _e('Just a Click and your website is ready for use. Your Site is faster to built, easy to use & Search Engine Optimized.','road-fighter'); ?></h3>
                                <?php } ?>
                </div>
                <div class="clear"></div>
                <div class="feature-content">
                    <div class="grid_8 alpha">
                        <div class="feature-content-inner first">
                            <div class="image-box">
                                <?php if (roadfighter_get_option('roadfighter_fimg1') != '') { ?>
                                    <a href="<?php if (roadfighter_get_option('roadfighter_link1') != '') {
                                    echo esc_url(roadfighter_get_option('roadfighter_link1'));
                                } ?>"><img src="<?php echo roadfighter_get_option('roadfighter_fimg1'); ?>" alt="First Feature Image" /></a>
                                <?php } else { ?>
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/1.jpg" /><?php } ?><a href="<?php if (roadfighter_get_option('roadfighter_link1') != '') {
                                    echo roadfighter_get_option('roadfighter_link1');
                                } ?>"><div class="mask"></div></a></div>
                            <div class="feature-content-text">
                                <?php if (roadfighter_get_option('roadfighter_headline1') != '') { ?><h3><a href="<?php if (roadfighter_get_option('roadfighter_link1') != '') {
                                        echo esc_url(roadfighter_get_option('roadfighter_link1'));
                                    } ?>"><?php echo stripslashes(roadfighter_get_option('roadfighter_headline1')); ?></a></h3>
                                <?php } else { ?>
                                    <h3><a href="#"><?php _e('Bring More Traffic To Website','road-fighter'); ?></a></h3>
                                <?php } ?>
                                <?php if (roadfighter_get_option('roadfighter_feature1') != '') { ?>
                                    <p><?php echo stripslashes(roadfighter_get_option('roadfighter_feature1')); ?></p>
                                <?php } else { ?>
                                    <p><?php _e('Facebook Like button and Like box Plugins Nowadays website builder wants to bring more visitors.','road-fighter'); ?></p>
                                <?php } ?>
                                <a class="read-more" href="<?php if (roadfighter_get_option('roadfighter_link1') != '') {
                                    echo esc_url(roadfighter_get_option('roadfighter_link1'));
                                } ?>"><?php _e('Read More', 'road-fighter') ?></a></div> </div>
                    </div>
                    <div class="grid_8">
                        <div class="feature-content-inner second">
                            <div class="image-box">
                                <?php if (roadfighter_get_option('roadfighter_fimg2') != '') { ?>
                                    <a href="<?php if (roadfighter_get_option('roadfighter_link2') != '') {
                                        echo esc_url(roadfighter_get_option('roadfighter_link2'));
                                    } ?>"><img src="<?php echo roadfighter_get_option('roadfighter_fimg2'); ?>" alt="First Feature Image" /></a>
                                <?php } else { ?>
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/2.jpg" /><?php } ?><a href="<?php if (roadfighter_get_option('roadfighter_link2') != '') {
                                echo esc_url(roadfighter_get_option('roadfighter_link2'));
                            } ?>"><div class="mask"></div></a></div>
                            <div class="feature-content-text">
                                <?php if (roadfighter_get_option('roadfighter_headline2') != '') { ?><h3><a href="<?php if (roadfighter_get_option('roadfighter_link2') != '') {
                                    echo esc_url(roadfighter_get_option('roadfighter_link2'));
                                } ?>"><?php echo stripslashes(roadfighter_get_option('roadfighter_headline2')); ?></a></h3>
                                <?php } else { ?>
                                    <h3><a href="#"><?php _e('Bring More Traffic To Website','road-fighter'); ?></a></h3>
                                <?php } ?>
                                <?php if (roadfighter_get_option('roadfighter_feature2') != '') { ?>
                                    <p><?php echo stripslashes(roadfighter_get_option('roadfighter_feature2')); ?></p>
                                <?php } else { ?>
                                    <p><?php _e('Facebook Like button and Like box Plugins Nowadays website builder wants to bring more visitors.','road-fighter'); ?></p>
                                    <?php } ?>
                                <a class="read-more" href="<?php if (roadfighter_get_option('roadfighter_link2') != '') {
                                echo esc_url(roadfighter_get_option('roadfighter_link2'));
                            } ?>"><?php _e('Read More', 'road-fighter') ?></a></div>
                        </div>
                    </div>
                    <div class=" grid_8 omega">
                        <div class="feature-content-inner third">
                            <div class="image-box">
                            <?php if (roadfighter_get_option('roadfighter_fimg3') != '') { ?>
                                    <a href="<?php if (roadfighter_get_option('roadfighter_link3') != '') {
                                echo esc_url(roadfighter_get_option('roadfighter_link3'));
                            } ?>"><img src="<?php echo roadfighter_get_option('roadfighter_fimg3'); ?>" alt="First Feature Image" /></a>
                                <?php } else { ?>
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/3.jpg" /><?php } ?><a href="<?php if (roadfighter_get_option('roadfighter_link3') != '') {
                                 echo esc_url(roadfighter_get_option('roadfighter_link3'));
                            } ?>"><div class="mask"></div></a></div>
                            <div class="feature-content-text">
                            <?php if (roadfighter_get_option('roadfighter_headline3') != '') { ?><h3><a href="<?php if (roadfighter_get_option('roadfighter_link3') != '') {
                                echo esc_url(roadfighter_get_option('roadfighter_link3'));
                            } ?>"><?php echo stripslashes(roadfighter_get_option('roadfighter_headline3')); ?></a></h3>
                                <?php } else { ?>
                                    <h3><a href="#"><?php _e('Bring More Traffic To Website','road-fighter'); ?></a></h3>
                                    <?php } ?>
                                    <?php if (roadfighter_get_option('roadfighter_feature3') != '') { ?>
                                    <p><?php echo stripslashes(roadfighter_get_option('roadfighter_feature3')); ?></p>
                                    <?php } else { ?>
                                    <p><?php _e('Facebook Like button and Like box Plugins Nowadays website builder wants to bring more visitors.','road-fighter'); ?></p>
                                <?php } ?>
                                <a class="read-more" href="<?php if (roadfighter_get_option('roadfighter_link3') != '') {
                            echo esc_url(roadfighter_get_option('roadfighter_link3'));
                        } ?>"><?php _e('Read More', 'road-fighter') ?></a> </div>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="bottom_tagline">
                    <div class=" grid_18 ipad-tagline alpha">
                        <div class="bottom_tagline_text">
                            <?php if (roadfighter_get_option('roadfighter_tag_head') != '') { ?>
                                <h1><?php echo stripslashes(roadfighter_get_option('roadfighter_tag_head')); ?></h1>
                                <?php } else { ?>
                                <h1><?php _e('Any Important notice with a call to action button can come here.','road-fighter'); ?></h1>
                                <?php } ?>
                        </div>
                    </div>
                    <div class=" grid_6 ipad-tagline omega">
                        <div class="bottom_tagline_button">
                            <?php if (roadfighter_get_option('roadfighter_homepage_button') != '') { ?>
                                <a href="<?php echo esc_url(roadfighter_get_option('roadfighter_homepage_button_link')); ?>"><?php echo stripslashes(roadfighter_get_option('roadfighter_homepage_button')); ?></a>
                                <?php } else { ?>
                                <a href="<?php echo esc_url(roadfighter_get_option('roadfighter_homepage_button_link')); ?>"><?php _e('View Portfolio','road-fighter'); ?></a>
                            <?php } ?>  
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<?php get_footer(); ?>
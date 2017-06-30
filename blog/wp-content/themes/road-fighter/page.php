<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query. 
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 */
?>
<?php get_header(); ?>
<div class="page_heading_container">
    <div class="container_24">
        <div class="grid_24">
            <div class="page_heading_content">
                <?php roadfighter_breadcrumbs(); ?>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="page-container">
    <div class="container_24">
        <div class="grid_24">
            <div class="page-content">
                <div class="grid_17 alpha">
                    <div class="content-bar">   
                        <h1><?php the_title(); ?></h1>
                        <?php if (have_posts()) : the_post(); ?>
                            <?php the_content(); ?>
                            <div class="clear"></div>
                            <?php wp_link_pages(array('before' => '<div class="page-link"><span>' . __('Pages:', 'road-fighter') . '</span>', 'after' => '</div>')); ?>
                        <?php endif; ?>
                    </div>
                    <!--Start Comment box-->
                    <?php comments_template(); ?>
                    <!--End Comment box-->	
                </div>
            <div class="grid_7 omega">
                <!--Start Sidebar-->
                <?php get_sidebar(); ?>
                <!--End Sidebar-->
            </div>
        </div>
    </div>
	    <div class="clear"></div>
	</div>
</div>
<?php get_footer(); ?>
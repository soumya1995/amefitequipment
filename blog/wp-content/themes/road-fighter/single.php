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
                        <!-- Start the Loop. -->
                        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                                <!--Start post-->
                                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                                    <div class="post_thumbnail"><?php the_post_thumbnail(); ?></div>
                                    <div class="post_heading_wrapper">
                                        <h1 class="post_title"><?php the_title(); ?></h1>
                                        <div class="post_date">
                                            <ul class="date">
                                                <li class="day"><?php echo get_the_time('d') ?></li>
                                                <li class="month"><?php echo get_the_time('M') ?></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="post_content">
                                        <?php the_content(); ?></div>
                                    <ul class="post_meta">
                                        <li class="posted_by"><?php the_author_posts_link(); ?></li>
                                        <li class="post_category"><?php the_category(', '); ?></li>
                                        <?php if (has_tag()) { ?>
                       <li class="post_tag"><?php the_tags(__('Post Tagged with ', 'road-fighter')); ?></li>
                                        <?php } ?>
                                        <li class="post_comment"><?php comments_popup_link('No Comments.', '1 Comment.', '% Comments.'); ?></li>
                                    </ul>
                                    <div class="clear"></div>
                                </div>
                            <?php endwhile;
                        else:
                            ?>
                            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                                <p>
                            <?php _e('Sorry, no posts matched your criteria.', 'road-fighter'); ?>
                                </p>
                            </div>
                        <?php endif; ?>
                        <div class="clear"></div>
                        <?php wp_link_pages(array('before' => '<div class="clear"></div><div class="page-link"><span>' . __('Pages:', 'road-fighter') . '</span>', 'after' => '</div>')); ?>
                        <!--Start Comment box-->
                        <?php comments_template(); ?>
                        <!--End Comment box-->
                        <div class="clear"></div>
                        <nav id="nav-single"> <span class="nav-previous">
                                <?php previous_post_link('%link', __('<span class="meta-nav">&larr;</span> Previous Post ', 'road-fighter')); ?>
                            </span> <span class="nav-next">
                        <?php next_post_link('%link', __('Next Post <span class="meta-nav">&rarr;</span>', 'road-fighter')); ?>
                            </span> </nav>
                        <!--End post-->
                    </div>
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
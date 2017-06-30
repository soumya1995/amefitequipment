<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 */
?>
<?php get_header(); ?>
<div class="page_heading_container">
    <div class="container_24">
        <div class="grid_24">
            <div class="page_heading_content">
                <p>
                    <?php if (is_day()) : ?>
                        <?php printf(__('Daily Archives: %s', 'road-fighter'), get_the_date()); ?>
                    <?php elseif (is_month()) : ?>
                        <?php printf(__('Monthly Archives: %s', 'road-fighter'), get_the_date('F Y')); ?>
                    <?php elseif (is_year()) : ?>
                        <?php printf(__('Yearly Archives: %s', 'road-fighter'), get_the_date('Y')); ?>
                    <?php else : ?>
                        <?php _e('Blog Archives', 'road-fighter'); ?>
                    <?php endif; ?>
                </p>
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
                        <?php if (have_posts()): ?>

                            <?php
                            /* Since we called the_post() above, we need to
                             * rewind the loop back to the beginning that way
                             * we can run the loop properly, in full.
                             */
                            rewind_posts();
                            /* Run the loop for the archives page to output the posts.
                             * If you want to overload this in a child theme then include a file
                             * called loop-archives.php and that will be used instead.
                             */
                            get_template_part('loop', 'archive');
                            ?>
                            <div class="clear"></div>
                            <nav id="nav-single"> <span class="nav-previous">
                                    <?php next_posts_link(__('&larr; Older posts', 'road-fighter')); ?>
                                </span> <span class="nav-next">
                                    <?php previous_posts_link(__('Newer posts &rarr;', 'road-fighter')); ?>
                                </span> </nav>
                        <?php endif; ?>
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
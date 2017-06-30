<!-- Start the Loop. -->
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <!--Start post-->
        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="post_heading_wrapper">
                <h1 class="post_title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
                <div class="post_date">
                    <ul class="date">
                        <li class="day"><?php echo get_the_time('d') ?></li>
                        <li class="month"><?php echo get_the_time('M') ?></li>
                    </ul>
                </div>
            </div>
            <div class="post_content">
                <?php if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail())) { ?>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail(); ?>
                    </a>
                    <?php
                } else {
                    echo roadfighter_main_image();
                }
                ?>			  
                <?php the_excerpt(); ?>
                <a class="read_more" href="<?php the_permalink() ?>"><?php _e('Continue Reading...','road-fighter'); ?></a></div>
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
<!--End post-->
<?php

function roadfighter_setup() {
    add_theme_support('post-thumbnails');
    add_image_size('post_thumbnail_1', 595, 224, false);
    add_theme_support('automatic-feed-links');
    add_theme_support( "title-tag" );
    //Load languages file
    load_theme_textdomain('road-fighter', get_template_directory() . '/languages');
    // This theme styles the visual editor with editor-style.css to match the theme style.
    add_editor_style();
    //Add Custom background support
    add_theme_support('custom-background', array(
        // Background color default
        'default-color' => '',
        // Background image default
        'default-image' => get_template_directory_uri() . '/images/bg.png'
    ));
}

add_action('after_setup_theme', 'roadfighter_setup');
/* ----------------------------------------------------------------------------------- */
/* Custom Menus Function
  /*----------------------------------------------------------------------------------- */

// Add CLASS attributes to the first <ul> occurence in wp_page_menu
function roadfighter_add_menuclass($ulclass) {
    return preg_replace('/<ul>/', '<ul class="ddsmoothmenu">', $ulclass, 1);
}

add_filter('wp_page_menu', 'roadfighter_add_menuclass');
add_action('after_setup_theme', 'roadfighter_register_custom_menu');

function roadfighter_register_custom_menu() {
    register_nav_menu('custom_menu', __('Main Menu', 'road-fighter'));
}

function roadfighter_nav() {
    if (function_exists('wp_nav_menu'))
        wp_nav_menu(array('theme_location' => 'custom_menu', 'container_id' => 'menu', 'menu_class' => 'ddsmoothmenu', 'fallback_cb' => 'roadfighter_nav_fallback'));
    else
        roadfighter_nav_fallback();
}

function roadfighter_nav_fallback() {
    ?>
    <div id="menu">
        <ul class="ddsmoothmenu">
            <?php
            wp_list_pages('title_li=&show_home=1&sort_column=menu_order');
            ?>
        </ul>
    </div>
    <?php
}

function roadfighter_nav_menu_items($items) {
    if (is_home()) {
        $homelink = '<li class="current_page_item">' . '<a href="' . esc_url(home_url('/')) . '">' . __('Home', 'road-fighter') . '</a></li>';
    } else {
        $homelink = '<li>' . '<a href="' . esc_url(home_url('/')) . '">' . __('Home', 'road-fighter') . '</a></li>';
    }
    $items = $homelink . $items;
    return $items;
}

add_filter('wp_list_pages', 'roadfighter_nav_menu_items');
/* ----------------------------------------------------------------------------------- */
/* Breadcrumbs Plugin
  /*----------------------------------------------------------------------------------- */

function roadfighter_breadcrumbs() {
$delimiter = '&raquo;';
    $home = __( 'Home', 'road-fighter' ); // text for the 'Home' link
    $before = '<span class="current">'; // tag before the current crumb
    $after = '</span>'; // tag after the current crumb
    echo '<div id="crumbs">';
    global $post;
    $homeLink = esc_url( home_url() );
    echo '<a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
    if ( is_category() ) {
            global $wp_query;
            $cat_obj = $wp_query->get_queried_object();
            $thisCat = $cat_obj->term_id;
            $thisCat = get_category( $thisCat );
            $parentCat = get_category( $thisCat->parent );
            if ( $thisCat->parent != 0 )
                    echo(get_category_parents( $parentCat, TRUE, ' ' . $delimiter . ' ' ));
            echo $before . __( 'Archive by category', 'road-fighter') . ' "' . single_cat_title( '', false ) . '"' . $after;
    }
    elseif ( is_day() ) {
            echo '<a href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '">' . get_the_time( 'Y' ) . '</a> ' . $delimiter . ' ';
            echo '<a href="' . esc_url( get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) ) . '">' . get_the_time( 'F' ) . '</a> ' . $delimiter . ' ';
            echo $before . get_the_time( 'd' ) . $after;
    } elseif ( is_month() ) {
            echo '<a href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '">' . get_the_time( 'Y' ) . '</a> ' . $delimiter . ' ';
            echo $before . get_the_time( 'F' ) . $after;
    } elseif ( is_year() ) {
            echo $before . get_the_time( 'Y' ) . $after;
    } elseif ( is_single() && !is_attachment() ) {
            if ( get_post_type() != 'post' ) {
                    $post_type = get_post_type_object( get_post_type() );
                    $slug = $post_type->rewrite;
                    echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
                    echo $before . get_the_title() . $after;
            } else {
                    $cat = get_the_category();
                    $cat = $cat[0];
                    echo get_category_parents( $cat, TRUE, ' ' . $delimiter . ' ' );
                    echo $before . get_the_title() . $after;
            }
    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' ) {
            $post_type = get_post_type_object( get_post_type() );
            echo $before . $post_type->labels->singular_name . $after;
    } elseif ( is_attachment() ) {
            $parent = get_post( $post->post_parent );
            $cat = get_the_category( $parent->ID );
            $cat = $cat[0];
            echo get_category_parents( $cat, TRUE, ' ' . $delimiter . ' ' );
            echo '<a href="' . esc_url( get_permalink( $parent ) ) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
            echo $before . get_the_title() . $after;
    } elseif ( is_page() && !$post->post_parent ) {
            echo $before . get_the_title() . $after;
    } elseif ( is_page() && $post->post_parent ) {
            $parent_id = $post->post_parent;
            $breadcrumbs = array();
            while ( $parent_id ) {
                    $page = get_page( $parent_id );
                    $breadcrumbs[] = '<a href="' . esc_url( get_permalink( $page->ID ) ) . '">' . get_the_title( $page->ID ) . '</a>';
                    $parent_id = $page->post_parent;
            }
            $breadcrumbs = array_reverse( $breadcrumbs );
            foreach ( $breadcrumbs as $crumb )
                    echo $crumb . ' ' . $delimiter . ' ';
            echo $before . get_the_title() . $after;
    } elseif ( is_search() ) {
            echo $before . __( 'Search results for', 'road-fighter' ) . ' "' . get_search_query() . '"' . $after;
    } elseif ( is_tag() ) {
            echo $before . __( 'Posts tagged ', 'road-fighter' ) . '"' . single_tag_title( '', false ) . '"' . $after;
    } elseif ( is_author() ) {
            global $author;
            $userdata = get_userdata( $author );
            echo $before . __( 'Articles posted by ', 'road-fighter' ) . $userdata->display_name . $after;
    } elseif ( is_404() ) {
            echo $before . __( 'Error 404', 'road-fighter' ) . $after;
    }
    if ( get_query_var( 'paged' ) ) {
            if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() )
                    echo ' (';
            echo __( 'Page', 'road-fighter' ) . ' ' . get_query_var( 'paged' );
            if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() )
                    echo ')';
    }
    echo '</div>';
}

//For Attachment Page
/**
 * Prints HTML with meta information for the current post (category, tags and permalink).
 *
 */
function roadfighter_posted_in() {
// Retrieves tag list of current post, separated by commas.
    $tag_list = get_the_tag_list('', ', ');
    if ($tag_list) {
        $posted_in = __('This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'road-fighter');
    } elseif (is_object_in_taxonomy(get_post_type(), 'category')) {
        $posted_in = __('This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'road-fighter');
    } else {
        $posted_in = __('Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'road-fighter');
    }
// Prints the string, replacing the placeholders.
    printf(
            $posted_in, get_the_category_list(', '), $tag_list, get_permalink(), the_title_attribute('echo=0')
    );
}
?>
<?php
/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * Used to set the width of images and content. Should be equal to the width the theme
 * is designed for, generally via the style.css stylesheet.
 */
if (!isset($content_width))
    $content_width = 590;
?>
<?php

/**
 * Register widgetized areas, including two sidebars and four widget-ready columns in the footer.
 *
 * To override twentyten_widgets_init() in a child theme, remove the action hook and add your own
 * function tied to the init hook.
 *
 * @uses register_sidebar
 */
function roadfighter_widgets_init() {
// Area 1, located at the top of the sidebar.
    register_sidebar(array(
        'name' => __('Primary Widget Area', 'road-fighter'),
        'id' => 'primary-widget-area',
        'description' => __('The primary widget area', 'road-fighter'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));
// Area 2, located below the Primary Widget Area in the sidebar. Empty by default.
    register_sidebar(array(
        'name' => __('Secondary Widget Area', 'road-fighter'),
        'id' => 'secondary-widget-area',
        'description' => __('The secondary widget area', 'road-fighter'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));
    // Area 3, located in the footer. Empty by default.
    register_sidebar(array(
        'name' => __('First Footer Widget Area', 'road-fighter'),
        'id' => 'first-footer-widget-area',
        'description' => __('The first footer widget area', 'road-fighter'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
    ));
    // Area 4, located in the footer. Empty by default.
    register_sidebar(array(
        'name' => __('Second Footer Widget Area', 'road-fighter'),
        'id' => 'second-footer-widget-area',
        'description' => __('The second footer widget area', 'road-fighter'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
    ));
    // Area 5, located in the footer. Empty by default.
    register_sidebar(array(
        'name' => __('Third Footer Widget Area', 'road-fighter'),
        'id' => 'third-footer-widget-area',
        'description' => __('The third footer widget area', 'road-fighter'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
    ));
    // Area 6, located in the footer. Empty by default.
    register_sidebar(array(
        'name' => __('Fourth Footer Widget Area', 'road-fighter'),
        'id' => 'fourth-footer-widget-area',
        'description' => __('The fourth footer widget area', 'road-fighter'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
    ));
}

/** Register sidebars by running roadfighter_widgets_init() on the widgets_init hook. */
add_action('widgets_init', 'roadfighter_widgets_init');
?>
<?php

/**
 * Pagination
 *
 */
function roadfighter_pagination($pages = '', $range = 2) {
    $showitems = ($range * 2) + 1;
    global $paged;
    if (empty($paged))
        $paged = 1;
    if ($pages == '') {
        global $wp_query;
        $pages = $wp_query->max_num_pages;
        if (!$pages) {
            $pages = 1;
        }
    }
    if (1 != $pages) {
        echo "<ul class='paging'>";
        if ($paged > 2 && $paged > $range + 1 && $showitems < $pages)
            echo "<li><a href='" . get_pagenum_link(1) . "'>&laquo;</a></li>";
        if ($paged > 1 && $showitems < $pages)
            echo "<li><a href='" . get_pagenum_link($paged - 1) . "'>&lsaquo;</a></li>";
        for ($i = 1; $i <= $pages; $i++) {
            if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems )) {
                echo ($paged == $i) ? "<li><a href='" . get_pagenum_link($i) . "' class='current' >" . $i . "</a></li>" : "<li><a href='" . get_pagenum_link($i) . "' class='inactive' >" . $i . "</a></li>";
            }
        }
        if ($paged < $pages && $showitems < $pages)
            echo "<li><a href='" . get_pagenum_link($paged + 1) . "'>&rsaquo;</a></li>";
        if ($paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages)
            echo "<li><a href='" . get_pagenum_link($pages) . "'>&raquo;</a></li>";
        echo "</ul>\n";
    }
}
?>
<?php

/////////Theme Options
/* ----------------------------------------------------------------------------------- */
/* Add Favicon
  /*----------------------------------------------------------------------------------- */
function roadfighter_childtheme_favicon() {
    if (roadfighter_get_option('roadfighter_favicon') != '') {
        echo '<link rel="shortcut icon" href="' . roadfighter_get_option('roadfighter_favicon') . '"/>' . "\n";
    } else {
        ?>
        <link rel="shortcut icon" href="<?php echo get_template_directory_uri() ?>/images/favicon.ico" />
        <?php
    }
}

add_action('wp_head', 'roadfighter_childtheme_favicon');
/* ----------------------------------------------------------------------------------- */
/* Show analytics code in footer */
/* ----------------------------------------------------------------------------------- */

function roadfighter_childtheme_analytics() {
    $output = roadfighter_get_option('roadfighter_analytics');
    if ($output <> "")
        echo stripslashes($output);
}

add_action('wp_head', 'roadfighter_childtheme_analytics');
/* ----------------------------------------------------------------------------------- */
/* Custom CSS Styles */
/* ----------------------------------------------------------------------------------- */

function roadfighter_of_head_css() {
    $output = '';
    $custom_css = roadfighter_get_option('roadfighter_customcss');
    if ($custom_css <> '') {
        $output .= $custom_css . "\n";
    }
// Output styles
    if ($output <> '') {
        $output = "<!-- Custom Styling -->\n<style type=\"text/css\">\n" . $output . "</style>\n";
        echo $output;
    }
}

add_action('wp_head', 'roadfighter_of_head_css');

// activate support for thumbnails
function roadfighter_category_id($cat_name) {
    $term = get_term_by('name', $cat_name, 'category');
    return $term->term_id;
}

/* ----------------------------------------------------------------------------------- */
/* Function to call first uploaded image in functions file
  /*----------------------------------------------------------------------------------- */

function roadfighter_main_image() {
    global $post, $posts;
    //This is required to set to Null
    $id = '';
    $the_title = '';
    // Till Here
    $permalink = get_permalink($id);
    $homeLink = get_template_directory_uri();
    $first_img = '';
    ob_start();
    ob_end_clean();
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
    if (isset($matches [1] [0])) {
        $first_img = $matches [1] [0];
    }
    if (empty($first_img)) { //Defines a default image  
    } else {
        print "<a href='$permalink'><img src='$first_img' width='250px' height='160px' class='postimg wp-post-image' alt='$the_title' /></a>";
    }
}
/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 */
function roadfighter_wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() )
		return $title;

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $sep $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $sep " . sprintf( __( 'Page %s', 'road-fighter' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'roadfighter_wp_title', 10, 2 );

?>
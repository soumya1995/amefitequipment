<div class="grid_6 alpha">
    <div class="footer_widget first">
        <?php if (is_active_sidebar('first-footer-widget-area')) : ?>
            <?php dynamic_sidebar('first-footer-widget-area'); ?>
        <?php else : ?>
            <h4><?php _e('Footer Widgets', 'road-fighter'); ?></h4>
            <div class="textwidget"><?php _e('Footer is widgetized. To setup the footer, drag the required Widgets in Appearance -> Widgets Tab in the First, Second, Third and Fourth Footer Widget Areas.', 'road-fighter'); ?></div>
        <?php endif; ?>
    </div>
</div>
<div class="grid_6">
    <div class="footer_widget">
        <?php if (is_active_sidebar('second-footer-widget-area')) : ?>
            <?php dynamic_sidebar('second-footer-widget-area'); ?>
        <?php else : ?> 
            <h4><?php _e('Latest Posts', 'road-fighter'); ?></h4>
            <ul>
                <li><a href="#"><?php _e('Entertainment', 'road-fighter'); ?></a></li>
                <li><a href="#"><?php _e('Following problems', 'road-fighter'); ?></a></li>
                <li><a href="#"><?php _e('FAQ', 'road-fighter'); ?></a></li>
                <li><a href="#"><?php _e('Music And Sports', 'road-fighter'); ?></a></li>
            </ul>
        <?php endif; ?> 
    </div>
</div>
<div class="grid_6">
    <div class="footer_widget">
        <?php if (is_active_sidebar('third-footer-widget-area')) : ?>
            <?php dynamic_sidebar('third-footer-widget-area'); ?>
        <?php else : ?>
            <h4><?php _e('Search Anything', 'road-fighter'); ?></h4>
            <div class="textwidget">
                <?php _e('Address: Magnet Brains 10 No. Arera Colony, Bhopal India<br/>Contact No : +91-9926465653<br/>     
                Email : support@inkthemes.com', 'road-fighter'); ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<div class="grid_6 omega">
    <div class="footer_widget last">
        <?php if (is_active_sidebar('fourth-footer-widget-area')) : ?>
            <?php dynamic_sidebar('fourth-footer-widget-area'); ?>
        <?php else : ?>
            <h4><?php _e('Search Widget','road-fighter');?></h4>
            <div class="textwidget"><?php _e('You can simply put the search widget here in order to allow the users to search their own content.','road-fighter');?></div>
            <form role="search" method="get" class="searchform" action="#">
                <div>
                    <input type="text" onfocus="if (this.value == 'Search') {
                                this.value = '';
                            }" onblur="if (this.value == '') {
                                        this.value = 'Search';
                                    }" value="Search" name="s" id="s">
                    <input type="submit" id="searchsubmit" value="">
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>
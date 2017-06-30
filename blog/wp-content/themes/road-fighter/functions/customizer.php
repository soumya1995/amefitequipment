<?php
class RoadFighter_Customizer {
    public static function RoadFighter_Register($wp_customize) {
        self::RoadFighter_Sections($wp_customize);
        self::RoadFighter_Controls($wp_customize);
    }
    public static function RoadFighter_Sections($wp_customize) {
        /**
         * General Section
         */
        $wp_customize->add_section('general_setting_section', array(
            'title' => __('General Settings', 'road-fighter'),
            'description' => __('Allows you to customize header logo, favicon, background etc settings for RoadFighter Theme.', 'road-fighter'), //Descriptive tooltip
            'panel' => '',
            'priority' => '10',
            'capability' => 'edit_theme_options'
            )
        );
        /**
         * Home Page Top Feature Area
         */
        $wp_customize->add_section('home_top_feature_area', array(
            'title' => __('Top Feature Area', 'road-fighter'),
            'description' => __('Allows you to setup Top feature area section for RoadFighter Theme.', 'road-fighter'), //Descriptive tooltip
            'panel' => '',
            'priority' => '11',
            'capability' => 'edit_theme_options'
                )
        );
        /**
         * Add panel for home page feature area
         */
        $wp_customize->add_panel('home_page_feature_area_panel', array(
            'title' => __('Home Page Feature Area', 'road-fighter'),
            'description' => __('Allows you to setup home page feature area section for RoadFighter Theme.', 'road-fighter'),
            'priority' => '12',
            'capability' => 'edit_theme_options'
        ));
        /**
         * Home Page Main Headings
         */
        $wp_customize->add_section('home_feature_main_headings', array(
            'title' => __('Home Page Headings', 'road-fighter'),
            'description' => __('Allows you to setup home page headings section for RoadFighter Theme.', 'road-fighter'),
            'panel' => 'home_page_feature_area_panel',
            'priority' => '',
            'capability' => 'edit_theme_options'
                )
        );
        /**
         * Home Page feature area 1
         */
        $wp_customize->add_section('home_feature_area_section1', array(
            'title' => __('First Feature Area', 'road-fighter'),
            'description' => __('Allows you to setup first feature area section for RoadFighter Theme.', 'road-fighter'),
            'panel' => 'home_page_feature_area_panel',
            'priority' => '',
            'capability' => 'edit_theme_options'
                )
        );
        /**
         * Home Page feature area 2
         */
        $wp_customize->add_section('home_feature_area_section2', array(
            'title' => __('Second Feature Area', 'road-fighter'),
            'description' => __('Allows you to setup second feature area section for RoadFighter Theme.', 'road-fighter'),
            'panel' => 'home_page_feature_area_panel',
            'priority' => '',
            'capability' => 'edit_theme_options'
                )
        );

        /**
         * Home Page feature area 3
         */
        $wp_customize->add_section('home_feature_area_section3', array(
            'title' => __('Third Feature Area', 'road-fighter'),
            'description' => __('Allows you to setup third feature area section for RoadFighter Theme.', 'road-fighter'),
            'panel' => 'home_page_feature_area_panel',
            'priority' => '',
            'capability' => 'edit_theme_options'
                )
        );
        /**
         * Home Page Feature area setting
         */
        $wp_customize->add_section('home_page_taglines', array(
            'title' => __('Home Page Taglines', 'road-fighter'),
            'description' => __('Allows you to setup Home Page Taglines Bottom Section for RoadFighter Theme.', 'road-fighter'),
            'panel' => 'home_page_feature_area_panel',
            'priority' => '',
            'capability' => 'edit_theme_options'
             )
        );
        /**
         * Style Section
         */
        $wp_customize->add_section('style_section', array(
            'title' => __('Style Setting', 'road-fighter'),
            'description' => __('Allows you to setup Top Footer Section Text for RoadFighter Theme.', 'road-fighter'),
            'panel' => '',
            'priority' => '13',
            'capability' => 'edit_theme_options'
                )
        );
    }
    public static function RoadFighter_Section_Content() {
        $section_content = array(
            'general_setting_section' => array(
                'roadfighter_logo',
                'roadfighter_favicon',
                'roadfighter_topright',
                'roadfighter_contact_number',
                'roadfighter_analytics'
            ),
            'home_top_feature_area' => array(
                'roadfighter_slideimage1',
                'roadfighter_sliderheading1',
                'roadfighter_Sliderlink1',
                'roadfighter_sliderdes1',
                'roadfighter_slider_button1'
            ),
            'home_feature_main_headings' => array(
                 'roadfighter_page_main_heading',
                 'roadfighter_page_sub_heading'
            ),
            'home_feature_area_section1' => array(
                'roadfighter_headline1',
                'roadfighter_fimg1',
                'roadfighter_feature1',
                'roadfighter_link1'
            ),
            'home_feature_area_section2' => array(
                'roadfighter_headline2',
                'roadfighter_fimg2',
                'roadfighter_feature2',
                'roadfighter_link2'
            ),
            'home_feature_area_section3' => array(
                'roadfighter_headline3',
                'roadfighter_fimg3',
                'roadfighter_feature3',
                'roadfighter_link3'
            ),
            'home_page_taglines' => array(
                'roadfighter_tag_head',
                'roadfighter_homepage_button',
                'roadfighter_homepage_button_link'
            ),
             'style_section' => array(
                'roadfighter_customcss'
            )
        );
        return $section_content;
    }

    public static function RoadFighter_Settings() {

        $roadfighter_settings = array(
            'roadfighter_logo' => array(
                'id' => 'roadfighter_options[roadfighter_logo]',
                'label' => __('Custom Logo', 'road-fighter'),
                'description' => __('Upload a logo for your Website. The recommended size for the logo is 200px width x 50px height.', 'road-fighter'),
                'type' => 'option',
                'setting_type' => 'image',
                'default' => get_template_directory_uri() . '/images/logo.png'
            ),
            'roadfighter_favicon' => array(
                'id' => 'roadfighter_options[roadfighter_favicon]',
                'label' => __('Custom Favicon', 'road-fighter'),
                'description' => __('Here you can upload a Favicon for your Website. Specified size is 16px x 16px.', 'road-fighter'),
                'type' => 'option',
                'setting_type' => 'image',
                'default' => ''
            ),     
            'roadfighter_topright' => array(
                'id' => 'roadfighter_options[roadfighter_topright]',
                'label' => __('Top Right Contact Details', 'road-fighter'),
                'description' => __('Mention the contact details here which will be displayed on the top right corner of Website.', 'road-fighter'),
                'type' => 'option',
                'setting_type' => 'text',
                'default' => __('For Reservation Call : 1.888.222.5847', 'road-fighter')
            ),
            'roadfighter_contact_number' => array(
                'id' => 'roadfighter_options[roadfighter_contact_number]',
                'label' => __('Contact Number For Tap To Call Feature', 'road-fighter'),
                'description' => __('Mention your contact number here through which users can interact to you directly. This feature is called tap to call and this will work when the user will access your website through mobile phones or iPhone.', 'road-fighter'),
                'type' => 'option',
                'setting_type' => 'text',
                'default' => __('5551234567', 'road-fighter')
            ),
            'roadfighter_analytics' => array(
                'id' => 'roadfighter_options[roadfighter_analytics]',
                'label' => __('Tracking Code', 'road-fighter'),
                'description' => __('Paste your Google Analytics (or other) tracking code here.', 'road-fighter'),
                'type' => 'option',
                'setting_type' => 'textarea',
                'default' => ''
            ),
            'roadfighter_slideimage1' => array(
                'id' => 'roadfighter_options[roadfighter_slideimage1]',
                'label' => __('Top Feature Image', 'road-fighter'),
                'description' => __('The optimal size of the image is 1920 px wide x 860 px height, but it can be varied as per your requirement.', 'road-fighter'),
                'type' => 'option',
                'setting_type' => 'image',
                'default' => get_template_directory_uri() . '/images/slider1.jpg'
            ),
            'roadfighter_sliderheading1' => array(
                'id' => 'roadfighter_options[roadfighter_sliderheading1]',
                'label' => __('Top Feature Heading', 'road-fighter'),
                'description' => __('Mention the heading for the Top Feature.', 'road-fighter'),
                'type' => 'option',
                'setting_type' => 'textarea',
                'default' => __('Premium WordPress Themes with Single Click Installation', 'road-fighter')
            ),
            'roadfighter_Sliderlink1' => array(
                'id' => 'roadfighter_options[roadfighter_Sliderlink1]',
                'label' => __('Link for Top Feature Image', 'road-fighter'),
                'description' => __('Mention the URL for first image.', 'road-fighter'),
                'type' => 'option',
                'setting_type' => 'link',
                'default' => '#'
            ),
            'roadfighter_sliderdes1' => array(
                'id' => 'roadfighter_options[roadfighter_sliderdes1]',
                'label' => __('Top Feature Description', 'road-fighter'),
                'description' => __('Here mention a short description for the Top Feature heading.', 'road-fighter'),
                'type' => 'option',
                'setting_type' => 'textarea',
                'default' => __('Premium WordPress Themes with Single Click Installation, Just a Click and your website is ready for use.Premium WordPress Themes.', 'road-fighter')
            ),
            'roadfighter_slider_button1' => array(
                'id' => 'roadfighter_options[roadfighter_slider_button1]',
                'label' => __('Link Text for Top Feature', 'road-fighter'),
                'description' => __('Mention the link text for top Feature Image', 'road-fighter'),
                'type' => 'option',
                'setting_type' => 'text',
                'default' => __('Read More', 'road-fighter')
            ),
            // Home Page Main Headings
            'roadfighter_page_main_heading' => array(
                'id' => 'roadfighter_options[roadfighter_page_main_heading]',
                'label' => __('Home Page Main Heading', 'road-fighter'),
                'description' => __('Mention the punch line for your business here.', 'road-fighter'),
                'type' => 'option',
                'setting_type' => 'textarea',
                'default' => __('Premium WordPress Themes with Single Click Installation.', 'road-fighter')
            ),
            'roadfighter_page_sub_heading' => array(
                'id' => 'roadfighter_options[roadfighter_page_sub_heading]',
                'label' => __('Home Page Sub Heading', 'road-fighter'),
                'description' => __('Mention the Sub heading for your business here that will complement the punch line.', 'road-fighter'),
                'type' => 'option',
                'setting_type' => 'textarea',
                'default' => __('Just a Click and your website is ready for use. Your Site is faster to built, easy to use & Search Engine Optimized.', 'road-fighter')
            ), 
            // First Feature Box
            'roadfighter_fimg1' => array(
                'id' => 'roadfighter_options[roadfighter_fimg1]',
                'label' => __('First Feature Image', 'road-fighter'),
                'description' => __('Choose image for your first Feature area. Optimal size 313px x 172px', 'road-fighter'),
                'type' => 'option',
                'setting_type' => 'image',
                'default' => get_template_directory_uri() . '/images/1.jpg'
            ),
            'roadfighter_headline1' => array(
                'id' => 'roadfighter_options[roadfighter_headline1]',
                'label' => __('First Feature Heading', 'road-fighter'),
                'description' => __('Mention the heading for First Feature Box that will showcase your business services.', 'road-fighter'),
                'type' => 'option',
                'setting_type' => 'textarea',
                'default' => __('Bring More Traffic To Website', 'road-fighter')
            ),       
            'roadfighter_feature1' => array(
                'id' => 'roadfighter_options[roadfighter_feature1]',
                'label' => __('First Feature Description', 'road-fighter'),
                'description' => __('Write short description for your First Feature Box.', 'road-fighter'),
                'type' => 'option',
                'setting_type' => 'textarea',
                'default' => __('Facebook Like button and Like box Plugins Nowadays website builder wants to bring more visitors.', 'road-fighter')
            ),
            'roadfighter_link1' => array(
                'id' => 'roadfighter_options[roadfighter_link1]',
                'label' => __('First feature Link', 'road-fighter'),
                'description' => __('Enter your text for First feature Link.', 'road-fighter'),
                'type' => 'option',
                'setting_type' => 'link',
                'default' => '#'
            ),
            // Second Feature Box
            'roadfighter_fimg2' => array(
                'id' => 'roadfighter_options[roadfighter_fimg2]',
                'label' => __('Second Feature Image', 'road-fighter'),
                'description' => __('Choose image for your Second Feature area. Optimal size 313px x 172px', 'road-fighter'),
                'type' => 'option',
                'setting_type' => 'image',
                'default' => get_template_directory_uri() . '/images/2.jpg'
            ),
            'roadfighter_headline2' => array(
                'id' => 'roadfighter_options[roadfighter_headline2]',
                'label' => __('Second Feature Heading', 'road-fighter'),
                'description' => __('Mention the heading for Second Feature Box that will showcase your business services.', 'road-fighter'),
                'type' => 'option',
                'setting_type' => 'textarea',
                'default' => __('Bring More Traffic To Website', 'road-fighter')
            ),       
            'roadfighter_feature2' => array(
                'id' => 'roadfighter_options[roadfighter_feature2]',
                'label' => __('Second Feature Description', 'road-fighter'),
                'description' => __('Write short description for your Second Feature Box.', 'road-fighter'),
                'type' => 'option',
                'setting_type' => 'textarea',
                'default' => __('Facebook Like button and Like box Plugins Nowadays website builder wants to bring more visitors.', 'road-fighter')
            ),
            'roadfighter_link2' => array(
                'id' => 'roadfighter_options[roadfighter_link2]',
                'label' => __('Second feature Link', 'road-fighter'),
                'description' => __('Enter your text for Second feature Link.', 'road-fighter'),
                'type' => 'option',
                'setting_type' => 'link',
                'default' => '#'
            ),
             // Third Feature Box
            'roadfighter_fimg3' => array(
                'id' => 'roadfighter_options[roadfighter_fimg3]',
                'label' => __('Third Feature Image', 'road-fighter'),
                'description' => __('Choose image for your Third Feature area. Optimal size 313px x 172px', 'road-fighter'),
                'type' => 'option',
                'setting_type' => 'image',
                'default' => get_template_directory_uri() . '/images/3.jpg'
            ),
            'roadfighter_headline3' => array(
                'id' => 'roadfighter_options[roadfighter_headline3]',
                'label' => __('Third Feature Heading', 'road-fighter'),
                'description' => __('Mention the heading for Third Feature Box that will showcase your business services.', 'road-fighter'),
                'type' => 'option',
                'setting_type' => 'textarea',
                'default' => __('Bring More Traffic To Website', 'road-fighter')
            ),       
            'roadfighter_feature3' => array(
                'id' => 'roadfighter_options[roadfighter_feature3]',
                'label' => __('Third Feature Description', 'road-fighter'),
                'description' => __('Write short description for your Third Feature Box.', 'road-fighter'),
                'type' => 'option',
                'setting_type' => 'textarea',
                'default' => __('Facebook Like button and Like box Plugins Nowadays website builder wants to bring more visitors.', 'road-fighter')
            ),
            'roadfighter_link3' => array(
                'id' => 'roadfighter_options[roadfighter_link3]',
                'label' => __('Third feature Link', 'road-fighter'),
                'description' => __('Enter your text for Third feature Link.', 'road-fighter'),
                'type' => 'option',
                'setting_type' => 'link',
                'default' => '#'
            ),
             'roadfighter_tag_head' => array(
                'id' => 'roadfighter_options[roadfighter_tag_head]',
                'label' => __('Home Page Tagline', 'road-fighter'),
                'description' => __('Mention the text for home page tagline.', 'road-fighter'),
                'type' => 'option',
                'setting_type' => 'textarea',
                'default' => __('Any Important notice with a call to action button can come here.', 'road-fighter')
            ),
            'roadfighter_homepage_button' => array(
                'id' => 'roadfighter_options[roadfighter_homepage_button]',
                'label' => __('Home Page Button Text', 'road-fighter'),
                'description' => __('Mention the text for home page button.', 'road-fighter'),
                'type' => 'option',
                'setting_type' => 'textarea',
                'default' => __('View Portfolio', 'road-fighter')
            ),
            'roadfighter_homepage_button_link' => array(
                'id' => 'roadfighter_options[roadfighter_homepage_button_link]',
                'label' => __('Home Page Button Link', 'road-fighter'),
                'description' => __('Mention the text for home page button link.', 'road-fighter'),
                'type' => 'option',
                'setting_type' => 'link',
                'default' => '#'
            ),
            'roadfighter_customcss' => array(
                'id' => 'roadfighter_options[roadfighter_customcss]',
                'label' => __('Custom CSS', 'road-fighter'),
                'description' => __('Quickly add your custom CSS code to your theme by writing the code in this block.', 'road-fighter'),
                'type' => 'option',
                'setting_type' => 'textarea',
                'default' => ''
            )   
        );
        return $roadfighter_settings;
    }
    public static function RoadFighter_Controls($wp_customize) {
        $sections = self::RoadFighter_Section_Content();
        $settings = self::RoadFighter_Settings();
        foreach ($sections as $section_id => $section_content) {
            foreach ($section_content as $section_content_id) {
                switch ($settings[$section_content_id]['setting_type']) {
                    case 'image':
                        self::add_setting($wp_customize, $settings[$section_content_id]['id'], $settings[$section_content_id]['default'], $settings[$section_content_id]['type'], 'roadfighter_sanitize_url');
                        $wp_customize->add_control(new WP_Customize_Image_Control(
                                $wp_customize, $settings[$section_content_id]['id'], array(
                            'label' => $settings[$section_content_id]['label'],
                            'description' => $settings[$section_content_id]['description'],
                            'section' => $section_id,
                            'settings' => $settings[$section_content_id]['id']
                                )
                        ));
                        break;
                    case 'text':
                        self::add_setting($wp_customize, $settings[$section_content_id]['id'], $settings[$section_content_id]['default'], $settings[$section_content_id]['type'], 'roadfighter_sanitize_text');
                        $wp_customize->add_control(new WP_Customize_Control(
                                $wp_customize, $settings[$section_content_id]['id'], array(
                            'label' => $settings[$section_content_id]['label'],
                            'description' => $settings[$section_content_id]['description'],
                            'section' => $section_id,
                            'settings' => $settings[$section_content_id]['id'],
                            'type' => 'text'
                                )
                        ));
                        break;
                    case 'textarea':
                        self::add_setting($wp_customize, $settings[$section_content_id]['id'], $settings[$section_content_id]['default'], $settings[$section_content_id]['type'], 'roadfighter_sanitize_textarea');

                        $wp_customize->add_control(new WP_Customize_Control(
                                $wp_customize, $settings[$section_content_id]['id'], array(
                            'label' => $settings[$section_content_id]['label'],
                            'description' => $settings[$section_content_id]['description'],
                            'section' => $section_id,
                            'settings' => $settings[$section_content_id]['id'],
                            'type' => 'textarea'
                                )
                        ));
                        break;
                    case 'link':

                        self::add_setting($wp_customize, $settings[$section_content_id]['id'], $settings[$section_content_id]['default'], $settings[$section_content_id]['type'], 'roadfighter_sanitize_url');

                        $wp_customize->add_control(new WP_Customize_Control(
                                $wp_customize, $settings[$section_content_id]['id'], array(
                            'label' => $settings[$section_content_id]['label'],
                            'description' => $settings[$section_content_id]['description'],
                            'section' => $section_id,
                            'settings' => $settings[$section_content_id]['id'],
                            'type' => 'text'
                                )
                        ));

                        break;
                    default:
                        break;
                }
            }
        }
    }
    public static function add_setting($wp_customize, $setting_id, $default, $type, $sanitize_callback) {
        $wp_customize->add_setting($setting_id, array(
            'default' => $default,
            'capability' => 'edit_theme_options',
            'sanitize_callback' => array('RoadFighter_Customizer', $sanitize_callback),
            'type' => $type
                )
        );
    }
    /**
     * adds sanitization callback funtion : textarea
     * @package RoadFighter
     */
    public static function roadfighter_sanitize_textarea($value) {
        $value = esc_html($value);
        return $value;
    }
    /**
     * adds sanitization callback funtion : url
     * @package RoadFighter
     */
    public static function roadfighter_sanitize_url($value) {
        $value = esc_url($value);
        return $value;
    }
    /**
     * adds sanitization callback funtion : text
     * @package RoadFighter
     */
    public static function roadfighter_sanitize_text($value) {
        $value = sanitize_text_field($value);
        return $value;
    }

    /**
     * adds sanitization callback funtion : email
     * @package RoadFighter
     */
    public static function roadfighter_sanitize_email($value) {
        $value = sanitize_email($value);
        return $value;
    }

    /**
     * adds sanitization callback funtion : number
     * @package RoadFighter
     */
    public static function roadfighter_sanitize_number($value) {
        $value = preg_replace("/[^0-9+ ]/", "", $value);
        return $value;
    }

}
// Setup the Theme Customizer settings and controls...
add_action('customize_register', array('RoadFighter_Customizer', 'RoadFighter_Register'));
function inkthemes_registers() {
          wp_register_script( 'inkthemes_jquery_ui', '//code.jquery.com/ui/1.11.0/jquery-ui.js', array("jquery"), true  );
	wp_register_script( 'inkthemes_customizer_script', get_template_directory_uri() . '/js/inkthemes_customizer.js', array("jquery","inkthemes_jquery_ui"), true  );
	wp_enqueue_script( 'inkthemes_customizer_script' );
	wp_localize_script( 'inkthemes_customizer_script', 'ink_advert', array(
            'pro' => __('View PRO version','road-fighter'),
            'url' => esc_url('http://www.inkthemes.com/wp-themes/wordpress-theme-slider/'),
			'support_text' => __('Need Help!','road-fighter'),
			'support_url' => esc_url('http://www.inkthemes.com/lets-connect/')
            )
            );
}
add_action( 'customize_controls_enqueue_scripts', 'inkthemes_registers' );

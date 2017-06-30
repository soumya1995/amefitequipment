<?php
/**
 * SKT Yogi Theme Customizer
 *
 * @package SKT Yogi
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function skt_yogi_lite_customize_register( $wp_customize ) {
	
	//Add a class for titles
    class skt_yogi_lite_Info extends WP_Customize_Control {
        public $type = 'info';
        public $label = '';
        public function render_content() {
        ?>
			<h3 style="text-decoration: underline; color: #DA4141; text-transform: uppercase;"><?php echo esc_html( $this->label ); ?></h3>
        <?php
        }
    }
	
	class WP_Customize_Textarea_Control extends WP_Customize_Control {
    public $type = 'textarea';
 
    public function render_content() {
        ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
            </label>
        <?php
    }
}
	
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->remove_control('header_textcolor');
	$wp_customize->remove_control('display_header_text');
	
	$wp_customize->add_section(
        'logo_sec',
        array(
            'title' => __('Logo (PRO Version)', 'skt-yogi-lite'),
            'priority' => 1,
            'description' => sprintf( __( 'Logo Settings available in %s.', 'skt-yogi-lite' ), sprintf( '<a href="%1$s" target="_blank">%2$s</a>', esc_url( '"'.SKT_PRO_THEME_URL.'"' ), __( 'PRO Version', 'skt-yogi-lite' ))),			
        )
    );  
    $wp_customize->add_setting('skt_yogi_lite_options[logo-info]',array(
            'type' => 'info_control',
            'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
        )
    );
    $wp_customize->add_control( new skt_yogi_lite_Info( $wp_customize, 'logo_section', array(
        'section' => 'logo_sec',
        'settings' => 'skt_yogi_lite_options[logo-info]',
        'priority' => null
        ) )
    );
	$wp_customize->add_setting('color_scheme',array(
			'default'	=> '#55deef',
			'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control(
		new WP_Customize_Color_Control($wp_customize,'color_scheme',array(
			'label' => __('Color Scheme','skt-yogi-lite'),			
			 'description' => sprintf( __( 'More color options in %s.', 'skt-yogi-lite' ), sprintf( '<a href="%1$s" target="_blank">%2$s</a>', esc_url( '"'.SKT_PRO_THEME_URL.'"' ), __( 'PRO Version', 'skt-yogi-lite' ))),			
			'section' => 'colors',
			'settings' => 'color_scheme'
		))
	);

	
	
// Home Three Boxes Section 	
	$wp_customize->add_section('section_second', array(
		'title'	=> __('Homepage Three Boxes Section','skt-yogi-lite'),
		'description'	=> __('Select Pages from the dropdown for homepage three boxes section','skt-yogi-lite'),
		'priority'	=> null
	));	
	
	
	$wp_customize->add_setting('page-column1',	array(
			'sanitize_callback' => 'skt_yogi_lite_sanitize_integer',
		));
 
	$wp_customize->add_control(	'page-column1',array('type' => 'dropdown-pages',
			'label' => __('','skt-yogi-lite'),
			'section' => 'section_second',
	));	
	
	
	$wp_customize->add_setting('page-column2',	array(
			'sanitize_callback' => 'skt_yogi_lite_sanitize_integer',
		));
 
	$wp_customize->add_control(	'page-column2',array('type' => 'dropdown-pages',
			'label' => __('','skt-yogi-lite'),
			'section' => 'section_second',
	));
	
	$wp_customize->add_setting('page-column3',	array(
			'sanitize_callback' => 'skt_yogi_lite_sanitize_integer',
		));
 
	$wp_customize->add_control(	'page-column3',array('type' => 'dropdown-pages',
			'label' => __('','skt-yogi-lite'),
			'section' => 'section_second',
	));	
	
	
		// Home Welcome Section 	
	$wp_customize->add_section('section_first',array(
		'title'	=> __('Homepage Welcome Section','skt-yogi-lite'),
		'description'	=> __('Select Page from the dropdown for first section','skt-yogi-lite'),
		'priority'	=> null
	));
	
	$wp_customize->add_setting('page-setting1',	array(
			'sanitize_callback' => 'skt_yogi_lite_sanitize_integer',
		));
 
	$wp_customize->add_control(	'page-setting1',array('type' => 'dropdown-pages',
			'label' => __('','skt-yogi-lite'),
			'section' => 'section_first',
	));
	
	$wp_customize->add_setting('moreinfo_link',array(
			'default'	=> '#',
			'sanitize_callback'	=> 'esc_url_raw'
	));
	
	$wp_customize->add_control('moreinfo_link',array(
			'label'	=> __('Add link more info button for welcome section','skt-yogi-lite'),
			'section'	=> 'section_first',
			'setting'	=> 'moreinfo_link'
	));		

	
	$wp_customize->add_section('slider_section',array(
		'title'	=> __('Slider Settings','skt-yogi-lite'),
		 'description' => sprintf( __( 'Add slider images here. <br><strong>More slider settings available in %s.', 'skt-yogi-lite' ), sprintf( '<a href="%1$s" target="_blank">%2$s</a>', esc_url( '"'.SKT_PRO_THEME_URL.'"' ), __( 'PRO Version', 'skt-yogi-lite' ))),			
		'priority'		=> null
	));	
	// Slide Image 1
	$wp_customize->add_setting('slide_image1',array(
		'default'	=> get_template_directory_uri().'/images/slides/slider1.jpg',
		'sanitize_callback'	=> 'esc_url_raw',
	));
	$wp_customize->add_control(   new WP_Customize_Image_Control( $wp_customize, 'slide_image1', array(
            'label' => __('Slide Image 1 (1400x682)','skt-yogi-lite'),
            'section' => 'slider_section',
            'settings' => 'slide_image1'
       		)
     	 )
	);	
	$wp_customize->add_setting('slide_title1',array(
			'default'	=> __('Fight Stress & Find Serenity','skt-yogi-lite'),
			'sanitize_callback' => 'sanitize_text_field',
	));
	$wp_customize->add_control(	'slide_title1', array(	
			'label'	=> __('Slide title 1','skt-yogi-lite'),
			'section'	=> 'slider_section',
			'setting'	=> 'slide_title1'
	));
	$wp_customize->add_setting('slide_desc1',array(
		'default'	=> __('Suspendisse potenti. Sed nec posuere nulla. Vestibulum et sagittis sem. Aenean lorem nibh, varius vel tellus sit amet, dapibus fermentum urna. Proin venenatis in metus a varius. Phasellus scelerisque tincidunt elit, quis mollis odio aliquam ac. Etiam vehicula porta ligula, at tincidunt lectus venenatis sed. Phasellus eu est est. Donec ut iaculis ante. Nullam a viverra leo. Cras a purus ut enim molestie luctus.','skt-yogi-lite'),
		'sanitize_callback'	=> 'wp_htmledit_pre'	
	));
	$wp_customize->add_control(	new WP_Customize_Textarea_Control( $wp_customize,'slide_desc1', array(
				'label'	=> __('Slider description  1','skt-yogi-lite'),
				'section'	=> 'slider_section',
				'setting'	=> 'slide_desc1'
	)));
	$wp_customize->add_setting('slide_link1',array(
			'default'	=> '#',
			'sanitize_callback'	=> 'esc_url_raw'
	));
	
	$wp_customize->add_control('slide_link1',array(
			'label'	=> __('Slide link 1','skt-yogi-lite'),
			'section'	=> 'slider_section',
			'setting'	=> 'slide_link1'
	));	
	// Slide Image 2
	$wp_customize->add_setting('slide_image2',array(
			'default'	=> get_template_directory_uri().'/images/slides/slider2.jpg',
			'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control(	new WP_Customize_Image_Control(	$wp_customize, 'slide_image2', array(
				'label'	=> __('Slide image 2','skt-yogi-lite'),
				'section'	=> 'slider_section',
				'setting'	=> 'slide_image2'
			)
		)
	);	
	$wp_customize->add_setting('slide_title2',array(	
			'default'	=> __('Reduce Fat & Increase Energy','skt-yogi-lite'),
			'sanitize_callback' => 'sanitize_text_field',
	));
	$wp_customize->add_control('slide_title2', array(	
			'label'	=> __('Slide title 2','skt-yogi-lite'),
			'section'	=> 'slider_section',
			'setting'	=> 'slide_title2'
	));	
	$wp_customize->add_setting('slide_desc2',array(
			'default'	=> __('Suspendisse potenti. Sed nec posuere nulla. Vestibulum et sagittis sem. Aenean lorem nibh, varius vel tellus sit amet, dapibus fermentum urna. Proin venenatis in metus a varius. Phasellus scelerisque tincidunt elit, quis mollis odio aliquam ac. Etiam vehicula porta ligula, at tincidunt lectus venenatis sed. Phasellus eu est est. Donec ut iaculis ante. Nullam a viverra leo. Cras a purus ut enim molestie luctus.','skt-yogi-lite'),
			'sanitize_callback'	=> 'wp_htmledit_pre'
	));
	$wp_customize->add_control(	new WP_Customize_Textarea_Control( $wp_customize,'slide_desc2', array(
				'label'	=> __('Slide description 2','skt-yogi-lite'),
				'section'	=> 'slider_section',
				'setting'	=> 'slide_desc2'
		))
	);	
	$wp_customize->add_setting('slide_link2',array(
			'default'	=> '#',
			'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('slide_link2',array(
		'label'	=> __('Slide link 2','skt-yogi-lite'),
		'section'	=> 'slider_section',
		'setting'	=> 'slide_link2'
	));	
	// Slide Image 3
	$wp_customize->add_setting('slide_image3',array(
			'default'	=> get_template_directory_uri().'/images/slides/slider3.jpg',
			'sanitize_callback'	=> 'esc_url_raw'
	));
	
	$wp_customize->add_control( new WP_Customize_Image_Control(	$wp_customize,'slide_image3', array(
				'label'	=> __('Slide Image 3','skt-yogi-lite'),
				'section'	=> 'slider_section',
				'setting'	=> 'slide_image3'				
		))
	);	
	$wp_customize->add_setting('slide_title3',array(
			'default'	=> __('Find Inner Peace & Greater Flexibility','skt-yogi-lite'),
			'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(	'slide_title3', array(		
			'label'	=> __('Slide title 3','skt-yogi-lite'),
			'section'	=> 'slider_section',
			'setting'	=> 'slide_title3'			
	));	
	$wp_customize->add_setting('slide_desc3',array(
			'default'	=> __('Suspendisse potenti. Sed nec posuere nulla. Vestibulum et sagittis sem. Aenean lorem nibh, varius vel tellus sit amet, dapibus fermentum urna. Proin venenatis in metus a varius. Phasellus scelerisque tincidunt elit, quis mollis odio aliquam ac. Etiam vehicula porta ligula, at tincidunt lectus venenatis sed. Phasellus eu est est. Donec ut iaculis ante. Nullam a viverra leo. Cras a purus ut enim molestie luctus.','skt-yogi-lite'),
			'sanitize_callback'	=> 'wp_htmledit_pre'
	));
	$wp_customize->add_control(	new WP_Customize_Textarea_Control($wp_customize,'slide_desc3', array(
				'label'	=> __('Slide Description 3','skt-yogi-lite'),
				'section'	=> 'slider_section',
				'setting'	=> 'slide_desc3'		
		))
	);	
	$wp_customize->add_setting('slide_link3',array(
			'default'	=> '#',
			'sanitize_callback'	=> 'esc_url_raw'
	));
	
	$wp_customize->add_control('slide_link3',array(
			'label'	=> __('Slide link 3','skt-yogi-lite'),
			'section'	=> 'slider_section',
			'setting'	=> 'slide_link3'
	));	
// Slide Image 4
	$wp_customize->add_setting('slide_image4',array(
			'default'	=> get_template_directory_uri().'/images/slides/slider4.jpg',
			'sanitize_callback'	=> 'wp_htmledit_pre'
	));
	$wp_customize->add_control(	new WP_Customize_Image_Control(	$wp_customize,'slide_image4', array(
				'label'	=> __('Slide Image 4','skt-yogi-lite'),
				'section'	=> 'slider_section',	
				'setting'	=> 'slide_image4'
		))
	);	
	$wp_customize->add_setting('slide_title4',array(
			'default'	=> 'Boost Immunity & Detoxify your body',
			'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(	'slide_title4', array(		
			'label'	=> __('Slide title 4','skt-yogi-lite'),
			'section'	=> 'slider_section',
			'setting'	=> 'slide_title4'		
	));
	$wp_customize->add_setting('slide_desc4',array(
			'default'	=> 'Suspendisse potenti. Sed nec posuere nulla. Vestibulum et sagittis sem. Aenean lorem nibh, varius vel tellus sit amet, dapibus fermentum urna. Proin venenatis in metus a varius. Phasellus scelerisque tincidunt elit, quis mollis odio aliquam ac. Etiam vehicula porta ligula, at tincidunt lectus venenatis sed. Phasellus eu est est. Donec ut iaculis ante. Nullam a viverra leo. Cras a purus ut enim molestie luctus.',
			'sanitize_callback'	=> 'wp_htmledit_pre'
	));
	$wp_customize->add_control(	new WP_Customize_Textarea_Control($wp_customize,'slide_desc4', array(
				'label'	=> __('Slide description 4','skt-yogi-lite'),
				'section'	=> 'slider_section',
				'setting'	=> 'slide_desc4'
		))
	);		
	$wp_customize->add_setting('slide_link4',array(
			'default'	=> '#',
			'sanitize_callback'	=> 'esc_url_raw'
	));	
	$wp_customize->add_control('slide_link4',array(
			'label'	=> __('Slide link 4','skt-yogi-lite'),
			'section'	=> 'slider_section',
			'setting'	=> 'slide_link4'
	));
	// Slide Image 5
	$wp_customize->add_setting('slide_image5',array(
			'default'	=> '',
			'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'slide_image5', array(
				'label'	=> __('Slide image 5','skt-yogi-lite'),
				'section'	=> 'slider_section',
				'setting'	=> 'slide_image5'
	   ))
	);
	$wp_customize->add_setting('slide_title5',array(
			'default'	=> '',
			'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(	'slide_title5', array(		
			'label'	=> __('Slide title 5','skt-yogi-lite'),
			'section'	=> 'slider_section',
			'setting'	=> 'slide_title5'
	));
	$wp_customize->add_setting('slide_desc5',array(
			'default'	=> '',
			'sanitize_callback'	=> 'wp_htmledit_pre'
	));
	$wp_customize->add_control(	new WP_Customize_Textarea_Control( $wp_customize,'slide_desc5', array(
				'label'	=> __('Slide description 5','skt-yogi-lite'),
				'section'	=> 'slider_section',
				'setting'	=> 'slide_desc5'
		))
	);
	$wp_customize->add_setting('slide_link5',array(
			'default'	=> '',
			'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('slide_link5',array(
			'label'	=> __('Slide link 5','skt-yogi-lite'),
			'section'	=> 'slider_section',
			'setting'	=> 'slide_link5'
	));	
	$wp_customize->add_section('social_sec',array(
			'title'	=> __('Social Settings','skt-yogi-lite'),				
			'description' => sprintf( __( 'More social icon available in %s.', 'skt-yogi-lite' ), sprintf( '<a href="%1$s" target="_blank">%2$s</a>', esc_url( '"'.SKT_PRO_THEME_URL.'"' ), __( 'PRO Version', 'skt-yogi-lite' ))),			
			'priority'		=> null
	));
	$wp_customize->add_setting('fb_link',array(
			'default'	=> '#facebook',
			'sanitize_callback'	=> 'esc_url_raw'	
	));
	
	$wp_customize->add_control('fb_link',array(
			'label'	=> __('Add facebook link here','skt-yogi-lite'),
			'section'	=> 'social_sec',
			'setting'	=> 'fb_link'
	));	
	$wp_customize->add_setting('twitt_link',array(
			'default'	=> '#twitter',
			'sanitize_callback'	=> 'esc_url_raw'
	));
	
	$wp_customize->add_control('twitt_link',array(
			'label'	=> __('Add twitter link here','skt-yogi-lite'),
			'section'	=> 'social_sec',
			'setting'	=> 'twitt_link'
	));
	$wp_customize->add_setting('gplus_link',array(
			'default'	=> '#gplus',
			'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('gplus_link',array(
			'label'	=> __('Add google plus link here','skt-yogi-lite'),
			'section'	=> 'social_sec',
			'setting'	=> 'gplus_link'
	));
	$wp_customize->add_setting('linked_link',array(
			'default'	=> '#linkedin',
			'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('linked_link',array(
			'label'	=> __('Add linkedin link here','skt-yogi-lite'),
			'section'	=> 'social_sec',
			'setting'	=> 'linked_link'
	));
	
	
	
	$wp_customize->add_section('header_office_hours',array(
			'title'	=> __('Header Office Time Table','skt-yogi-lite'),
			'description'	=> __('','skt-yogi-lite'),
			'priority'		=> null
	));
	$wp_customize->add_setting('office_timing',array(			
			'default'	=> __('Week days: 05:00 - 22:00 Saturday: 08:00 - 18:00 Sunday: Closed','skt-yogi-lite'),
			'sanitize_callback'	=> 'sanitize_text_field'	
	));
	
	$wp_customize->add_control('office_timing',array(
			'label'	=> __('enter your office timing','skt-yogi-lite'),
			'section'	=> 'header_office_hours',
			'setting'	=> 'office_timing'
	));	
	
	
	
	
	$wp_customize->add_section('footer_area',array(
			'title'	=> __('Footer Area','skt-yogi-lite'),
			'priority'	=> null,			
			'description' => sprintf( __( 'To remove credit & copyright text upgrade to  %s.', 'skt-yogi-lite' ), sprintf( '<a href="%1$s" target="_blank">%2$s</a>', esc_url( '"'.SKT_PRO_THEME_URL.'"' ), __( 'PRO Version', 'skt-yogi-lite' ))),
	));
	$wp_customize->add_setting('skt_yogi_lite_options[credit-info]', array(
            'type' => 'info_control',
            'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
        )
    );
    $wp_customize->add_control( new skt_yogi_lite_Info( $wp_customize, 'cred_section', array(
		'label'	=> __('','skt-yogi-lite'),
        'section' => 'footer_area',
        'settings' => 'skt_yogi_lite_options[credit-info]'
        ) )
    );
	
	
	$wp_customize->add_setting('about_title',array(
			'default'	=> __('About Yogi','skt-yogi-lite'),
			'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('about_title',array(
			'label'	=> __('Add title for about Yogi','skt-yogi-lite'),
			'section'	=> 'footer_area',
			'setting'	=> 'about_title'
	));
	
	$wp_customize->add_setting('about_description',array(
			'default'	=> __('Consectetur, adipisci velit, sed quiaony on numquam eius modi tempora incidunt, ut laboret dolore agnam aliquam quaeratine voluptatem. ut enim ad minima veniamting suscipit suscipit lab velit, sed quiaony on numquam eius.','skt-yogi-lite'),
			'sanitize_callback'	=> 'wp_htmledit_pre'
	));
	
	$wp_customize->add_control(	new WP_Customize_Textarea_Control( $wp_customize,'about_description', array(	
			'label'	=> __('Add description for about Yogi','skt-yogi-lite'),
			'section'	=> 'footer_area',
			'setting'	=> 'about_description'
	)) );
	
	$wp_customize->add_setting('recentpost_title',array(
			'default'	=> __('Recent Posts','skt-yogi-lite'),
			'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('recentpost_title',array(
			'label'	=> __('Add title for recent posts','skt-yogi-lite'),
			'section'	=> 'footer_area',
			'setting'	=> 'recentpost_title'
	));
	
	$wp_customize->add_setting('contact_title',array(
			'default'	=> __('Contact Info','skt-yogi-lite'),
			'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('contact_title',array(
			'label'	=> __('Add Footer Contact Info','skt-yogi-lite'),
			'section'	=> 'footer_area',
			'setting'	=> 'contact_title'
	));		
	
	
	$wp_customize->add_setting('contact_add',array(
			'default'	=> __('100 King St, Melbourne PIC 4000, Australia','skt-yogi-lite'),
			'sanitize_callback'	=> 'wp_htmledit_pre'
	));
	
	$wp_customize->add_control(	new WP_Customize_Textarea_Control( $wp_customize, 'contact_add', array(
				'label'	=> __('Add contact address here','skt-yogi-lite'),
				'section'	=> 'footer_area',
				'setting'	=> 'contact_add'
			)
		)
	);
	$wp_customize->add_setting('contact_no',array(
			'default'	=> __('+123 456 7890','skt-yogi-lite'),
			'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('contact_no',array(
			'label'	=> __('Add contact number here.','skt-yogi-lite'),
			'section'	=> 'footer_area',
			'setting'	=> 'contact_no'
	));
	$wp_customize->add_setting('contact_mail',array(
			'default'	=> 'contact@company.com',
			'sanitize_callback'	=> 'sanitize_email'
	));
	
	$wp_customize->add_control('contact_mail',array(
			'label'	=> __('Add you email here','skt-yogi-lite'),
			'section'	=> 'footer_area',
			'setting'	=> 'contact_mail'
	));
	
	
	$wp_customize->add_section( 'theme_layout_sec', array(
            'title' => __('Layout Settings (PRO Version)', 'skt-yogi-lite'),
            'priority' => null,			
			'description' => sprintf( __( 'Layout Settings available in   %s.', 'skt-yogi-lite' ), sprintf( '<a href="%1$s" target="_blank">%2$s</a>', esc_url( '"'.SKT_PRO_THEME_URL.'"' ), __( 'PRO Version', 'skt-yogi-lite' ))),
			
        )
    );  
    $wp_customize->add_setting('skt_yogi_lite_options[layout-info]', array(
            'type' => 'info_control',
            'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
        )
    );
    $wp_customize->add_control( new skt_yogi_lite_Info( $wp_customize, 'layout_section', array(
        'section' => 'theme_layout_sec',
        'settings' => 'skt_yogi_lite_options[layout-info]',
        'priority' => null
        ) )
    );
	
	$wp_customize->add_section('theme_font_sec', array(
            'title' => __('Fonts Settings (PRO Version)', 'skt-yogi-lite'),
            'priority' => null,			
			'description' => sprintf( __( 'Font Settings available in   %s.', 'skt-yogi-lite' ), sprintf( '<a href="%1$s" target="_blank">%2$s</a>', esc_url( '"'.SKT_PRO_THEME_URL.'"' ), __( 'PRO Version', 'skt-yogi-lite' ))),		
			
        )
    );  
    $wp_customize->add_setting('skt_yogi_lite_options[font-info]', array(
            'type' => 'info_control',
            'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
        )
    );
    $wp_customize->add_control( new skt_yogi_lite_Info( $wp_customize, 'font_section', array(
        'section' => 'theme_font_sec',
        'settings' => 'skt_yogi_lite_options[font-info]',
        'priority' => null
        ) )
    );
	
    $wp_customize->add_section( 'theme_doc_sec', array(
            'title' => __('Documentation &amp; Support', 'skt-yogi-lite'),
            'priority' => null,
            'description' => sprintf( __( 'For documentation and support check this link %s.', 'skt-yogi-lite' ), sprintf( '<a href="%1$s" target="_blank">%2$s</a>', esc_url( '"'.SKT_THEME_DOC.'"' ), __( 'SKT Yogi Documentation', 'skt-yogi-lite' )
						)
					),
        )
    );  
    $wp_customize->add_setting('skt_yogi_lite_options[info]', array(
            'type' => 'info_control',
            'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
        )
    );
    $wp_customize->add_control( new skt_yogi_lite_Info( $wp_customize, 'doc_section', array(
        'section' => 'theme_doc_sec',
        'settings' => 'skt_yogi_lite_options[info]',
        'priority' => 10
        ) )
    );		
}
add_action( 'customize_register', 'skt_yogi_lite_customize_register' );

//Integer
function skt_yogi_lite_sanitize_integer( $input ) {
    if( is_numeric( $input ) ) {
        return intval( $input );
    }
}

function skt_yogi_lite_custom_css(){
		?>
        	<style type="text/css"> 
					
					a, .blog_lists h2 a:hover,
					#sidebar ul li a:hover,
					.recent-post h6:hover,				
					.copyright-txt span,					
					a.more-button span,
					.cols-4 span,					
					.listpages:hover h4,
					.header .header-inner .nav ul li a:hover, 
					.header .header-inner .nav ul li.current_page_item a,
					.morelink,
					.header span.tagline,
					.MoreLink
					{ color:<?php echo esc_attr( get_theme_mod('color_scheme','#55deef')); ?>;}
					 
					.social-icons a:hover, 
					.pagination ul li .current, 
					.pagination ul li a:hover, 
					#commentform input#submit:hover,								
					h3.widget-title,				
					.wpcf7 input[type="submit"],
					.listpages:hover .morelink,
					.MoreLink:hover,
					.headerfull,
					.slide_info h2,
					.nivo-controlNav a.active
					{ background-color:<?php echo esc_attr( get_theme_mod('color_scheme','#55deef')); ?> !important;}
					
					.header .header-inner .nav,				
					.listpages:hover .morelink,
					.MoreLink,
					.section_title,
					.listpages,
					.listpages h2,
					.morelink,
					#wrapfirst h1,
					.cols-3 h5 span
					{ border-color:<?php echo esc_attr( get_theme_mod('color_scheme','#55deef')); ?>;}
					
			</style>  
<?php  
} 
add_action('wp_head','skt_yogi_lite_custom_css');	

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function skt_yogi_lite_customize_preview_js() {
	wp_enqueue_script( 'skt_yogi_lite_customizer', get_template_directory_uri() . '/js/customize-preview.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'skt_yogi_lite_customize_preview_js' );


function skt_yogi_lite_custom_customize_enqueue() {
	wp_enqueue_script( 'skt-yogi-lite-custom-customize', get_template_directory_uri() . '/js/custom.customize.js', array( 'jquery', 'customize-controls' ), false, true );
}
add_action( 'customize_controls_enqueue_scripts', 'skt_yogi_lite_custom_customize_enqueue' );
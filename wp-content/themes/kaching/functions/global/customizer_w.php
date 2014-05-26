<?php
/**
 * tfbasedetails theme customizer  
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @since Kaching 1.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */

add_theme_support( 'custom-background' );
$defaults = array(
   'default-color' => '',
   'default-image' => '',
   'wp-head-callback' => '_custom_background_cb',
   'admin-head-callback' => '',
   'admin-preview-callback' => ''
);

add_theme_support( 'custom-background', $defaults );


class tfbasedetails_Customize
{
   
   /**
    * This hooks into 'customize_register' (available as of WP 3.4) and allows
    * you to add new sections and controls to the Theme Customize screen.
    * 
    * Note: To enable instant preview, we have to actually write a bit of custom
    * javascript. See live_preview() for more.
    *  
    * @see add_action('customize_register',$func)
    * @param \WP_Customize_Manager $wp_customize
    * @link http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
    * @since Proffet 1.0
    */

   public static function register ( $wp_customize )
   {

      $wp_customize->remove_section( 'title_tagline');
      $wp_customize->add_setting( 'background_color' , array(
         'default' => '#F0F0ED'
      ) );
      
      $wp_customize->add_section( 'tfbasedetails_options_hp', 
         array(
            'title' => __( 'Homepage Options', 'tfbasedetails' ), //Visible title of section
            'priority' => 135, //Determines what order this appears in
            'capability' => 'edit_theme_options', //Capability needed to tweak
            'description' => __('Allows you to adjust text titles which appear over widgets on the homepage.', 'tfbasedetails'), //Descriptive tooltip
         ) 
      );

      $wp_customize->add_section( 'tfbasedetails_wooc_hp', 
         array(
            'title' => __( 'WooCommerce Options', 'tfbasedetails' ), //Visible title of section
            'priority' => 140, //Determines what order this appears in
            'capability' => 'edit_theme_options', //Capability needed to tweak
            'description' => __('Manage key WooCommerce theme settings.', 'tfbasedetails'), //Descriptive tooltip
         ) 
      );

      $wp_customize->add_section( 'tfbasedetails_options_font', 
         array(
            'title' => __( 'Google Web Fonts', 'tfbasedetails' ), //Visible title of section
            'priority' => 136, //Determines what order this appears in
            'capability' => 'edit_theme_options', //Capability needed to tweak
            'description' => __('Allows you to adjust the web font for the site.', 'tfbasedetails'), //Descriptive tooltip
         ) 
      );

      $wp_customize->add_section( 'tfbasedetails_options_global', 
         array(
            'title' => __( 'Global Page Options', 'tfbasedetails' ), //Visible title of section
            'priority' => 136, //Determines what order this appears in
            'capability' => 'edit_theme_options', //Capability needed to tweak
            'description' => __('Allows you to adjust global page options.', 'tfbasedetails'), //Descriptive tooltip
         ) 
      );

      $wp_customize->add_setting( 'tf_primary_color', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '#6abd45', //Default setting/value to save
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'tf_primary_color', //Set a unique ID for the control
         array(
            'label' => __( 'Primary Color', 'tfbasedetails' ), //Admin-visible name of the control
            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'tf_primary_color', //Which setting to load and manipulate (serialized is okay)
            'priority' => 20, //Determines the order this control appears in for the specified section
         ) 
      ) );
      
      $wp_customize->get_setting( 'tf_primary_color' )->transport = 'postMessage';

      $wp_customize->add_setting( 'tf_primary_linkhover_color', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '#6abd45', //Default setting/value to save
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'tf_primary_linkhover_color', //Set a unique ID for the control
         array(
            'label' => __( 'Main Menu Link Hover Color', 'tfbasedetails' ), //Admin-visible name of the control
            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'tf_primary_linkhover_color', //Which setting to load and manipulate (serialized is okay)
            'priority' => 30, //Determines the order this control appears in for the specified section
         ) 
      ) );
      
      $wp_customize->get_setting( 'tf_primary_linkhover_color' )->transport = 'postMessage';

      $wp_customize->add_setting( 'tf_mainlinks_color', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '#6abd45', //Default setting/value to save
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'tf_mainlinks_color', //Set a unique ID for the control
         array(
            'label' => __( 'Main Link Hover Color', 'tfbasedetails' ), //Admin-visible name of the control
            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'tf_mainlinks_color', //Which setting to load and manipulate (serialized is okay)
            'priority' => 40, //Determines the order this control appears in for the specified section
         ) 
      ) );
      
      $wp_customize->get_setting( 'tf_mainlinks_color' )->transport = 'postMessage';

      $wp_customize->add_setting( 'tf_toplinks_color', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '#6B6B6A', //Default setting/value to save
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'tf_toplinks_color', //Set a unique ID for the control
         array(
            'label' => __( 'Top Header Links Color', 'tfbasedetails' ), //Admin-visible name of the control
            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'tf_toplinks_color', //Which setting to load and manipulate (serialized is okay)
            'priority' => 50, //Determines the order this control appears in for the specified section
         ) 
      ) );
      
      $wp_customize->get_setting( 'tf_toplinks_color' )->transport = 'postMessage';

      $wp_customize->add_setting( 'tf_buttontext_color', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '#fff', //Default setting/value to save
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'tf_buttontext_color', //Set a unique ID for the control
         array(
            'label' => __( 'Button Text Color', 'tfbasedetails' ), //Admin-visible name of the control
            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'tf_buttontext_color', //Which setting to load and manipulate (serialized is okay)
            'priority' => 60, //Determines the order this control appears in for the specified section
         ) 
      ) );
      
      $wp_customize->get_setting( 'tf_buttontext_color' )->transport = 'postMessage';

      $wp_customize->add_setting( 'tf_footerbg_color', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '#292929', //Default setting/value to save
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'tf_footerbg_color', //Set a unique ID for the control
         array(
            'label' => __( 'Footer Background Color', 'tfbasedetails' ), //Admin-visible name of the control
            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'tf_footerbg_color', //Which setting to load and manipulate (serialized is okay)
            'priority' => 70, //Determines the order this control appears in for the specified section
         ) 
      ) );
      
      $wp_customize->get_setting( 'tf_footerbg_color' )->transport = 'postMessage';

      $wp_customize->add_setting( 'tf_secondfooterbg_color', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '#1F1E1E', //Default setting/value to save
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'tf_secondfooterbg_color', //Set a unique ID for the control
         array(
            'label' => __( 'Footer Boxes Color', 'tfbasedetails' ), //Admin-visible name of the control
            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'tf_secondfooterbg_color', //Which setting to load and manipulate (serialized is okay)
            'priority' => 80, //Determines the order this control appears in for the specified section
         ) 
      ) );
      
      $wp_customize->get_setting( 'tf_secondfooterbg_color' )->transport = 'postMessage';

      $wp_customize->add_setting( 'tf_footerlines_color', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '#363333', //Default setting/value to save
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'tf_footerlines_color', //Set a unique ID for the control
         array(
            'label' => __( 'Footer Light border color', 'tfbasedetails' ), //Admin-visible name of the control
            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'tf_footerlines_color', //Which setting to load and manipulate (serialized is okay)
            'priority' => 80, //Determines the order this control appears in for the specified section
         ) 
      ) );
      
      $wp_customize->get_setting( 'tf_footerlines_color' )->transport = 'postMessage';

      $wp_customize->add_setting( 'tf_footertext_color', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '#CEC5C5', //Default setting/value to save
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'tf_footertext_color', //Set a unique ID for the control
         array(
            'label' => __( 'Footer Widgets Text Color', 'tfbasedetails' ), //Admin-visible name of the control
            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'tf_footertext_color', //Which setting to load and manipulate (serialized is okay)
            'priority' => 90, //Determines the order this control appears in for the specified section
         ) 
      ) );
      
      $wp_customize->get_setting( 'tf_footertext_color' )->transport = 'postMessage';

      $wp_customize->add_setting( 'tf_footerhighlight_color', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '#6abd45', //Default setting/value to save
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'tf_footerhighlight_color', //Set a unique ID for the control
         array(
            'label' => __( 'Footer Text Highlight Color', 'tfbasedetails' ), //Admin-visible name of the control
            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'tf_footerhighlight_color', //Which setting to load and manipulate (serialized is okay)
            'priority' => 100, //Determines the order this control appears in for the specified section
         ) 
      ) );
      
      $wp_customize->get_setting( 'tf_footerhighlight_color' )->transport = 'postMessage';

      $wp_customize->add_setting( 'tf_hpnewslink_color', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => '#6abd45', //Default setting/value to save
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      
      
      $wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
         $wp_customize, //Pass the $wp_customize object (required)
         'tf_hpnewslink_color', //Set a unique ID for the control
         array(
            'label' => __( 'Homepage News Items Link Color', 'tfbasedetails' ), //Admin-visible name of the control
            'section' => 'colors', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
            'settings' => 'tf_hpnewslink_color', //Which setting to load and manipulate (serialized is okay)
            'priority' => 100, //Determines the order this control appears in for the specified section
         ) 
      ) );
      
      $wp_customize->get_setting( 'tf_hpnewslink_color' )->transport = 'postMessage';


      $wp_customize->add_setting( 'tf_hp_text1', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => __( 'Welcome to Kaching!', 'tfbasedetails' ), 
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      

      $wp_customize->add_control( 'tf_hp_text1', array(
         'label' => __( 'Homepage Welcome Message', 'tfbasedetails' ), //Admin-visible name of the control
         'section'   => 'tfbasedetails_options_hp',
         'type'    => 'text', // text (default), checkbox, radio, select, dropdown-pages
         'settings' => 'tf_hp_text1', //Which setting to load and manipulate (serialized is okay)
         'priority' => 110, //Determines the order this control appears in for the specified section
      ) );      

      $wp_customize->get_setting( 'tf_hp_text1' )->transport = 'postMessage';

      $wp_customize->add_setting( 'tf_hp_footermsg', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => __( 'Copyright Notice', 'tfbasedetails' ), 
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      

      $wp_customize->add_control( 'tf_hp_footermsg', array(
         'label' => __( 'Footer Copyright Notice', 'tfbasedetails' ), //Admin-visible name of the control
         'section'   => 'tfbasedetails_options_hp',
         'type'    => 'text', // text (default), checkbox, radio, select, dropdown-pages
         'settings' => 'tf_hp_footermsg', //Which setting to load and manipulate (serialized is okay)
         'priority' => 110, //Determines the order this control appears in for the specified section
      ) );      

      $wp_customize->get_setting( 'tf_hp_footermsg' )->transport = 'postMessage';

      $wp_customize->add_setting( 'tf_hp_slides', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => __( 'yes', 'tfbasedetails' ), 
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      

      $wp_customize->add_control( 'tf_hp_slides', array(
         'label' => __( 'Display Text on Sliders?', 'tfbasedetails' ), //Admin-visible name of the control
         'section'   => 'tfbasedetails_options_hp',
         'type'    => 'radio', // text (default), checkbox, radio, select, dropdown-pages
         'choices' => array(
            'yes' => 'Yes',
            'no' => 'No',
            ),
         'settings' => 'tf_hp_slides', //Which setting to load and manipulate (serialized is okay)
         'priority' => 110, //Determines the order this control appears in for the specified section
      ) );      

      $wp_customize->get_setting( 'tf_hp_slides' )->transport = 'postMessage';

      $wp_customize->add_setting( 'tf_webfont', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => __( 'Lato', 'tfbasedetails' ), 
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      

      $wp_customize->add_control( 'tf_webfont', array(
         'label' => __( 'Heading Font (Defaults to Lato)', 'tfbasedetails' ), //Admin-visible name of the control
         'section'   => 'tfbasedetails_options_font',
         'type'    => 'text', // text (default), checkbox, radio, select, dropdown-pages
         'settings' => 'tf_webfont', //Which setting to load and manipulate (serialized is okay)
         'priority' => 110, //Determines the order this control appears in for the specified section

      ) );      

      $wp_customize->get_setting( 'tf_webfont' )->transport = 'postMessage';

      $wp_customize->add_setting( 'tf_webbodyfont', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => __( 'Lato', 'tfbasedetails' ), 
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      

      $wp_customize->add_control( 'tf_webbodyfont', array(
         'label' => __( 'Body Font (Defaults to Lato)', 'tfbasedetails' ), //Admin-visible name of the control
         'section'   => 'tfbasedetails_options_font',
         'type'    => 'text', // text (default), checkbox, radio, select, dropdown-pages
         'settings' => 'tf_webbodyfont', //Which setting to load and manipulate (serialized is okay)
         'priority' => 110, //Determines the order this control appears in for the specified section

      ) );      

      $wp_customize->get_setting( 'tf_webbodyfont' )->transport = 'postMessage';

      $wp_customize->add_setting( 'tf_hide_comments', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => __( 'no', 'tfbasedetails' ), 
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      

      $wp_customize->add_control( 'tf_hide_comments', array(
         'label' => __( 'Display comments on pages?', 'tfbasedetails' ), //Admin-visible name of the control
         'section'   => 'tfbasedetails_options_global',
         'default' => __( 'no', 'tfbasedetails' ), 
         'type'    => 'radio', // text (default), checkbox, radio, select, dropdown-pages
         'choices' => array(
            'yes' => 'Yes',
            'no' => 'No',
            ),
         'settings' => 'tf_hide_comments', //Which setting to load and manipulate (serialized is okay)
         'priority' => 110, //Determines the order this control appears in for the specified section
      ) );      

      $wp_customize->get_setting( 'tf_hide_comments' )->transport = 'postMessage';

      $wp_customize->add_setting( 'tf_woonoprods', //Give it a SERIALIZED name (so all theme settings can live under one db record)
         array(
            'default' => __( '12', 'tfbasedetails' ), 
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
         ) 
      );      

      $wp_customize->add_control( 'tf_woonoprods', array(
         'label' => __( 'Number of products per page', 'tfbasedetails' ), //Admin-visible name of the control
         'section'   => 'tfbasedetails_wooc_hp',
         'type'    => 'text', // text (default), checkbox, radio, select, dropdown-pages
         'settings' => 'tf_woonoprods', //Which setting to load and manipulate (serialized is okay)
         'priority' => 110, //Determines the order this control appears in for the specified section

      ) );      

      $wp_customize->get_setting( 'tf_woonoprods' )->transport = 'postMessage';

   }
   
   /**
    * This will output the custom WordPress settings to the live theme's WP head.
    * 
    * Used by hook: 'wp_head'
    * 
    * @see add_action('wp_head',$func)
    * @since Proffet 1.0
    */

   public static function header_output()
   {

      ?>
      <!--Customizer CSS--> 
      <style type="text/css">

           <?php self::generate_css('body', 'background-color', 'background_color'); ?> 

           <?php self::generate_css('.woocommerce .woocommerce_tabs ul.tabs li.active a, .woocommerce .woocommerce-tabs ul.tabs li.active a, ul.tabNavigation li a.active', 'border-top', 'tf_primary_color', '1px solid'); ?>
           <?php self::generate_css('.hp-offer, .hpslide_pricewrap, .centertoptitle, .hpslides h2, .flexslider:hover .flex-next:hover, .flexslider:hover .flex-prev:hover, .jcarousel-next:hover, .jcarousel-next:focus, .jcarousel-next:active, .jcarousel-prev:hover, .jcarousel-prev:focus, .jcarousel-prev:active, #slider:hover .nivo-nextNav:hover, #slider:hover .nivo-prevNav:hover', 'background-color', 'tf_primary_color'); ?> 
           <?php self::generate_css('.nav li ul', 'border-top-color', 'tf_primary_color'); ?> 
           <?php self::generate_css('.add_review a, .product .summary .single_add_to_cart_button, .onsale, ul.mini-cart li ul.cart_list li.buttons .button, .flex-control-paging li a.flex-active, button.button,input.button,input[type=submit], .widget_shopping_cart .buttons a, a.checkout-button, a.shipping-calculator-button, li.product a.button, .single-product .upsells li.product a.button, .single-product .related li.product a.button, .tax-product_cat ul.products li.product a.button, .tax-product_tag ul.products li.product a.button,
                                    .place-order .button, .shop_table button.button, .shop_table input.button, .shop_table input[type="submit"], .shop_table .widget_shopping_cart .buttons a, .shop_table a.checkout-button, a.shipping-calculator-button, .shipping-calculator-form button, #respond input#submit, .wpcf7-submit#submit, .pagination span, .pagination a', 'background', 'tf_primary_color'); ?> 
           <?php self::generate_css('.nav li ul li a:hover, .nav li ul li.current_page_item a, header h1 a:link, header h1 a:visited, .bottomnav a:hover, #feature1 span.nextarrow:hover, #feature1 span.prevarrow:hover, #feature2 span.nextarrow:hover, #feature2 span.prevarrow:hover, #breadcrumb a:hover, .woocommerce-breadcrumb a:hover, .accordion .title a:hover, .accordion .title.active a, .toggle .title:hover, .toggle .title.active', 'color', 'tf_primary_color'); ?>
           <?php self::generate_css('.sideslidetitle', 'border-bottom-color', 'tf_primary_color'); ?> 
           <?php self::generate_css('.post-thumb img', 'border-bottom', 'tf_primary_color', '5px solid '); ?> 

           <?php self::generate_css('.product .summary .single_add_to_cart_button, button.button, input.button, input[type="submit"], .widget_shopping_cart .buttons a, a.checkout-button, a.shipping-calculator-button, ul.mini-cart li ul.cart_list li.buttons .button, #respond input#submit, .wpcf7-submit#submit', 'color', 'tf_buttontext_color'); ?> 
          
           <?php self::generate_css('a:hover, .widget ul.product_list_widget a:hover, .wooside .widget li a:hover, #sidebar_content li.current-menu-item a, #sort-by a.active, .tf_showcase:hover a, .entry-title a:hover, .widget ul.product_list_widget a:hover', 'color', 'tf_mainlinks_color'); ?>
           <?php self::generate_css('.nav li a:hover, .nav li.current_page_item a, .nav li.current_menu_item a', 'color', 'tf_primary_linkhover_color'); ?> 

           <?php self::generate_css('#vtoplinks #slogan, .sub_menu a, .sub_menu a:visited, #vtoplinks a[href^=tel]', 'color', 'tf_toplinks_color'); ?> 

           <?php self::generate_css('#site-footer', 'background', 'tf_footerbg_color'); ?> 

           <?php self::generate_css('.tf-blog-widget a', 'color', 'tf_hpnewslink_color'); ?> 
           
           <?php self::generate_css('#site-footer .first-footer-widget .widget_product_categories, #site-footer .first-footer-widget .widget_mailchimpsf_widget, .middlefooter', 'background', 'tf_secondfooterbg_color'); ?> 
           
           <?php self::generate_css('#site-footer h4.strap', 'border-bottom', 'tf_secondfooterbg_color', '1px solid '); ?> 

           <?php self::generate_css('#site-footer, #site-footer .widget-title, #site-footer .widget ul.product_list_widget a, #site-footer .widget ul.product_list_widget li .amount, .tf_tweet_widget ul li > a, #site-footer .tf_tweet_widget ul li > a, .tf_tweet_widget ul li span a, #site-footer .tf_tweet_widget ul li span a, #site-footer .tf_tweet_widget a, #site-footer .widget_product_categories a', 'color', 'tf_footertext_color'); ?> 

           <?php self::generate_css('#site-footer h4.strap, #site-footer .widget_nav_menu ul li', 'border-bottom-color', 'tf_footerlines_color'); ?> 

           <?php self::generate_css('.middlefooter a, #site-footer h4.strap strong', 'color', 'tf_footerhighlight_color'); ?> 

           <?php self::generate_css('body, select, input, textarea, button', 'font-family', 'tf_webbodyfont'); ?> 
           <?php self::generate_css('h1, h2, h3, h4, h5, h6', 'font-family', 'tf_webfont'); ?> 
           <?php self::generate_css('.hpslides h2, .dealwidgethead h3, #sidebar .widget-title, #sidebar-left .widget-title, #sidebar-right .widget-title, .wooside .widget-title, #sort-by, .widgethead h3, .widget_jcarousel_featured_products h3, .sidefeatproduct h3, ul.mini-cart li ul.cart_list li.cart-title h3', 'font-family', 'tf_webfont'); ?> 

      </style> 
      <!--/Customizer CSS-->
      <?php
   }
   
   /**
    * This outputs the javascript needed to automate the live settings preview.
    * Also keep in mind that this function isn't necessary unless your settings 
    * are using 'transport'=>'postMessage' instead of the default 'transport'
    * => 'refresh'
    * 
    * Used by hook: 'customize_preview_init'
    * 
    * @see add_action('customize_preview_init',$func)
    * @since Proffet 1.0
    */

   public static function live_preview()
   {
      wp_enqueue_script( 
           'tfbasedetails-themecustomizer', //Give the script an ID
           get_template_directory_uri() . '/js/theme-customizer.js', 
           array( 'jquery','customize-preview' ), //Define dependencies
           '1.0', //Define a version (optional) 
           true //Specify whether to put in footer (leave this true)
      );
   }

    /**
     * This will generate a line of CSS for use in header output. If the setting
     * ($mod_name) has no defined value, the CSS will not be output.
     * 
     * @uses get_theme_mod()
     * @param string $selector CSS selector
     * @param string $style The name of the CSS *property* to modify
     * @param string $mod_name The name of the 'theme_mod' option to fetch
     * @param string $prefix Optional. Anything that needs to be output before the CSS property
     * @param string $postfix Optional. Anything that needs to be output after the CSS property
     * @param bool $echo Optional. Whether to print directly to the page (default: true).
     * @return string Returns a single line of CSS with selectors and a property.
     * @since Proffet 1.0
     */

   public static function generate_css( $selector, $style, $mod_name, $prefix='', $postfix='', $echo=true)
    {
      $return = '';
      $mod = get_theme_mod($mod_name);
      $mod = str_replace('+', ' ', $mod);

      if ( ! empty( $mod ) )
      {
         $return = sprintf('%s { %s:%s; }',
            $selector,
            $style,
            $prefix.$mod.$postfix
         );
         if ( $echo )
         {
            echo $return;
         }
      }
      return $return;
    }
   }

   function tf_styles() {

      // Load Google Fonts

         if ( 'off' !== _x( 'on', 'Lato font: on or off', 'tfbasedetails' ) ) {
              $subsets = 'latin,latin-ext';

              /* translators: To add an additional Lato character subset specific to your language, translate
                 this to 'greek', 'cyrillic' or 'vietnamese'. Do not translate into your own language. */
              $subset = _x( 'no-subset', 'Lato font: add new subset (greek, cyrillic, vietnamese)', 'tfbasedetails' );

              if ( 'cyrillic' == $subset )
                  $subsets .= ',cyrillic,cyrillic-ext';
              elseif ( 'greek' == $subset )
                  $subsets .= ',greek,greek-ext';
              elseif ( 'vietnamese' == $subset )
                  $subsets .= ',vietnamese';


                  $hfamily = get_theme_mod('tf_webfont', "Lato"); 

                  if ( strlen ( trim ($hfamily) ) > 0 ) { 
                     $hfamily = $hfamily; 
                  } else {
                     $hfamily = "Lato";
                  }

                  $protocol = is_ssl() ? 'https' : 'http';
                  $query_args = array(
                     'family' => $hfamily,
                     'subset' => $subsets,
                  );
                  wp_enqueue_style( 'tfbasedetails-fonts', add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" ), array(), null );        
              

                  $hbodyfamily = get_theme_mod('tf_webbodyfont', "Lato"); 

                  if ( strlen ( trim ($hbodyfamily) ) > 0 ) { 
                     $hbodyfamily = $hbodyfamily; 
                  } else {
                     $hbodyfamily = "Lato";
                  }

                  $protocol = is_ssl() ? 'https' : 'http';
                  $query_args = array(
                     'family' => $hbodyfamily,
                     'subset' => $subsets,
                  );
                  wp_enqueue_style( 'tfbasedetails-body-fonts', add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" ), array(), null );        
              
         }
   }

add_action( 'wp_enqueue_scripts', 'tf_styles' );

//Setup the Theme Customizer settings and controls...
add_action( 'customize_register' , array( 'tfbasedetails_Customize' , 'register' ) );

//Output custom CSS to live site
add_action( 'wp_head' , array( 'tfbasedetails_Customize' , 'header_output' ) );

//Enqueue live preview javascript in Theme Customizer admin screen
add_action( 'customize_preview_init' , array( 'tfbasedetails_Customize' , 'live_preview' ) );

add_action ('admin_menu', 'tf_admin');

function tf_admin() {
    // add the Customize link to the admin menu
    add_theme_page( 'Customize', 'Customize', 'edit_theme_options', 'customize.php' );
}
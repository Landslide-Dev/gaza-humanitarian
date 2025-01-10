<?php



    /*===================================
    =            REMOVE JUNK            =
    ===================================*/
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'index_rel_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'start_post_rel_link', 10, 0);
    remove_action('wp_head', 'parent_post_rel_link', 10, 0);
    remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
    remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0 );
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
    remove_action('wp_head', 'rel_canonical');
    remove_action('rest_api_init', 'wp_oembed_register_route');
    remove_filter('oembed_dataparse', 'wp_filter_oembed_result');
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'wp_oembed_add_host_js');
    remove_action('wp_head', 'rest_output_link_wp_head');
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');






    /*===================================
    =            THEME SETUP            =
    ===================================*/
    function setup_theme() {
        // Theme Settings
        add_theme_support('automatic-feed-links');
        register_nav_menus();
        add_theme_support('post-thumbnails');
        add_theme_support('html5');
        add_theme_support('title-tag');



        // Old
        // add_image_size('side-image', 295);
        // // add_image_size('staff-bio', 200);
        // add_image_size('partnership-image', 150);

        // THUMBS
        add_image_size('reduced', 2000, 2000, FALSE);
        add_image_size('reduced_cropped', 2000, 2000, TRUE);

        add_image_size('tile', 500, 500, FALSE);
        add_image_size('tile_cropped', 500, 500, TRUE);
        add_filter('image_size_names_choose', function($sizes) {
            return array_merge($sizes, array(
                'tile' => __('Tile'),
                'tile_cropped' => __('Tile Cropped')
            ));
        });

    }
    add_action('after_setup_theme', 'setup_theme');





    /*===================================================
    =            REMOVE STUPID SRCSET IMAGES            =
    ===================================================*/
    add_filter('wp_get_attachment_image_attributes', function($attr) {
        if (isset($attr['sizes']))
            unset($attr['sizes']);

        if (isset($attr['srcset']))
            unset($attr['srcset']);

        return $attr;

     }, PHP_INT_MAX);
    add_filter('wp_calculate_image_sizes', '__return_false',  PHP_INT_MAX);
    add_filter('wp_calculate_image_srcset', '__return_false', PHP_INT_MAX);
    remove_filter('the_content', 'wp_make_content_images_responsive');





	/*======================================
	=            DYNAMIC ASSETS            =
	======================================*/
	function dynamic_assets() {

		$current_url = $_SERVER['REQUEST_URI'];
		$current_url = explode('?', $current_url);
		$current_url = $current_url[0];
		$current_url = trim($current_url, '/');

		if (!is_admin()) {

			// wp_deregister_script('jquery');

			// Use latest jQuery with IE support
			// wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js', FALSE, '1.9.1', FALSE);
			// wp_enqueue_script('jquery');

			// About Only
			if ($current_url == 'about') {

			}

			// wp_register_script('plugins', get_template_directory_uri() . '/js/plugins.min.js', array('jquery'), '1.2s222', TRUE);
			// wp_enqueue_script('plugins');

			// wp_register_script('scripts', '/wp-content/themes/scotchpress/js/scripts.js', array('jquery'), '1.'.rand(), TRUE);
			// wp_enqueue_script('scripts');
		}
	}
	add_action('wp_enqueue_scripts', 'dynamic_assets');


	/*==========================================
	=            ASYNC LOAD SCRIPTS            =
	==========================================*/
	// function add_async_forscript($url)
	// {
	//     if (strpos($url, '#asyncload')===false)
	//         return $url;
	//     else if (is_admin())
	//         return str_replace('#asyncload', '', $url);
	//     else
	//         return str_replace('#asyncload', '', $url)."' async='async";
	// }
	// add_filter('clean_url', 'add_async_forscript', 11, 1);




    /*===============================
    =            RSS FIX            =
    ===============================*/
	// function rss_fix($content) {
	// 	global $post;

    //     // Add featured image
	// 	if (has_post_thumbnail($post->ID ))
	// 		$content = '' . get_the_post_thumbnail($post->ID, 'post-thumbnail') . '' . $content;

	// 	return $content;
	// }
	// add_filter('the_excerpt_rss', 'rss_fix');
	// add_filter('the_content_feed', 'rss_fix');



	/*========================================
	=            HTML5 STYLE TAGS            =
	========================================*/
	// function html5_style_tag($tag) {
	// 	$tag = str_replace("type='text/css'", '', $tag);
	// 	$tag = str_replace("'", '"', $tag);
	// 	$tag = str_replace(" />", '>', $tag);

	// 	return $tag;
	// }
	// add_filter('style_loader_tag', 'html5_style_tag');


    /*=======================================
    =            DISABLE XML-RPC            =
    =======================================*/
    add_filter('xmlrpc_enabled', '__return_false');



    /*==================================================
    =            REMOVE UNWANTED MENU ITEMS            =
    ==================================================*/
    function remove_menus () {
        // Remove the Editor
        remove_action('admin_menu', '_add_themes_utility_last', 101);

        // Remove Comments
        remove_menu_page('edit-comments.php');

        // Remove Theme Options
        global $submenu;
        unset($submenu['themes.php'][5]); // Switch Themes
        unset($submenu['themes.php'][6]); // Customize
    }
    add_action('admin_menu', 'remove_menus');





	/*==================================
	=            GET SLICES            =
	==================================*/
	// function get_slice($slice, $data = array()) {
	// 	global $post;
	// 	extract($data);
	// 	ob_start();
	// 	include(locate_template('slices/'.$slice.'.php'));
	// 	return ob_get_clean();
	// }


    /*=====================================
    =            ARCHIVE TITLE            =
    =====================================*/
    function grab_title() {
        global $post;
        global $wp_query;
        if (is_page() || is_single())
        {
            return get_the_title();
        }
        elseif (is_archive() && !is_category() && !is_tag() && !is_author() && !is_tax())
        {
            if (is_post_type_archive('event')) :

                if (isset($_GET['show']) && $_GET['show'] == 'upcoming') return 'Upcoming Events';
                if (isset($_GET['show']) && $_GET['show'] == 'past') return 'Past Events';
                if (!isset($_GET['show'])) return 'All Events';

            endif;

            if (is_year()) return get_the_time('Y');
            if (is_month()) return get_the_time('F,  Y');
            if (is_day()) return get_the_time('F j, Y');
        }
        elseif (is_tag())
        {
            return single_tag_title('', FALSE);
        }
        elseif (is_search() && $_GET['s'] != '')
        {
            $search = get_search_query();
            if (strlen($search) > 25) $search = substr($search, 0, 15).'...';
            return '"'.$search.'"';
        }
        elseif (is_search() && $_GET['s'] == '')
        {
            return 'All Posts';
        }
        elseif (is_404())
        {
            return '404 Error!';
        }
        elseif (is_author())
        {
            $author = get_user_by('id', $post->post_author)->data;
            return 'Posts by '.get_the_author_meta('first_name', $author->ID);
        }
        elseif (is_category())
        {
            $category = get_category(get_query_var('cat'));
            return $category->name;
        }
        elseif (is_tax())
        {
            return $wp_query->queried_object->name;
        }
        else
        {
            return FALSE;
        }
    }

    /*=====================================
    =            GRAB SUBTITLE            =
    =====================================*/
    function grab_subtitle() {
        global $post;
        global $wp_query;

        if (is_archive() && !is_category() && !is_tag() && !is_author() && !is_tax())
        {
            return 'Archive';
        }
        if (is_page())
        {
            if (is_front_page()) return false;

            if ( function_exists('yoast_breadcrumb') ) {
                return yoast_breadcrumb( '','', 0);
            }


            
            $new_subheader = '';
            $slugs = $_SERVER['REQUEST_URI'];
            $slugs = explode('/', $slugs);
            $build_up = '';
            $count = count($slugs);
            foreach ($slugs as $slug)
            {
                if ($slug != '')
                {
                    $build_up .= '/'.$slug; 
                    $new_subheader .= '<a href="'.get_permalink(url_to_postid($build_up)).'">'.get_the_title(url_to_postid($build_up)).'</a> ';
                    $new_subheader .= ' <span class="breader"><i class="fas fa-angle-right"></i></span> ';
                    $i++;
                }
            }


            if (trim(strip_tags($new_subheader)) == trim(get_the_title())) {
                return get_bloginfo();
            }

            return $new_subheader;
            return get_the_title(wp_get_post_parent_id($post->ID));
        }
        elseif (is_single() && get_post_type() == 'post')
        {
            $cat_array = array();
            $categories = get_the_category();
            if ($categories && !empty($categories)) : foreach ($categories as $category) :
                $cat_array[] = '<a href="'.get_category_link($category->term_id).'">'.$category->name.'</a>';
            endforeach; endif;
            if (!empty($cat_array)) $subheader = implode(' <span class="separator">|</span> ', $cat_array);

            return $subheader;
        }
        elseif (is_tag())
        {
            return 'Tagged';
        }
        elseif (is_search() && $_GET['s'] != '')
        {
            return 'Search Results';
        }
        elseif (is_search() && $_GET['s'] == '')
        {
            return 'Search Results';
        }
        elseif (is_404())
        {
            return 'Page Not Found';
        }
        elseif (is_author())
        {
            return 'Author';
        }
        elseif (is_category())
        {
            return 'Category';
        }
        elseif (is_tax())
        {
            return 'Taxonomy';
        }
        else
        {
            return FALSE;
        }
    }












    /*========================================
    =            CUSTOM ENDPOINTS            =
    ========================================*/
    add_action('pre_get_posts', function ($query) {

        if (!is_admin() && $query->is_main_query()) :

            global $wp;
            // require_once 'routes/index.php';


            if ($wp->request == '_purge-caches') {

                $what = purge_cloudflare_cache();
                var_dump($what);
                
                exit;
            }




        endif;
    });





	/*=================================================
	=            EXCLUDE PAGES FROM SEARCH            =
	=================================================*/
	// function exclude_pages( $query ) {
    //     if ($query->is_search) {
	// 		$query->set('post_type', 'post');
	//     }

	//     return $query;
	// }
	// add_filter('pre_get_posts', 'exclude_pages');






    /*==================================
    =            MAKE POPUP            =
    ==================================*/
    function make_popup($url) {

        if (!$url) return NULL;

        if (strpos($url, 'list=') > 0) return NULL;
        
        if (strpos($url, 'youtube.com') > 0) return 'make-popup';
        if (strpos($url, 'vimeo.com') > 0) return 'make-popup';
        if (strpos($url, '.png') > 0) return 'make-popup';
        if (strpos($url, '.jpg') > 0) return 'make-popup';
        if (strpos($url, '.jpeg') > 0) return 'make-popup';
        if (strpos($url, '.gif') > 0) return 'make-popup';
        if (strpos($url, 'pop-me-up=1') > 0) return 'make-popup';

        return NULL;
    }

    // function page_has_popup() {
    //     if (get_field('override_sitewide_popup') && get_field('override_type') == 'disable') {
    //         return false;
    //     }
    //     return boolval(get_field('turn_popup_on', 'option'));
    // }

    function get_popup_field($key) {
        return (grab_field($key) ? grab_field($key) : get_field($key, 'option'));
    }

    function is_video_url($url) {

        if (!$url) return FALSE;

        if (strpos($url, 'youtube.com') > 0) return TRUE;
        if (strpos($url, 'vimeo.com') > 0) return TRUE;

        return FALSE;
    }



    /*=====================================
    =            IS NEW WINDOW            =
    =====================================*/
    function is_new_window($url, $post_id = FALSE) {

        // if (strpos($url,'/donate') !== false) {
        //     return '_blank';
        // }

        // if URL ends with .pdf...
        if (substr($url, -4) == '.pdf') return '_blank';
        if (substr($url, -4) == '.png') return '_blank';
        if (substr($url, -4) == '.jpg') return '_blank';
        if (substr($url, -4) == '.jpeg') return '_blank';

        
        if ($post_id) :

            if (get_field('_pprredirect_active', $post_id)) return '_blank';

        endif;

        if (substr($url, 0, 1) == '/') return '_self';
        if (substr($url, 0, 1) == '#') return '_self';

        if (strpos($url, $_SERVER['HTTP_HOST']) === false) {
            return '_blank';
        } else {
            return '_self';
        }
    }



    /*===========================
    =            SVG            =
    ===========================*/
    function cc_mime_types($mimes) {
        $mimes['svg'] = 'image/svg+xml';
        $mimes['webp'] = 'image/webp';
        return $mimes;
    }
    add_filter('upload_mimes', 'cc_mime_types');


    /*====================================
    =            SOCIAL MEDIA            =
    ====================================*/
    // if (!wp_next_scheduled('my_task_hook')) {
    //     wp_schedule_event( time(), 'hourly', 'my_task_hook' );
    // }
    // add_action( 'my_task_hook', 'my_task_function' );

    // function my_task_function() {
    //     // @file_get_contents(get_site_url().'/.process-facebook');
    //     @file_get_contents(get_site_url().'/_process-twitter');
    //     // @file_get_contents(get_site_url().'/_process-instagram');
    //     // @file_get_contents(get_site_url().'/_process-medium');
    // }



















    // add_action('acf/include_fields', function() {
    //     if (!function_exists('acf_add_local_field_group')) {
    //         return;
    //     }
    
    //     acf_add_local_field_group([
    //         'key' => 'group_msea_convention_template',
    //         'title' => 'MSEA Convention Template',
    //         'location' => [
    //             [
    //                 [
    //                     'param' => 'post_type',
    //                     'operator' => '==',
    //                     'value' => 'page',
    //                 ],
    //             ],
    //         ],

    //         'fields' => [
    //             [
    //                 'key' => 'hero_group_tab',
    //                 'label' => 'Hero',
    //                 'type' => 'tab',
    //                 'placement' => 'left',
    //                 'endpoint' => 0,
    //             ],
    //                 [
    //                     'key' => 'field_6744f5779c303', 
    //                     'label' => 'Instructions',
    //                     'name' => '',
    //                     'type' => 'tab',
    //                     'instructions' => '',
    //                     'required' => 0,
    //                     'conditional_logic' => 0,
    //                     'placement' => 'top',
    //                     'endpoint' => 1,
    //                     'selected' => 0,
    //                 ],
    //                 [
    //                     'key' => 'field_6744f5d90c8bd',
    //                     'label' => 'Notes',
    //                     'name' => '',
    //                     'type' => 'message',
    //                     'instructions' => '',
    //                     'required' => 0,
    //                     'conditional_logic' => 0,
    //                     'message' => 'Lorem ipsum',
    //                     'new_lines' => 'wpautop',
    //                     'esc_html' => 0,
    //                 ],
    //                 [
    //                     'key' => 'field_6744f4eb0f702',
    //                     'label' => 'Mockup',
    //                     'name' => '',
    //                     'type' => 'message',
    //                     'instructions' => '',
    //                     'required' => 0,
    //                     'conditional_logic' => 0,
    //                     'message' => '<img src="/template/img/hero.jpg">',
    //                     'new_lines' => '',
    //                     'esc_html' => 0,
    //                 ],
    //                 [
    //                     'key' => 'field_6744f5879c304',
    //                     'label' => 'Options',
    //                     'name' => '',
    //                     'type' => 'tab',
    //                     'instructions' => '',
    //                     'required' => 0,
    //                     'conditional_logic' => 0,
    //                     'placement' => 'top',
    //                     'endpoint' => 0,
    //                     'selected' => 0,
    //                 ],
    //                 [
    //                     'key' => 'field_6744f3fe0f6ff',
    //                     'label' => 'Subheader',
    //                     'name' => 'subheader',
    //                     'type' => 'text',
    //                     'instructions' => '',
    //                     'required' => 0,
    //                     'conditional_logic' => 0,
    //                     'default_value' => '',
    //                     'maxlength' => '',
    //                     'allow_in_bindings' => 0,
    //                     'placeholder' => '',
    //                 ],
    //                 [
    //                     'key' => 'field_6744f4060f700',
    //                     'label' => 'Header',
    //                     'name' => 'header', 
    //                     'type' => 'text',
    //                     'instructions' => '',
    //                     'required' => 0,
    //                     'conditional_logic' => 0,
    //                     'default_value' => '',
    //                     'maxlength' => '',
    //                     'allow_in_bindings' => 0,
    //                     'placeholder' => '',
    //                 ],
    //                 [
    //                     'key' => 'field_6744f40b0f701',
    //                     'label' => 'Text',
    //                     'name' => 'text',
    //                     'type' => 'text',
    //                     'instructions' => '',
    //                     'required' => 0,
    //                     'conditional_logic' => 0,
    //                     'default_value' => '',
    //                     'maxlength' => '',
    //                     'allow_in_bindings' => 0,
    //                     'placeholder' => '',
    //                 ],
    //             [
    //                 'key' => 'field_6744f66f44eb0',
    //                 'label' => 'Featured Buttons',
    //                 'name' => '',
    //                 'type' => 'tab',
    //                 'instructions' => '',
    //                 'required' => 0,
    //                 'conditional_logic' => 0,
    //                 'placement' => 'left',
    //                 'endpoint' => 1,
    //                 'selected' => 0,
    //             ],
    //             [
    //                 'key' => 'field_6744f70a018a3',
    //                 'label' => 'fdafsd',
    //                 'name' => 'fdafsd',
    //                 'type' => 'text',
    //                 'instructions' => '',
    //                 'required' => 0,
    //                 'conditional_logic' => 0,
    //                 'default_value' => '',
    //                 'maxlength' => '',
    //                 'allow_in_bindings' => 0,
    //                 'placeholder' => '',
    //             ],
    //         ],

    //     ]);
    // });









    // Cloudflare cache purge function
    function purge_cloudflare_cache() {
        $auth_token = 'nOp3wtR22m-oz4S-_9DxBHp6de9L1a6gH5ddKqX9';
        $zone_id = '542fe71adf6bcf092e9970ef41f1dbc1'; // Add your Cloudflare zone ID here
        
        $url = "https://api.cloudflare.com/client/v4/zones/{$zone_id}/purge_cache";
        
        $args = array(
            'method' => 'POST',
            'headers' => array(
                'Authorization' => 'Bearer ' . $auth_token,
                'Content-Type' => 'application/json'
            ),
            'body' => json_encode(array(
                'purge_everything' => true
            ))
        );

        $response = wp_remote_post($url, $args);

        if (is_wp_error($response)) {
            error_log('Cloudflare cache purge failed: ' . $response->get_error_message());
            return false;
        }

        $body = json_decode(wp_remote_retrieve_body($response), true);
        
        // if ($body['success']) {
            return $body;
        // }
        
        // error_log('Cloudflare cache purge failed: ' . print_r($body['errors'], true));
        // return false;
    }

    // Hook into WordPress save actions to automatically purge cache
    add_action('save_post', 'purge_cloudflare_cache');
    add_action('edit_post', 'purge_cloudflare_cache');
    add_action('delete_post', 'purge_cloudflare_cache');





    if (function_exists('acf_add_options_page')) {
        acf_add_options_page(array(
            'page_title'    => 'Settings',
            'menu_title'    => 'Settings',
            'menu_slug'     => 'general-settings',
            'capability'    => 'edit_posts',
            'redirect'      => false
        ));
    }






    function grab_field($key, $id = NULL, $type = NULL, $pointer = NULL) {
        if ($type == 'default') return get_field($key, $id);

        if (is_category() || $type == 'category')
        {
            if (is_null($id)) :
                $category = get_category(get_query_var('cat'));
                $id = $category->term_id;
            endif;

            return get_field($key, $category);
        }
        elseif (is_tag() || $type == 'tag')
        {
            if (is_null($id))
                $id = get_queried_object()->term_id;

            return get_option('post_tag_'.$id.'_'.$key);
        }
        elseif (is_tax() || $type == 'tax')
        {
            global $wp_query;
            if (is_null($id))
                $id = $wp_query->queried_object->term_id;

            if (is_null($pointer))
                $pointer = $wp_query->queried_object->taxonomy;

            return get_option($pointer.'_'.$id.'_'.$key);
        }
        elseif (is_search())
        {
            return FALSE;
        }
        else
        {
            return get_field($key, $id);
        }
    }
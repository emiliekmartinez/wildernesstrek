<?php
function my_theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

// INCLUDE JS AND CSS FILES HERE
function camp_eagle_scripts() {
    // CSS DIRECTORY
    wp_enqueue_style( 'slick-css', get_stylesheet_directory_uri() . '/css/slick.css' );
    wp_enqueue_style( 'slick-theme-css', get_stylesheet_directory_uri() . '/css/slick-theme.css' );
    // wp_enqueue_style( 'style-css-2', get_stylesheet_directory_uri() . '/style-2.css' );
    // Foundation CSS
    wp_enqueue_style( 'foundation-min', get_stylesheet_directory_uri() . '/css/foundation.min.css' );
    wp_enqueue_style( 'foundation-app-css', get_stylesheet_directory_uri() . '/css/app.css' );
    
    // JS DIRECTORY
    wp_enqueue_script( 'custom-js', get_stylesheet_directory_uri() . '/js/custom.js', array(), '1.0.0', true );
    wp_enqueue_script( 'custom-js-2', get_stylesheet_directory_uri() . '/js/custom-2.js', array(), '1.0.0', true );

    // Sweet Alert Includes
    wp_enqueue_script( 'sweet-alert', get_stylesheet_directory_uri() . '/js/sweetalert.min.js', array(), '1.0.0', true );

    // Scroll Magic Includes
    wp_enqueue_script( 'scrollmagic', get_stylesheet_directory_uri() . '/js/minified/ScrollMagic.min.js', array(), '1.0.0', true );
    wp_enqueue_script( 'TweenMax', get_stylesheet_directory_uri() . '/js/greensock/TweenMax.min.js', array(), '1.0.0', false );
    wp_enqueue_script( 'TimelineLite', get_stylesheet_directory_uri() . '/js/greensock/TimelineLite.min.js', array(), '1.0.0', false );
    wp_enqueue_script( 'TimelineMax', get_stylesheet_directory_uri() . '/js/greensock/TimelineMax.min.js', array(), '1.0.0', false );
    wp_enqueue_script( 'TweenLite', get_stylesheet_directory_uri() . '/js/greensock/TweenLite.min.js', array(), '1.0.0', false );
    wp_enqueue_script( 'animation-gsap', get_stylesheet_directory_uri() . '/js/plugins/animation.gsap.min.js', array(), '1.0.0', true );
    wp_enqueue_script( 'CSS-Rule-Plugin', get_stylesheet_directory_uri() . '/js/CSSRulePlugin.js', array(), '1.0.0', true );
    //DRAW SVG
    wp_enqueue_script( 'Draw-SVG', get_stylesheet_directory_uri() . '/js/greensock/plugins/DrawSVGPlugin.min.js', array(), '1.0.0', true );
    // Triggers
    wp_enqueue_script( 'tracking-indicators', get_stylesheet_directory_uri() . '/js/plugins/debug.addIndicators.min.js', array(), '1.0.0', true );
    // AngularJS Includes
    wp_enqueue_script( 'angular-min', get_stylesheet_directory_uri() . '/js/angular.min.js', array(), '1.0.0', false );
    // ReactJS Includes
    wp_enqueue_script( 'react-min', get_stylesheet_directory_uri() . '/js/react.min.js', array(), '1.0.0', false );
    wp_enqueue_script( 'react-dom', get_stylesheet_directory_uri() . '/js/react-dom.js', array(), '1.0.0', false );
    // Slick SLider JS Includes
    wp_enqueue_script( 'slick-slider', get_stylesheet_directory_uri() . '/js/slick.min.js', array(), '1.0.0', false );

    // Foundation JS Includes
    wp_enqueue_script( 'foundation-js', get_stylesheet_directory_uri() . '/js/vendor/foundation.js', array(), '1.0.0', true );
    wp_enqueue_script( 'foundation-app-js', get_stylesheet_directory_uri() . '/js/app.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'camp_eagle_scripts' );

// ALLOW SVG UPLOADS
function my_custom_mime_types( $mimes ) {
 
// New allowed mime types.
$mimes['svg'] = 'image/svg+xml';
$mimes['svgz'] = 'image/svg+xml';
$mimes['doc'] = 'application/msword';
 
// Optional. Remove a mime type.
unset( $mimes['exe'] );
 
return $mimes;
}
add_filter( 'upload_mimes', 'my_custom_mime_types' );

// SUPPORT FOR SVG
function add_file_types_to_uploads($file_types){
  $new_filetypes = array();
  $new_filetypes['svg'] = 'image/svg+xml';
  $file_types = array_merge($file_types, $new_filetypes );
  return $file_types;
}
add_action('upload_mimes', 'add_file_types_to_uploads');



// ENABLING AND DISABLING WPAUTOP ON EITHER PAGES OR POSTS
function disable_wpautop_on_pages($content)
{

  $post_id = get_the_ID();

  //If it's a Page we remove wpautop by default, unless overriden
  if ( get_post_type() == 'page' ) {

    //check for the 'enable_wpautop' override in the Custom Fields
    if ( get_post_meta($post_id, 'disable_wpautop', true )) {
      return wpautop($content);
    }
    return $content;
  }
  
  //All other post types (blog posts or custom types) use wpautop
  //unless overriden with 'disable_wpautop'
  if ( get_post_meta($post_id, 'enable_wpautop', true )) {
    return $content;
  }  
  return wpautop($content);

}
remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );
add_filter( 'the_content', 'disable_wpautop_on_pages' );
add_filter( 'the_excerpt', 'disable_wpautop_on_pages' );

// GENERATE STAFF CUSTOM POST TYPE
function ce_staff_init() {
    $args = array(
      'label' => 'Staff',
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'page',
        'hierarchical' => false,
        'rewrite' => array('slug' => 'staff'),
        'query_var' => true,
        'menu_icon' => 'dashicons-groups',
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'trackbacks',
            'custom-fields',
            'comments',
            'revisions',
            'thumbnail',
            'author',
            'page-attributes',)
        );

    register_post_type( 'staff', $args );
}
add_action( 'init', 'ce_staff_init' );


// Include Sidebar Menu
function register_my_menus() {
  register_nav_menus(
    array(
      'side-menu' => __( 'Side Menu' ),
      'mobile-menu' => __( 'Mobile Menu' ),
    )
  );
}

add_action( 'init', 'register_my_menus' );


// Add duplicate button for pages and posts
function rd_duplicate_post_as_draft(){
    global $wpdb;
    if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'rd_duplicate_post_as_draft' == $_REQUEST['action'] ) ) ) {
        wp_die('No post to duplicate has been supplied!');
    }
 
    /*
     * Nonce verification
     */
    if ( !isset( $_GET['duplicate_nonce'] ) || !wp_verify_nonce( $_GET['duplicate_nonce'], basename( __FILE__ ) ) )
        return;
 
    /*
     * get the original post id
     */
    $post_id = (isset($_GET['post']) ? absint( $_GET['post'] ) : absint( $_POST['post'] ) );
    /*
     * and all the original post data then
     */
    $post = get_post( $post_id );
 
    /*
     * if you don't want current user to be the new post author,
     * then change next couple of lines to this: $new_post_author = $post->post_author;
     */
    $current_user = wp_get_current_user();
    $new_post_author = $current_user->ID;
 
    /*
     * if post data exists, create the post duplicate
     */
    if (isset( $post ) && $post != null) {
 
        /*
         * new post data array
         */
        $args = array(
            'comment_status' => $post->comment_status,
            'ping_status'    => $post->ping_status,
            'post_author'    => $new_post_author,
            'post_content'   => $post->post_content,
            'post_excerpt'   => $post->post_excerpt,
            'post_name'      => $post->post_name,
            'post_parent'    => $post->post_parent,
            'post_password'  => $post->post_password,
            'post_status'    => 'draft',
            'post_title'     => $post->post_title,
            'post_type'      => $post->post_type,
            'to_ping'        => $post->to_ping,
            'menu_order'     => $post->menu_order
        );
 
        /*
         * insert the post by wp_insert_post() function
         */
        $new_post_id = wp_insert_post( $args );
 
        /*
         * get all current post terms ad set them to the new post draft
         */
        $taxonomies = get_object_taxonomies($post->post_type); // returns array of taxonomy names for post type, ex array("category", "post_tag");
        foreach ($taxonomies as $taxonomy) {
            $post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
            wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
        }
 
        /*
         * duplicate all post meta just in two SQL queries
         */
        $post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
        if (count($post_meta_infos)!=0) {
            $sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
            foreach ($post_meta_infos as $meta_info) {
                $meta_key = $meta_info->meta_key;
                if( $meta_key == '_wp_old_slug' ) continue;
                $meta_value = addslashes($meta_info->meta_value);
                $sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
            }
            $sql_query.= implode(" UNION ALL ", $sql_query_sel);
            $wpdb->query($sql_query);
        }
 
 
        /*
         * finally, redirect to the edit post screen for the new draft
         */
        wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
        exit;
    } else {
        wp_die('Post creation failed, could not find original post: ' . $post_id);
    }
}
add_action( 'admin_action_rd_duplicate_post_as_draft', 'rd_duplicate_post_as_draft' );
 
/*
 * Add the duplicate link to action list for post_row_actions
 */
function rd_duplicate_post_link( $actions, $post ) {
    if (current_user_can('edit_posts')) {
        $actions['duplicate'] = '<a href="' . wp_nonce_url('admin.php?action=rd_duplicate_post_as_draft&post=' . $post->ID, basename(__FILE__), 'duplicate_nonce' ) . '" title="Duplicate this item" rel="permalink">Duplicate</a>';
    }
    return $actions;
}
 
add_filter( 'post_row_actions', 'rd_duplicate_post_link', 10, 2 );
add_filter( 'page_row_actions', 'rd_duplicate_post_link', 10, 2 );
add_filter( 'category_row_actions', 'rd_duplicate_post_link', 10, 2 );




// CUSTOM ADMIN DASHBOARD CSS INCLUDE
function my_admin_dashboard() {
echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('stylesheet_directory') . '/admin/admin.css" />';
}
add_action('admin_head', 'my_admin_dashboard');


// CUSTOM LOGIN CSS INCLUDE
function my_custom_login() {
echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('stylesheet_directory') . '/login/custom-login-styles.css" />';
}
add_action('login_head', 'my_custom_login');


// REPOINT LOGO URL
function my_login_logo_url() {
return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
return 'Your Site Name and Info';
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );


// LOGIN ERROR MODS
function login_error_override()
{
    return 'Incorrect login details.';
}
add_filter('login_errors', 'login_error_override');

// REMOVE LOGIN SHAKE
function my_login_head() {
remove_action('login_head', 'wp_shake_js', 12);
}
add_action('login_head', 'my_login_head');

// CHANGE REDIRECT URL
function admin_login_redirect( $redirect_to, $request, $user )
{
global $user;
if( isset( $user->roles ) && is_array( $user->roles ) ) {
if( in_array( "administrator", $user->roles ) ) {
return $redirect_to;
} else {
return home_url();
}
}
else
{
return $redirect_to;
}
}
add_filter("login_redirect", "admin_login_redirect", 10, 3);

// SET REMEMBER ME TO CHECKED
function login_checked_remember_me() {
add_filter( 'login_footer', 'rememberme_checked' );
}
add_action( 'init', 'login_checked_remember_me' );

function rememberme_checked() {
echo "<script>document.getElementById('rememberme').checked = true;</script>";
}

// ADMIN FOOTER
function wpse_edit_footer() {
    add_filter( 'admin_footer_text', 'wpse_edit_text', 11 );
}

function wpse_edit_text($content) {
    return "Design and developed by <a target='_blank' href='https://holmesmillet.com'>Holmes Millet Advertising</a> and <a target='_blank' href='https://hminteractive.io'>HM Interactive</a>";
}

add_action( 'admin_init', 'wpse_edit_footer' );


// DISABLE OPTIMIZATION ON SPECIFIC PAGES
add_filter('autoptimize_filter_noptimize','my_ao_noptimize',10,0);
function my_ao_noptimize() {
if (strpos($_SERVER['REQUEST_URI'],'tell-us-your-story','memories')!==false) {
return true;
} else {
return false;
}
}

// REMOVE QUERY STRINGS
// function _remove_script_version( $src ){ 
//     $parts = explode( '?', $src );  
//     return $parts[0]; 
// } 
// add_filter( 'script_loader_src', '_remove_script_version', 15, 1 ); 
// add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );

// Defer Javascripts
// Defer jQuery Parsing using the HTML5 defer property
// if (!(is_admin() )) {
//     function defer_parsing_of_js ( $url ) {
//         if ( FALSE === strpos( $url, '.js' ) ) return $url;
//         if ( strpos( $url, 'jquery.js' ) ) return $url;
//         // return "$url' defer ";
//         return "$url' defer onload='";
//     }
//     add_filter( 'clean_url', 'defer_parsing_of_js', 11, 1 );
// }

/**
 * Defer parsing of javascript.
 */


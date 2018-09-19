<?php

/* loading theme style */
function unite_child_enqueue_styles()
{

    $parent_style = 'unite-style';

    wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css');
    wp_enqueue_style('unite-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array($parent_style),
        wp_get_theme()->get('Version')
    );
}
add_action('wp_enqueue_scripts', 'unite_child_enqueue_styles');

/*
 * create post type "films" and its taxonomies
 * */
function create_post_films()
{
    register_post_type('films',
        array(
            'labels' => array(
                'name' => __('Films'),
                'add_new' => __( 'New film' ),
                'add_new_item' => __( 'Add New film' ),
                'edit_item' => __( 'Edit film' ),
                'new_item' => __( 'New film' ),
                'view_item' => __( 'View film' ),
                'search_items' => __( 'Search films' ),
                'not_found' =>  __( 'No films Found' ),
                'not_found_in_trash' => __( 'No films found in Trash' ),
            ),
            'menu_icon' => 'dashicons-format-video',
            'public' => true,
            'hierarchical' => true,
            'has_archive' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'capability_type' => 'page',
            'supports' => array(
                'title',
                'editor',
                'thumbnail',
	            'page-attributes'
            ),
        )
    );
    register_taxonomy("genre", array("films"), array(
        'labels' => array(
	        'name'              => 'Genre',
	        'singular_name'     => 'Film Genre',
	        'search_items'      => 'Search Film Genres',
	        'all_items'         => 'All Film Genres',
	        'edit_item'         => 'Edit Film Genres',
	        'update_item'       => 'Update Film Genre',
	        'add_new_item'      => 'Add New Film Genre',
	        'new_item_name'     => 'New Film Genre Name',
	        'menu_name'         => 'Film Genre',
        ),
        "hierarchical" => false,
        "rewrite" => true,
        'sort' => true,
        'args' => array( 'orderby' => 'term_order' ),
        'show_admin_column' => true
    ));
    register_taxonomy("country", array("films"), array(
	    'labels' => array(
		    'name'              => 'Country',
		    'singular_name'     => 'Film Country',
		    'search_items'      => 'Search Film Countries',
		    'all_items'         => 'All Film Countries',
		    'edit_item'         => 'Edit Film Countries',
		    'update_item'       => 'Update Film Country',
		    'add_new_item'      => 'Add New Film Country',
		    'new_item_name'     => 'New Film Country Name',
		    'menu_name'         => 'Film Country',
	    ),
	    "hierarchical" => false,
        "rewrite" => true,
        'sort' => true,
        'args' => array( 'orderby' => 'term_order' ),
        'show_admin_column' => true
    ));
    register_taxonomy("year", array("films"), array(
	    'labels' => array(
		    'name'              => 'Year',
		    'singular_name'     => 'Film Year',
		    'search_items'      => 'Search Film Years',
		    'all_items'         => 'All Film Years',
		    'edit_item'         => 'Edit Film Years',
		    'update_item'       => 'Update Film Year',
		    'add_new_item'      => 'Add New Film Year',
		    'new_item_name'     => 'New Film Year Name',
		    'menu_name'         => 'Film Year',
	    ),
	    "hierarchical" => false,
        "rewrite" => true,
        'sort' => true,
        'args' => array( 'orderby' => 'term_order' ),
        'show_admin_column' => true
    ));
    register_taxonomy("actors", array("films"), array(
	    'labels' => array(
		    'name'              => 'Actors',
		    'singular_name'     => 'Film Actor',
		    'search_items'      => 'Search Film Actors',
		    'all_items'         => 'All Film Actors',
		    'edit_item'         => 'Edit Film Actors',
		    'update_item'       => 'Update Film Actors',
		    'add_new_item'      => 'Add New Film Actors',
		    'new_item_name'     => 'New Film Actors Name',
		    'menu_name'         => 'Film Actors',
	    ),
	    "hierarchical" => false,
        "singular_label" => "Actors",
        "rewrite" => true,
        'sort' => true,
        'args' => array( 'orderby' => 'term_order' ),
        'show_admin_column' => true
    ));
}

add_action('init', 'create_post_films');

function add_films_meta_boxes()
{
    add_meta_box("films_meta", "Films Details", "add_films_meta_box", "films", "normal", "low");
}

function add_films_meta_box()
{
    global $post;
    $custom = get_post_custom($post->ID);

    ?>
    <div class="container">
    <div class="row">
    <div class='col-sm-6'>
        <div class="form-group">
            <label class="" for="ticket_price">Ticket Price:</label>
            <input type="number" id="ticket_price" name="ticket_price" value="<?= @$custom["ticket_price"][0] ?>"
                   />
        </div>
    </div>

    <div class='col-sm-6'>
        <div class="form-group">
            <label class="" for="release_date">Release Date:</label>
            <input type="date" id="release_date" name="release_date" value="<?= @$custom["release_date"][0] ?>"
                   />
        </div>
    </div>
    </div>
    </div>
    <?php
}

/**
 * Save custom field data when creating/updating posts
 */
function save_films_custom_fields()
{
    global $post;

    if ($post) {
        update_post_meta($post->ID, "ticket_price", @$_POST["ticket_price"]);
        update_post_meta($post->ID, "release_date", @$_POST["release_date"]);
    }
}

add_action('admin_init', 'add_films_meta_boxes');
add_action('save_post', 'save_films_custom_fields');

add_filter( 'manage_films_posts_columns', 'set_custom_edit_films_columns' );
function set_custom_edit_films_columns($columns) {
    unset( $columns['author'] );
    $columns['ticket_price'] = __( 'Ticket Price', 'ticket_price' );
    $columns['release_date'] = __( 'Release Date', 'release_date' );

    return $columns;
}

// Add the data to the custom columns for the book post type:
add_action( 'manage_films_posts_custom_column' , 'custom_films_column', 10, 2 );
function custom_films_column( $column, $post_id ) {
    switch ( $column ) {
        case 'ticket_price' :
            echo get_post_meta( $post_id , 'ticket_price' , true );
            break;
        case 'release_date' :
            echo get_post_meta( $post_id , 'release_date' , true );
            break;

    }
}


function latest_films( $atts ){

	$args = array(
		'numberposts' => 5,
		'offset' => 0,
		'category' => 0,
		'orderby' => 'post_date',
		'order' => 'DESC',
		'include' => '',
		'exclude' => '',
		'meta_key' => '',
		'meta_value' =>'',
		'post_type' => 'films',
		'post_status' => 'publish, future',
		'suppress_filters' => true
	);

	$recent_posts = wp_get_recent_posts( $args, ARRAY_A );

    $output ='<h2>Recent Films</h2><ul>';

	foreach( $recent_posts as $recent ){
		$output .='<li><a href="' . get_permalink($recent["ID"]) . '">' .   $recent["post_title"].'</a> </li> ';
	}
	wp_reset_query();

	$output .= '</ul>';

	return $output;
}
add_shortcode( 'latest_films', 'latest_films' );

/**
 * @param $form
 *
 * @return string
 * place shortcode under search form
 */
function alter_search_form( $form )
{
	return $form . do_shortcode('[latest_films]');
}
add_filter( 'get_search_form', 'alter_search_form' );

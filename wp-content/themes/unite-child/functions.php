<?php

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

function create_post_films()
{
    register_post_type('films',
        array(
            'labels' => array(
                'name' => __('Films'),
            ),
            'public' => true,
            'hierarchical' => true,
            'has_archive' => true,
            'supports' => array(
                'title',
                'editor',
                'thumbnail',
            ),
        )
    );
    register_taxonomy("genre", array("films"), array(
        "hierarchical" => false,
        "label" => "Genre",
        "singular_label" => "Genre",
        "rewrite" => true
    ));
    register_taxonomy("country", array("films"), array(
        "hierarchical" => false,
        "label" => "Country",
        "singular_label" => "Country",
        "rewrite" => true
    ));
    register_taxonomy("year", array("films"), array(
        "hierarchical" => false,
        "label" => "Year",
        "singular_label" => "Year",
        "rewrite" => true
    ));
    register_taxonomy("actors", array("films"), array(
        "hierarchical" => false,
        "label" => "Actors",
        "singular_label" => "Actors",
        "rewrite" => true
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
    $columns['genre'] = __( 'Genre', 'genre' );
    $columns['country'] = __( 'Country', 'country' );
    $columns['year'] = __( 'Year', 'year' );
    $columns['actors'] = __( 'Actors', 'actors' );

    return $columns;
}

// Add the data to the custom columns for the book post type:
add_action( 'manage_films_posts_custom_column' , 'custom_films_column', 10, 2 );
function custom_films_column( $column, $post_id ) {
    switch ( $column ) {

        case 'genre' :
            $terms = get_the_term_list( $post_id , 'genre' , '' , ',' , '' );
            if ( is_string( $terms ) )
                echo $terms;
            else
                _e( 'Unable to get genre(s)', '' );
            break;

        case 'country' :
            $terms = get_the_term_list( $post_id , 'country' , '' , ',' , '' );
            if ( is_string( $terms ) )
                echo $terms;
            else
                _e( 'Unable to get country(s)', '' );
            break;

        case 'year' :
            $terms = get_the_term_list( $post_id , 'year' , '' , ',' , '' );
            if ( is_string( $terms ) )
                echo $terms;
            else
                _e( 'Unable to get year', '' );
            break;

        case 'actors' :
            $terms = get_the_term_list( $post_id , 'actors' , '' , ',' , '' );
            if ( is_string( $terms ) )
                echo $terms;
            else
                _e( 'Unable to get actor(s)', '' );
            break;

        case 'ticket_price' :
            echo get_post_meta( $post_id , 'ticket_price' , true );
            break;
        case 'release_date' :
            echo get_post_meta( $post_id , 'release_date' , true );
            break;

    }
}



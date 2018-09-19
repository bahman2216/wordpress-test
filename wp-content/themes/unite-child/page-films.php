<?php
/**
 * Created by PhpStorm.
 * User: Muhammad
 * Date: 9/19/2018
 * Time: 15:30
 */
get_header(); ?>

    <div id="primary" class="content-area col-sm-12 col-md-8 <?php echo of_get_option( 'site_layout' ); ?>">
        <main id="main" class="site-main" role="main">

          <?php
            $args = array(
                'post_type' => 'films',
            );
            $films = new WP_Query( $args );

            if ( $films->have_posts() ) : while ( $films->have_posts() ) : $films->the_post();
            $meta = get_post_meta( $post->ID, 'title', true ); ?>

                <h1>Title</h1>
                <?php the_title(); ?>

                <h1>Content</h1>
                <?php the_content(); ?>

            <?php endwhile; endif; wp_reset_postdata(); ?>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

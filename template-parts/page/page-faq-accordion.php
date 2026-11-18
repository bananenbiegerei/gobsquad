<ul class="accordion m-0 p-0 list-none bg-translucent-white">
<?php
// WP_Query arguments
$args = array(
'post_type'              => array( 'faqs' ),
'category_name' => 'reality and risk' // @BS this should be the selected category name…
);
$query = new WP_Query( $args );
// The Loop
if ( $query->have_posts() ) {
while ( $query->have_posts() ) {
$query->the_post(); ?>
<?php get_template_part('template-parts/partials/faq-card') ?>
<?php }
} else {
// no posts found
}
// Restore original Post Data
wp_reset_postdata();
?>
</ul>

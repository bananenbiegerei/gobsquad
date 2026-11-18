<?php
/*
 * Context text for a featured image. Uses the attachment's Description
 * (post_content) first, then its Caption (post_excerpt), so editors have two
 * places to add photo credit / context. Hidden until hover or keyboard
 * focus on pointer devices; always visible where there is no hover
 * (`touch:`). The background follows the nearest colour scheme
 * (`--scheme-text`, else primary). Pass `caption` in $args to print a
 * gallery image's own text instead of the featured image's.
 */
if ( isset( $args ) && array_key_exists( 'caption', $args ) ) {
  $caption = $args['caption'];
} else {
  $thumbnail_id = get_post_thumbnail_id();
  $attachment   = $thumbnail_id ? get_post( $thumbnail_id ) : null;
  $caption      = $attachment ? ( $attachment->post_content ?: $attachment->post_excerpt ) : '';
}
?>
<?php if ( $caption ) { ?>
  <p class="absolute bottom-0 left-0 mb-0 w-auto p-4 text-xs leading-none text-white text-shadow-none bg-[var(--scheme-text,var(--color-primary))] opacity-0 group-hover:opacity-100 group-focus-within:opacity-100 group-hover/swiper:opacity-100 group-focus-within/swiper:opacity-100 touch:opacity-100"><?php echo wp_kses_post( $caption ); ?></p>
<?php } ?>

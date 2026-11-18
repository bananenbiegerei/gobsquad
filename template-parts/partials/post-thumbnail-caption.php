<?php
/*
 * Context text for a featured image. Uses the attachment's Description
 * (post_content) first, then its Caption (post_excerpt), so editors have two
 * places to add photo credit / context. The text stays in the DOM when
 * visually hidden on hover-capable devices (see .caption in pages.css).
 */
$thumbnail_id = get_post_thumbnail_id();
$attachment   = $thumbnail_id ? get_post( $thumbnail_id ) : null;
$caption      = $attachment ? ( $attachment->post_content ?: $attachment->post_excerpt ) : '';
?>
<?php if ( $caption ) { ?>
  <p class="small caption"><?php echo wp_kses_post( $caption ); ?></p>
<?php } ?>

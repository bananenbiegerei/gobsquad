<?php
// check if the flexible content field has rows of data
if( have_rows('flexible_contents') ):
     // loop through the rows of data
    while ( have_rows('flexible_contents') ) : the_row();
        if( get_row_layout() == 'gallery' ):
        	get_template_part('template-parts/block/gallery');
        elseif( get_row_layout() == 'text' ):
        	get_template_part('template-parts/block/text');
        elseif( get_row_layout() == 'single_image' ):
          get_template_part('template-parts/block/image');
        endif;
    endwhile;
else :
    // no layouts found
endif;
?>

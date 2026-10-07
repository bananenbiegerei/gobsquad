<?php
$caption = get_post(get_post_thumbnail_id())->post_content;
?>
<?php if ($caption) { ?>
  <p class="small caption"><?php echo $caption; ?></p>
<?php } ?>

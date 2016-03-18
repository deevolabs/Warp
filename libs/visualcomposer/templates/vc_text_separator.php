<?php
extract(shortcode_atts(array(
    'title' => '',
    'title_align' => 'separator_align_center',
    'subtext' => '',
    'id' => '',
    'class' =>''  
), $atts));

wp_enqueue_style('dx.text_separator');

 
$class_attr = ' class="text_separator ' . $title_align . ' ' . $class . '"';

if($id!='') $id = ' id="' . $id . '"';
else $id = '';


?>

<div <?php echo $id; ?> <?php echo $class_attr; ?>>
    <span>
	   <?php if($title!=''): ?><span class="title"><?php echo $title; ?></span><?php endif; ?>
    </span>
    <?php if($subtext!=''): ?><div class="subtext"><?php echo $subtext; ?></div><?php endif; ?>
</div>

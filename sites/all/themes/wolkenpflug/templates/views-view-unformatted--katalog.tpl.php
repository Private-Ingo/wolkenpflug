<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<?php if (!empty($title)): ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>
<?php foreach ($rows as $id => $row): ?>
  <?php if(($id + 1) % 3 == 1)
  	print '<div class="katalog_row clearfix">';
  ?>
  <div<?php if ($classes_array[$id]) { print ' class="' . $classes_array[$id] .'"';  } ?>>
    <?php print $row;?>
  </div>
  <?php if(($id + 1) % 3 == 0 || $id + 1 == count($rows))
  	print '</div>';
  	?>
<?php endforeach; ?>

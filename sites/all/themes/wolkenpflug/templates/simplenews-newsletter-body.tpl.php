<?php

/**
 * @file
 * Default theme implementation to format the simplenews newsletter body.
 *
 * Copy this file in your theme directory to create a custom themed body.
 * Rename it to override it. Available templates:
 *   simplenews-newsletter-body--[tid].tpl.php
 *   simplenews-newsletter-body--[view mode].tpl.php
 *   simplenews-newsletter-body--[tid]--[view mode].tpl.php
 * See README.txt for more details.
 *
 * Available variables:
 * - $build: Array as expected by render()
 * - $build['#node']: The $node object
 * - $title: Node title
 * - $language: Language code
 * - $view_mode: Active view mode
 * - $simplenews_theme: Contains the path to the configured mail theme.
 * - $simplenews_subscriber: The subscriber for which the newsletter is built.
 *   Note that depending on the used caching strategy, the generated body might
 *   be used for multiple subscribers. If you created personalized newsletters
 *   and can't use tokens for that, make sure to disable caching or write a
 *   custom caching strategy implemention.
 *
 * @see template_preprocess_simplenews_newsletter_body()
 */

	$nowMonat = time() - 2629743;
	
	$query = db_select('node', 'n');
	$query->fields('n', array('nid'));
	$query->condition('n.status', 1);
	$query->condition('n.type', 'werk');
	$query->condition('n.created', $nowMonat , '>' );
	$query->orderBy('created', 'DESC');
	$result = $query->execute();
	
	$record = $result->fetchAll();
	$output = '';
	global $base_root;

	foreach($record as $nid)
	{
		$node = node_load($nid->nid);
		
		// Get some field items from a field called field_image.
		if ($image_items = field_get_items('node', $node, 'field_image'))
		{
			$image_item = array_shift($image_items);
		
		
			// Load the associated file.
			$file = file_load($image_item['fid']);
		
			// An array of image styles to create.
			$image_styles = array('newsletter_image');
		
			foreach ($image_styles as $style_name)
			{
				// Get the location of the new image.
				$derivative_uri = image_style_path($style_name, $file->uri);
				$style = image_style_load($style_name);
				// Create the image.
				image_style_create_derivative($style, $file->uri, $derivative_uri);
			}
		}
		
		$alias = drupal_get_path_alias('node/'. $nid->nid);
		$output[$nid->nid]['title'] = '<a href="' . $base_root .'/' . $alias . '">' . $node->title . '</a>';
		$output[$nid->nid]['summary'] = $node->body[LANGUAGE_NONE][0]['summary'];
		$output[$nid->nid]['imageurl'] = image_style_url('newsletter_image', $node->field_image['und'][0]['uri']);
		$output[$nid->nid]['url'] = $base_root .'/' . $alias;
		
	}
	
?>
	<style>
<!--
body
{
	background: url("<?php print$base_root; ?>/sites/all/themes/wolkenpflug/images/blaetter.jpg") repeat fixed 0 0;
	color:#ffffff !important;
	padding-top:50px;

}

a
{
	color:#ffffff;
}
td
{
	padding:10px;
}
-->
</style>
	
<h3><?php print t('Dear') . ' '. $simplenews_subscriber->mail;?></h3>

	<table align="center" width="800" border="0" cellspacing="0" cellpadding="0" style="margin-right:auto; margin-left:auto;" >
	<tr>
		<td width="220px">
			<a href="$base_root"><img style="width: 220px;" src="<?php print $base_root; ?>/sites/default/files/wolke-tranz.png"></a>
		</td>
		<td style="font-size: 26px; padding-top:30px;">
			<h3><?php print $title; ?></h3>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="border-bottom:2px solid #909090; ">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2" style="font-size: 26px; padding-top:30px; text-align: center">
			<?php print render($build['body']); ?>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="border-bottom:2px solid #909090; ">&nbsp;</td>
	</tr>
	<?php foreach ($output as $print):?>
	<tr>
		<td colspan="2" style="font-size: 26px; padding-top:30px; text-align: center">
		<?php print $print['title'];?>
		</td>
	</tr>
	<tr>
		<td  colspan="2" style="font-size: 20px; text-align: center;">
		<?php print $print['summary'];?>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="text-align: center;">
		<a href="<?php print $print['url'];?>">
			<img style="border: 2px solid #909090; padding:4px;"src="<?php print $print['imageurl'];?>">
		</a>
		</td>
	</tr>
	<tr>
	<td colspan="2" style="border-bottom:2px solid #909090; ">&nbsp;</td>
	</tr>
	<?php endforeach;?>
	</table>
	

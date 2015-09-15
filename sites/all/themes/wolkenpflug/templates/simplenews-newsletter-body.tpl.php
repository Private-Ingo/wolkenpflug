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
?>
<h3><?php print $title; ?></h3>

<h4><?php print t('Dear') . ' '. $simplenews_subscriber->mail;?></h4>
<?php print render($build['body']); ?>
<?php 
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
		
		$alias = drupal_get_path_alias('node/'. $nid->nid);
		
		$output[$nid->nid]['title'] = '<a href="' . $base_root .'/' . $alias . '">' . $node->title . '</a>';
		$output[$nid->nid]['summary'] = $node->body['und'][0]['summary'];
		$output[$nid->nid]['imageurl'] = image_style_url('newsletter_image', $node->field_image['und'][0]['uri']);
		$output[$nid->nid]['url'] = $base_root .'/' . $alias;
		
	}
	
	?>
	<<style>
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
	<table width="600" border="0" cellspacing="0" cellpadding="0" style="background-ima" >
	<?php foreach ($output as $print):?>
	<tr>
		<td style="font-size: 26px; padding-top:30px;">
		<?php print $print['title'];?>
		</td>
	</tr>
	<tr>
		<td  style="font-size: 20px;" align="left">
		<?php print $print['summary'];?>
		</td>
	</tr>
	<tr>
		<td>
		<a href="<?php print $print['url'];?>"><img style="border: 2px solid #909090; padding:4px;"src="<?php print $print['imageurl'];?>"></a>
		</td>
	</tr>
	<tr>
	<td style="border-bottom:2px solid #909090; ">&nbsp;</td>
	</tr>
	<?php endforeach;?>
	</table>
	

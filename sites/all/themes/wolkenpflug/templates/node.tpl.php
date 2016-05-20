<?php

/**
 * @file
 * Default theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: An array of node items. Use render($content) to print them all,
 *   or print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $user_picture: The node author's picture from user-picture.tpl.php.
 * - $date: Formatted creation date. Preprocess functions can reformat it by
 *   calling format_date() with the desired parameters on the $created variable.
 * - $name: Themed username of node author output from theme_username().
 * - $nodes_url: Direct url of the current node.
 * - $display_submitted: Whether submission information should be displayed.
 * - $submitted: Submission information created from $name and $date during
 *   template_preprocess_node().
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - node: The current template type, i.e., "theming hook".
 *   - node-[type]: The current node type. For example, if the node is a
 *     "Blog entry" it would result in "node-blog". Note that the machine
 *     name will often be in a short form of the human readable label.
 *   - node-teaser: Nodes in teaser form.
 *   - node-preview: Nodes in preview mode.
 *   The following are controlled through the node publishing options.
 *   - node-promoted: Nodes promoted to the front page.
 *   - node-sticky: Nodes ordered above other non-sticky nodes in teaser
 *     listings.
 *   - node-unpublished: Unpublished nodes visible only to administrators.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type, i.e. story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $view_mode: View mode, e.g. 'full', 'teaser'...
 * - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * Field variables: for each field instance attached to the node a corresponding
 * variable is defined, e.g. $node->body becomes $body. When needing to access
 * a field's raw values, developers/themers are strongly encouraged to use these
 * variables. Otherwise they will have to explicitly specify the desired field
 * language, e.g. $node->body['en'], thus overriding any language negotiation
 * rule that was previously applied.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see template_process()
 */
	hide($content['field_image']);
	hide($content['comments']);
	hide($content['links']);
	hide($content['field_gruppe']);
	hide($content['service_links']);
	hide($content['field_peecho']);
	unset($content['links']['node']);
	
	global $language;
	global $user;
	$icons = '';
	$addClass = '';
	
	if(isset($content['field_gruppe']) && isset($content['field_gruppe']['#items']))
	{
		foreach ($content['field_gruppe']['#items'] as $item)
		{	
			if($item['taxonomy_term']->language == $language->language)
			{//echo '<pre>' . print_r($item['taxonomy_term'], true) . '</pre>'; die();
				$icons .= '<a href="/'. drupal_get_path_alias('taxonomy/term/'. $item['taxonomy_term']->tid , $language->language) . '">';
				$icons .= theme('image_style', array('path' => $item['taxonomy_term']->field_raume_icons[LANGUAGE_NONE][0]['uri'], 'style_name' => 'raume_icons', 'title' =>$item['taxonomy_term']->name, 'alt' =>$item['taxonomy_term']->name));
				$icons .='</a>';
			}
		}
	}
	$args = arg();
	$iscomment = false;
	if ($args[0] == 'comment' && $args[1] == 'reply')
	{
		$iscomment = true;
	}
?>

<article id="node-<?php print $node->nid; ?>" class="<?php if($type == 'page' ? print 'page_text ' : ''); ?> <?php if($type == 'text' ? print 'text_article ' : ''); ?><?php print $classes; ?> clearfix" <?php print $attributes; ?>>
<?php if(!$page && $type != 'text' && $type != 'simplenews' && !$iscomment):?>
	<div class="text_container">
		<div class="text_container_border">
			<?php print $user_picture; ?>
			<header class="article-header">
		  		<?php if ($display_submitted): ?>
		   		<div class="submit-wrapper">
				      <!-- Then show the date in parts for better theming. -->
				      <div class="date-in-parts">
				        <span class="day"><?php print $thedate; ?></span>
				        <span class="month"><?php print $themonth; ?></span>
				        <span class="year"><?php print $theyear; ?></span>
				      </div><!--//date-in-parts -->
				</div><!--//submit-wrapper-->
		  		<?php endif; ?>
		  		<div class="title-wrapper">
		  			<?php print render($title_prefix); ?>
				<?php if (!$page && $title): ?>
				<h2<?php print $title_attributes; ?>>
					<a href="<?php print $node_url ?>" title="<?php print $title ?>">
		        	<?php print $title ?>
		      		</a>
				</h2>
				<?php else: ?>
		   			 <!-- node h1 title -->
				    <?php if ($title): ?>
				      <h1<?php print $title_attributes; ?>><?php print $title; ?></h1>
				    <?php endif; ?>
				<?php endif; ?>
				<?php print render($title_suffix); ?>
		  				<!-- Overidden in template.php to show just username. -->
		    	<?php if ($display_submitted): ?>
					<?php print $submitted; ?>
				<?php endif; ?>
		  		</div><!-- // submitted -->
			</header>
	
			<?php print render($content);?>
			<?php if($node->rate_werk['#markup']):?>
			<div class="rate">
			<?php print $node->rate_werk['#markup'];?>
			</div>
			<?php  endif;?>
			<?php if ($node_block): ?>
			    <div id="node-block">
			      <?php print render($node_block); ?>
			    </div>
		  	<?php endif; ?>
	
				<div class="content_links clearfix">
				  <?php if (!empty($content['links'])): ?>
				      <nav class="links node-links clearfix"><?php print render($content['links']); ?></nav>
				  <?php endif; ?>
				  <div class="service_links_container">
				  <?php if(isset($node->field_drucken[LANGUAGE_NONE][0]['value']) && $node->field_drucken[LANGUAGE_NONE][0]['value'] == 1 && ($user->uid == 1 || $user->uid == 8)): ?>
				  <div class="print_link">
						<button title="<?php print t('My Print');?>" data-cp-url="<?php print $content['field_image']['#object']->field_image[LANGUAGE_NONE][0]['filename'];?>">
						</button>
						<div class="text">
						<?php print t('My Print');?>
						</div>
					<div class="info"><a  href="/druck-info" title="<?php print t('More Info');?>"></a></div>
				  </div>
				  <?php  endif;?>
				  	<?php print render($content['service_links']); ?>
				  	</div>
					<div class="icon_container">
				    	<?php if ($icons ? print $icons : '') ?>
					</div>
				</div>
		</div>
	 </div>
	<div class="image_container">
	  	<?php print render($content['field_image']);?>
	</div>
  <?php elseif($type == 'text' && !$iscomment):?>
  	  <?php if ($title): ?>
			      <h2<?php print $title_attributes; ?>><?php print $title; ?></h2>
			    <?php endif; ?>
	<div class="pure_text">
			<div class="icon_container">
	    	<?php if ($icons ? print $icons : '') ?>
		</div>	
  		<?php print render($content); ?>
  			<div class="service_links_container">
  			
		<?php print render($content['service_links']); ?>
	</div>	
  </div>
  </div>
    <?php elseif($type == 'simplenews' && !$iscomment):?>
  	  <?php if ($title): ?>
			      <h1<?php print $title_attributes; ?>><?php print $title; ?></h1>
	<?php endif; ?>
	<div class="pure_text">
	
  <?php print render($content); ?>	
  
  <?php elseif($page || $iscomment):?>
	  <script type="text/javascript">
		  function toggleCommentSection (element)
		  {
		  	var comment = jQuery(element);
		  	var container = comment.next();
		  	if (comment.hasClass('comment_expanded'))
		  	{
		  		container.slideUp();
		  		comment.removeClass('comment_expanded');
		  	}
		  	else
		  	{
		  		container.slideDown();
		  		comment.addClass('comment_expanded');
		  	}
		  }
	  </script>
   <?php if ($title && !$iscomment): ?>
		<h1<?php print $title_attributes; ?>><?php print $title; ?></h1>
	<?php endif; ?>
  	<div class="icon_container">
	    <?php if ($icons ? print $icons : '') ?>
	</div>	
	<div class="page_content">
			<?php if(isset($node->field_drucken[LANGUAGE_NONE][0]['value']) && $node->field_drucken[LANGUAGE_NONE][0]['value'] == 1 && ($user->uid == 1 || $user->uid == 8)): ?>
		<div class="print_link">
	 		<button title="<?php print t('My Print');?>" data-cp-url="<?php print $content['field_image']['#object']->field_image[LANGUAGE_NONE][0]['filename'];?>"></button>
				<div class="text">
					<?php print t('My Print');?>
				</div>
			<div class="info"><a  href="/druck-info" title="<?php print t('More Info');?>"></a></div>
		</div>
		<?php  endif;?>
		<?php print render($content['service_links']); ?>
		<?php print render($content); ?>
  		<?php print render($content['field_image']);?>
  		
  		<?php print render($content['comments']);?>
	</div>
  <?php endif;?>
 
</article>

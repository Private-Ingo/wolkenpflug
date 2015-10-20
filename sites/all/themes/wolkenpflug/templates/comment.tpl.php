<?php

/**
 * @file
 * Default theme implementation for comments.
 *
 * Available variables:
 * - $author: Comment author. Can be link or plain text.
 * - $content: An array of comment items. Use render($content) to print them all, or
 *   print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $created: Formatted date and time for when the comment was created.
 *   Preprocess functions can reformat it by calling format_date() with the
 *   desired parameters on the $comment->created variable.
 * - $changed: Formatted date and time for when the comment was last changed.
 *   Preprocess functions can reformat it by calling format_date() with the
 *   desired parameters on the $comment->changed variable.
 * - $new: New comment marker.
 * - $permalink: Comment permalink.
 * - $submitted: Submission information created from $author and $created during
 *   template_preprocess_comment().
 * - $picture: Authors picture.
 * - $signature: Authors signature.
 * - $status: Comment status. Possible values are:
 *   comment-unpublished, comment-published or comment-preview.
 * - $title: Linked title.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the following:
 *   - comment: The current template type, i.e., "theming hook".
 *   - comment-by-anonymous: Comment by an unregistered user.
 *   - comment-by-node-author: Comment by the author of the parent node.
 *   - comment-preview: When previewing a new or edited comment.
 *   The following applies only to viewers who are registered users:
 *   - comment-unpublished: An unpublished comment visible only to administrators.
 *   - comment-by-viewer: Comment by the user currently viewing the page.
 *   - comment-new: New comment since last the visit.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * These two variables are provided for context:
 * - $comment: Full comment object.
 * - $node: Node object the comments are attached to.
 *
 * Other variables:
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 *
 * @see template_preprocess()
 * @see template_preprocess_comment()
 * @see template_process()
 * @see theme_comment()
 *
 * @ingroup themeable
 */
	global $base_url;
	$args = request_path();
	$argsPart = explode('/',$args);
	$iscomment = false;
	if ($argsPart[0] == 'comment' && $comment->cid == $argsPart[1])
	{
		$iscomment = true;
	}
	

	
	$desText = $comment->comment_body[LANGUAGE_NONE][0]['value'];
	$desText = str_replace(array("\r\n", "\n", "\r", "\t"), ' ', $desText);
	$desText = trim($desText);
?>
<div class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
  <?php print $picture ?>
  
<div class="comment_head clearfix">

  <?php print render($title_prefix); ?>
  <h3<?php print $title_attributes; ?>><?php print $title ?></h3>
  <?php print render($title_suffix); ?>

  <div class="submitted">
    <?php //print $permalink; ?>
   <?php setlocale(LC_TIME, "de_DE"); print $comment->name . ' ,  ' . strftime('%d %B %Y %H:%M',$comment->created) ?>
  </div>
  
</div>
<div class="expand_comment <?php if($iscomment ? print 'comment_expanded': '');?>" onclick="javascript: if(eval(typeof toggleCommentSection === 'function')){toggleCommentSection(this)};">
	<img src="/sites/all/themes/wolkenpflug/images/arrow_up.png" title="<?php print t('open/close');?>">
</div>
<div class="comment_body"  <?php if($iscomment ? print 'style="display:block;"': '');?>>
  <div class="content"<?php print $content_attributes; ?>>
    <?php
      // We hide the comments and links now so that we can render them later.
      hide($content['links']);
      print render($content);
    ?>
    <?php if ($signature): ?>
    <div class="user-signature clearfix">
      <?php print $signature ?>
    </div>
    <?php endif; ?>
  </div>
  <div class="service-links">
		<a 
			target="_blank" rel="nofollow" class="service-links-facebook" 
			title="<?php print t('Share on Facebook');?>"
			href="http://www.facebook.com/sharer.php?u=<?php print $base_url .'/comment/' . $comment->cid . '#comment-' . $comment->cid; ?>&amp;t=<?php print $desText; ?>">
			<img alt="Facebook logo" src="<?php print $base_url;?>/sites/all/modules/service_links/images/facebook.png" typeof="foaf:Image">
		</a>
		<a 
			class="service-links-google-plus" 
			target="_blank" rel="nofollow" title="<?php print t('Share on Google+');?>" 
			href="https://plus.google.com/share?url=<?php print $base_url . '/comment/' . $comment->cid . '#comment-' . $comment->cid; ?>">
			
			<img alt="Google+ logo" src="<?php print $base_url;?>/sites/all/modules/service_links/images/google_plus.png" typeof="foaf:Image">
		</a>
		<a 
			class="service-links-twitter" target="_blank" rel="nofollow" 
			title="<?php print t('Share on Twitter');?>" 
			href="http://twitter.com/share?url=<?php print $base_url . '/comment/' . $comment->cid . '#comment-' . $comment->cid; ?>&text=<?php print $desText; ?>">
			<img alt="Twitter logo" src="<?php print $base_url;?>/sites/all/modules/service_links/images/twitter.png" typeof="foaf:Image">
		</a>
		<a 
			class="service-links-forward" 
			target="_blank" rel="nofollow" 
			title="<?php print t('Send to Friend');?>" 
			href="<?php print $base_url;?>/forward?path=<?php print 'comment/' . $comment->cid; ?>">
			<img alt="Forward logo" src="<?php print $base_url;?>/sites/all/modules/service_links/images/forward.png" typeof="foaf:Image">
		</a>
	</div>
</div>
</div>

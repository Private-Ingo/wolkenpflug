<?php

/**
 * This template should only contain the contents of the body
 * of the email, what would be inside of the body tags, and not
 * the header.  You should use tables for layout since Microsoft
 * actually regressed Outlook 2007 to not supporting CSS layout.
 * All styles should be inline.
 *
 * For more information, consult this page:
 * http://www.anandgraves.com/html-email-guide#effective_layout
 *
 * If you are upgrading from an old version of Forward, be sure
 * to visit the Forward settings page to enable use of the new
 * template system.
 */

$path = explode('/', $variables['vars']['path']);
$comment = FALSE;
if($path[0] == 'comment')
{
	if(is_numeric($path[1]))
	{
		$comment = TRUE;
		$query = db_select('comment', 'c');
		$query->fields('c', array('nid'));
		$query->condition('c.cid', $path[1]);
		$result = $query->execute();
		$result = $result->fetch();
		$nodeOBJ = node_load($result->nid);
		
		$image = theme('image_style', array('path' => $nodeOBJ->field_image[LANGUAGE_NONE][0]['uri'], 'style_name' => 'inpage', 'title' => $nodeOBJ->title));
		
		$commentObj = comment_load($path[1], $reset = FALSE);
		$commentSubject = $commentObj->subject;
		$commentText = 	$commentObj->comment_body[LANGUAGE_NONE][0]['value'];
		
	}
}

?>
<html>
  <body>
    <table width="<?php print $width; ?>" cellspacing="0" cellpadding="10" border="0">
      <thead>
        <tr>
          <td>
            <h1 style="font-family:Arial,Helvetica,sans-serif; font-size:18px;"><a href="<?php print $site_url; ?>" title="<?php print $site_name; ?>"><?php //print $logo; ?> <?php print $site_name; ?></a></h1>
          </td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td style="font-family:Arial,Helvetica,sans-serif; font-size:12px;">
            <?php print $forward_message; ?>
            <?php if ($message) { ?>
            <p><?php print t('Message from Sender'); ?></p><p><?php print $message; ?></p>
            <?php } ?>
            <?php if ($title) { ?><h2 style="font-size: 14px;"><?php print $title; ?></h2><?php } ?>
            <?php if ($submitted) { ?><p><em><?php print $submitted; ?></em></p><?php } ?>
            <?php if ($node) { ?><div><?php print $node; ?></div><?php } ?><p><?php print $link; ?></p>
          </td>
        </tr>
       
       <?php if($comment == TRUE) { ?>
       	<tr>
          <td style="font-family:Arial,Helvetica,sans-serif; font-size:16px;">
            <?php print $commentSubject; ?>
            </td>
         </tr>
         <tr>
            <td style="font-family:Arial,Helvetica,sans-serif; font-size:14px;">
            	<?php print $commentText; ?>
            </td>
          </tr>
          <tr>
          	<td>
            	<?php print $image; ?>
            </td>
         </tr>
          
        <?php } ?>
        <?php if ($dynamic_content) { ?><tr>
          <td style="font-family:Arial,Helvetica,sans-serif; font-size:12px;">
            <?php print $dynamic_content; ?>
            <?php if(isset($image))
            	print $image;
            ?>
          </td>
        </tr><?php } ?>
        <?php if ($forward_ad_footer) { ?><tr>
          <td style="font-family:Arial,Helvetica,sans-serif; font-size:12px;">
            <?php print $forward_ad_footer; ?>
          </td>
        </tr><?php } ?>
        <?php if ($forward_footer) { ?><tr>
          <td style="font-family:Arial,Helvetica,sans-serif; font-size:12px;">
            <?php print $forward_footer; ?>
          </td>
        </tr><?php } ?>
      </tbody>
    </table>
  </body>
</html>
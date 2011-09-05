<?php defined( '_JEXEC' ) or die( 'Restricted access' );
//require_once 'twitter.class.php';

class_exists('SimpleTwitter') || require('twitter.class.php');
//echo $notfound;
// enables caching (path must exists and must be writable!)
// Twitter::$cacheDir = dirname(__FILE__) . '/temp';


$i = 0;
$twitter = new SimpleTwitter( $params->get( 'username' ), $params->get( 'password' ), $this->format );
$number = $params->get( 'tweetnumber' );

$withFriends = FALSE;
$channel = $twitter->load($withFriends);
?>
<?global $notfound;
if ($notfound != 'true'): ?>
<?php
// EDIT: Below you can edit how the tweets are displayed.
?>

<strong><em><font color="#000000" face="Verdana, Arial, Helvetica, sans-serif" size="2">Edit how this looks in the mod_simpletwitter.php file</font></em></strong></p>
<ul>
<?foreach ($channel->status as $status): ?>
<?if ($i < $number): ?>
<?php
//This parses the urls so they are actual links that can be clicked

			$rule = '/.*?((?:http|https)(?::\/{2}[\w]+)(?:[\/|\.]?)(?:[^\s"]*))/is';
			
			preg_match_all( $rule, $status->text, $matches );
			
			foreach( $matches[1] as $url ) :
				
				$status->text = str_replace( $url, '<a href="'. $url .'" target="_blank">'. $url .'</a>', $status->text );
			$full = 'yes';
			endforeach;
			
			If ($full != 'yes')
			{
			$rule1 = '/.*?((?:www)(?:[\/|\.]?)(?:[^\s"]*))/is';
			
			preg_match_all( $rule1, $status->text, $matches1 );
			
			foreach( $matches1[1] as $url1 ) :
				
				$status->text = str_replace( $url1, '<a href="http://'. $url1 .'" target="_blank">'. $url1 .'</a>', $status->text );
			$full = 'no';
			endforeach;
			}
			$full = 'no';
//End link parser
?>

	<li>
	<?=$status->text?>
	<small>on <?=date("D, d M, Y", strtotime($status->created_at))?></small>
	</li>
<?$i++ ?>
<?endif?>
<?endforeach?>
</ul>
<?else :?>
<? echo "<P>Sorry, Twitter cannot be contacted. Try again soon.</P>"?>
<?endif?>
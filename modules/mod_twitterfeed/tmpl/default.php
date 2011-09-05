<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<?php


// Disable basic Twitter style for now.  Advanced is much more powerful.
if(false) {
// if ($params->get('twitterfeedtype', 1)) {

// ********* Basic Twitter Style *********
  	
?>
		
<div id="twitter_div<?php echo $params->get( 'moduleclass_sfx'); ?>">
<h2 style="display: none;" ><?php echo $params->get( 'twitterfeedtitle'); ?></h2>
    <ul id="twitter_update_list"></ul>
    <a href="http://twitter.com/<?php echo $params->get( 'twitteruser'); ?>" rel="nofollow" id="twitter-link" style="display:block;text-align:right;">follow me on Twitter</a>
    </div>
    <script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>
    <script type="text/javascript" src="http://twitter.com/statuses/user_timeline/<?php echo $params->get( 'twitteruser'); ?>.json?callback=twitterCallback2&amp;count=<?php echo $params->get( 'twitteritems'); ?>"></script>

<?php
	
   }
   else {
   // ********* RSS STYLE *********
    if( $feed != false )
    {
    	//image handling
    	$iUrl 	= isset($feed->image->url)   ? $feed->image->url   : null;
    	$iTitle = isset($feed->image->title) ? $feed->image->title : null;



// ////////////////////////////////////////////////////////////
// //////////   Div Style                 ///////////////////
// ////////////////////////////////////////////////////////////
      if(true) // $params->get('twitterfeeddisplay', 0) == "0") 
      {
      
    	?>
   	
    	<div id="twitterfeedrssdiv" class="twitterfeedrss<?php echo $params->get( 'moduleclass_sfx'); ?>">
    	<?php
    	// feed description
    	if (!is_null( $feed->title ) && $params->get('rsstitle', 1)) {
    		?>
				<div class="twitterfeedtitle<?php echo $params->get( 'moduleclass_sfx'); ?>">
        <a href="<?php echo str_replace( '&', '&amp', $feed->link ); ?>" target="_blank">
    						<?php echo $feed->title; ?></a>
        </div>
    		<?php
    	}
    
  
    	// feed description
    	if ($params->get('rssdesc', 0)) {
    	?>
    	<div class="twitterfeeddescription<?php echo $params->get( 'moduleclass_sfx'); ?>">
    		<?php echo $feed->description; ?>
   		</div>
    		<?php
    	}
    
    	// feed image
    	if ($params->get('rssimage', 0) && $iUrl) {
    	?>
    	<div class="twitterfeedimage<?php echo $params->get( 'moduleclass_sfx'); ?>">
    	<img src="<?php echo $iUrl; ?>" alt="<?php echo @$iTitle; ?>"/>
    	</div>
    	<?php
    	}
    
    	$actualItems = count( $feed->items );
    	$setItems    = $params->get('twitteritems', 5);
    
    	if ($setItems > $actualItems) {
    		$totalItems = $actualItems;
    	} else {
    		$totalItems = $setItems;
    	}
    	?>
    	
    	<div id="twitterfeedallitemsdiv" class="twitterfeedallitems<?php echo $params->get( 'moduleclass_sfx'); ?>">
    			<?php
    			
          $words = $params->def('word_count', 0);
    			
          for ($j = 0; $j < $totalItems; $j ++)
    			{
    				$currItem = & $feed->items[$j];

            // parse item description

    					// item description
    					$text = $currItem->get_description();
    					$text = str_replace('&apos;', "'", $text);
    
/**
              if($params->get('twitterfeedhashtags', 0) == "0") {
                  // filter out hashtags
                  $texts = explode(' ', $text);
                  $text = '';
                  foreach ($texts as $word) {

                    if(!(strpos($word, '<') === 0))
                    {
// echo "SHOULD REPLACE HASH" ;
 $text .= ' '.$texts[$i];
    							  }
    							}
              }
    
    **/
    					// word limit check
    					if ($words)
    					{
                                                
    						$texts = explode(' ', $text);
    						$count = count($texts);
    						if ($count > $words)
    						{
    							$text = '';
    							for ($i = 0; $i < $words; $i ++) {
    								$text .= ' '.$texts[$i];
    							}
    							$text .= '...';
    						}
    						
    					}
    					    				
    				
    				// item title
    				?>
    				<div class="twitterfeeditem<?php echo $params->get( 'moduleclass_sfx'); ?>">
    				<?php
    				  				    				
        				if ($params->get('twitterfeeditemlink', 0) && !is_null( $currItem->get_link() )) {
        				   $linktext = $params->get( 'twitterfeedtitle', '');
        				   if($linktext == '') {
                      $linktext = $params->get( 'twitteruser');
                   }
        				?>
        					<a href="<?php echo $currItem->get_link(); ?>" target="_blank" rel="nofollow"><?php echo $linktext; ?>:</a>
        					<?php echo $text ?>  				
        				<?php
                } else {
        				?>
        					<?php echo $text ?>
                <?php                        
                }
            
            
            ?>
            </div>
            
          <?php
      		}
      		?>
      		<div id="twitterfeedfollowmediv" style="display:block;text-align:right;">
      		    <a href="http://twitter.com/<?php echo $params->get( 'twitteruser'); ?>" rel="nofollow"><?php echo $params->get('followmetext', 'Follow me on Twitter'); ?></a>
    		  </div>
    	</div>
    	<div id="twitterfeedpoweredbylink" style="display:block;text-align:right;font-size:8px">
    	    Powered by <a href="http://gammablue.com/twitter-feed" alt="Powered by TwitterFeed, by GammaBlue Developments">Twitter Feed</a>
    	</div>

</div>
    <?php 
    } // End of Div style.
    
    

    
    } 
    
    
    }
  
  ?>

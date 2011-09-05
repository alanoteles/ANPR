<?php
defined('_JEXEC') or die('Restricted access');

/**
 * This is a file to add template specific chrome to module rendering.  To use it you would
 * set the style attribute for the given module(s) include in your template to use the style
 * for each given modChrome function.
 *
 * eg.  To render a module mod_test in the sliders style, you would use the following include:
 * <jdoc:include type="module" name="test" style="slider" />
 *
 * This gives template designers ultimate control over how modules are rendered.
 *
 * NOTICE: All chrome wrapping methods should be named: modChrome_{STYLE} and take the same
 * three arguments.
 */


/**
 * Custom module chrome, echos the whole module in a <div> and the header in <h{x}>. The level of
 * the header can be configured through a 'headerLevel' attribute of the <jdoc:include /> tag.
 * Defaults to <h3> if none given
 */

function modChrome_wrapper_box ($module, &$params, &$attribs)
{
	$headerLevel = isset($attribs['headerLevel']) ? (int) $attribs['headerLevel'] : 3;
	if (!empty ($module->content)) : ?>
		<div class="wrapper-box module<?php echo $params->get('moduleclass_sfx'); ?>">
           <?php if ($module->showtitle) : ?>
                <div class="boxTitle">
                    <div class="title">
							<div class="right-bg">
							<div class="left-bg"><h<?php echo $headerLevel; ?> ><?php echo $module->title; ?></h<?php echo $headerLevel; ?>></div>
							</div>
						</div>
                 </div>
                <?php endif; ?>
                <div class="clear">
                     <div class="boxIndent">
                        <?php echo $module->content; ?>
                    </div>
               </div>  
		</div>
	<?php endif; 
}
function modChrome_wrapper_box2 ($module, &$params, &$attribs)
{
	$headerLevel = isset($attribs['headerLevel']) ? (int) $attribs['headerLevel'] : 3;
	if (!empty ($module->content)) : ?>
		<div class="wrapper-box module<?php echo $params->get('moduleclass_sfx'); ?>">
        	<div class="bgs2">
            	<div class="bgs1">
                	<div class="bgs3">
                    	<?php if ($module->showtitle) : ?>
                        <div class="boxTitle">
                            <h<?php echo $headerLevel; ?> ><?php echo $module->title; ?></h<?php echo $headerLevel; ?>>
                         </div>
                        <?php endif; ?>
                        <div class="clear">
                             <div class="boxIndent">
                                <?php echo $module->content; ?>
                            </div>
                       </div>  
                    </div>
                </div>
            </div>
		</div>
	<?php endif; 
}

function modChrome_wrapper_box_block ($module, &$params, &$attribs)
{
	$headerLevel = isset($attribs['headerLevel']) ? (int) $attribs['headerLevel'] : 3;
	if (!empty ($module->content)) : ?>
		<div class="wrapper_box_block module<?php echo $params->get('moduleclass_sfx'); ?>">
        	<div class="top_line">
            	<div class="right_line">
                	<div class="bottom_line">
                    	<div class="left_line">
                        	<div class="corner1">
                            	<div class="corner2">
                                	<div class="corner3">
                                    	<div class="corner4">
                                        	<div class="corner_box_indent">
           <?php if ($module->showtitle) : ?>
                <div class="boxTitle">
                    <h<?php echo $headerLevel; ?> ><a href="#"><?php echo $module->title; ?></a></h<?php echo $headerLevel; ?>>
                 </div>
                <?php endif; ?>
                <div class="clear">
                     <div class="boxIndent">
                        <?php echo $module->content; ?>
                    </div>
               </div>
               </div>
               </div>
               </div>
               </div>
               </div>
               </div>
               </div>
               </div>
               </div>  
		</div>
	<?php endif; 
}

function modChrome_wrapper_box1 ($module, &$params, &$attribs)
{
	$headerLevel = isset($attribs['headerLevel']) ? (int) $attribs['headerLevel'] : 3;
	if (!empty ($module->content)) : ?>
		<div class="wrapper-box-footer module<?php echo $params->get('moduleclass_sfx'); ?>">
           <?php if ($module->showtitle) : ?>
                <div class="boxTitle">
                    <h<?php echo $headerLevel; ?> ><?php echo $module->title; ?></h<?php echo $headerLevel; ?>>
                 </div>
                <?php endif; ?>
                <div class="clear">
                     <div class="boxIndent">
                        <?php echo $module->content; ?>
                    </div>
               </div>  
		</div>
	<?php endif; 
}

function modChrome_topmenu ($module, &$params, &$attribs)
{	
	?>
    	<?php
		$headerLevel = isset($attribs['headerLevel']) ? (int) $attribs['headerLevel'] : 3;
		if (!empty ($module->content)) : ?>
	<?php echo $module->content; ?>
	<?php endif; ?>
    <?php
}


function modChrome_search ($module, &$params, &$attribs)
{
	$headerLevel = isset($attribs['headerLevel']) ? (int) $attribs['headerLevel'] : 3;
	if (!empty ($module->content)) : ?>
<div class="module-search<?php echo $params->get('moduleclass_sfx'); ?>">
    <?php if ($module->showtitle) : ?>    <h<?php echo $headerLevel; ?>><?php echo $module->title; ?></h<?php echo $headerLevel; ?>>

    <?php endif; ?>
    <?php echo $module->content; ?> </div>
<?php endif;
}






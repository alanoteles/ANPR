<?php
    defined( '_JEXEC' ) or die( 'Restricted access' );
    echo '<div class="componentheading">Restaurant Reviews</div>';
    ?>
    
    <script>
    
                jQuery(function ($) {
                  //  $('body').css('color','red');
                });
                
                //alert('asas');
            </script>
    
    <?php
    
    jimport('joomla.application.helper');
    require_once( JApplicationHelper::getPath( 'html' ) );
    
    HTML_reviews::showReview($rows, $option);
    
    JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.$option.DS.'tables');
    
    switch($task) {
        case 'view':
            viewReview($option);
            break;
        default:
            showPublishedReviews($option);
            break;
    }
    
    function showPublishedReviews($option) {
        
        $db =& JFactory::getDBO();
        
        $query = "SELECT * FROM #__reviews WHERE published = '1' ORDER BY review_date DESC";
        
        $db->setQuery( $query );
        $rows = $db->loadObjectList();
        
        if ($db->getErrorNum()) {
            echo $db->stderr();
            return false;
        }
        
        HTML_reviews::showReviews($rows, $option);
        
    }
    
    
    
    function viewReview($option) {
        $id = JRequest::getVar('id', 0);
        $row =& JTable::getInstance('review', 'Table');
        $row->load($id);
        
        if(!$row->published) {
            JError::raiseError( 404, JText::_( 'Invalid ID provided' ) );
        }
        
        HTML_reviews::showReview($row, $option);
    }
?>
    
<?php
/**
 * @package WordPress
 * @subpackage Logic theme
 */
?>


    <div class="footer mrgTop">
    	<div class="footerLinks">
<?

				$exclude_page = get_page_by_path("footer");
				$exclude_trees = $exclude_page->ID;
				$exclude_page = get_page_by_path("members-area");
				$exclude_pages = $exclude_page->ID;
				$exclude_line = $exclude_pages.",".$exclude_trees;
				$args = array (
				"title_li" => "",
				"exclude_tree" => $exclude_line,
				//"exclude" => $exclude_pages,
				"depth" => 1,
				"echo" => 0,
				);
				$menu = wp_list_pages($args);
				//echo $menu; 
				
$page = get_page_by_path('footer');
$args = array(
    'child_of'     => $page->ID,
    'title_li'     => '',
    'echo'         => 1,
    'sort_column'  => 'menu_order, post_title',
	'echo' => 0,
	);
				//$menu .= wp_list_pages($args);
				//$menu = preg_replace('/title=\"(.*?)\"/','',$menu);
// footer navigation
if (selfURL() == get_bloginfo('url').'/forum/')
{			

$menu = wp_nav_menu( array( 'menu' => 'footer_forum', 'container' => '', 'container_class' => '', 'echo' => false, 'depth' => 1,) );				
} else $menu = wp_nav_menu( array( 'menu' => 'footer', 'container' => '', 'container_class' => '', 'echo' => false, 'depth' => 1,) );
//				$to_replace = 'class="page_item ';
//				$replacement = 'class="page_item last ';

				//echo substr_replace($menu,$replacement,strrpos($menu,$to_replace),strlen($replacement));
				echo $menu; 

?>

        </div>
<script>
jq(document).ready(function() {
jq("div.footerLinks .menu ul li:last").addClass("last");
jq("div.footerLinks .menu ul li:first").addClass("first");
});
</script>		
        
        <? 
		
if (function_exists('dynamic_sidebar')) dynamic_sidebar("footer_gallery"); 
		?>
        
        <div class="footerContent">
        
<? 
if (function_exists('dynamic_sidebar')) dynamic_sidebar("footer_left"); 			
if (function_exists('dynamic_sidebar')) dynamic_sidebar("footer_center"); 			
if (function_exists('dynamic_sidebar')) dynamic_sidebar("footer_right"); 


?>			</div>
        
    </div>
    
</div>

		<?php wp_footer(); ?>
</body>
</html>

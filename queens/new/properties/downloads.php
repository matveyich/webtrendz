<div class="wrap">
<?
pr_m_('User downloads page','','h2');
?>
</div>
<?
if (isset($_GET['page_id'])) $page_id = $_GET['page_id']; else $page_id = 1;
//pr_general_prop_list($page_id);
$prid = 0;
// we use non existing prid = 0 as we have no such pr_properties.ID 
	// file upload
	if($_FILES[$pr_prefix.'file_upload'] != NULL)
	{
		$filename = pr_upload($prid,'file_upload');
			// добавляем запись в таблицу files
		if($_POST['pr_file_title'] != '')
      $filetitle = $_POST['pr_file_title'];
      else $filetitle = $filename;
		if($filename != false)
			{
			$wpdb->query("INSERT INTO ".$pr_files_table." (ID,prid,file_name,title) values (NULL,".$prid.",'".$filename."','".$filetitle."');");
			//$wpdb->show_errors();
			//$wpdb->print_error();
			}
	}
	// file title update
	$i = 0;
if (isset($_POST[$pr_prefix.'file_name_title']))
{ 
 foreach($_POST[$pr_prefix.'file_name_title'] as $_title)
	{
    $wpdb->query($wpdb->prepare("UPDATE $pr_files_table SET title = '%s' WHERE ID = %d",$_title,$_POST[$pr_prefix.'file_name_index'][$i]));
    $i++;
  }
}  
  if(isset($_POST['pr_file_name_del']))
	{
		//print_r($_POST['pr_file_name_del']);
		pr_delete_files("files",$_POST['pr_file_name_del']);		
	}
?>
	<?
	pr_edit_subform("form_start");
	?>	
	<div class="pr_block">
	<div class="metabox-holder">
		<div class="postbox widefat">
		<h3 class="manage-column column-title"><span>Edit uploaded files</span></h3>
		<div class="inside">	
			
			<?if(isset($prid)) {?><p><?pr_edit_subform('files_list_edit',$prid);?></p><?
      
      pr_edit_subform("submit",NULL,NULL,"Update");
      }?>

		</div>
		</div>	
	</div>
	</div>
	<?
	pr_edit_subform("form_end");
	pr_edit_subform("form_start");
	?>  		
	<div class="pr_block">
	<div class="metabox-holder">
		<div class="postbox widefat">
		<h3 class="manage-column column-title"><span>Upload</span></h3>
		<div class="inside">	
	<?//pr_m_('Upload file','notice','div');?>			
			<p><?pr_edit_subform('upload_form',NULL,NULL,$pr_prefix.'file_upload');?></p>
			<p>
	<?
	echo "File title<br>";
  pr_edit_subform('text',NULL,NULL,'pr_file_title');
  echo "<br>";
  pr_edit_subform("hidden",NULL,NULL,"pr_action",$action);// this states whether we add or edit
	if ($prid != NULL) pr_edit_subform("hidden",NULL,NULL,"pr_id",$prid);// this states what property we are editing in case of action = edit
	pr_edit_subform("submit",NULL,NULL,"Upload");
	?>		</p>
		</div>
		</div>	
	</div>
	</div>		

	<?
	pr_edit_subform("form_end");
	?>
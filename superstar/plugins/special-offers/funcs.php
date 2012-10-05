<?

require_once (dirname (__FILE__) . '/config.php');

function so_menu()
{
if ( function_exists('add_menu_page') )
  {
	add_menu_page(__('Special offers', 'video-ratings'), __('Special offers', 'video-ratings'), 'manage_so',  'special-offers/manager.php', '',  plugins_url('special-offers/images/icon.png'));
	add_submenu_page( 'special-offers/manager.php', "Manage offers", "Manage offers", 'manage_so', 'special-offers/manager.php', '');
	add_submenu_page( 'special-offers/manager.php', "Add offer", "Add offer", 'manage_so', 'special-offers/add.php', '');
	add_submenu_page( 'special-offers/manager.php', "Manage destinations", "Manage destinations", 'manage_so', 'special-offers/destinations.php', '');
	add_submenu_page( 'special-offers/manager.php', "Manage categories", "Manage categories", 'manage_so', 'special-offers/categories.php', '');
  }
}

/// internal functions
function so_get_data_by_id($id)
{
	global $so_table;
	global $wpdb;
	return $wpdb->get_row($wpdb->prepare("SELECT featured, destination, category, resort_name, room_type, num_of_nights, stars, tour_type, direct_flights, departure_date, board_type, price, link FROM ".$so_table." WHERE ID = %d;",$id), ARRAY_N);
}

/////// admin panel functions
function so_get_img_by_id($id)
{
	global $so_table, $wpdb;
	if($offer = $wpdb->get_row($wpdb->prepare("SELECT img_src FROM ".$so_table." WHERE ID = %d;",$id)))
	{
		return $offer->img_src;
	}
	else return false;
}
function so_show_img_by_id($id)
{
	global $so_img_show_folder,$so_prefix;
	if ($img_src = so_get_img_by_id($id))
	{
		$del_link = "<input type=\"checkbox\" name=\"".$so_prefix."img_delete\" value=\"1\"> Delete image";
		return "<img src=\"".$so_img_show_folder.$img_src."\">".$del_link;
	}
	else return "No image";
}
function so_edit_offer($id)
{
	global $so_prefix;
	if (isset($_POST['action']) and $_POST['action'] == "update_offer" and isset($_POST['update_id']))
		{ so_update_offer($_POST['update_id']);}
	
	so_add_form();
}
function so_update_offer($id)
{
	global $wpdb, $so_table,$so_prefix,$so_upload;

	if (
		isset($_POST[$so_prefix.'destination']) and $_POST[$so_prefix.'destination'] != ""
		and isset($_POST[$so_prefix.'category']) and $_POST[$so_prefix.'category'] != ""
		and isset($_POST[$so_prefix.'resort_name']) and $_POST[$so_prefix.'resort_name'] != ""
		and isset($_POST[$so_prefix.'room_type']) and $_POST[$so_prefix.'room_type'] != ""
		and isset($_POST[$so_prefix.'num_of_nights']) and $_POST[$so_prefix.'num_of_nights'] != ""
		and isset($_POST[$so_prefix.'star_rating']) and $_POST[$so_prefix.'star_rating'] != ""
		and isset($_POST[$so_prefix.'tour_type']) and $_POST[$so_prefix.'tour_type'] != ""
		and isset($_POST[$so_prefix.'direct_flights']) and $_POST[$so_prefix.'direct_flights'] != ""
		and isset($_POST[$so_prefix.'departure_date']) and $_POST[$so_prefix.'departure_date'] != ""
		and isset($_POST[$so_prefix.'board_type']) and $_POST[$so_prefix.'board_type'] != ""
		and isset($_POST[$so_prefix.'price']) and $_POST[$so_prefix.'price'] != ""
		and isset($_POST[$so_prefix.'link'])and $_POST[$so_prefix.'link'] != ""
		)
	{
	$where = array(
	'ID' => $id,
	);
	if(isset($_POST[$so_prefix.'featured'])) $featured = $_POST[$so_prefix.'featured']; else $featured = 0;
	$data = array(
	'destination' => $_POST[$so_prefix.'destination'],
	'category' => $_POST[$so_prefix.'category'],
	'resort_name' => $_POST[$so_prefix.'resort_name'],
	'room_type' => $_POST[$so_prefix.'room_type'],
	'stars' => $_POST[$so_prefix.'star_rating'],
	'tour_type' => $_POST[$so_prefix.'tour_type'],
	'num_of_nights' => $_POST[$so_prefix.'num_of_nights'],
	'direct_flights' => $_POST[$so_prefix.'direct_flights'],
	'departure_date' => $_POST[$so_prefix.'departure_date'],
	'board_type' => $_POST[$so_prefix.'board_type'],
	'price' => $_POST[$so_prefix.'price'],
	'link' => $_POST[$so_prefix.'link'],
	'featured' => $featured,
	);

		$wpdb->update($so_table,$data,$where);
	if(isset($_POST[$so_prefix.'img_delete'])) 
		{
		$data = array(
				'img_src' => NULL,
				);
				$where = array(
				'ID' => $id,
				);
				$wpdb->update($so_table, $data, $where);
		unlink($so_upload.so_get_img_by_id($id));; // delte image on demand
		}
	if(isset($_FILES[$so_prefix.'image']) and $_FILES[$so_prefix.'image']['error'] != 4)
		{
			if ($img_file = so_get_img_by_id($id)) unlink($so_upload.$img_file); //delete existing file
			$filename = so_upload($id);
			$data = array(
				'img_src' => $filename,
				);
				$where = array(
				'ID' => $id,
				);
				$wpdb->update($so_table, $data, $where);
		}
		
		echo "Offer was updated!";
	} else {echo "Not all fields are filled corectly!<br>";}
}

function so_delete_offer($id)
{
	global $wpdb, $so_table;
	$wpdb->query($wpdb->prepare("DELETE FROM ".$so_table." WHERE ID = %d;",$id));
}
function so_manage_offers()
{
	global $so_table, $wpdb, $so_destination_table, $so_categories_table, $so_prefix;
	if (isset($_GET['action']) and $_GET['action'] == $so_prefix.'offer_edit' and isset($_GET[$so_prefix.'offer_id']))
	{
		so_edit_offer($_GET[$so_prefix.'offer_id']);
	}
	else 
	{
	
	if (isset($_GET['action']) and $_GET['action'] == $so_prefix.'offer_delete' and isset($_GET[$so_prefix.'offer_id']))
		{
			so_delete_offer($_GET[$so_prefix.'offer_id']);
		}
	
	if ($offers = $wpdb->get_results("SELECT o.ID as ID, o.resort_name as resort_name, o.price as price, o.featured as featured,d.Name as destination,c.Name as category FROM ".$so_table." o, ".$so_destination_table." d, ".$so_categories_table." c WHERE o.destination = d.ID AND o.category = c.ID ORDER BY o.category ASC, o.destination ASC, o.resort_name;"))
		{ 
			?>
			<table class="widefat">
				<thead>
					<tr>
						<th class="manage-column column-title">#</th>
						<th class="manage-column column-title">Featured</th>
						<th class="manage-column column-title">Destination</th>
						<th class="manage-column column-title">Category</th>
						<th class="manage-column column-title">Resort</th>
						<th class="manage-column column-title">Price</th>
						<th class="manage-column column-title">Action</th>
					</tr>
				</thead>
				<tbody>
				<?
			
				foreach($offers as $offer) {
				?>
					<tr>
						<td><?echo $offer->ID;?></td>
						<td><?echo $offer->featured;?></td>
						<td><?echo $offer->destination;?></td>
						<td><?echo $offer->category;?></td>
						<td><?echo $offer->resort_name;?></td>
						<td>&pound;<?echo $offer->price;?></td>
						<td><a href="admin.php?page=<?echo $_GET['page']?>&action=<?echo $so_prefix?>offer_delete&<?echo $so_prefix?>offer_id=<?echo $offer->ID;?>">Delete</a> | <a href="admin.php?page=<?echo $_GET['page']?>&action=<?echo $so_prefix?>offer_edit&<?echo $so_prefix?>offer_id=<?echo $offer->ID;?>">Edit</a></td>
					</tr>
				<?
				}
				?>	
				</tbody>
			</table>
			<?
		}
		else echo "There are no special offers defined at the moment";
		}
}
function so_upload($id = "")
{
	global $so_prefix, $so_upload;
	$filename = $so_prefix.$id."_".$_FILES[$so_prefix.'image']['name'];
	//echo strpos($_FILES[$so_prefix.'image']['type'],"image");
	if (strpos($_FILES[$so_prefix.'image']['type'],"image") !== false) {
    if(move_uploaded_file($_FILES[$so_prefix.'image']['tmp_name'], $so_upload.$filename))
	{
	print "<p>File was uploaded</p>";
	return $filename;
	}
    
} 
else {
	print "<p>File isn't an image<br>";
	print_r($_FILES);
	print "</p>";
	return false;
}
	
}

function so_add_data()
{
	global $so_prefix, $so_table;
	global $wpdb, $so_error;
if (isset($_POST['submit']) and $_POST['submit'] == "Submit") 
	{
	if (
		isset($_POST[$so_prefix.'destination']) and $_POST[$so_prefix.'destination'] != ""
		and isset($_POST[$so_prefix.'category']) and $_POST[$so_prefix.'category'] != ""
		and isset($_POST[$so_prefix.'resort_name']) and $_POST[$so_prefix.'resort_name'] != ""
		and isset($_POST[$so_prefix.'room_type']) and $_POST[$so_prefix.'room_type'] != ""
		and isset($_POST[$so_prefix.'num_of_nights']) and $_POST[$so_prefix.'num_of_nights'] != ""
		and isset($_POST[$so_prefix.'star_rating']) and $_POST[$so_prefix.'star_rating'] != ""
		and isset($_POST[$so_prefix.'tour_type']) and $_POST[$so_prefix.'tour_type'] != ""
		and isset($_POST[$so_prefix.'direct_flights']) and $_POST[$so_prefix.'direct_flights'] != ""
		and isset($_POST[$so_prefix.'departure_date']) and $_POST[$so_prefix.'departure_date'] != ""
		and isset($_POST[$so_prefix.'board_type']) and $_POST[$so_prefix.'board_type'] != ""
		and isset($_POST[$so_prefix.'price']) and $_POST[$so_prefix.'price'] != ""
		and isset($_POST[$so_prefix.'link'])and $_POST[$so_prefix.'link'] != ""
		)
	{
		echo "New entry has been added.";
		if(isset($_POST[$so_prefix.'featured'])) $featured = $_POST[$so_prefix.'featured']; else $featured = 0;
	$data = array(
	'ID' => NULL,
	'destination' => $_POST[$so_prefix.'destination'],
	'category' => $_POST[$so_prefix.'category'],
	'resort_name' => $_POST[$so_prefix.'resort_name'],
	'room_type' => $_POST[$so_prefix.'room_type'],
	'stars' => $_POST[$so_prefix.'star_rating'],
	'tour_type' => $_POST[$so_prefix.'tour_type'],
	'num_of_nights' => $_POST[$so_prefix.'num_of_nights'],
	'direct_flights' => $_POST[$so_prefix.'direct_flights'],
	'departure_date' => $_POST[$so_prefix.'departure_date'],
	'board_type' => $_POST[$so_prefix.'board_type'],
	'price' => $_POST[$so_prefix.'price'],
	'link' => $_POST[$so_prefix.'link'],
	'img_src' => NULL,
	'featured' => $featured,
	);
	$wpdb->insert($so_table, $data);
	//$wpdb->show_errors();
	//$wpdb->print_error();
	if(isset($_FILES[$so_prefix.'image']) and $_FILES[$so_prefix.'image']['error'] != 4)
		{
		$last_id = $wpdb->get_var("SELECT LAST_INSERT_ID();");
		//echo $last_id;
		//print_r($last_id);
		$filename = so_upload($last_id);
		$so_error = false;
		if($filename == false)
		{
			$so_error = true;
		} else 
			{
				$data = array(
				'img_src' => $filename,
				);
				$where = array(
				'ID' => $last_id,
				);
				$wpdb->update($so_table, $data, $where);
			}	
		}
	} else {
		echo "Not all fields were filled";
		$so_error = true;
		}
	}
}
function so_add_form()
{ 
global $so_prefix, $so_destination_table, $so_categories_table;
global $wpdb, $so_error;

$featured = "";
$destination = "";
$category = "";
$resort_name = "";
$room_type = "";
$num_of_nights = "";
$star_rating = "";
$tour_type = "";
$direct_flights = "";
$departure_date = "";
$board_type = "";
$price = "";
$link = "";
//if (isset($so_error) and $so_error == true)
//{
	if (isset($_POST[$so_prefix.'featured'])) $featured = "checked";
	if (isset($_POST[$so_prefix.'destination'])) $destination = $_POST[$so_prefix.'destination'];
	if (isset($_POST[$so_prefix.'category'])) $category = $_POST[$so_prefix.'category'];
	if (isset($_POST[$so_prefix.'resort_name'])) $resort_name = $_POST[$so_prefix.'resort_name'];
	if (isset($_POST[$so_prefix.'room_type'])) $room_type = $_POST[$so_prefix.'room_type']; else $room_type = "n/a";
	if (isset($_POST[$so_prefix.'num_of_nights'])) $num_of_nights = $_POST[$so_prefix.'num_of_nights']; else $num_of_nights = "n/a";
	if (isset($_POST[$so_prefix.'star_rating'])) $star_rating = $_POST[$so_prefix.'star_rating']; else $star_rating = "n/a";
	if (isset($_POST[$so_prefix.'tour_type'])) $tour_type = $_POST[$so_prefix.'tour_type']; else $tour_type = "n/a";
	if (isset($_POST[$so_prefix.'direct_flights'])) $direct_flights = $_POST[$so_prefix.'direct_flights']; else $direct_flights = "n/a";
	if (isset($_POST[$so_prefix.'departure_date'])) $departure_date = $_POST[$so_prefix.'departure_date']; else $departure_date = "n/a";
	if (isset($_POST[$so_prefix.'board_type'])) $board_type = $_POST[$so_prefix.'board_type']; else $board_type = "n/a";
	if (isset($_POST[$so_prefix.'price'])) $price = $_POST[$so_prefix.'price']; else $price = "n/a";
	if (isset($_POST[$so_prefix.'link'])) $link = $_POST[$so_prefix.'link']; else $link = "n/a";
//}
	if (isset($_GET['action']) and $_GET['action'] == $so_prefix.'offer_edit' and isset($_GET[$so_prefix.'offer_id']))
	{
		list($featured, $destination, $category, $resort_name, $room_type, $num_of_nights, $star_rating, $tour_type, $direct_flights, $departure_date, $board_type, $price, $link) = so_get_data_by_id($_GET[$so_prefix.'offer_id']);
		if ($featured == 1) $featured = "checked";
	}	
	?>
	<div class="addform">
	<form action="" method="post" name="special_offer_form" enctype="multipart/form-data">
		<p>
			Featured <input type="checkbox" name="<? echo $so_prefix;?>featured" value="1" <? echo $featured;?>>
		</p>
		<p>
			Destination
			<select name="<? echo $so_prefix;?>destination">
			<option disabled>select one below</option>
<?
if ($destinations = $wpdb->get_results("SELECT * FROM ".$so_destination_table.";"))
		{
		foreach($destinations as $destination_so) 
			{
			?>
			<option value="<?echo $destination_so->ID?>" <?if ($destination == $destination_so->ID) echo "selected";?>><?echo $destination_so->Name;?></option>
			<?
			}
		}
?>	
			</select>
		</p>
		<p>
			Category
			<select name="<? echo $so_prefix;?>category">
			<option disabled>select one below</option>
<?
if ($categories = $wpdb->get_results("SELECT * FROM ".$so_categories_table.";"))
		{
		foreach($categories as $category_so) 
			{
			?>
			<option value="<?echo $category_so->ID?>" <?if ($category == $category_so->ID) echo "selected";?>><?echo $category_so->Name;?></option>
			<?
			}
		}
?>			
			</select>			
		</p>
		<p>
			Resort name<br>
			<input type="text" name="<? echo $so_prefix;?>resort_name" value="<?echo $resort_name?>">
		</p>
		<p>
			Room type<br>
			<input type="text" name="<? echo $so_prefix;?>room_type" value="<?echo $room_type;?>">
		</p>
		<p>
			Number of nights<br>
			<input type="text" name="<? echo $so_prefix;?>num_of_nights" value="<?echo $num_of_nights;?>">
		</p>
		<p>
			Star rating<br>
			<input type="text" name="<? echo $so_prefix;?>star_rating" value="<?echo $star_rating;?>">
		</p>
		<p>
			Tour type<br>
			<input type="text" name="<? echo $so_prefix;?>tour_type" value="<?echo $tour_type;?>">
		</p>
		<p>
			Direct flights<br>
			<input type="text" name="<? echo $so_prefix;?>direct_flights" value="<?echo $direct_flights;?>">
		</p>
		<p>
			Departure date<br>
			<input type="text" name="<? echo $so_prefix;?>departure_date" value="<?echo $departure_date;?>">
		</p>
		<p>
			Board type<br>
			<input type="text" name="<? echo $so_prefix;?>board_type" value="<?echo $board_type;?>">
		</p>
		<p>
			Price<br>
			&pound;<input type="text" name="<? echo $so_prefix;?>price" value="<?echo $price;?>">
		</p>
		<p>
			Link<br>
			<input type="text" name="<? echo $so_prefix;?>link" value="<?echo $link;?>">
		</p>
		<p>
			Upload image<br>
			<input type="file" name="<? echo $so_prefix;?>image">
			<p>
<?
	if (isset($_GET['action']) and $_GET['action'] == $so_prefix.'offer_edit' and isset($_GET[$so_prefix.'offer_id']))
	{
	echo	so_show_img_by_id($_GET[$so_prefix.'offer_id']);
	?>
		<input type="hidden" name="action" value="update_offer">
		<input type="hidden" name="update_id" value="<?echo $_GET[$so_prefix.'offer_id'];?>">
		
	<?
	}
?>			
			</p>
		</p>
		<p>
			<input type="submit" name="submit" value="Submit">
		</p>
	</form>	
	</div>
	<?
}
function so_add_destination_form()
{
	global $so_prefix;
	?>
	<form name="add_destination_form" action="" method="post">
	<p>
	Add new destination<br>
		Name: <input type="text" name="<?echo $so_prefix?>destination_name"><br>
		Gallery id: <?echo so_list_galids();?><br>
		Page id: <?echo so_list_pageids();?><br>
		<input type="hidden" name="action" value="<?echo $so_prefix?>destination_add">
		<input type="submit" name="submit" value="Add new">
	</p>
	</form>
	<?
}
function so_edit_destination_form($id, $field = "submit")
{
	global $so_prefix,$wpdb, $so_destination_table;
	switch ($field) {
	case "form_start":
		?>
	<form name="edit_destination_form" action="admin.php?page=<?echo $_GET['page']?>" method="post">
		<?
	break;
	case "form_end":
		?>
	</form>	
		<?
	break;
	case "submit":
		?>
	<input type="submit" name="submit" value="Submit">	
	<input type="hidden" name="action" value="<?echo $so_prefix?>destination_edit">
	<input type="hidden" name="<?echo $so_prefix?>destination_id" value="<?echo $id?>">
		<?
	break;
	default:
	$dest = $wpdb->get_results("SELECT ".$field." FROM ".$so_destination_table." WHERE ID = ".$id.";");
	switch ($field)
	{
		case "pid":
		echo so_list_pageids($dest[0]->$field);
		break;
		case "gid":
		echo so_list_galids($dest[0]->$field);		
		break;
		default:
	?>
<input type="text" name="<?echo $so_prefix?>destination_<?echo $field?>" value="<?echo $dest[0]->$field;?>">
	<?		
		break;
	}

	break;		
		}
}

function so_update_destination($id,$name,$gid,$pid)
{
	global $wpdb, $so_destination_table;
	$data = array(
	'Name' => $name,
	'gid' => $gid,
	'pid' => $pid,
	);
	$where = array (
	'ID' => $id,
	);
	$wpdb->update($so_destination_table, $data, $where, array('%s','%d','%d'), array('%d'));
	$wpdb->show_errors();
	//$wpdb->print_error();
}
function so_add_destination($name,$gid,$pid)
{
	global $wpdb, $so_destination_table;
	$data = array(
	'ID' => NULL,
	'Name' => $name,
	'gid' => $gid,
	'pid' => $pid,
	);
	$wpdb->insert($so_destination_table, $data);
	$wpdb->show_errors();
	//$wpdb->print_error();
}
function so_delete_destination($id)
{
	global $wpdb, $so_destination_table;
	$wpdb->query($wpdb->prepare('DELETE FROM '.$so_destination_table.' WHERE ID = %d ;', $id));
}
function so_manage_destinations()
{
	global $wpdb, $so_destination_table,$so_prefix;	
	
	if (isset($_POST['action']) and $_POST['action'] == $so_prefix.'destination_add' and isset($_POST[$so_prefix.'destination_name']))
		{
			so_add_destination($_POST[$so_prefix.'destination_name'],$_POST[$so_prefix.'destination_gid'],$_POST[$so_prefix.'destination_pid']);
		}
	if (isset($_GET['action']) and $_GET['action'] == $so_prefix.'destination_delete' and isset($_GET[$so_prefix.'destination_id']))
		{
			so_delete_destination($_GET[$so_prefix.'destination_id']);
		}
	if (isset($_POST[$so_prefix.'destination_Name']) and isset($_POST[$so_prefix.'destination_id']) and isset($_POST['action']) and $_POST['action'] == $so_prefix.'destination_edit')
		{
			so_update_destination($_POST[$so_prefix.'destination_id'],$_POST[$so_prefix.'destination_Name'],$_POST[$so_prefix.'destination_gid'],$_POST[$so_prefix.'destination_pid']);
		}

	// first we get destinations list
	if ($destinations = $wpdb->get_results("SELECT * FROM ".$so_destination_table.";"))
		{ 
		if (isset($_GET['action']) and $_GET['action'] == $so_prefix."destination_edit" and isset($_GET[$so_prefix.'destination_id'])) 
								{
									so_edit_destination_form($_GET[$so_prefix.'destination_id'],"form_start");
								}
			?>
			<table class="widefat">
				<thead>
					<tr>
						<th class="manage-column column-title">#</th>
						<th class="manage-column column-title">Destination</th>
						<th class="manage-column column-title">Gallery id</th>
						<th class="manage-column column-title">Page id</th>
						<th class="manage-column column-title">Action</th>
					</tr>
				</thead>
				<tbody>
				<?
			
				foreach($destinations as $destination) {
				?>
					<tr>
						<td><?echo $destination->ID;?></td>
						<td><?
							if (isset($_GET['action']) and $_GET['action'] == $so_prefix."destination_edit" and isset($_GET[$so_prefix.'destination_id']) and $_GET[$so_prefix.'destination_id'] == $destination->ID) 
								{
									so_edit_destination_form($_GET[$so_prefix.'destination_id'],"Name");
								}
								else echo $destination->Name;?>
						</td>
						<td><?
							if (isset($_GET['action']) and $_GET['action'] == $so_prefix."destination_edit" and isset($_GET[$so_prefix.'destination_id']) and $_GET[$so_prefix.'destination_id'] == $destination->ID) 
								{
									so_edit_destination_form($_GET[$so_prefix.'destination_id'],"gid");
								}
								else echo $destination->gid;?>
						</td>
						<td><?
							if (isset($_GET['action']) and $_GET['action'] == $so_prefix."destination_edit" and isset($_GET[$so_prefix.'destination_id']) and $_GET[$so_prefix.'destination_id'] == $destination->ID) 
								{
									so_edit_destination_form($_GET[$so_prefix.'destination_id'],"pid");
								}
								else echo $destination->pid;?>
						</td>
						<td><a href="admin.php?page=<?echo $_GET['page']?>&action=<?echo $so_prefix?>destination_delete&<?echo $so_prefix?>destination_id=<?echo $destination->ID;?>">Delete</a> | 
		
		<?
		if (isset($_GET['action']) and $_GET['action'] == $so_prefix."destination_edit" and isset($_GET[$so_prefix.'destination_id']) and $_GET[$so_prefix.'destination_id'] == $destination->ID) 
								{
so_edit_destination_form($_GET[$so_prefix.'destination_id'],"submit");
								} else {?>
<a href="admin.php?page=<?echo $_GET['page']?>&action=<?echo $so_prefix?>destination_edit&<?echo $so_prefix?>destination_id=<?echo $destination->ID;?>">Edit</a>
						<?}?>
						</td>
					</tr>
				<?
				}
				?>	
				</tbody>
			</table>
			<?
		if (isset($_GET['action']) and $_GET['action'] == $so_prefix."destination_edit" and isset($_GET[$so_prefix.'destination_id'])) 
								{
									so_edit_destination_form($_GET[$so_prefix.'destination_id'],"form_end");
								}			
		}
		else echo "There are no destinations defined at the moment";
	so_add_destination_form();
}
function so_add_category_form()
{
	global $so_prefix;
	?>
	<form name="add_category_form" action="" method="post">
	<p>
	Add new category<br>
		<input type="text" name="<?echo $so_prefix?>category_name">
		<input type="hidden" name="action" value="<?echo $so_prefix?>category_add">
		<input type="submit" name="submit" value="Submit">
	</p>
	</form>
	<?
}
function so_edit_category_form($id)
{
	global $so_prefix,$wpdb, $so_categories_table;
	$name = $wpdb->get_results("SELECT Name FROM ".$so_categories_table." WHERE ID = ".$id.";");
	?>
	<form name="edit_category_form" action="admin.php?page=<?echo $_GET['page']?>" method="post">

		<input type="text" name="<?echo $so_prefix?>category_name" value="<?echo $name[0]->Name;?>">
		<input type="hidden" name="action" value="<?echo $so_prefix?>category_edit">
		<input type="hidden" name="<?echo $so_prefix?>category_id" value="<?echo $id?>">
		<input type="submit" name="submit" value="Submit">

	</form>
	<?
}
function so_update_category($id,$name)
{
	global $wpdb, $so_categories_table;
	$data = array(
	'Name' => $name,
	);
	$where = array (
	'ID' => $id,
	);
	$wpdb->update($so_categories_table, $data, $where, array('%s'), array('%d'));
	$wpdb->show_errors();
}
function so_add_category($name)
{
	global $wpdb, $so_categories_table;
	$data = array(
	'ID' => NULL,
	'Name' => $name,
	);
	$wpdb->insert($so_categories_table, $data);
	$wpdb->show_errors();
}
function so_delete_category($id)
{
	global $wpdb, $so_categories_table;
	$wpdb->query($wpdb->prepare('DELETE FROM '.$so_categories_table.' WHERE ID = %d ;', $id));
}
function so_manage_categories()
{
	global $wpdb, $so_categories_table,$so_prefix;	
	
	if (isset($_POST['action']) and $_POST['action'] == $so_prefix.'category_add' and isset($_POST[$so_prefix.'category_name']))
		{
			so_add_category($_POST[$so_prefix.'category_name']);
		}
	if (isset($_GET['action']) and $_GET['action'] == $so_prefix.'category_delete' and isset($_GET[$so_prefix.'category_id']))
		{
			so_delete_category($_GET[$so_prefix.'category_id']);
		}
	if (isset($_POST[$so_prefix.'category_name']) and isset($_POST[$so_prefix.'category_id']) and isset($_POST['action']) and $_POST['action'] == $so_prefix.'category_edit')
		{
			so_update_category($_POST[$so_prefix.'category_id'],$_POST[$so_prefix.'category_name']);
		}

	// first we get destinations list
	if ($categories = $wpdb->get_results("SELECT * FROM ".$so_categories_table.";"))
		{ 
			?>
			<table class="widefat">
				<thead>
					<tr>
						<th class="manage-column column-title">#</th>
						<th class="manage-column column-title">Category</th>
						<th class="manage-column column-title">Action</th>
					</tr>
				</thead>
				<tbody>
				<?
			
				foreach($categories as $category) {
				?>
					<tr>
						<td><?echo $category->ID;?></td>
						<td><?
							if (isset($_GET['action']) and $_GET['action'] == $so_prefix."category_edit" and isset($_GET[$so_prefix.'category_id']) and $_GET[$so_prefix.'category_id'] == $category->ID) 
								{
									so_edit_category_form($_GET[$so_prefix.'category_id'], "Name");
								}
								else echo $category->Name;?>
						</td>
						<td><a href="admin.php?page=<?echo $_GET['page']?>&action=<?echo $so_prefix?>category_delete&<?echo $so_prefix?>category_id=<?echo $category->ID;?>">Delete</a> | <a href="admin.php?page=<?echo $_GET['page']?>&action=<?echo $so_prefix?>category_edit&<?echo $so_prefix?>category_id=<?echo $category->ID;?>">Edit</a></td>
					</tr>
				<?
				}
				?>	
				</tbody>
			</table>
			<?
		}
		else echo "There are no categories defined at the moment";
	so_add_category_form();
}

function so_offers_parse($tag)
{
	global $wpdb, $so_table, $so_destination_table, $so_categories_table,$so_img_show_folder;
	switch($tag)
	{
		case "[homepage offers]":
			$result = $tag;
		break;		
		case "[hotel offers]":
		global $post;
$offers = $wpdb->get_results("Select o.ID, o.stars, o.resort_name, o.price, o.link, o.img_src 
FROM ".$so_table." o, ". $so_destination_table." d, ".$so_categories_table." c 
WHERE o.category = c.ID AND c.Name = 'Hotel' AND o.destination = d.ID AND d.pid = '".$post->ID."';");				
			$result = '
<div class="recHotels">
			<h2>Superstar recommended hotels in '.$post->post_title.' </h2>
			<ul class="grid">			
			';
			foreach ($offers as $offer)
			{
				$result .= '
								<li>
									<h3>'.$offer->resort_name.' '.$offer->stars.' Hotel </h3>
									<p>
									<a href="'.$offer->link.'" class="left">

										<img src="'.$so_img_show_folder.$offer->img_src.'" alt="'.$offer->resort_name.'">
									</a>
									<span class="price">From Price: <strong>&pound;'.$offer->price.' per person per night</strong></span>
									</p>
									<p><a href="'.$offer->link.'" class="chkavail">check hotel availability</a></p>
								</li>				
				';
			}
			$result .= '
			</ul>
</div>
<script>
$("div.recHotels>ul.grid>li:last").addClass("nobdr");
</script>			
			';
		break;		
		case "[hotel offers all]":
		global $post;
$offers = $wpdb->get_results("Select o.ID, o.stars, o.resort_name, o.price, o.link, o.img_src 
FROM ".$so_table." o, ".$so_categories_table." c 
WHERE o.category = c.ID AND c.Name = 'Hotel';");				
			$result = '
<div class="recHotels">
			<h2>Superstar recommended hotels</h2>
			<ul class="grid">			
			';
			foreach ($offers as $offer)
			{
				$result .= '
								<li>
									<h3>'.$offer->resort_name.' '.$offer->stars.' Hotel </h3>
									<p>
									<a href="'.$offer->link.'" class="left">

										<img src="'.$so_img_show_folder.$offer->img_src.'" alt="'.$offer->resort_name.'">
									</a>
									<span class="price">From Price: <strong>&pound;'.$offer->price.' per person per night</strong></span>
									</p>
									<p><a href="'.$offer->link.'" class="chkavail">check hotel availability</a></p>
								</li>				
				';
			}
			$result .= '
			</ul>
</div>
<script>
$("div.recHotels>ul.grid>li:last").addClass("nobdr");
</script>			
			';
		break;		
		case "[holiday offers]":
$offers = $wpdb->get_results("Select o.ID, o.stars, o.num_of_nights, o.resort_name, d.Name as destination, o.direct_flights, o.departure_date, o.board_type, o.price, o.link, o.img_src 
FROM ".$so_table." o, ". $so_destination_table." d, ".$so_categories_table." c 
WHERE o.category = c.ID AND c.Name = 'Holiday' AND o.destination = d.ID;");			
			$result = '
			<strong>Some of our holiday packages</strong>
<table cellspacing="1" cellpadding="0" border="0" width="100%" class="someoffers">';
			foreach($offers as $offer)
			{
				$result .= '
 <tr>
 <td>
	<table class="teaser" cellspacing="0">
	
	<tr>
		<td colspan="2">
	<h2>'.$offer->num_of_nights.'nts at the '.$offer->stars.' '.$offer->resort_name.', in '.$offer->destination.' only &pound;'.$offer->price.'</h2>
		</td>
		<td class="call2book" rowspan="2">
		  <a href="'.$offer->link.'" target="_blank">
		  <strong>Book this offer</strong></a>
		</td>
	</tr>
    <tr>
         <td class="imgCell">
   	         <img src="'.$so_img_show_folder.$offer->img_src.'" />
         </td>
         <td><ul class="bull">
			 <li><span>Direct Flights: </span><strong>'.$offer->direct_flights.'</strong></li>
			 <li><span>Departure Date:</span><strong>'.$offer->departure_date.' for '.$offer->num_of_nights.' nights</strong></li>
			 <li><span>Accommodation: </span><strong>'.$offer->stars.' '.$offer->resort_name.'</strong></li>
			 <li><span>Board Type: </span><strong>'.$offer->board_type.'</strong></li></ul>
	    </td>
	</tr>

    </table>
 </td>
 </tr>								
				';
			}
			$result .= '</table>';
			$result .= '<script>$("table.someoffers>tbody>tr:odd>td>table").addClass("green");</script>';
			
			
		break;
		case "[destination gallery]":
		global $post;
			$gal = $wpdb->get_results("SELECT gid FROM ".$so_destination_table." WHERE pid = ".$post->ID.";");

			if ($gal[0]->gid != 0) {
			$result = "[nggallery id=".$gal[0]->gid." template=destinations]";
			} else $result = $tag;
		break;
		default:
			$result = $tag;
		break;
	}
	return $result;
}
function so_offers_parse_params($params)
{
	global $wpdb, $so_table, $so_destination_table, $so_categories_table,$so_img_show_folder;	
	//echo sizeof($params);
	$result = '';
	for($i = 0;$i<sizeof($params);$i++)
	{
		switch ($params[$i])
		{
			case "destination":

$offers = $wpdb->get_results("Select o.ID, o.stars, o.num_of_nights, o.resort_name, d.Name as destination, o.direct_flights, o.departure_date, o.board_type, o.price, o.link, o.img_src 
FROM ".$so_table." o, ". $so_destination_table." d, ".$so_categories_table." c 
WHERE o.destination = ".$params[$i+1]." AND c.Name = 'Holiday' AND o.category = c.ID AND d.ID = ".$params[$i+1].";");			
			$result = '
			<strong>Some of our holiday packages</strong>
<table cellspacing="1" cellpadding="0" border="0" width="100%" class="someoffers">';
			foreach($offers as $offer)
			{
				$result .= '
 <tr>
 <td>
	<table class="teaser" cellspacing="0">
	
	<tr>
		<td colspan="2">
	<h2>'.$offer->num_of_nights.'nts at the '.$offer->stars.' '.$offer->resort_name.', in '.$offer->destination.' only &pound;'.$offer->price.'</h2>
		</td>
		<td class="call2book" rowspan="2">
		  <a href="'.$offer->link.'" target="_blank">
		  <strong>Book this offer</strong></a>
		</td>
	</tr>
    <tr>
         <td class="imgCell">
   	         <img src="'.$so_img_show_folder.$offer->img_src.'" />
         </td>
         <td><ul class="bull">
			 <li><span>Direct Flights: </span><strong>'.$offer->direct_flights.'</strong></li>
			 <li><span>Departure Date:</span><strong>'.$offer->departure_date.' for '.$offer->num_of_nights.' nights</strong></li>
			 <li><span>Accommodation: </span><strong>'.$offer->stars.' '.$offer->resort_name.'</strong></li>
			 <li><span>Board Type: </span><strong>'.$offer->board_type.'</strong></li></ul>
	    </td>
	</tr>

    </table>
 </td>
 </tr>								
				';
			}
			$result .= '</table>';
			$result .= '<script>$("table.someoffers>tbody>tr:odd>td>table").addClass("green");</script>';
			break;
			case "template":
				switch($params[$i+1])
				{
					case "table":
$offers = $wpdb->get_results("Select o.ID, o.stars, o.num_of_nights, o.resort_name, d.Name as destination, o.direct_flights, o.departure_date, o.board_type, o.price, o.link, o.img_src 
FROM ".$so_table." o, ". $so_destination_table." d, ".$so_categories_table." c 
WHERE o.category = c.ID AND c.Name = 'Holiday' AND o.destination = d.ID;");									
$result .= '
<div class="clear" id="holiday_offers_table">
<h2>Citybreak Offers to Israel (Price per person)</h2>
<table class="offersTable" summary="Citybreak Special offers to Israel">
<thead>
<tr>
<th class="side">Resort</th>
<th>Star Rtg</th>
<th>Nts</th>

<th>Price</th>
<th>Book Now</th>
</tr>
</thead>
<tbody>';
foreach ($offers as $offer) 
{
$result .= '
<tr>
<td class="side">'.$offer->resort_name.'</td>
<td>'.$offer->stars.'</td>
<td>'.$offer->num_of_nights.'</td>
<td>&pound;'.$offer->price.'</td>
<td><a class="chkavail" href="'.$offer->link.'" target="_blank">Book this offer</a></td>
</tr>';
}

$result .= '
</tbody>
</table>
</div>
<script>
$("#holiday_offers_table>table>tbody>tr:even").addClass("even")
</script>
';
					break;
				}
			break;
			default:
				//$result .= "$params[$i]";
			break;
		}
	}
	return $result;
}
function so_show_offers($content)
{
	$offer_tags = array('[homepage offers]','[hotel offers]','[hotel offers all]','[holiday offers]','[destination gallery]');
	foreach ($offer_tags as $offer_tag) {
		$content=str_replace($offer_tag,so_offers_parse($offer_tag),$content);
    }
	$exprs = array("\[holiday[[:space:]]offers[[:space:]]([a-z]+)=([0-9]+)]","\[holiday[[:space:]]offers[[:space:]]([a-z]+)=([a-z0-9]+)]");
	foreach ($exprs as $expr) {	
		if (ereg($expr, $content, $params))
		{
			//print_r($params);
			$content = ereg_replace($expr, so_offers_parse_params($params), $content);
		}
	}
	return $content;
}

function so_special_offers_inwidget($promotext, $flighttext)
{

	global $wpdb, $so_table, $so_destination_table, $so_categories_table;

	$hotel_offers = $wpdb->get_results("SELECT o.ID as id, o.resort_name as resort_name, o.room_type as room_type, o.num_of_nights as num_of_nights, o.stars as stars, o.price as price, o.link as link
FROM ".$so_table." o, ".$so_categories_table." c
WHERE o.featured = 1 AND o.category = c.ID AND c.Name = 'Hotel'
ORDER BY o.ID ASC;");

	$holiday_offers = $wpdb->get_results("SELECT o.ID as id, o.resort_name as resort_name, o.num_of_nights as num_of_nights, o.stars as stars, o.price as price, o.link as link
FROM ".$so_table." o, ".$so_categories_table." c
WHERE o.featured = 1 AND o.category = c.ID AND c.Name = 'Holiday'
ORDER BY o.ID ASC;");	

	$tour_offers = $wpdb->get_results("SELECT o.ID as id, o.resort_name as resort_name, o.num_of_nights as num_of_nights, o.tour_type as tour_type, o.price as price
FROM ".$so_table." o, ".$so_categories_table." c
WHERE o.featured = 1 AND o.category = c.ID AND c.Name = 'Tour'
ORDER BY o.ID ASC;");

?>

<div id="rotate">

<ul class="ui-tabs-nav">
<li class="ui-tabs-selected"><a href="#fragment-1"><span>Special Promotion</span></a></li>
<li><a href="#fragment-2"><span>Flight Offers</span></a></li>
<li><a href="#fragment-3"><span>Hotel Offers</span></a></li>
<li><a href="#fragment-4"><span>Citybreak Offers</span></a></li>
<li><a href="#fragment-5"><span>Tour Offers</span></a></li>
</ul>

<div id="fragment-1" class="ui-tabs-panel ui-tabs-hide">
<?echo $promotext;?>
</div>

<div id="fragment-2" class="ui-tabs-panel ui-tabs-hide">
<?echo $flighttext;?>
</div>

<div id="fragment-3" class="ui-tabs-panel ui-tabs-hide">
<h2>Hotel Offers in Israel (Prices are Per Person Per Night)</h2>
<table class="offersTable" summary="Hotel Special offers to Israel">
<thead>
<tr>
<th class="side">Resort</th>
<th>Room</th>
<th>Nts</th>
<th>Price</th>
<th>Book Now</th>
</tr>
</thead>

<tbody>
<?
foreach ($hotel_offers as $offer) 
{
	echo '
<tr>
<td class="side">'.$offer->stars.' '.$offer->resort_name.'</td>
<td>'.$offer->room_type.'</td>
<td>'.$offer->num_of_nights.'</td>
<td>From &pound;'.$offer->price.'</td>
<td><a class="chkavail" href="'.$offer->link.'" target="_blank">Book this offer</a></td>
</tr>';
}
?>

</tbody>
</table>
</div>

<div id="fragment-4" class="ui-tabs-panel ui-tabs-hide">
<h2>Citybreak Offers to Israel (Price per person)</h2>
<table class="offersTable" summary="Citybreak Special offers to Israel">
<thead>
<tr>
<th class="side">Resort</th>
<th>Star Rtg</th>
<th>Nts</th>

<th>Price</th>
<th>Book Now</th>
</tr>
</thead>
<tbody>
<?
foreach ($holiday_offers as $offer) 
{
	echo '
<tr>
<td class="side">'.$offer->resort_name.'</td>
<td>'.$offer->stars.'</td>
<td>'.$offer->num_of_nights.'</td>
<td>&pound;'.$offer->price.'</td>
<td><a class="chkavail" href="'.$offer->link.'" target="_blank">Book this offer</a></td>
</tr>';
}
?>

</tbody>
</table>
</div>

<div id="fragment-5" class="ui-tabs-panel ui-tabs-hide">
<h2>Tour Offers in Israel (Price per person)</h2>
<table class="offersTable" summary="Tour Special offers to Israel">
<thead>

<tr>
<th class="side">Resort</th>
<th>Tour Type</th>
<th>Nts</th>
<th>Price</th>
<th>Book Now</th>
</tr>
</thead>
<tbody>
<?
foreach ($tour_offers as $offer) 
{
	echo '
<tr>
<td class="side">'.$offer->resort_name.'</td>
<td>'.$offer->tour_type.'</td>
<td>'.$offer->num_of_nights.'</td>
<td>&pound;'.$offer->price.'</td>
<td><strong>Call 0207 121 1500</strong></td>
</tr>';
}
?>

</tbody>
</table>

</div>
</div>
<script>
$("#rotate>div>table>tbody>tr:even").addClass("even")
</script>
<?					
}

//////////// widget
class special_offers extends WP_Widget {
    /** constructor */
    function special_offers() {
	                $widget_ops = array('classname' => 'widget_text', 'promotext' => __('Special promotion text'), 'flighttext' => __('Flight offers text'));
	                $control_ops = array('width' => 500, 'height' => 350);
	                $this->WP_Widget('special-offers', __('Special offers'), $widget_ops, $control_ops);
	        }
	
	        function widget( $args, $instance ) {
	                extract($args);
	                $title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
	                $promotext = apply_filters( 'widget_text', $instance['promotext'], $instance );
	                $flighttext = apply_filters( 'widget_text', $instance['flighttext'], $instance );
		
					echo $before_widget;	   
	if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } 					
	so_special_offers_inwidget($promotext, $flighttext);				
	                echo $after_widget;
	        }
	
	        function update( $new_instance, $old_instance ) {
	                $instance = $old_instance;
	                $instance['title'] = strip_tags($new_instance['title']);
	                if ( current_user_can('unfiltered_html') )
	                        $instance['promotext'] =  $new_instance['promotext'];
	                else
	                        $instance['promotext'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['promotext']) ) ); // wp_filter_post_kses() expects slashed	               
					if ( current_user_can('unfiltered_html') )
	                        $instance['flighttext'] =  $new_instance['flighttext'];
	                else
	                        $instance['flighttext'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['flighttext']) ) ); // wp_filter_post_kses() expects slashed
	                $instance['filter'] = isset($new_instance['filter']);
	                return $instance;
	        }
	
	        function form( $instance ) {
	                $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'code' => '' ) );
	                $title = strip_tags($instance['title']);
	                $promotext = format_to_edit($instance['promotext']);
	                $flighttext = format_to_edit($instance['flighttext']);
	?>
	                <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
	                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
					<p><label for="<?php echo $this->get_field_id('promotext'); ?>"><?php echo 'Special promotion text:'; ?></label>
	                <textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('promotext'); ?>" name="<?php echo $this->get_field_name('promotext'); ?>"><?php echo $promotext; ?></textarea></p>
					<p><label for="<?php echo $this->get_field_id('flighttext'); ?>"><?php echo 'Flight offers text'; ?></label>
	                <textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('flighttext'); ?>" name="<?php echo $this->get_field_name('flighttext'); ?>"><?php echo $flighttext; ?></textarea>
	
	                </p>
	<?php
	        }

}
add_action('widgets_init', create_function('', 'return register_widget("special_offers");'));

function so_list_pageids($selected = "")
{
	global $wpdb,$so_prefix;
	$query = "SELECT ID, post_title FROM ".$wpdb->posts." WHERE post_type = 'page' ORDER BY ID";
	$pages = $wpdb->get_results($query);
	$result = '<select name="'.$so_prefix.'destination_pid">';
	$result .= '<option disabled>Page ID</option>';
	foreach ($pages as $page)
	{
		$result .= '<option value="'.$page->ID.'"';
		if ($selected == $page->ID) $result .= ' selected ';
		$result .= '>'.$page->ID.' - '.$page->post_title.'</option>';
	}
	$result .= '</select>';
	return $result;
}
function so_list_galids($selected = "")
{
	global $wpdb,$so_prefix,$table_prefix;
	$query = "SELECT gid AS ID, title FROM ".$table_prefix."ngg_gallery ORDER BY ID";
	$gals = $wpdb->get_results($query);
	$result = '<select name="'.$so_prefix.'destination_gid">';
	$result .= '<option disabled>Gallery ID</option>';
	foreach ($gals as $gal)
	{
		$result .= '<option value="'.$gal->ID.'"';
		if ($selected == $gal->ID) $result .= ' selected ';
		$result .= '>'.$gal->ID.' - '.$gal->title.'</option>';
	}
	$result .= '</select>';
	return $result;
}

/////////////////// special funcs
function so_upgrade_plugin($to_ver)
{
	global $wpdb,$so_destination_table,$so_version;
	//switch($to_ver)
	//{
		//case 2:
			$sql_update = "ALTER TABLE `".$so_destination_table."` ADD COLUMN `gid` int NULL AFTER `Name`, ADD COLUMN `pid` int NULL AFTER `gid`;";
			//echo $sql_update;
			$wpdb->query($sql_update);
			$wpdb->show_errors();
			$wpdb->print_error(); 
			update_option( "so_version", $to_ver );
			echo "special offers plugin was upgraded";
		//break;
	//}

}
?>
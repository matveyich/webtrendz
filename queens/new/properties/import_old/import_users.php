<?
$file = file('users.csv');
$fp = fopen('users.sql','w');
$today = date('Y-m-d H:i:s');
foreach ($file as $k=>$row)
{
	if ($k>0)
	{
	$fields = explode(';',$row);
	foreach($fields as $i=>$field)
	{
		$fields[$i] = str_replace("'","\'",trim($field));//echo "'$fields[$i]'<br>";
		if ($fields[$i] == '') $fields[$i] = 'NULL';
	}
	list($id,$email,$firstname,$lastname,$title,$numberofrooms,$maximumprice,$type,$telnumber,$tag) = $fields;
	if ($email == 'none@none.com' || $email == '.' || $email == '') $email = "'none@none.com'"; else $email = "'$email'";
	$display_name = "'$title $firstname $lastname'";
	if ($lastname == '.' || $lastname == '') $lastname = 'NULL'; else $lastname = "'$lastname'";
	if ($title == '.' || $title == '') $title = 'NULL'; else $title = "'$title'";
	if ($firstname == '.' || $firstname == '') $firstname = 'NULL'; else $firstname = "'$firstname'";
	
	$sql = "INSERT INTO wp_users (ID,user_login,user_nicename,user_email,user_status,display_name) 
	values 
	($id, $lastname, $lastname,$email,0,$display_name);\n";
	fwrite($fp,$sql);
	
	$sql = "INSERT INTO wp_usermeta (umeta_id,user_id,meta_key,meta_value) 
	values 
	(NULL, $id, 'wp_capabilities','a:1:{s:10:\"subscriber\";s:1:\"1\";}');\n";
	fwrite($fp,$sql);
	$sql = "INSERT INTO wp_usermeta (umeta_id,user_id,meta_key,meta_value) 
	values 
	(NULL, $id, 'wp_user_level','0');\n";
	fwrite($fp,$sql);
	
	if ($lastname != 'NULL'){
	$sql = "INSERT INTO wp_usermeta (umeta_id,user_id,meta_key,meta_value) 
	values 
	(NULL, $id, 'nickname',$lastname);\n";
	fwrite($fp,$sql);
	}
	if ($title != 'NULL'){
	$sql = "INSERT INTO wp_usermeta (umeta_id,user_id,meta_key,meta_value) 
	values 
	(NULL, $id, 'title',$title);\n";
	fwrite($fp,$sql);
	}
	if ($firstname != 'NULL'){
	$sql = "INSERT INTO wp_usermeta (umeta_id,user_id,meta_key,meta_value) 
	values 
	(NULL, $id, 'first_name',$firstname);\n";
	fwrite($fp,$sql);
	}
	if ($lastname != 'NULL'){
	$sql = "INSERT INTO wp_usermeta (umeta_id,user_id,meta_key,meta_value) 
	values 
	(NULL, $id, 'last_name',$lastname);\n";
	fwrite($fp,$sql);
	}
	
	if ($tag != 'NULL'){
	switch($tag)
	{
		case "Mobile":
		$sql = "INSERT INTO wp_usermeta (umeta_id,user_id,meta_key,meta_value) 
	values 
	(NULL, $id, 'mobile','$telnumber');\n";
		fwrite($fp,$sql);
		break;
		default:
		$sql = "INSERT INTO wp_usermeta (umeta_id,user_id,meta_key,meta_value) 
	values 
	(NULL, $id, 'phone1','$telnumber');\n";
		fwrite($fp,$sql);
		break;
	}
	}
	
	if ($type != 'NULL')
	{
	switch ($type)
	{
		case "sale":
	$sql = "INSERT INTO wp_usermeta (umeta_id,user_id,meta_key,meta_value) 
	values 
	(NULL, $id, 'price','$maximumprice');\n";
	fwrite($fp,$sql);
	$sql = "INSERT INTO wp_usermeta (umeta_id,user_id,meta_key,meta_value) 
	values 
	(NULL, $id, 'sale','on');\n";
	fwrite($fp,$sql);
		break;
		case "rent":
	$sql = "INSERT INTO wp_usermeta (umeta_id,user_id,meta_key,meta_value) 
	values 
	(NULL, $id, 'rent_price','$maximumprice');\n";
	fwrite($fp,$sql);
	$sql = "INSERT INTO wp_usermeta (umeta_id,user_id,meta_key,meta_value) 
	values 
	(NULL, $id, 'rent','on');\n";
	fwrite($fp,$sql);
		break;
	}
	}	
	
	}
}
fclose($fp);
include('users.sql');
?>
<?
$file = file('lettings_import.csv');
$fp = fopen('lettings_import.sql','w');
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
	list($Id,$Price,$PricePM,$Landlord,$Status,$Furnishing,$Type,$NumberOfBedrooms,$IsFeatured,$IsActive,$ReferenceNumber,$ViewingArrangements,$Description,$DisplayFrom,$AvailableFrom,$Area,$BuildingName,$DoorNumber,$Street,$PostCode) = $fields;
	list($a_date,$a_time) = explode(' ',$AvailableFrom);
	list($d_date,$d_time) = explode(' ',$DisplayFrom);
	$sql = "INSERT INTO pr_properties (ID,let_weekrent,descr,viewarrange,refnumber,area,type,bedroomnum,addr_building_name,addr_door_number,addr_street,addr_postcode,extra_date_avail_from,extra_date_displ_from,extra_active,extra_featured,extra_furnishing,extra_status,property_type,user_id,date_created,date_updated) values (NULL,$Price,'$Description','$ViewingArrangements','$ReferenceNumber',$Area,$Type,$NumberOfBedrooms,'$BuildingName','$DoorNumber','$Street','$PostCode','$a_date','$d_date',1,$IsFeatured,'$Furnishing',$Status,1,$Landlord,'".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."');\n";
	fwrite($fp,$sql);
	}
}
$sql = "UPDATE pr_properties SET viewarrange = NULL WHERE viewarrange = 'NULL';
UPDATE pr_properties SET refnumber = NULL WHERE refnumber = 'NULL';
UPDATE pr_properties SET addr_building_name = NULL WHERE addr_building_name = 'NULL';
UPDATE pr_properties SET extra_furnishing = NULL WHERE extra_furnishing = 'NULL';
UPDATE pr_properties SET extra_status = NULL WHERE extra_status = 'NULL';
UPDATE pr_properties SET order_ref = NULL WHERE order_ref = 'NULL';";
fwrite($fp,$sql);
fclose($fp);
include('lettings_import.sql');
?>
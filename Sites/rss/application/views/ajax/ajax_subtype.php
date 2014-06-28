<?php
include('db.php');
if($_POST['id'])
{
	$id=$_POST['id'];
	$sql=mysql_query("select b.id,b.data from data_parent a,data b where b.id=a.did and parent='$id'");

	while($row=mysql_fetch_array($sql))
	{
		$id=$row['id'];
		$data=$row['data'];
		echo '<option value="'.$id.'">'.$data.'</option>';

	}
	foreach ($query4 as $item4){
		echo '<option value="'.$item3->NT03_SubTypeID.'">'.$item4->SubType.'</option>';
	}
}

?>
<?php

//fetch.php

include('function.php');

$startGET = filter_input(INPUT_GET, "start", FILTER_SANITIZE_NUMBER_INT);

$start = $startGET ? intval($startGET) : 0;

$lengthGET = filter_input(INPUT_GET, "length", FILTER_SANITIZE_NUMBER_INT);

$length = $lengthGET ? intval($lengthGET) : 10;

$searchQuery = filter_input(INPUT_GET, "searchQuery", FILTER_SANITIZE_STRING);

$search = empty($searchQuery) || $searchQuery === "null" ? "" : $searchQuery;

$sortColumnIndex = filter_input(INPUT_GET, "sortColumn", FILTER_SANITIZE_NUMBER_INT);

$sortDirection = filter_input(INPUT_GET, "sortDirection", FILTER_SANITIZE_STRING);

$column = array("fullname", "gender", "age", "region", "district", "shehia");

$query = "SELECT * FROM victim ";

$query .= '
	WHERE victim_id LIKE "%'.$search.'%" 
	OR fullname LIKE "%'.$search.'%" 
	OR gender LIKE "%'.$search.'%" 
	OR age LIKE "%'.$search.'%" 
	OR region LIKE "%'.$search.'%"
	OR district LIKE "%'.$search.'%"
	OR shehia LIKE "%'.$search.'%" 
	';


if($sortColumnIndex != '')
{
	$query .= 'ORDER BY '.$column[$sortColumnIndex].' '.$sortDirection.' ';
}
else
{
	$query .= 'ORDER BY victim_id DESC ';
}

$query1 = '';

if($length != -1)
{
	$query1 = 'LIMIT ' . $start . ', ' . $length;
}

$statement = $connect->prepare($query);

$statement->execute();

$number_filter_row = $statement->rowCount();

$result = $connect->query($query . $query1);

$data = array();

foreach($result as $row)
{
	$sub_array = array();

	$sub_array[] = $row['fullname'];

	$sub_array[] = $row['gender'];

	$sub_array[] = $row['age'];

	$sub_array[] = $row['region'];
	
	$sub_array[] = $row['district'];
	
	$sub_array[] = $row['shehia'];
	
	$sub_array[] = $row['ir_number'];

	$sub_array[] = '<button type="button" onclick="fetch_data('.$row["victim_id"].')" class="btn btn-warning btn-sm">Edit</button>&nbsp;<button type="button" class="btn btn-danger btn-sm" onclick="delete_data('.$row["victim_id"].')">Delete</button>';

	$data[] = $sub_array;
}



$output = array(
	"recordsTotal"	       	=>	count_all_data($connect),
	"recordsFiltered"      	=>	$number_filter_row,
	"data"				=>	$data
);

echo json_encode($output);

?>

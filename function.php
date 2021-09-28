<?php

//function.php

//$connect = new PDO("mysql:host=localhost;dbname=testing", "hassliipro", "hassliipro");
$connect = new PDO("mysql:host=localhost;dbname=dppznz_dpp_filing_system", "hassliipro", "hassliipro");

function fetch_top_five_data($connect)
{
	$query = "
	SELECT * FROM victim
	ORDER BY victim_id DESC 
	LIMIT 5";

	$result = $connect->query($query);

	$output = '';

	foreach($result as $row)
	{
		$output .= '
		
		<tr>
			<td>'.$row["fullname"].'</td>
			<td>'.$row["gender"].'</td>
			<td>'.$row["age"].'</td>
			<td>'.$row["region"].'</td>
			<td>'.$row["district"].'</td>
			<td>'.$row["shehia"].'</td>
                       <td>'.$row["ir_number"].'</td>
<td><button type="button" onclick="fetch_data('.$row["victim_id"].')" class="btn btn-warning btn-sm">Edit</button>&nbsp;
<button type="button" class="btn btn-danger btn-sm" onclick="delete_data('.$row["victim_id"].')">Delete</button></td>
		</tr>
		';
	}
	return $output;
}

function count_all_data($connect)
{
	$query = "SELECT * FROM victim";

	$statement = $connect->prepare($query);

	$statement->execute();

	return $statement->rowCount();
}

?>

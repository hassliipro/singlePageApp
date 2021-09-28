<?php

//action.php

include('function.php');

if(isset($_POST["action"]))
{
	if($_POST["action"] == 'Add' || $_POST["action"] == 'Update')
	{
		$output = array();
		$fullname     = $_POST["fullname"];
		$gender       = $_POST["gender"];
		$age          = $_POST["age"];

		$region       = $_POST["region"];
		$district     = $_POST["district"];
		$shehia       = $_POST["shehia"];
		$ir_number    = $_POST["ir_number"];;

		if(empty($fullname))
		{
			$output['fullname_error'] = 'Full Name is Required';
		}

		if(empty($gender))
		{
			$output['gender_error'] = 'Gender Name is Required';
		}

		if(empty($age))
		{
			$output['age_error'] = 'Age is Required';
		}
		
		if(empty($region))
		{
			$output['region_error'] = 'Region is Required';
		}
		
		if(empty($district))
		{
			$output['district_error'] = 'District is Required';
		}
		
		if(empty($shehia))
		{
			$output['shehia_error'] = 'Shehia is Required';
		}
		
		if(empty($ir_number))
		{
			$output['shehia_error'] = 'Shehia is Required';
		}
		
		
		
	
	

		if(count($output) > 0)
		{

			echo json_encode($output);
		}
		else
		{
			$data = array(
				':fullname' =>	$fullname,
				':gender'   =>	$gender,
				':age'      =>	$age,
				':region'   =>	$region,
				':district' =>	$district,
				':shehia'   =>	$shehia,
				':ir_number'=> $ir_number
			);
			
			
			
			if($_POST['action'] == 'Add')
			{
				$query = "
				INSERT INTO victim 
				(fullname, gender, age, region, district, shehia, ir_number) 
				VALUES (:fullname, :gender, :age, :region, :district, :shehia, :ir_number)
				";

				$statement = $connect->prepare($query);

				if($statement->execute($data))
				{
					$output['success'] = '<div class="alert alert-success">New Data Added</div>';

					echo json_encode($output);
				}
			}

			if($_POST['action'] == 'Update')
			{
				$query = "
				UPDATE victim 
				SET fullname = :fullname, 
				gender       = :gender, 
				age          = :age, 
				region       = :gender,
				district     = :district,
				shehia       = :shehia,
				ir_number    = :ir_number 
				WHERE victim_id = '".$_POST["victim_id"]."'
				";

				$statement = $connect->prepare($query);

				if($statement->execute($data))
				{
					$output['success'] = '<div class="alert alert-success">Data Updated</div>';
				}

				echo json_encode($output);

			}
		}
	}

	if($_POST['action'] == 'fetch')
	{
		$query = "
		SELECT * FROM victim 
		WHERE victim_id = '".$_POST["id"]."'
		";

		$result = $connect->query($query);

		$data = array();

		foreach($result as $row)
		{

			$data['fullname']        = $row['fullname'];

			$data['gender']          = $row['gender'];

			$data['age']             = $row['age'];

			$data['region']          = $row['region'];
			
			$data['district']        = $row['district'];
			
			$data['shehia']          = $row['shehia'];
			
			$data['ir_number']       = $row['ir_number'];

		}

		echo json_encode($data);
	}

	if($_POST['action'] == 'delete')
	{
		$query = "
		DELETE FROM victim 
		WHERE victim_id = '".$_POST["id"]."'
		";

		if($connect->query($query))
		{
			$output['success'] = '<div class="alert alert-success">Data Deleted</div>';

			echo json_encode($output);
		}
	}
}

?>

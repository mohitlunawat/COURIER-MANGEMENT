<?php
session_start();
?>
<!DOCTYPE HTML> 
<html>
<head>
	<style text="text/css">
	.error {color: #FF0000;}
	label{
		font-size: 20px;
		color: black;
	}
	</style>
</head>
<body bgcolor="">
	<?php include 'EMP-LOGIN.php';?>
<?php
$c_id = $o_id = $place_r = $appr_to = $complete = $rc_from = "";
$c_error = $o_error = $p_error = $a_error = $complete_error = $rc_error = "";
$c_id2 = $o_id2 = $place_r2 = $appr_to2 = $complete2 = $rc_from2 = "";
$service = $place_reached = $approachig_to = $recived_from = "";

$server = "localhost";
$username = "root";
$password = "";
$dbname = "project";
$conn = mysqli_connect($server,$username,$password,$dbname);

if (!$conn)
{
    die("Connection failed: " . mysqli_connect_error());
}
else
{
	
}



if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	if(isset($_POST['search']))
	{
			if (empty($_POST["ci"]))
			{
				$c_error = "Customer id is required";
			}
			else
			{
				$c_id  = test_input($_POST["ci"]);
				if(!preg_match("/^[C]{1}[0-9]{3}$/",$c_id ))
				{
					$c_error = "Type numbers Not in correct format!!!!";
				}
				else
				{
					$c_id2 = test_input($_POST["ci"]);
				}
			}
	
	
			if (empty($_POST["di"]))
			{
				$o_error = "Order Id id is required";
			}
			else
			{
				$o_id  = test_input($_POST["di"]);
				if(!preg_match("/^[T]{1}[S]{1}[0-9]{2}$/",$o_id ))
				{
					$o_error = "Type numbers Not in correct format!!!!";
				}
				else
				{
					$o_id2 = test_input($_POST["di"]);
				}
			}
			echo $o_id2;
			echo $c_id2;
			$sql="SELECT receive,current,next,complete FROM updatet WHERE customer_id='$c_id2' AND order_id='$o_id2'";
			$result=mysqli_query($conn,$sql);
			if (mysqli_num_rows($result) > 0)
			{
				// output data of each row
				while($row = mysqli_fetch_assoc($result))
				{
					$service = $row["complete"];
					$approachig_to = $row["next"];
					$place_reached = $row["current"];
					$recived_from = $row["receive"];
				}
			}
			else
			{
				echo "0 results";
			}
		
	}
	else
	{
		
		$c_id2 = test_input($_POST["ci"]);
		$o_id2 = test_input($_POST["di"]);
		if (empty($_POST["rc"]))
		{
			$rc_error = "Name is required";
		} 
		else
		{
			$rc_from = test_input($_POST["rc"]);
			if (!preg_match("/^[a-zA-Z ]*$/",$rc_from))	/* */
			{
				$rc_error = "Only letters and white space allowed";
			}
			else
			{
				$rc_from2 = test_input($_POST["rc"]);
			}
		}
			
		if (empty($_POST["pr"]))
		{
			$p_error = "Name is required";
		} 
		else
		{
			$place_r = test_input($_POST["pr"]);
			if (!preg_match("/^[a-zA-Z ]*$/",$place_r))	/* */
			{
				$p_error = "Only letters and white space allowed";
			}
			else
			{
				$place_r2 = test_input($_POST["pr"]);
			}
		}
		if (empty($_POST["at"]))
		{
			$a_error = "Name is required";
		} 
		else
		{
			$appr_to = test_input($_POST["at"]);
			if (!preg_match("/^[a-zA-Z ]*$/",$appr_to))	/* */
			{
				$a_error = "Only letters and white space allowed";
			}
			else
			{
				$appr_to2 = test_input($_POST["at"]);
			}
		}
		if (empty($_POST["sc"]))
		{
			$complete_error = "Name is required";
		} 
		else
		{
			$complete = test_input($_POST["sc"]);
			if (!preg_match("/^[a-zA-Z ]*$/",$complete))	/* */
			{
				$complete_error = "Only letters and white space allowed";
			}
			else
			{
				$complete2 = test_input($_POST["sc"]);
			}
		}
		echo $place_r2;
		echo $appr_to2;
		echo $complete2;
		$sql = "UPDATE updatet SET receive = '$rc_from2',current = '$place_r2',next = '$appr_to2',complete = '$complete2'
		WHERE customer_id = '$c_id2' AND order_id = '$o_id2'";
		if (mysqli_query($conn, $sql))
		{
			echo "Record updated successfully";
		}
		else
		{
			echo "Error updating record: " . mysqli_error($conn);
		}
			
	}
}	
function test_input($data)
{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
}
?>
<center>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
	<label>CUSTOMER_ID:- </label><input type="text" name="ci" value="<?php echo isset($_POST['ci']) ? $_POST['ci'] : '' ?>"/><span class="error">* <?php echo $c_error;?></br>
	<label>ORDER_ID:-</label><input type="text" name="di" value="<?php echo isset($_POST['di']) ? $_POST['di'] : '' ?>"/><span class="error">* <?php echo $o_error;?></br>
	<input type="submit" value="SEARCH" name="search"/></br>
	<label>RECIEVED FROM:-</label></td><td><input type="text" name="rc" value="<?php echo $recived_from ?>"/><span class="error">* </td><td><?php echo $rc_error;?></br>
	<label>PLACE-REACHED:-</label></td><td><input type="text" name="pr" value="<?php echo $place_reached ?>"/><span class="error">* </td><td><?php echo $p_error;?></br>
	<label>APPROACHING-TO:-</label></td><td><input type="text" name="at" value="<?php echo $approachig_to ?>"/><span class="error">* </td><td><?php echo $a_error;?></br>
	<label>SERIVCE COMPLETE:-</label></td><td><input type="text" name="sc" value="<?php echo $service ?>"/><span class="error">* </td><td><?php echo $complete_error?></br>
	<input type="submit" value="UPDATE" name="update"/>
</form>
</center>
</body>
</html>
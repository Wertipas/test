<!DOCTYPE html>
<html>
<head>
    <title>Latest Event</title>
</head>
<body>
    <h1>Latest Event from Database</h1>
<?php
 
	$hostname = "localhost"; 
	$username = "root"; 
	$password = ""; 
	$database = "sensor_db"; 

	$conn =file_get_contents('sensor_db.sql');

	if (!$conn) 
	{ 
		die("Connection failed!"); 
	} 

	echo "Database connection is OK"; 
	
	$rawData = file_get_contents('php://input');

    // Decode the JSON data
    $data = json_decode($rawData, true);

	if ($data !== null)
	{
		 
		$t = $data['temperature'];
		$h = $data['humidity'];

		$sql = "INSERT INTO dht11 (temperature, humidity) VALUES (".$t.", ".$h.")"; 

		if (mysqli_query($conn, $sql)) 
		{ 
			echo "\nNew record created successfully"; 
		}
		else{ 
			echo "Error: " . $sql . "<br>" . mysqli_error($conn); 
		}
	}
	
	$sql = "SELECT temperature, humidity, datetime FROM dht11 ORDER BY datetime DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>temperature</th><th>humidity</th><th>Datetime</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["temperature"] . "</td><td>" . $row["humidity"] . "</td><td>" . $row["datetime"] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No data found in the database.";
    }

    $conn->close();
    ?>
</body>
</html>
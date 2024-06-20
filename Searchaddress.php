<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carss";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$ID = isset($_POST['ID']) ? $_POST['ID'] : ''; 
if (empty($ID)) {
    // If $ID is empty, select all rows
    $sql = "SELECT * FROM address";
} else {
    $sql = "SELECT * FROM address where id='" . $ID . "'";
}
$result = $conn->query($sql);


echo "<table style='border-collapse: collapse; width: 100%; margin-top: 20px;'>";
echo "<tr style='background-color: #62516D; color: #ffffff; text-align: left;'>";
echo "<th style='padding: 15px; border-radius: 100px;'>Id</th><th style='padding: 15px; border-radius: 100px;'>Building</th><th style='padding: 15px; border-radius: 100px;'>Street</th><th style='padding: 15px; border-radius: 100px;'>City</th><th style='padding: 15px; border-radius: 100px;'>Country</th>";
echo "</tr>";

if ($result->num_rows > 0) {
    // output data of each row
    $rowCounter = 0;
    while($row = $result->fetch_assoc()) {
        $rowStyle = $rowCounter % 2 == 0 ? 'background-color: #f2f2f2;' : 'background-color: #ffffff;';
        echo "<tr style='$rowStyle'>";
        echo "<td style='padding: 10px;'>" . $row["id"]. "</td><td style='padding: 10px;'>" . $row["buidling"]. "</td><td style='padding: 10px;'>" . $row["street"]. "</td><td style='padding: 10px;'>" . $row["city"] ."</td> <td style='padding: 10px;'>" . $row["country"]. "</td>";
        echo "</tr>";
        $rowCounter++;
    }
    echo "</table>"; // Close the table tag here
} else {
    echo "<p style='color: #ff0000;'>0 results</p>";
}

$conn->close();
?>

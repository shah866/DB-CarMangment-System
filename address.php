<?php
session_start();

if (!isset($_SESSION['name'])) {
    // The user is not logged in, redirect to login page
    header('Location: login.html');
}
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carss";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_id"])) {
  $id = $_POST["update_id"];
  $buidling = $_POST["buidling"];
  $street= $_POST["street"];
  $city = $_POST["city"];
  $country = $_POST["country"];

  $updateSql = "UPDATE address SET id='$id',buidling='$buidling',street='$street',city='$city',country='$country' WHERE id='$id'";
  if ($conn->query($updateSql) === TRUE) {
      echo "<p style='color: #008000;'>updated successfully</p>";
  } else {
      echo "<p style='color: #ff0000;'>Error updating name: " . $conn->error . "</p>";
  }
}
if ($_SERVER["REQUEST_METHOD"] == "POST"  && isset($_POST["id"]) && isset($_POST["buidling"]) && isset($_POST["street"]) && isset($_POST["city"])&& isset($_POST["country"])) {
  $id = $_POST["id"];
  $buidling = $_POST["buidling"];
  $street= $_POST["street"];
  $city = $_POST["city"];
  $country = $_POST["country"];
  // Validate and sanitize input if needed
  $checkIdSql = "SELECT * FROM address WHERE id = '$id'";
    $checkIdResult = $conn->query($checkIdSql);

    if ($checkIdResult->num_rows > 0) {
        echo "<p style='color: #ff0000;'>Error: ID already exists</p>";
    }
    else {
  // Insert data into the "car" table
  $insertSql = "INSERT INTO address (id, buidling, street, city,country) VALUES ('$id', '$buidling', '$street', '$city','$country')";
  if ($conn->query($insertSql) === TRUE) {
      echo "<p style='color: #008000;'>New record created successfully</p>";
  } else {
      echo "<p style='color: #ff0000;'>Error: " . $conn->error . "</p>";
  }
}
}
$sqlid = "SELECT id FROM address";
$resultid = $conn->query($sqlid);

$sql = "SELECT * FROM address";
$result = $conn->query($sql);

echo "<h1 style='color: #62516D; text-align: center;'>The Address Table</h1>";

echo "<table style='border-collapse: collapse; width: 100%; margin-top: 20px;'>";
echo "<tr style='background-color: #62516D; color: #ffffff;'>";
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
<!DOCTYPE html>
<html>

<head>
    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        @media screen and (max-width: 900px) {
            table{
                width: 500px;
            
            }
            h1{
                font-size: 20px;
            }
            tr{
                font-size: 10px; 
            }
            h2{
                font-size: 18px;   
            }
          select{
           width:70px ;
            }
            input{
                width:90px ;
            }
        }
        @media screen and (max-width: 400px) {
            table{
                width: 300px;
            
            } 
        }

    </style>
</head>

<body>
    

    <form method="post" style="margin-top: 20px;">
        <h2 style="color: #62516D;">Insert New Address</h2>
        
        <label for="id" style="color: #62516D; font-weight: bold;"  >id:</label>
        <input type="number" name="id" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; width: 60px;">
        
        <label for="buidling" style="color: #62516D; font-weight: bold;">building:</label>
        <input type="number" name="buidling" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        
        <label for="street" style="color: #62516D; font-weight: bold;">Street:</label>
        <input type="text" name="street" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

        <label for="city" style="color: #62516D; font-weight: bold;">City:</label>
        <input type="text" name="city" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

        <label for="country" style="color: #62516D; font-weight: bold;">Country:</label>
        <input type="text" name="country" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        
        <input type="submit" value="Insert" style="margin: 10px;
            padding: 12.5px 30px;
            border: 0;
            border-radius: 100px;
            background-color: rgba(98, 81, 109, 0.8);
            color: #ffffff;
            font-weight: bold;">
    </form>

    <form method="post" style="margin-top: 20px;">
    <h2 style="color: #62516D;">Update On Address</h2>
    
    <label for="update_id" style="color: #62516D; font-weight: bold;"> id:</label>
    <select name="update_id" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        <?php
        
        while ($row = $resultid->fetch_assoc()) {
            echo "<option value='" . $row["id"] . "'>" . $row["id"] . "</option>";
        }
        ?>
    </select>

        <label for="buidling" style="color: #62516D; font-weight: bold;">building:</label>
        <input type="number" name="buidling" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        
        <label for="street" style="color: #62516D; font-weight: bold;">Street:</label>
        <input type="text" name="street" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

        <label for="city" style="color: #62516D; font-weight: bold;">City:</label>
        <input type="text" name="city" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

        <label for="country" style="color: #62516D; font-weight: bold;">Country:</label>
        <input type="text" name="country" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

    <input type="submit" value="Update" style="margin: 10px;
        padding: 12.5px 30px;
        border: 0;
        border-radius: 100px;
        background-color: rgba(98, 81, 109, 0.8);
        color: #ffffff;
        font-weight: bold;">
</form>

    <label for="id"  style="color: #62516D; font-weight: bold;">Address ID:</label>
    <input type="number" id="id" name="customerId" style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
    <button id="searchBtn" style="margin: 10px;
        padding: 12.5px 30px;
        border: 0;
        border-radius: 100px;
        background-color: rgba(98, 81, 109, 0.8);
        color: #ffffff;
        font-weight: bold;">Search</button>
    <div id="searchResult"></div>
    <script>
        $(document).ready(function () {
            $("#searchBtn").click(function () {
                // Use $.post to send an AJAX POST request
                $.post("Searchaddress.php", {
                    ID: $("#id").val()
                }, function (data, status) {
                    // Handle the response from the server
                    console.log("Data: " + data + "\nStatus: " + status);
                    $("#searchResult").html(data);
                });
            });
        });
    </script>

</body>

</html>

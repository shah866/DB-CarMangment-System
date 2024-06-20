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
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_name"])) {
    $name = $_POST["update_name"];
    $type = $_POST["type"];
    $city = $_POST["city"];
    $country = $_POST["country"];

  // Validate and sanitize input if needed

  // Update only the "name" field in the "car" table
  $updateSql = "UPDATE manufacture SET name='$name',type='$type',city='$city',country='$country ' WHERE name='$name'";
  if ($conn->query($updateSql) === TRUE) {
      echo "<p style='color: #008000;'>updated successfully</p>";
  } else {
      echo "<p style='color: #ff0000;'>Error updating name: " . $conn->error . "</p>";
  }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["name"]) && isset($_POST["type"]) && isset($_POST["city"]) && isset($_POST["country"])) {
    $name = $_POST["name"];
    $type = $_POST["type"];
    $city = $_POST["city"];
    $country = $_POST["country"];

    // Check if the name already exists in the table
    $checkNameSql = "SELECT * FROM manufacture WHERE name = '$name'";
    $checkNameResult = $conn->query($checkNameSql);

    if ($checkNameResult->num_rows > 0) {
        echo "<p style='color: #ff0000;'>Error: Name already exists</p>";
    } else {
        // Insert data into the "manufacture" table
        $insertSql = "INSERT INTO manufacture (name, type, city, country) VALUES ('$name', '$type', '$city', '$country')";
        if ($conn->query($insertSql) === TRUE) {
            echo "<p style='color: #008000;'>New record created successfully</p>";
        } else {
            echo "<p style='color: #ff0000;'>Error: " . $conn->error . "</p>";
        }
    }
}

$sqlid = "SELECT name FROM manufacture";
$resultid = $conn->query($sqlid);

$sql = "SELECT * FROM manufacture";
$result = $conn->query($sql);

echo "<h1 style='color: #62516D; text-align: center;'>The Manufacture Table</h1>";

echo "<table style='border-collapse: collapse; width: 100%; margin-top: 20px;'>";
echo "<tr style='background-color: #62516D; color: #ffffff;'>";
echo "<th style='padding: 15px; border-radius: 100px;'>Name</th><th style='padding: 15px; border-radius: 100px;'>Type</th><th style='padding: 15px; border-radius: 100px;'>City</th><th style='padding: 15px; border-radius: 100px;'>Country</th>";
echo "</tr>";

if ($result->num_rows > 0) {
  // output data of each row
  $rowCounter = 0;
  while($row = $result->fetch_assoc()) {
    $rowStyle = $rowCounter % 2 == 0 ? 'background-color: #f2f2f2;' : 'background-color: #ffffff;';
    echo "<tr style='$rowStyle'>";
    echo "<td style='padding: 10px;'>" . $row["name"]. "</td><td style='padding: 10px;'>" . $row["type"]. "</td><td style='padding: 10px;'>" . $row["city"]. "</td><td style='padding: 10px;'>" . $row["country"] ."</td>";
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
        <h2 style="color: #62516D;">Insert New Manufacture</h2>
        
        
        
        <label for="name" style="color: #62516D; font-weight: bold;">Name:</label>
        <input type="text" name="name" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        
        <label for="type" style="color: #62516D; font-weight: bold;">type:</label>
        <input type="text" name="type" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

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
    <h2 style="color: #62516D;">Update on Manufacture</h2>

    <label for="update_name" style="color: #62516D; font-weight: bold;">Name:</label>
    <select name="update_name" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            <?php
            // Populate the dropdown with existing addresses
            while ($row = $resultid->fetch_assoc()) {
                echo "<option value='" . $row["name"] . "'>" . $row["name"] . "</option>";
            }
            ?>
        </select>
        
        
        <label for="type" style="color: #62516D; font-weight: bold;">type:</label>
        <input type="text" name="type" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

        <label for="city" style="color: #62516D; font-weight: bold;">City:</label>
        <input type="text" name="city" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

        <label for="country" style="color: #62516D; font-weight: bold;">Country:</label>
        <input type="text" name="country" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        
    
    
    <input type="submit" value="Update " style="margin: 10px;
        padding: 12.5px 30px;
        border: 0;
        border-radius: 100px;
        background-color: rgba(98, 81, 109, 0.8);
        color: #ffffff;
        font-weight: bold;">
</form>

    <label for="name"  style="color: #62516D; font-weight: bold;"> Name :</label>
    <input type="text" id="name" name="customerId" style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
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
                $.post("Searchmanu.php", {
                    name: $("#name").val()
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

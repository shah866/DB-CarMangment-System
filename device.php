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
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_no"])) {
  $oldName = $_POST["update_no"];
  $name = $_POST["name"];
  $price = $_POST["price"];
  $weight = $_POST["weight"];
  $made = $_POST["made"];

  // Validate and sanitize input if needed

  // Update only the "name" field in the "car" table
  $updateSql = "UPDATE device SET no='$oldName', name='$name',price='$price',weight='$weight',made='$made' WHERE no='$oldName'";
  if ($conn->query($updateSql) === TRUE) {
      echo "<p style='color: #008000;'> updated successfully</p>";
  } else {
      echo "<p style='color: #ff0000;'>Error updating name: " . $conn->error . "</p>";
  }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["no"]) && isset($_POST["name"]) && isset($_POST["price"]) && isset($_POST["weight"]) && isset($_POST["made"])) {
    $no = $_POST["no"];
    $name = $_POST["name"];
    $price = $_POST["price"];
    $weight = $_POST["weight"];
    $made = $_POST["made"];

    // Check if the no already exists in the table
    $checkNoSql = "SELECT * FROM device WHERE no = '$no'";
    $checkNoResult = $conn->query($checkNoSql);

    if ($checkNoResult->num_rows > 0) {
        echo "<p style='color: #ff0000;'>Error: Number (Number) already exists</p>";
    } else {
        // Insert data into the "device" table
        $insertSql = "INSERT INTO device (no, name, price, weight, made) VALUES ('$no', '$name', '$price', '$weight', '$made')";
        if ($conn->query($insertSql) === TRUE) {
            echo "<p style='color: #008000;'>New record created successfully</p>";
        } else {
            echo "<p style='color: #ff0000;'>Error: " . $conn->error . "</p>";
        }
    }
}

$sqlAddresses = "SELECT * FROM manufacture";
$resultAddresses = $conn->query($sqlAddresses);

$sqlAddressess = "SELECT * FROM manufacture";
$resultAddressess = $conn->query($sqlAddressess);

$sqlid = "SELECT no FROM device";
$resultid = $conn->query($sqlid);

$sql = "SELECT * FROM device";
$result = $conn->query($sql);

echo "<h1 style='color: #62516D; text-align: center;'>The Device Table</h1>";

echo "<table style='border-collapse: collapse; width: 100%; margin-top: 20px;'>";
echo "<tr style='background-color: #62516D; color: #ffffff; text-align: left;'>";
echo "<th style='padding: 15px; border-radius: 100px;'>No</th><th style='padding: 15px;border-radius: 100px;'>Name</th><th style='padding: 15px;border-radius: 100px;'>Price</th><th style='padding: 15px;border-radius: 100px;'>Weight</th><th style='padding: 15px;border-radius: 100px;'>Made</th>";
echo "</tr>";

if ($result->num_rows > 0) {
    // output data of each row
    $rowCounter = 0;
    while ($row = $result->fetch_assoc()) {
        $rowStyle = $rowCounter % 2 == 0 ? 'background-color: #f2f2f2;' : 'background-color: #ffffff;';
        echo "<tr style='$rowStyle'>";
        echo "<td style='padding: 10px;'>" . $row["no"] . "</td><td style='padding: 10px;'>" . $row["name"] . "</td><td style='padding: 10px;'>" . $row["price"] . "</td><td style='padding: 10px;'>" . $row["weight"] . "</td><td style='padding: 10px;'>" . $row["made"] . "</td>";
        echo "</tr>";
        $rowCounter++;
    }
    echo "</table>";
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
        <h2 style="color: #62516D;">Insert New device</h2>
        
        <label for="no" style="color: #62516D; font-weight: bold;"  >no:</label>
        <input type="number" name="no" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; width: 60px;">
        
        <label for="name" style="color: #62516D; font-weight: bold;"> Name:</label>
        <input type="text" name="name" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        
        <label for="price" style="color: #62516D; font-weight: bold;">Price:</label>
        <input type="text" name="price" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

        <label for="weight" style="color: #62516D; font-weight: bold;">Weight:</label>
        <input type="text" name="weight" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
       

        <label for="made" style="color: #62516D; font-weight: bold;">Made :</label>
        <select name="made" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            <?php
            // Populate the dropdown with existing addresses
            while ($row = $resultAddresses->fetch_assoc()) {
                echo "<option value='" . $row["name"] . "'>" . $row["name"] . "</option>";
            }
            ?>
        </select>

   
        
        <input type="submit" value="Insert" style="margin: 10px;
            padding: 12.5px 30px;
            border: 0;
            border-radius: 100px;
            background-color: rgba(98, 81, 109, 0.8);
            color: #ffffff;
            font-weight: bold;">
    </form>

    <form method="post" style="margin-top: 20px;">
    <h2 style="color: #62516D;">Update On device </h2>

    <label for="update_no" style="color: #62516D; font-weight: bold;"  >no:</label>
         <select name="update_no" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            <?php
            // Populate the dropdown with existing addresses
            while ($row = $resultid->fetch_assoc()) {
                echo "<option value='" . $row["no"] . "'>" . $row["no"] . "</option>";
            }
            ?>
        </select>
        
        <label for="name" style="color: #62516D; font-weight: bold;"> Name:</label>
        <input type="text" name="name" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        
        <label for="price" style="color: #62516D; font-weight: bold;">Price:</label>
        <input type="text" name="price" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

        <label for="weight" style="color: #62516D; font-weight: bold;">Weight:</label>
        <input type="text" name="weight" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
       

        <label for="made" style="color: #62516D; font-weight: bold;">Made :</label>
        <select name="made" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            <?php
            // Populate the dropdown with existing addresses
            while ($row = $resultAddressess->fetch_assoc()) {
                echo "<option value='" . $row["name"] . "'>" . $row["name"] . "</option>";
            }
            ?>
        </select>
    
    

    <input type="submit" value="Update" style="margin: 10px;
        padding: 12.5px 30px;
        border: 0;
        border-radius: 100px;
        background-color: rgba(98, 81, 109, 0.8);
        color: #ffffff;
        font-weight: bold;">
</form>

    <label for="device number"  style="color: #62516D; font-weight: bold;">device number:</label>
    <input type="number" id="deviceNo" name="deviceNo" style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
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
                $.post("Searchdevice.php", {
                    NO: $("#deviceNo").val()
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

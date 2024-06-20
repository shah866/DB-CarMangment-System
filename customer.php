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
  $f_name = $_POST["f_name"];
    $l_name = $_POST["l_name"];
    $address = $_POST["address"];
    $job = $_POST["job"];

  // Validate and sanitize input if needed

  // Update only the "name" field in the "car" table
  $updateSql = "UPDATE customer SET id='$id',f_name=' $f_name',l_name='$l_name',address='$address', job=' $job' WHERE id='$id'";
  if ($conn->query($updateSql) === TRUE) {
      echo "<p style='color: #008000;'>updated successfully</p>";
  } else {
      echo "<p style='color: #ff0000;'>Error updating name: " . $conn->error . "</p>";
  }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"]) && isset($_POST["f_name"]) && isset($_POST["l_name"]) && isset($_POST["address"]) && isset($_POST["job"])) {
    $id = $_POST["id"];
    $f_name = $_POST["f_name"];
    $l_name = $_POST["l_name"];
    $address = $_POST["address"];
    $job = $_POST["job"];

    // Check if the id already exists in the table
    $checkIdSql = "SELECT * FROM customer WHERE id = '$id'";
    $checkIdResult = $conn->query($checkIdSql);

    if ($checkIdResult->num_rows > 0) {
        echo "<p style='color: #ff0000;'>Error: ID already exists</p>";
    } else {
        // Insert data into the "customer" table
        $insertSql = "INSERT INTO customer (id, f_name, l_name, address, job) VALUES ('$id', '$f_name', '$l_name', '$address', '$job')";
        if ($conn->query($insertSql) === TRUE) {
            echo "<p style='color: #008000;'>New record created successfully</p>";
        } else {
            echo "<p style='color: #ff0000;'>Error: " . $conn->error . "</p>";
        }
    }
}

$sqlid = "SELECT id FROM customer";
$resultid = $conn->query($sqlid);
// Fetch addresses for the dropdown
$sqlAddresses = "SELECT * FROM address";
$resultAddresses = $conn->query($sqlAddresses);

$sqlAddressess = "SELECT * FROM address";
$resultAddressess = $conn->query($sqlAddressess);
// Fetch customers for the table
$sql = "SELECT * FROM customer";
$result = $conn->query($sql);

echo "<h1 style='color: #62516D; text-align: center;'>The Customer Table</h1>";

echo "<table style='border-collapse: collapse; width: 100%; margin-top: 20px;'>";
echo "<tr style='background-color: #62516D; color: #ffffff; text-align: left;'>";
echo "<th style='padding: 15px; border-radius: 100px;'>Id</th><th style='padding: 15px;border-radius: 100px;'>F_name</th><th style='padding: 15px;border-radius: 100px;'>L_name</th><th style='padding: 15px;border-radius: 100px;'>Address</th><th style='padding: 15px;border-radius: 100px;'>Job</th>";
echo "</tr>";

if ($result->num_rows > 0) {
    // output data of each row
    $rowCounter = 0;
    while ($row = $result->fetch_assoc()) {
        $rowStyle = $rowCounter % 2 == 0 ? 'background-color: #f2f2f2;' : 'background-color: #ffffff;';
        echo "<tr style='$rowStyle'>";
        echo "<td style='padding: 10px;'>" . $row["id"] . "</td><td style='padding: 10px;'>" . $row["f_name"] . "</td><td style='padding: 10px;'>" . $row["l_name"] . "</td><td style='padding: 10px;'>" . $row["address"] . "</td><td style='padding: 10px;'>" . $row["job"] . "</td>";
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
        <h2 style="color: #62516D;">Insert New Customer</h2>
        
        <label for="id" style="color: #62516D; font-weight: bold;"  >id:</label>
        <input type="number" name="id" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; width: 60px;">
        
        <label for="f_name" style="color: #62516D; font-weight: bold;">First Name:</label>
        <input type="text" name="f_name" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        
        <label for="l_name" style="color: #62516D; font-weight: bold;">Last Name:</label>
        <input type="text" name="l_name" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

        <label for="address" style="color: #62516D; font-weight: bold;">Address:</label>
        <select name="address" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            <?php
            // Populate the dropdown with existing addresses
            while ($row = $resultAddresses->fetch_assoc()) {
                echo "<option value='" . $row["id"] . "'>" . $row["id"] . "</option>";
            }
            ?>
        </select>

        <label for="job" style="color: #62516D; font-weight: bold;">Job:</label>
        <input type="text" name="job" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        
        <input type="submit" value="Insert" style="margin: 10px;
            padding: 12.5px 30px;
            border: 0;
            border-radius: 100px;
            background-color: rgba(98, 81, 109, 0.8);
            color: #ffffff;
            font-weight: bold;">
    </form>

    <form method="post" style="margin-top: 20px;">
    <h2 style="color: #62516D;">Update On customer </h2>

    <label for="update_id" style="color: #62516D; font-weight: bold;"  >id:</label>
    <select name="update_id" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            <?php
            // Populate the dropdown with existing addresses
            while ($row = $resultid->fetch_assoc()) {
                echo "<option value='" . $row["id"] . "'>" . $row["id"] . "</option>";
            }
            ?>
        </select>
        
        <label for="f_name" style="color: #62516D; font-weight: bold;"> First Name:</label>
        <input type="text" name="f_name" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        
        <label for="l_name" style="color: #62516D; font-weight: bold;">Last Name:</label>
        <input type="text" name="l_name" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

        <label for="address" style="color: #62516D; font-weight: bold;">Address:</label>
        <select name="address" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            <?php
            // Populate the dropdown with existing addresses
            while ($row = $resultAddressess->fetch_assoc()) {
                echo "<option value='" . $row["id"] . "'>" . $row["id"] . "</option>";
            }
            ?>
        </select>

        <label for="job" style="color: #62516D; font-weight: bold;">Job:</label>
        <input type="text" name="job" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
    
    

    <input type="submit" value="Update" style="margin: 10px;
        padding: 12.5px 30px;
        border: 0;
        border-radius: 100px;
        background-color: rgba(98, 81, 109, 0.8);
        color: #ffffff;
        font-weight: bold;">
</form>

    <label for="customerId"  style="color: #62516D; font-weight: bold;">Customer ID:</label>
    <input type="number" id="customerId" name="customerId" style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
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
                $.post("searchcustomer.php", {
                    ID: $("#customerId").val()
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

<?php

session_start();

if (!isset($_SESSION['name'])) {
    // The user is not logged in, redirect to login page
    header('Location: login.html');
    exit;
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

// Handle form submission for name update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_name"])) {
    $oldName = $_POST["update_name"];
    $model = $_POST["model"];
    $year = $_POST["year"];
    $made = $_POST["made"];

    // Validate and sanitize input if needed

    // Update only the "name" field in the "car" table
    $updateSql = "UPDATE car SET name='$oldName', model='$model', year='$year', made='$made' WHERE name='$oldName'";
    if ($conn->query($updateSql) === TRUE) {
        echo "<p style='color: #008000;'> updated successfully</p>";
    } else {
        echo "<p style='color: #ff0000;'>Error updating name: " . $conn->error . "</p>";
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["name"]) && isset($_POST["model"]) && isset($_POST["year"]) && isset($_POST["made"])) {
    $name = $_POST["name"];
    $model = $_POST["model"];
    $year = $_POST["year"];
    $made = $_POST["made"];

    // Check if the name already exists in the table
    $checkNameSql = "SELECT * FROM car WHERE name = '$name'";
    $checkNameResult = $conn->query($checkNameSql);

    if ($checkNameResult->num_rows > 0) {
        echo "<p style='color: #ff0000;'>Error: Name already exists</p>";
    } else {
        // Insert data into the "car" table
        $insertSql = "INSERT INTO car (name, model, year, made) VALUES ('$name', '$model', '$year', '$made')";
        if ($conn->query($insertSql) === TRUE) {
            echo "<p style='color: #008000;'>New record created successfully</p>";
        } else {
            echo "<p style='color: #ff0000;'>Error: " . $conn->error . "</p>";
        }
    }
}


// Fetch existing car names for the combo box
$sqlNames = "SELECT name FROM car";
$resultNames = $conn->query($sqlNames);

$sql = "SELECT * FROM car";
$result = $conn->query($sql);

echo "<h1 style='color: #62516D; text-align: center;'>The Cars Table</h1>";

echo "<table style='border-collapse: collapse;  margin-top: 20px; width: 100%;'>";
echo "<tr style='background-color: #62516D; color: #ffffff; '>";
echo "<th style='padding: 15px; border-radius: 100px;'>Name</th><th style='padding: 15px;border-radius: 100px;'>Model</th><th style='padding: 15px;border-radius: 100px;'>Year</th><th style='padding: 15px;border-radius: 100px;'>Made</th>";
echo "</tr>";

if ($result->num_rows > 0) {
    // output data of each row
    $rowCounter = 0;
    while ($row = $result->fetch_assoc()) {
        $rowStyle = $rowCounter % 2 == 0 ? 'background-color: #f2f2f2;' : 'background-color: #ffffff;';
        echo "<tr style='$rowStyle'>";
        echo "<td style='padding: 10px;text-align: center;'>" . $row["name"] . "</td><td style='padding: 10px; text-align: center;'>" . $row["model"] . "</td><td style='padding: 10px;text-align: center;'>" . $row["year"] . "</td><td style='padding: 10px;text-align: center;'>" . $row["made"] . "</td>";
        echo "</tr>";
        $rowCounter++;
    }
    echo "</table>";
} else {
    echo "<p style='color: #ff0000;'>0 results</p>";
}

?>

<!-- Insert form with styled labels and text fields -->
<form method="post" style="margin-top: 20px;">
    <h2 style="color: #62516D;">Insert New Car</h2>
    <label for="name" style="color: #62516D; font-weight: bold;">Name:</label>
    <input type="text" name="name" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
    
    <label for="model" style="color: #62516D; font-weight: bold;">Model:</label>
    <input type="text" name="model" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
    
    <label for="year" style="color: #62516D; font-weight: bold;">Year:</label>
    <input type="text" name="year" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
    <label for="made" style="color: #62516D; font-weight: bold;">Made :</label>
    <select name="made" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        <?php
        $sqlNamess = "SELECT name FROM manufacture";
        $resultNamess = $conn->query($sqlNamess);
        // Populate the combo box with existing car names
        while ($row = $resultNamess->fetch_assoc()) {
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

<!-- Update form for name only with combo box -->
<form method="post" style="margin-top: 20px;">
    <h2 style="color: #62516D;">Update On Car </h2>

    <label for="update_name" style="color: #62516D; font-weight: bold;">Name:</label>
    <select name="update_name" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        <?php
        
        // Populate the combo box with existing car names
        while ($row = $resultNames->fetch_assoc()) {
            echo "<option value='" . $row["name"] . "'>" . $row["name"] . "</option>";
        }
        ?>
    </select>
    
    <label for="model" style="color: #62516D; font-weight: bold;">Model:</label>
    <input type="text" name="model" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
    
    <label for="year" style="color: #62516D; font-weight: bold;">Year:</label>
    <input type="text" name="year" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
    <label for="made" style="color: #62516D; font-weight: bold;">Made :</label>
    <select name="made" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        <?php
        $sqlNamess = "SELECT name FROM manufacture";
        $resultNamess = $conn->query($sqlNamess);
        // Populate the combo box with existing car names
        while ($row = $resultNamess->fetch_assoc()) {
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
    

    <label for="carName"  style="color: #62516D; font-weight: bold;">Car Name:</label>
    <input type="text" id="carName" name="carName" style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
    <button id="b" style="margin: 10px;
        padding: 12.5px 30px;
        border: 0;
        border-radius: 100px;
        background-color: rgba(98, 81, 109, 0.8);
        color: #ffffff;
        font-weight: bold;">Search</button>
    <div id="result"></div>
    <script>
        $(document).ready(function () {
            $("#b").click(function () {
                // Use $.post to send an AJAX POST request
                $.post("Searchcar.php", {
                    carName: $("#carName").val()
                }, function (data, status) {
                    // Handle the response from the server
                    console.log("Data: " + data + "\nStatus: " + status);
                    $("#result").html(data);
                });
            });
        });
    </script>

</body>

</html>

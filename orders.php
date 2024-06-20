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
  $date = $_POST["date"];
  $customer = $_POST["customer"];
  $car = $_POST["car"];

  
  $updateSql = "UPDATE orders SET id='$id', date='$date',customer='$customer ',car='$car' WHERE id='$id'";
  if ($conn->query($updateSql) === TRUE) {
      echo "<p style='color: #008000;'>updated successfully</p>";
  } else {
      echo "<p style='color: #ff0000;'>Error updating name: " . $conn->error . "</p>";
  }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"]) && isset($_POST["date"]) && isset($_POST["customer"]) && isset($_POST["car"])) {
  $id = $_POST["id"];
  $date = $_POST["date"];
  $customer = $_POST["customer"];
  $car = $_POST["car"];

  // Check if the id already exists in the table
  $checkIdSql = "SELECT * FROM orders WHERE id = '$id'";
  $checkIdResult = $conn->query($checkIdSql);

  if ($checkIdResult->num_rows > 0) {
      echo "<p style='color: #ff0000;'>Error: Id already exists</p>";
  } else {
      // Insert data into the "orders" table
      $insertSql = "INSERT INTO orders (id, date, customer, car) VALUES ('$id', '$date', '$customer', '$car')";
      if ($conn->query($insertSql) === TRUE) {
          echo "<p style='color: #008000;'>New record created successfully</p>";
      } else {
          echo "<p style='color: #ff0000;'>Error: " . $conn->error . "</p>";
      }
  }
}


$sqlid = "SELECT id FROM orders";
$resultid = $conn->query($sqlid);
// Fetch cares for the dropdown
$sqlcustomer = "SELECT * FROM customer";
$resultcustomer = $conn->query($sqlcustomer);

$sqlcustomerr = "SELECT * FROM customer";
$resultcustomerr = $conn->query($sqlcustomerr);

$sqlcar = "SELECT * FROM car";
$resultcar = $conn->query($sqlcar);

$sqlcarr = "SELECT * FROM car";
$resultcarr = $conn->query($sqlcarr);

$sql = "SELECT * FROM orders";
$result = $conn->query($sql);

echo "<h1 style='color: #62516D; text-align: center;'>The Orders Table</h1>";

echo "<table style='border-collapse: collapse; width: 100%; margin-top: 20px;'>";
echo "<tr style='background-color: #62516D; color: #ffffff;'>";
echo "<th style='padding: 15px; border-radius: 100px;'>Id</th><th style='padding: 15px; border-radius: 100px;'>Date</th><th style='padding: 15px; border-radius: 100px;'>Customer</th><th style='padding: 15px; border-radius: 100px;'>Car</th>";
echo "</tr>";

if ($result->num_rows > 0) {
  // output data of each row
  $rowCounter = 0;
  while($row = $result->fetch_assoc()) {
    $rowStyle = $rowCounter % 2 == 0 ? 'background-color: #f2f2f2;' : 'background-color: #ffffff;';
    echo "<tr style='$rowStyle'>";
    echo "<td style='padding: 10px;'>" . $row["id"]. "</td><td style='padding: 10px;'>" . $row["date"]. "</td><td style='padding: 10px;'>" . $row["customer"]. "</td><td style='padding: 10px;'>" . $row["car"] ."</td>";
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
        <h2 style="color: #62516D;">Insert New Order</h2>
        
        <label for="id" style="color: #62516D; font-weight: bold;"  >id:</label>
        <input type="number" name="id" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; width: 60px;">
        
        <label for="date" style="color: #62516D; font-weight: bold;">date:</label>
        <input type="date" name="date" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        
       

        <label for="customer" style="color: #62516D; font-weight: bold;"> Customer:</label>
        <select name="customer" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            <?php
            // Populate the dropdown with existing cares
            while ($row = $resultcustomer->fetch_assoc()) {
                echo "<option value='" . $row["id"] . "'>" . $row["id"] . "</option>";
            }
            ?>
        </select>

        <label for="car" style="color: #62516D; font-weight: bold;">Car:</label>
        <select name="car" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            <?php
            // Populate the dropdown with existing cares
            while ($row = $resultcar->fetch_assoc()) {
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
    <h2 style="color: #62516D;">Update  on order </h2>
    <label for="update_id" style="color: #62516D; font-weight: bold;"  >id:</label>
    <select name="update_id" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            <?php
            // Populate the dropdown with existing cares
            while ($row = $resultid->fetch_assoc()) {
                echo "<option value='" . $row["id"] . "'>" . $row["id"] . "</option>";
            }
            ?>
        </select>
        
        <label for="date" style="color: #62516D; font-weight: bold;">date:</label>
        <input type="date" name="date" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        
       

        <label for="customer" style="color: #62516D; font-weight: bold;"> Customer:</label>
        <select name="customer" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            <?php
            // Populate the dropdown with existing cares
            while ($row = $resultcustomerr->fetch_assoc()) {
                echo "<option value='" . $row["id"] . "'>" . $row["id"] . "</option>";
            }
            ?>
        </select>

        <label for="car" style="color: #62516D; font-weight: bold;">Car:</label>
        <select name="car" required style="margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            <?php
            // Populate the dropdown with existing cares
            while ($row = $resultcarr->fetch_assoc()) {
                echo "<option value='" . $row["name"] . "'>" . $row["name"] . "</option>";
            }
            ?>
        </select>
    
   

    <input type="submit" value="Update " style="margin: 10px;
        padding: 12.5px 30px;
        border: 0;
        border-radius: 100px;
        background-color: rgba(98, 81, 109, 0.8);
        color: #ffffff;
        font-weight: bold;">
</form>

    <label for="id"  style="color: #62516D; font-weight: bold;"> order ID:</label>
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
                $.post("searchorders.php", {
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

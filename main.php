<?php
session_start();
if(isset($_SESSION['name'])){
    // The user is already logged in, display the HTML content
?>
<!DOCTYPE html>
<html>

<head>
       <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;700&display=swap">

    <title>lab 10</title>
    <style>
        body {
            font-family: 'Ubuntu', sans-serif;
            margin: 0;
            padding: 0;
        }

        #header-container {
            position: relative;
            background-color: rgba(98, 81, 109, 0.8);
            padding: 100px;
            text-align: left;
            height: 150px;
        }

        #header-container h5,
        #header-container h1 {
            margin: 0;
            color: #ffffff;
        }

        #header-container h5 {
            font-size: 18px;
        }

        #header-container h1 {
            margin: 10px 0;
            font-size: 32px;
            font-weight: bold;
        }

        .grid-container {
            display: grid;
            grid-template-columns: auto auto auto auto;
           
            gap: 20px;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        .card-button {
            width: 200px;
            margin: 10px;
            padding: 20px;
            border: 2px solid rgba(255, 255, 255, 0.8);
            border-radius: 15px;
            background-color: rgba(98, 81, 109, 0.8);
            color: #ffffff;
            font-weight: bold;
            transition: all 0.5s;
            -webkit-transition: all 0.5s;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .card-button:hover {
            background-color: rgba(178, 157, 192, 0.8);
            box-shadow: 0 0 20px #db97f050;
            transform: scale(1.1);
        }

        .card-button:active {
            background-color: rgba(134, 90, 161, 0.8);
            transition: all 0.25s;
            -webkit-transition: all 0.25s;
            box-shadow: none;
            transform: scale(0.98);
        }

        .card-button i {
            margin-bottom: 10px;
            font-size: 24px;
        }

        .card-button span {
            font-size: 18px;
        }
        #logout-link {
            position: absolute;
            top: 10px;
            right: 20px;
            color: #ffffff;
            text-decoration: none;
            font-size: 18px;
            border: 2px solid #ffffff;
            padding: 5px 10px;
            border-radius: 8px;
            transition: all 0.3s;
        }

        #logout-link:hover {
            background-color: #ffffff;
            color: #000000;
        }
        @media screen and (max-width: 900px) {
            .grid-container{
                grid-template-columns: auto auto  ;
            }
            #header-container{
                height: 70px;
            }
            #header-container  h1{
                font-size: 20px;
            }
            #header-container  h5{
                font-size: 8px;
            }
            #logout-link{
                font-size: 12px;
            }
            .card-button{
                width:150px;
            }

        }
        @media screen and (max-width: 400px) {
            .grid-container{
                grid-template-columns:  auto  ;
            }
        }
        @media screen and (max-width: 395px) {
            .grid-container{
                grid-template-columns:  auto  ;
            }
            #header-container  h1{
                font-size: 10px;
            }
            #header-container  h5{
                font-size: 5px;
            }
        }

    </style>
</head>

<body>
    <div id="header-container">
        <a id="logout-link" href="logout.php"> log out</a>
        <br>
        <h5>Welcome</h5>
        <h1>Here are the tables in the cars database</h1>
        <h5>This project is to show you how we can change on SQL tables and show them using PHP</h5>
        <br>
        <h5>Made By Shahd Qattoush</h5>
    </div>

    <div class="grid-container">
        <button class="card-button" onclick="redirectTo('car.php')"><i class="fas fa-car"></i><span> Car</span></button>
        <button class="card-button" onclick="redirectTo('address.php')"><i class="fas fa-map-marker-alt"></i><span> Address</span></button>
        <button class="card-button" onclick="redirectTo('car_part.php')"><i class="fas fa-cogs"></i><span> Car Part</span></button>
        <button class="card-button" onclick="redirectTo('orders.php')"><i class="fas fa-shopping-cart"></i><span> Orders</span></button>
        <button class="card-button" onclick="redirectTo('device.php')"><i class="fas fa-mobile-alt"></i><span> Device</span></button>
        <button class="card-button" onclick="redirectTo('manufacture.php')"><i class="fas fa-industry"></i><span> Manufacture</span></button>
        <button class="card-button" onclick="redirectTo('customer.php')"><i class="fas fa-user"></i><span> Customer</span></button>
    </div>

    <script>
        function redirectTo(url) {
            window.location.href = url;
        }
    </script>
</body>

</html>
<?php
} else {
    // The user is not logged in, redirect to login page
    header('Location: login.html');
}
?>

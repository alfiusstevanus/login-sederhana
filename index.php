<?php
session_start();
include('server/connection.php');

$sql = "Select * from users";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
} else {
    echo "Tidak ada hasil";
}

if (!isset($_SESSION['logged_in'])) {
    header('location: login.php');
    exit;
}

if (isset($_GET['logout'])) {
    if (isset($_SESSION['logged_in'])) {
        unset($_SESSION['logged_in']);
        unset($_SESSION['user_email']);
        header('location: login.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome, <?php echo $row['user_name']; ?> </title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <style>
        li {
            margin: 0;
            padding: 0 0 0 20px;
            text-indent: -20px;
            list-style-type: none;
        }

        /* aa */
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #90A17D;
            margin: 0 auto;
            width: 50%;
        }

        a {
            color: black;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div style=" border:4px solid black ; margin: 0 auto; width: 50%; width: 300px; height: 450px; background-color: #E5EBB2;text-align: center;">
        <span>
            <br>
            <p> Selamat Datang, <?php echo $row['user_name']; ?> !</p>
            <h3>Your Profile</h3>
            <img style="width: 100px;" src="<?php echo $row['user_photo']; ?>" alt="error!">
            <br>
            <br>
            <li>User ID : <?php echo $row['user_id']; ?></li>
            <li>Name : <?php echo $row['user_name']; ?></li>
            <li>Email : <?php echo $row['user_email']; ?></li>
            <li>Phone : <?php echo $row['user_phone']; ?></li>
            <li>Address : <?php echo $row['user_address']; ?></li>
            <li>City : <?php echo $row['user_city']; ?></li>
            <br>
            <button><a href="index.php?logout=3" id="logout-btn"> LOG OUT</a></button>
        </span>

    </div>

</body>

</html>
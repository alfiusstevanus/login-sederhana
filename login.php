<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        li {
            margin: 0;
            padding: 0 0 0 20px;
            text-indent: -20px;
            list-style-type: none;
        }

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
    <?php
    session_start();
    include('server/connection.php');
    if (isset($_SESSION['logged_in'])) {
        header('location: index.php');
        exit;
    }
    if (isset($_POST['login_btn'])) {

        $email = $_POST['user_email'];
        $password = ($_POST['user_password']);

        $query = "SELECT user_id, user_name, user_email, user_password, user_phone,
    user_address, user_city, user_photo FROM users
    WHERE user_email = ? AND user_password = ? LIMIT 1";

        $stmt_login = $conn->prepare($query);
        $stmt_login->bind_param('ss', $email, $password);


        if ($stmt_login->execute()) {

            $stmt_login->bind_result(
                $user_id,
                $user_name,
                $user_email,
                $user_password,
                $user_phone,
                $user_address,
                $user_city,
                $user_photo
            );
            $stmt_login->store_result();

            if ($stmt_login->num_rows() == 1) {

                $stmt_login->fetch();

                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_name'] = $user_name;
                $_SESSION['user_email'] = $user_email;
                $_SESSION['user_phone'] = $user_phone;
                $_SESSION['user_address'] = $user_address;
                $_SESSION['user_city'] = $user_city;
                $_SESSION['user_photo'] = $user_photo;
                $_SESSION['logged_in'] = true;

                header('location: index.php?message=Logged in succesfully');
            } else {
                header('location: login.php?error=Could not verify your account');
            }
        } else {
            //error
            header('location: login.php?error=Something went wrong!');
        }
    }
    ?>
    <section>
        <div style=" border:4px solid black ; margin: 0 auto; width: 50%; width: 300px; height: 450px; background-color: #E5EBB2;text-align: center;">
            <div style="text-align: center; display:inline  ; width: max-content;">
                <div>
                    <form id="login-form" method="POST" action="login.php">
                        <?php if (isset($_GET['error'])) ?>
                        <div role="alert">
                            <?php if (isset($_GET['error'])) {
                                echo $_GET['error'];
                            } ?>
                        </div>
                        <div>
                            <br>
                            <h3>Login</h3>
                            <div>
                                <p>Email</p>
                                <input type="email" name="user_email">
                            </div>
                            <div>
                                <p>Password</p>
                                <input type="password" name="user_password">
                            </div>
                            <br>
                            <div>
                                <input type="submit" class="site-btn" id="login-btn" name="login_btn" value="LOGIN" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

</body>

</html>
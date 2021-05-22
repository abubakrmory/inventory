<?php
include('connect.php');
if (isset($_SESSION["type"])) {
    header("location:index.php");
}
$message = '';
if (isset($_POST['login'])) {
    $query = 'SELECT * FROM user_details WHERE user_email=:user_email';
    $statement = $connect->prepare($query);
    $statement->execute(
        array('user_email' => $_POST["user_email"])
    );
    $count = $statement->rowCount();
    if ($count > 0) {
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            if (password_verify($_POST["user_password"], $row["user_password"])) {
                if ($row['user_status'] == 'Active') {
                    $_SESSION['type'] = $row['user_type'];
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['user_name'] = $row['user_name'];
                    header("location:index.php");
                } else {
                    $message = '<label>Your Account is not active</label>';
                }
            } else {
                $message = '<label>Wrong Password</label>';
            }
        }
    } else {
        $message = '<label>Wrong Email Address</label>';
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
    <script scr="js/jquery-3.6.0.min.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <script scr="js/bootstrap.min.js"></script>

</head>

<body>
    <br />
    <div class="container">
        <h2 class="text-center text-primary">Inventory Managment System</h2>
        <br>
        <div class="card">
            <div class="card-header text-center">
                Login
            </div>
            <div class="card-body">
                <form method="POST">
                    <?php echo $message;  ?>
                    <div class="form-group">
                        <label>Email address</label>
                        <input type="email" name="user_email" value="abubakrmory@gmail.com" class="form-control" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="user_password" value="rasmuslerdorf" class="form-control" placeholder="Enter Password">
                    </div>
                    <div class="form-group">
                        <input type="submit" name="login" value="Login" class="btn btn-info" />
                    </div>
                </form>
            </div>
        </div>
</body>

</html>
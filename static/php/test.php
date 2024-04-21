<?php
include_once "../model/conmql.php";
$conn = testConnect();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="post">
        <label for="">Username</label>
        <input type="text" name="username" id="">
        <br>
        <label for="">Password</label>
        <input type="password" name="password" id="">

        <br>
        <input type="submit" name="submit" value="Login Now">
    </form>
</body>
<?php
$password = null;
if (isset($_POST['submit']) && ($_POST['submit'])) {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = hash("sha256", $_POST['password']);
            $expire = time() + 60 * 60 * 24 * 30;
            setcookie("pass", $password, $expire);
        }
    }
}

if($password == $_COOKIE['pass']) {
    echo 'Successfully';
} else {
    echo "Failed";
}
?>

</html>
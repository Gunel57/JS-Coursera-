<?php
session_start();
require_once "pdo.php";

if (isset($_POST['cancel'])) {
   
    header("Location: index.php");
    return;
}

$salt = 'XyZzy12*_';
if (isset($_POST['pass']) && isset($_POST['email'])) {
    $check =	md5($_POST['pass']);


    $stmt = $pdo->prepare('SELECT user_id, name FROM users WHERE email = :em AND password = :pw');

    $stmt->execute(array(':em' => htmlentities($_POST['email']), ':pw' => $check));


    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row !== false) {

        $_SESSION['name'] = $row['name'];

        $_SESSION['user_id'] = $row['user_id'];

        header("Location: index.php");

        return;
    }

}
?>
<!DOCTYPE html>
<html>
<head>
    <?php require_once "bootstrap.php"; ?>
    <title>Gunel Bakhramova</title>
</head>

<body>
<div class="container">
    <h1>Please Log In</h1>
    <?php
    if (isset($_SESSION['error'])) {
        echo('<p style="color: red;">' . htmlentities($_SESSION['error']) . "</p>\n");
        unset($_SESSION['error']);
    }
    ?>
    <form method="POST" action="login.php">
        User Name <input type="text" name="email"><br/>
        Password <input type="text" name="pass" id="id_1723"><br/>
        <input type="submit" onclick="return doValidate();" value="Log In">
        <input type="submit" name="cancel" value="Cancel">
    </form>
    <p>
        For a password hint, view source and find a password hint
        in the HTML comments.
    
    </p>
</div>

<script type="text/javascript">
	function doValidate() {
    console.log('Validating...');
    try {
        pw = document.getElementById('id_1723').value;
        console.log("Validating pw="+pw);
        if (pw == null || pw == "") {
            alert("Both fields must be filled out");
            return false;
        }
        return true;
    } catch(e) {
        return false;
    }
    return false;
}
</script>
</body>
</html>
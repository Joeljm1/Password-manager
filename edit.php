<?php
require_once "databaseConnect.php";
session_start();
$site=$_GET['site'];
$tname = 'login' . $_SESSION['sno'];
if (isset($_POST['Submit'])) {
    $newUname = $_POST['new_uname'];
    $newPswd = $_POST['new_pswd'];
    $newSite = $_POST['new_site'];
    $result=$conn->query("SELECT * FROM $tname WHERE site='$newSite'");
    if ($result->num_rows > 0 && $newSite !== $_GET['site']) {
        $error_message = "Site already exists in the database!";
    } else {
        $conn->query("UPDATE $tname SET uname='$newUname', password=' $newPswd', site=' $newSite' WHERE site='$site'");
        header("Location: edit.php?site=" . $_GET['site'] . "&success=1");
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Site</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #007bff;
            padding: 10px 0;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }

        .navbar button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-right: 10px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .navbar button:hover {
            background-color: #0056b3;
        }

        h1 {
            text-align: center;
            color: #007bff;
        }

        form {
            width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #555;
        }

        input[type="text"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        p.success-message {
            text-align: center;
            color: green;
        }

        p.error-message {
            text-align: center;
            color: red;
        }
    </style>
</head>
<body>
<div class="navbar">
        <button onclick="location.href='dashboard.php'">Dashboard</button>
        <button onclick="location.href='pswd.php'">Check Passwords</button>
    </div>
    <h1>Edit Site</h1>

    <?php
    if (isset($_GET['success']) && $_GET['success'] == 1) {
        echo "<p class='success-message'>Site details updated successfully!</p>";
        header('Location: pswd.php'); 
    }
    if (isset($error_message)) {
        echo "<p class='error-message'>$error_message</p>";
    }
    ?>

    <form method="POST">
        <label>New Username:</label>
        <input type="text" name="new_uname"><br>

        <label>New Password:</label>
        <input type="text" name="new_pswd"><br>

        <label>New Site:</label>
        <input type="text" name="new_site" ><br>

        <input type="submit" name="Submit" value="Update">
    </form>

</body>
</html>

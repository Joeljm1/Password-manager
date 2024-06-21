<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
        }
        .topbar {
            background-color: #007BFF;
            color: white;
            padding: 10px 0;
            text-align: center;
        }
        form {
            margin: 50px;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #fff;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input[type="text"] {
            padding: 10px;
            width: 100%;
            margin-bottom: 20px;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            border: none;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-left: 55px;
            background-color: #fafafa;
        }
        th, td {
            padding: 5px;
            border: 1px solid #ccc;
            color: #333;
        }
        th {
            background-color: #007BFF;
            color: #fff;
        }
        .edit-button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 5px 10px; 
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="topbar">
        <a href="dashboard.php" style="color: white; text-decoration: none;">Dashboard</a>
    </div>
    
    <form method="POST">
        <label>Enter site (Leave empty to get all passwords)<input type="text" name="site"></label>
        <br>
        <input type="submit" name="Submit">
    </form>

    <?php
    if(isset($_POST['Submit']))
    {
        session_start();
        $tableName="login".$_SESSION['sno'];
        require_once "databaseConnect.php";
        $site=$_POST['site'];
        $sql="Select * from $tableName where site like '%$site%'; ";
        $row=$conn->query($sql);
        echo "<table border=1><tr><th>Username</th><th>Site</th><th>Password</th><th>Edit</th>";
        if($row->num_rows>0)
        {
            while($result=$row->fetch_assoc())
            {
                $uname=$result['uname'];
                $password=$result['password'];
                $site=$result['site'];
                echo "<tr><td>$uname</td><td>$site</td><td>$password</td><td>";
                echo "<a href='edit.php?site=$site' class='edit-button'>Edit</a>";
                echo "</td></tr>";
            }
        }
    }
    ?>
    <a href="dashboard.php" style="padding-left: 55px">Click here</a> to store the passwords
    <br><br>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Password Manager</title>
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
            margin-bottom: 20px;
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

        #container {
            width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #007bff;
            font-size: 28px;
            margin-bottom: 30px;
        }

        form {
            margin-top: 20px;
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

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .suggested-password {
            font-size: 14px;
            margin-top: 10px;
            color: #888;
        }

        .password-generator {
            text-align: center;
            margin-top: 20px;
        }

        .password-generator button {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .password-generator button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <button onclick="location.href='pswd.php'">Check Passwords</button>
    </div>
    <div id="container">
        <h1>Password Manager</h1>
        <?php 
        if(isset($_POST['Submit'])) {  
            session_start();
            $sno=$_SESSION['sno'];
            require_once "databaseConnect.php";
            $uname=$_POST['uname'];
            $pswd=$_POST['pswd'];   
            $site=$_POST['site'];
            $check_sql = "SELECT * FROM login$sno WHERE site='$site'";
            $result=$conn->query($check_sql);
            
            if($result->num_rows > 0) 
            {
                echo "<p style='color:red;'>Site already exists in the database!</p>";
            } 
            else
            {
                $stmt=$conn->prepare("INSERT INTO login$sno (uname, password, site) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $uname, $pswd, $site);
                $stmt->execute();
                $stmt->close();
                echo "<p style='color:green;'>Site added successfully!</p>";
            }
        }
        ?>
        <form method="POST">
            <label>Website:<input type="text" name="site"></label>
            <label>Username:<input type="text" name="uname"></label>
            <?php
            $val="";
            $num = '0123456789 ';
            $alpha='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz ';
            $signs='!@#$%& ';
            if(isset($_POST['SuggestPass'])) {
                for($i = 0; $i < 6; $i++) {
                    $val.= $alpha[rand(0, strlen($alpha)-1)];
                }
                $val.=$num[rand(0,strlen($num)-1)];
                $val.=$signs[rand(0,strlen($signs)-1)];
            }
            echo "<label>Password:<input type='text' name='pswd' value='$val'></label>";
            ?>
            <!--<label>Password:<input type="password" name="pswd"></label>-->
            <div class="password-generator">
                <button type="submit" name="SuggestPass">Generate Password</button>
            <br>
            <br>    
            <input type="submit" name="Submit"></div>
            <?php 
            if(isset($_POST['SuggestPass']))
            {
                echo "<div class='suggested-password'>Suggested Password:$val</div>";
            }
            ?>
        </form>
        <a href="pswd.php">Click here to see your password</a>
    </div>
</body>
</html>

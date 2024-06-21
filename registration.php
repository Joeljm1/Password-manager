<html>

<head>
    <title>Login page</title>
    <link rel="stylesheet" href="style2.css">
</head>

<body bgcolor="#232b2b">
    <?php
        if(isset($_POST["submit"]))
        {
            $user=$_POST["uname"];
            $mail=$_POST["email"];
            $pswd1=$_POST["pswd1"];
            $pswd2=$_POST["pswd2"];
            $error=array();
            require_once "databaseConnect.php";
            $sql="Select * from login where email='$mail'";
            $rowc=$conn->query($sql);
            if($rowc->num_rows >0)
            {
                $error[]="Mail already exists";
            }
            $hash=password_hash($pswd1,PASSWORD_DEFAULT);
            if(empty($user)||empty($mail)||empty($pswd1)||empty($pswd2))
            {
                $error[]="All feilds are required";
            }
            if($pswd1!=$pswd2)
            {
                $error[]="Passwords do not match";
            }
            if(!filter_var($mail,FILTER_VALIDATE_EMAIL))
            {
                $error[]="Email not valid";
            }
            if(strlen($pswd1)<8)
            {
                $error[]="Size of password is less than 8 characters";
            }
            if(count($error)>0)
            {
                foreach($error as $e)
                {
                    echo "<div class='error'>".$e."</div>";
                }
            }
            else
            {
                $stmt = $conn->prepare("INSERT INTO login(userid,email,password) values (?,?,?);");
                $stmt->bind_param("sss", $user, $mail,$hash);
                $stmt->execute();
                $stmt->close();
                $sql = "SELECT sno FROM login where email='$mail'";
                $result=$conn->query($sql);
                if($result===FALSE)
                {
                    echo "error occured";
                }
                else
                {
                    $dict=$result->fetch_assoc();
                    $tableName="login".$dict['sno'];
                }
                if($conn->query("Create table $tableName (uname varchar(100) not null,password varchar(100) not null,site varchar(200) not null);")===FALSE)
                {
                    echo "error creating table";
                }
                header("Location: registrationComplete.html");
            }
        }
    ?>
    <form method="Post">
    <div id="box">
        <div id="txt">
            Registration
            <hr>

        </div>
        <div id="login">
            <input type="text" placeholder="Enter username" name="uname" required>
            <hr width="452px">
            <br><br>
            <input type="email" placeholder="Enter email id" name="email" required>
            <hr width="452px">
            <br><br>
            <input type="password" placeholder="Enter password" name="pswd1" required minlength="8">
            <hr width="452px">
            <br><br>
            <input type="password" placeholder="Re-enter password" name="pswd2" required minlength="8">
            <hr width="452px">
            <br>
            <br>

            <div id="logbox">

                <input type="submit" text="Submit1" id="gr" name="submit">
            </div>
        </div>
</form>
</body>

</html>
<html>

<head>
    <title>Login page</title>
    <style>
        body {
        background-color: #d3d3d3;
        background-image: linear-gradient(315deg, red 0%, blue 74%);
    }
    #gr{
        background-color:#3ded97;
    }
    #box {
        margin-left: 35%;
        margin-top: 10%;
        height: 550px;
        width: 500px;
        background-color: white;
        border-radius: 40px;
    }

    #logbox {
        margin-left: 120px;
        padding-top: 25px;
        text-align: center;
        background-color: #3ded97;
        height: 50px;
        width: 200px;
        border-radius: 70px;
    }

    .error{
        color:red;
        font-weight:bold;
        margin-left: 35%;
        width: 500px;
        background-color: white;
        height:20px;
        background-color:yellow;
        border-radius: 40px;
        }


    a {
        color: grey;
        text-decoration: none;
    }

    #txt {
        font-family: 'Times New Roman', Times, serif;
        font-size: 40px;
        text-align: center;
        padding-top: 20px
    }

    input:focus {
        outline: none;
        color: black;
    }

    input {
        padding-left: 15px;
        border: none;
        color: grey;
        font-size: 20px;
    }

    #login {
        padding-top: 30px;
        padding-left: 20px;
        color: grey;
        font-size: 20px;
        padding-top: 20px;
    }

    input:hover {
        font-weight: bold;
    }

    #logbox:hover {
        background-color: #0ce681;
        transition: 0.5s;
    }
    </style>
</head>

<body >
    <?php
    if(isset($_POST['Submit']))
    {
        require_once('databaseConnect.php');    
        $uname=$_POST['uname'];
        $mail=$_POST['mail'];
        $pswd=$_POST['pswd'];
        $error=array();
        $sql="Select * from login where email='$mail' and userid='$uname';";
        $select=$conn->query($sql);
        if($select->num_rows>0)
        {
            $row = $select->fetch_assoc();
            $sno=$row['sno'];
            if(!password_verify($pswd,$row["password"]))
            {
                $error[]="Password does not match";
            }
            else
            {
                session_start();
                $_SESSION['sno']=$sno;
                header("Location:dashboard.php");
                die();
            }
        }
        else
        {
            $error[]="Mail and/or username does not exist";
        }
        foreach($error as $e)
        {
            echo "<div class='error'>$e</div>";
        }
        
    }
    ?>
    <form method ="Post">
    <div id="box">
        <div id="txt">
            Login
            <hr>

        </div>
        <div id="login">
            <input type="text" placeholder="Enter username" name="uname" required>
            <hr width="452px">
            <br><br>
            <input type="email" placeholder="Enter email" name="mail" required>
            <hr width="452px">
            <br><br>
            <input type="password" placeholder="Enter password" name="pswd" minlenght="8" required>
            <hr width="452px">
            <br>
            <a href="registration.php">Register here</a>
            <br><br>

            <div id="logbox">

                <input type="submit" name="Submit" id="gr">
            </div>
        </div>
</body>

</html>
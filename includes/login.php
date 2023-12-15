<?php

if(isset($_SESSION['admin']) && ($_SESSION['admin']==1)){


  echo "<div align=center><h5>You are already logged in</h5></div>";

}
else{
    if(isset($_POST['submit'])){
        
        $stmt = $conx->prepare("SELECT * FROM users WHERE username=? AND password=?");
        $passw = md5($_POST['password']);
        $stmt->bind_param("ss", $_POST['username'], $passw);
        $stmt->execute();
        $result = $stmt->get_result();
        $creds = $result->fetch_assoc();
        $stmt->close();

        if($creds){
            $_SESSION['username'] = $creds['username'];
            $_SESSION['password'] = $creds['password'];
            $_SESSION['admin'] = 1;
            header("Location: ".$_SERVER['PHP_SELF']);
        }
        else{
            header("Location: ".$_SERVER['PHP_SELF']."?action=login");
        }

    }
    else{

  ?>

  <div align=center>
    <fieldset style=width:300;>
    <legend><b>Login</b></legend>
        <form action="<?php echo $_SERVER['PHP_SELF']."?action=login"; ?>" method="post">
            <br>
            Username/Email: <input type=text name=username><br>
            Password: <input type=password name=password><br>
            <br><input type=submit name="submit" value=Login><br>
        </form>
    </fieldset>
  </div>

  <?php

    }
}

?>
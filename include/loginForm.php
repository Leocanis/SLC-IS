<?php
if (isset($form) && isset($session) && !$session->logged_in) {
    ?>
    <form action="process.php" method="POST" class="form-signin">              
        
        
            <input class="form-control" name="user" type="text" placeholder="Naudotojo vardas" value="<?php echo $form->value("user"); ?>"/><br>
            <?php echo $form->error("user"); ?>
        
        
            <input class="form-control" name="pass" type="password" placeholder="Slaptažodis" value="<?php echo $form->value("pass"); ?>"/><br>
            <?php echo $form->error("pass"); ?>
         
        
            <input type="submit" class="btn btn-lg btn-primary btn-block" value="Prisijungti"/>
            <input type="checkbox" name="remember" 
            <?php
            if ($form->value("remember") != "") {
                echo "Pažymėtas";
            }
            ?>/>
            Atsiminti   
        
        <input type="hidden" name="sublogin" value="1"/>
        
            <a href="forgotpass.php">Negalite prisijungti?</a>           
            
             
    </form>
    <?php
}
?>
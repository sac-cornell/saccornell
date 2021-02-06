<?php
// INCLUDE ON EVERY TOP-LEVEL PAGE!
include("includes/init.php");
$title = "Contact";

//Form validation
//If submit button is pressed;
if (isset($_POST['submit'])){
    $validform=TRUE;
    $fname= filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
    $lname= filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
    $email= filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $msg= filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

    //error messages are intialized at hidden
    $visibility="hidden";

    //validate first name
    if(trim($fname)==""){
        $validform=FALSE;
        $error1= "*please enter your first name";
        $visibility="visible";
    }
    //validate last name
    if(trim($lname)==""){
        $validform=FALSE;
        $error2= "*please enter your last name";
        $visibility="visible";
    }
    //validate email
    if(!$email){
        $validform=FALSE;
        $error3= "*please enter a valid email";
        $visibility="visible";
    }
     //validate message
     if(trim($msg)==""){
        $validform=FALSE;
        $error4= "*please enter a message";
        $visibility="visible";
    }
    else{
        //Form can be mailed
        session_start();
        $_SESSION["firstname"] = $fname;
        $_SESSION["lastname"] = $lname;
        $_SESSION["email"] = $email;
        $_SESSION["message"] = $msg;
        $to = "lam364@cornell.edu"; //CHANGE TO CORRECT ADDRESS
        $subject = "South Asian Council Web Form Question";
        $txt = $msg;
        $headers = "From:".$email;
        mail($to,$subject,$txt,$headers); //remove echo
        header('Location: confirmation.php');
    }
}
else{
    $visibility="hidden";
}

?>

<!DOCTYPE html>
<html lang="en">

<?php include("includes/header.php"); ?>

<body>
<?php include("includes/nav.php"); ?>

    <div class='topOfPage contact'>
        <h1><?php echo $title; ?></h1>
    </div>

<div class="main" id="scroll">
    <!-- Socials icons from https://iconmonstr.com/ -->

    <div id="contactPage">
        <p>Let us know if you have any questions!</p>

        <form id="contact" action="#scroll" method='post' autocomplete="off">

            <ul id="list">
            <li><span class="label">First Name:</span><span class="<?php echo($visibility)?>"><?php echo($error1)?></span></li>
            <li><input type="text" name="first_name" placeholder="First Name" value="<?php echo(htmlspecialchars($fname))?>"/></li>
            <li><span class="label">Last Name:</span><span class="<?php echo($visibility)?>"><?php echo($error2)?></span></li>
            <li><input type="text" name="last_name" placeholder="Last Name" value="<?php echo(htmlspecialchars($lname))?>"/></li>
            <li><span class="label">Email:</span><span class="<?php echo($visibility)?>"><?php echo($error3)?></span></li>
            <li><input type="email" name="email" placeholder="Email" value="<?php echo(htmlspecialchars($email))?>"/></li>
            <li><span class="label">Message:</span><span class="<?php echo($visibility)?>"><?php echo($error4)?></span></li>
            <li><textarea name="message" placeholder="Leave us a question, comment, or concern and we'll get back to you as soon as possible!" cols=50 rows=10><?php echo(htmlspecialchars($msg))?></textarea></li>
            <li> <input id="submit" type="submit" name="submit" value="Send"/></li>
            </ul>

        </form>
    </div>

    <img class="about_page_logo" src="images/transparent_logo.png">

</div>



<?php include("includes/footer.php"); ?>
</body>

</html>

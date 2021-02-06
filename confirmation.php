<?php
// INCLUDE ON EVERY TOP-LEVEL PAGE!
include("includes/init.php");
$title = "Form Confirmation";
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<?php include("includes/header.php"); ?>

<body>
<?php include("includes/nav.php"); ?>

    <div class='topOfPage contact'>
        <h1><?php echo $title; ?></h1>
    </div>

<div class="main">
    <!-- Socials icons from https://iconmonstr.com/ -->
    <p>Thanks for reaching out!</br> We will get back to you as soon as possible.</p>
    <ul id="confirm">
        <li><span class="subtitle">Name: </span><?php echo($_SESSION["firstname"]) ?> <?php echo($_SESSION["lastname"]) ?></li>
        <li><span class="subtitle">Email: </span><?php echo($_SESSION["email"]) ?></li>
        <li><span class="subtitle">Message: </span><?php echo($_SESSION["message"]) ?></li>
        <li><input id="submit2" type="submit" name="submit2" onclick="location.href='contact.php'" value="Back to Contact Page"/></li>
    </ul>
</div>

<?php include("includes/footer.php"); ?>
</body>

</html>

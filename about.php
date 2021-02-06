<?php
// INCLUDE ON EVERY TOP-LEVEL PAGE!
include("includes/init.php");

$title = "About";
?>
<!DOCTYPE html>
<html lang="en">

<?php include("includes/header.php"); ?>

<body>
<?php include("includes/nav.php"); ?>

  <div class='topOfPage about'>
    <h1><?php echo $title; ?></h1>
  </div>

  <!-- All information from South Asian Council -->

  <div class="about_page">
  <h2>What is the South Asian Council?</h2>
  <p>"We, the members of the South Asian community at Cornell University, do hereby propose the establishment of the South Asian Council to serve as the umbrella organization for all organizations at Cornell University that are concerned with South Asian issues. The South Asian Council will aim to raise awareness and advocacy for South Asian interests, provide support for the South Asian community, and build collaborations internal and external to the community."</p>

  <h2>SAC Mission Statement</h2>
  <p>“We will advocate for South Asian voices, faces, and needs at all levels of Cornell administration and beyond. We will challenge conversations that do not extend beyond the American racial binary. We will center and affirm space for the voices of the marginalized, unseen, and unheard, in our community, and that includes individuals who are Muslim, Sikh, LGBTQIA+, working class, low caste, first generation, non-American, and undocumented. We are not only allies, but strive to be included as members of POC coalitions, because our stories are not devoid of pain, erasure, and violence in the United States, in our motherlands, and abroad.”</p>
  <img class="about_page_logo" src="images/transparent_logo.png">
  </div>

  <?php include("includes/footer.php"); ?>
</body>

</html>

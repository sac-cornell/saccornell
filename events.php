<?php
// INCLUDE ON EVERY TOP-LEVEL PAGE!
include("includes/init.php");
$db = open_or_init_sqlite_db('secure/sac.sqlite', 'secure/init.sql');
$title = "Events";

if (isset($_POST["delete"])) {
  $id = $_POST['delete'][0];
  $sql = "DELETE FROM otherevents WHERE (id==$id)";
  $params = array();
  $deletion = exec_sql_query($db, $sql, $params)->fetchAll();
  unlink("uploads/otherevents/" . $file_name . "." . $ext);
}

if (isset($_POST['upload'])) {
  if (trim($_POST['title']) == "") {
    echo "Please fill out all required fields";
  } else {
    $upload = $_FILES['file'];
    if ($upload['error'] == UPLOAD_ERR_OK) {
      $file_name = $_FILES['file']['name'];
      $upload_ext = end((explode(".", $file_name)));
      $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
      $link = null;
      if (trim($_POST['link']) != "") {
        $link = filter_input(INPUT_POST, 'link', FILTER_SANITIZE_URL);
      }
      $source = null;
      if (trim($_POST['source']) != "") {
        $source = filter_input(INPUT_POST, 'source', FILTER_SANITIZE_STRING);
      }
      $sourcelink = null;
      if (trim($_POST['sourcelink']) != "") {
        $sourcelink = filter_input(INPUT_POST, 'sourcelink', FILTER_SANITIZE_URL);
      }
      $sql = "INSERT INTO otherevents (title, link, file_name, ext, source, sourcelink) VALUES (:title, :link, :file_name, :ext, :source, :sourcelink)";
      $params = array(
        ':title' => $title,
        ':link' => $link,
        ':file_name' => $file_name,
        ':ext' => $upload_ext,
        ':source' => $source,
        ':sourcelink' => $sourcelink
      );
      $result = exec_sql_query($db, $sql, $params);
      if ($result) {
        $new_path = 'uploads/otherevents/' . $file_name . "." . $upload_ext;
        move_uploaded_file($upload['tmp_name'], $new_path);
      }
    } else {
      echo "please upload an image file";
    }
  }
}
// Get other events information from DB
$sql = "SELECT * FROM otherevents";
$param = array();
$otherevents = exec_sql_query($db, $sql, $param)->fetchAll();

function displayEvent($id, $title, $link, $file_name, $ext, $source, $sourcelink)
{
  $img = 'uploads/otherevents/' . $file_name . "." . $ext;
  ?>
  <div class='otherEventBox' id='otherevent'>
    <!-- <?php echo htmlspecialchars($source) ?> -->
    <a target="_blank" href=<?php echo htmlspecialchars($link) ?>><img src=<?php echo htmlspecialchars($img) ?>></a>
    <?php
    if ($source != NULL && $sourcelink != NULL) {
      ?> <p class='source'>Image Source: <a href="<?php echo htmlspecialchars($sourcelink) ?>"><?php echo htmlspecialchars($source) ?></a></p> <?php
                                                                                                                                                } ?>
    <p><?php if (isset($_POST['edit'])) { ?>
        <form action="#edit_loc" method="post">
          <button type="submit" name="delete[]" value="<?php echo htmlspecialchars($id) ?>">Delete</button>
        </form>


      </p>
    <?php } ?>
    <a target="_blank" href=<?php echo htmlspecialchars($link) ?> class='eventTitle'><?php echo htmlspecialchars($title) ?></a>
  </div>
<?php
}
?>

<!DOCTYPE html>
<html lang="en">

<?php include("includes/header.php"); ?>

<body>

  <?php include("includes/nav.php"); ?>

  <div class='topOfPage events'>
    <h1><?php echo $title; ?></h1>
  </div>


  <!-- All information from South Asian Council -->
  <?php
  if (isset($_GET['event'])) {
    if ($_GET['event'] == 'chai') {
      ?>
      <div class="back"><a class="back_to_events" href="events.php">< Back to Events</a></div>
      <p class='chats'>Here are our most recent Chai &amp; Chats! Feel free to browse each Chai & Chat to be caught up with our latest conversations! Chats are ordered from most recent to oldest.</p>

      <?php
      $sql = "SELECT * FROM chai";
      $chais = exec_sql_query($db, $sql)->fetchAll();
      foreach ($chais as $chai) {
        $imgPath = 'images/' . $chai['img_name'] . '.' . $chai['img_ext'];
        // Image Source: South Asian Council
        echo '<h3 class="chai">' . htmlspecialchars($chai['event_name']) . '</h3>';
        echo '<div class="indiv_chai"><div class="chai_pic"><img src="' . $imgPath . '"><a href="https://www.facebook.com/SouthAsianCouncilCornell"><p class="source">Image Source: South Asian Council</p></a></div><div><p>' . htmlspecialchars($chai['description']) . '</p></div></div>';
      }
      ?>

      <!-- CLIENT-SIDE NEEDS FOR PAGE (not for turn-in) -->
      <p class='chats'>Here are our most recent Chai &amp; Chats! Feel free to browse the presentations for each Chai & Chat to be caught up with our latest conversations! Presentations are ordered from most recent to oldest; you can also reference the links below for specific dates.</p>
                                                                                                                       <nav id="cc">
                                                                                                                        <ul>
                                                                                                                        <li><a href="#7">Tuesday, Sept. 4th, 2018: Financial Literacy</a></li>
                                                                                                                        <li><a href="#6">Tuesday, Oct. 16th, 2018: Destigmatizing South Asian Mental Health</a></li>
                                                                                                                        <li><a href="#5">Tuesday, Oct. 23rd, 2018: Greek & Desi</a></li>
                                                                                                                        <li><a href="#4">Friday, Oct. 26th, 2018: Cafe Con Leche X Masala Chai</a></li>
                                                                                                                        <li><a href="#3">Tuesday, Nov. 13th, 2018: Desis United</a></li>
                                                                                                                        <li><a href="#2">Tuesday, Feb. 12th, 2018: Queering Desi</a></li>
                                                                                                                        <li><a href="#1">Tuesday, Mar. 12th, 2018: Interracial Dating</a></li>
                                                                                                                        </ul>
                                                                                                                      </nav>
                                                                                                                       <a id='1'></a><iframe src='https://docs.google.com/presentation/d/e/2PACX-1vRTZ54V4Y8lNmgqFGPwSrfZSuLFNYWCjieofif2Zxb4Jy6Flpa5FPDxAxPGEXzukkGBotALr5rSPzGx/embed?start=false&loop=false&delayms=3000' frameborder='0' width='960' height='569' allowfullscreen='true' mozallowfullscreen='true' webkitallowfullscreen='true'></iframe>
                                                                                                                       <a id="2"></a><iframe src="https://docs.google.com/presentation/d/e/2PACX-1vSmZMZOcfOyfi9hcKdSnowaKX21hDiRq24u7OvMC4-g4lomPPTBP0rB5X6ifp8-XrGRsfMa1xxHG84N/embed?start=false&loop=false&delayms=3000" frameborder="0" width="960" height="569" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>
                                                                                                                       <a id="3"></a><iframe src="https://docs.google.com/presentation/d/e/2PACX-1vSOeHw2-eQD6XT6BLuERLvsrriJE4KjZRJx-JeTg_yGPPt9q-bEgTG-6BZZvKGGzbNTaH9Ln9uBPXbx/embed?start=false&loop=false&delayms=3000" frameborder="0" width="960" height="569" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>
                                                                                                                       <a id="4"></a><iframe src="https://docs.google.com/presentation/d/e/2PACX-1vSzuQOTIN4B643Uw4VxIEiEmlsM0v7ktmjKSxZgNr96W2l-c0zXWvpwjinKAeqcP7wMRQqcUcEHco_k/embed?start=false&loop=false&delayms=3000" frameborder="0" width="960" height="569" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>
                                                                                                                       <a id="5"></a><iframe src="https://docs.google.com/presentation/d/e/2PACX-1vRjvjLJrJIZpseG2v1tx5182dZDeNNzKWgqTLueKFmY7e1h5edw2MHsb7ScvjpGTwm719MJdVbkwU-Q/embed?start=false&loop=false&delayms=3000" frameborder="0" width="960" height="569" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>
                                                                                                                       <a id="6"></a><iframe src="https://docs.google.com/presentation/d/e/2PACX-1vQkdLqcygeD7WqVtQD5Putv2HfphcRcjDtuhA5XkYAC9irxsZR3DQTOHd8nygWq5yYdYqFI09LPd1Za/embed?start=false&loop=false&delayms=3000" frameborder="0" width="960" height="569" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>
                                                                                                                       <a id="7"></a><iframe src="https://docs.google.com/presentation/d/e/2PACX-1vQ2A30pTOHQtKWBJI2ise9rl5i8nUGu45sMlZL6jjRr6edbnVFf7_hbF3nkWr_-Uk0pePl9H2TNPSWh/embed?start=false&loop=false&delayms=3000" frameborder="0" width="960" height="569" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>
      <a class="back_to_events" href="events.php">
        <p>Back to Events</p>
      </a>

    <?php } elseif ($_GET['event'] == 'bollywood') { ?>
      <div class="back"><a class="back_to_events" href="events.php">< Back to Events</a></div>
      <!-- Image Source: South Asian Council -->
      <div id="bolly_box">
        <a class="b_img" target="_blank" href="https://www.facebook.com/events/925349444340806/"><img class="bn_img" src="images/bollywoodnight.jpg"></a>
        <a href='https://www.facebook.com/SouthAsianCouncilCornell/' class="source">Image Source: South Asian Council</a>
      </div>
      <p class="chats">Every year, SAC hosts a dance night with all Bollywood music (nostalgic throwbacks and current bops & bangers) for which all proceeds are donated to a nonprofit that serves the South Asian community.
        8pm-10pm is for those under 21; 21+ can stay til 1am!</p>
      <p class="chats">This year, we will be donating to the Asian Pacific American Network of Oregon - APANO. Out of the 123 immigrants that were transferred by Immigration And Customs Enforcement (ICE) to a facility in Sheridan, Oregon over the past month, 52 reportedly Indian, mainly Sikhs and Christians who say they are fleeing religious persecution. The group also includes 13 immigrants from Nepal and two from Bangladesh.
        APANO continues to provide them free legal services, translators, and advocates for better conditions for those detained.</p>
      <a class="back_to_events" href="events.php">
        <p>Back to Events</p>
      </a>

    <?php } elseif ($_GET['event'] == 'shaadi') { ?>
      <div class="back"><a class="back_to_events" href="events.php">< Back to Events</a></div>
      <!-- Image Source: South Asian Council -->
      <figure><a class="b_img" target="_blank" href="https://www.facebook.com/events/334311253858187/"><img class="bn_img" src="images/mock_shaadi.jpg"></a>
        <a href='https://www.facebook.com/SouthAsianCouncilCornell/'>
          <figcaption class='source'>Image Source: South Asian Council</figcaption>
        </a></figure>
      <p class='chats'>It’s shaadi season! SAC’s Mock Shaadi is an annual interfaith and intercultural mock wedding celebration that showcases and celebrates that richness and diversity of South Asian cultural and religious wedding traditions. Come through for a night filled with delicious food, music, and dancing!</p>
      <!-- Image Source: South Asian Council -->
      <figure><img class="bn_img" src="images/shaadi_mcs.png"><a href='https://www.facebook.com/SouthAsianCouncilCornell/'>
          <figcaption class='source'>Image Source: South Asian Council</figcaption>
        </a></figure>
      <a class="back_to_events" href="events.php">
        <p>Back to Events</p>
      </a>

    <?php } elseif ($_GET['event'] == 'celebrasian') { ?>
      <div class="back"><a class="back_to_events" href="events.php">< Back to Events</a></div>
      <!-- Image Source: CAPSU -->
      <figure><a class="b_img" target="_blank" href="https://www.facebook.com/events/982843885250941/"><img class="bn_img" src="images/celebrasian.jpg"></a>
        <a href="http://www.cornellcapsu.org/">
          <figcaption class='source'>Image Source: CAPSU</figcaption>
        </a></figure>
      <p class='chats'>Celebr(ASIAN) is an awards ceremony recognizing the efforts and achievements of the Asian and Asian-American community at Cornell. This year, Celebr(ASIAN) will be held on Wednesday, May 1st in Willard Straight Hall's Memorial Room. Doors will open at 4:30 PM. Free food will be catered from the Taste of Thai and New Delhi Diamonds.</p>
      <p class='chats'>Please contact Jong Hang (jh998) and Stephanie Lin (scl97) or Kumar Nandanampati (vkn2), Aashka Piprottar (ap655), and Katha Sikka (kks72) with any questions.</p>
      <a class="back_to_events" href="events.php">
        <p>Back to Events</p>
      </a>
    <?php } ?>
    <img class="events_page_logo" src="images/transparent_logo.png">
  <?php } else { ?>

    <!-- All information from South Asian Council -->
    <div class="events_page">
      <div id='chai' class='mainevent'>
          <h2>Chai &amp; Chats</h2>
          <p>Chai &amp; Chats is a programming series seeking to raise awareness of oft-overlooked sociopolitical issues within the South Asian diaspora. Past topics have included dialogues surrounding post-colonialism feminism, interracial dating, refugee crisis, and overcoming homophobia and anti-blackness in the Desi community. Occurring on <strong>Tuesdays from 5-6 PM in Willard Straight Hall</strong>, this series always features free samosas & chai from New Delhi Diamonds!</p>
          <a class='click_events' href='events.php?event=chai'>Learn More</a>
      </div>

      <div id='bollywood' class='mainevent'>
          <h2>Bollywood Night</h2>
          <p>A dance night with all Bollywood music (nostalgic throwbacks and current bops & bangers) for which all proceeds are donated to a nonprofit that serves the South Asian community.</p>
          <a class='click_events' href='events.php?event=bollywood'>Learn More</a>
      </div>

      <div id='shaadi' class='mainevent'>
          <h2>Mock Shaadi</h2>
          <p>SAC’s Mock Shaadi is an annual interfaith and intercultural mock wedding celebration that showcases and celebrates that richness and diversity of South Asian cultural and religious wedding traditions.</p>
          <a class='click_events' href='events.php?event=shaadi'>Learn More</a>
      </div>

      <div id='celebrasian' class='mainevent'>
          <h2>celebr(ASIAN) with CAPSU</h2>
          <p>An awards ceremony recognizing the efforts and achievements of the Asian and Asian-American community at Cornell.</p>
          <a class='click_events' href='events.php?event=celebrasian'>Learn More</a>
      </div>
    </div>

    <div id="otherEvents">
      <div>
        <h2>Other Events &amp; Co-sponsored Events</h2>
      </div>
      <div id='eventPhotoBox'>
        <?php
        foreach ($otherevents as $event) {
          displayEvent($event['id'], $event['title'], $event['link'], $event['file_name'], $event['ext'], $event['source'], $event['sourcelink']);
          $id = $event['id'];
          $file_name = $event['file_name'];
          $ext = $event['ext'];
        }
        ?>
      </div>
      <div class="edit" id='edit_loc'>
        <!-- Allow the admin to add to or delete from "other events" -->
        <?php if (is_admin_logged_in()) { ?>
          <form action="#edit_loc" name="edit" method="post">
            <input type="submit" name="edit" value="Edit" />
          </form>
        <?php }
      if (isset($_POST['edit'])) { ?>
          <form name="edit" action="#otherevent" method="post" enctype="multipart/form-data">
            <p>Add an Event</p>
            <p id="small">Inputs with a * are required</p>
            <ul id="editor">
              <li><label for="title">*Title</label>
                <input type="text" name='title' /></li>
              <li><label for="link">Link</label>
                <input type="text" name='link' /></li>
              <li><label for="file">*File Upload</label>
                <input type="file" name="file" accept=".jpg, .jpeg, .png" /></li>
              <li><label for="source">Source</label>
                <input type="text" name='source' /></li>
              <li><label for="sourcelink">Source Link</label>
                <input type="text" name='sourcelink' /></li>
              <input type="submit" name="upload" value="Upload" />
          </form>
        <?php } ?>

      </div>

      <img class="about_page_logo" src="images/transparent_logo.png">
    </div>

  <?php } ?>
  <?php include("includes/footer.php"); ?>

</body>

</html>

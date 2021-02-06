<?php
// INCLUDE ON EVERY TOP-LEVEL PAGE!
include("includes/init.php");

$title = "Members";

$memID = 0;

$sql = "SELECT * FROM members";
$execboard = exec_sql_query($db, $sql) -> fetchAll();

function image($file_name, $ext) {
  echo "<img src='images/" . htmlspecialchars($file_name) . "." . htmlspecialchars($ext) . "'>";
}

if ( isset($_POST['add_member']) && is_admin_logged_in() ) {
  $valid = true;
  $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
  $position = filter_input(INPUT_POST, 'position', FILTER_SANITIZE_STRING);
  $year = filter_input(INPUT_POST, 'year');
  $major = filter_input(INPUT_POST, 'major', FILTER_SANITIZE_STRING);
  $minor = filter_input(INPUT_POST, 'minor', FILTER_SANITIZE_STRING);
  $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
  $involvement = filter_input(INPUT_POST, 'involvement', FILTER_SANITIZE_STRING);
  if ( $name == '' || $position == '' ) {
    $valid = false;
  }

  $upload = $_FILES['uploadPhoto'];
  if ( $upload['error'] == UPLOAD_ERR_OK && $valid == true) {
    $file_name = basename($upload['name'] , ".");
    $extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    $params = array (
      ':file_name' => $file_name,
      ':ext' => $extension,
      ':name' => $name,
      ':position' => $position,
      ':year' => $year,
      ':major' => $major,
      ':description' => $description,
      ':involvement' => $involvement
    );
    if ( $minor == '' ) {
      $sql = 'INSERT INTO members (file_name, ext, name, position, year, major, description, involvement) VALUES (:file_name, :ext, :name, :position, :year, :major, :description, :involvement)';
    } else {
      $params[':minor'] = $minor;
      $sql = 'INSERT INTO members (file_name, ext, name, position, year, major, minor, description, involvement) VALUES (:file_name, :ext, :name, :position, :year, :major, :minor, :description, :involvement)';
    }
    $result = exec_sql_query($db, $sql, $params);
    $execboard = exec_sql_query($db, "SELECT * FROM members;")->fetchAll();
    $newID = $db->lastInsertId('id');
    if ($result) {
      $newPath = 'images/' . $file_name . '.' . $extension;
      move_uploaded_file($_FILES['uploadPhoto']['tmp_name'], $newPath);
    }
  } else {
    array_push($messages, "upload unsuccessful");
  }
}

if ( isset($_POST['delete_member']) && is_admin_logged_in() ) {
  $id = filter_input(INPUT_POST, 'id');
  $sql = "DELETE FROM members WHERE id=:id";
  $params = array(
  ':id' => $id
  );
  $result = exec_sql_query($db, $sql, $params)->fetchAll();
  $execboard = exec_sql_query($db, "SELECT * FROM members;")->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="en">

<script type="text/javascript" src="scripts/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="scripts/members.js"></script>

<?php include("includes/header.php"); ?>

<body>
<?php include("includes/nav.php"); ?>

  <div class='topOfPage mems'>
    <h1><?php echo $title; ?></h1>
  </div>

  <div class='members'>
    <?php if (is_admin_logged_in()) { ?>
        <button class="add" onclick="openMemberForm()">+</button>
    <?php } ?>

      <div class="modal hidden" id="editMembers">
        <div class="modalContent">
          <span class="close" onclick="closeMemberForm()">&times;</span>
          <h2>Add a member</h2>
          <form id="add_member" action="members.php" method="post" enctype="multipart/form-data">
            <ul>
                <li> <label for="name">Name:</label><br />
                    <input type="text" id="name" name="name" required> </li>

                <li><label for="position">Position:</label>
                    <input type="text" id="position" name="position" required></li>

                <li><label for="year">Year:</label>
                    <input type="number" id="year" name="year" required></li>

                <li><label for='major'>Major:</label>
                    <input type='text' id='major' name='major' required/></li>

                <li><label for='minor'>Minor:</label>
                    <input type='text' id='minor' name='minor'/></li>

                <li><label for='description'>Description:</label>
                  <textarea id='description' name='description' rows='4' cols='30'></textarea></li>

                <li><label for='involvement'>Involvement:</label>
                  <textarea id='involvement' name='involvement' rows='4' cols='30'></textarea></li>

                <li><label for='uploadPhoto'>Upload Photo:</label>
                  <input id='uploadPhoto' type='file' name='uploadPhoto' required></li>

                <button name="add_member" type="submit">Add Member</button>
            </ul>
          </form>
        </div>
      </div>

    <?php
      foreach ($execboard as $eboard) {
        $boxID = '"modal' . $eboard['id'] . '"';

        // display members
        $imgPath = "images/" . $eboard['file_name'] . "." . $eboard['ext'];
        echo "<div class='member' id='" . htmlspecialchars($eboard['id']) . "' onclick='openModal(" . $boxID . ")'>";
        echo "<div class='memberPic'><img src='" . $imgPath . "'></div>";
        echo "<h2 class='membertitle'>" . htmlspecialchars($eboard['position']) . "</h2>";
        echo "<p>" . htmlspecialchars($eboard['name']) . "</p></div>";

        // hidden modals
        ?><div class="modal hidden" id=<?php echo $boxID ?>>
        <div class="modalContent">
          <span class="close" onclick='closeModal(<?php echo $boxID ?>)'>&times;</span>
          <div class="modalDescript">
            <div class="modalPic"><?php echo "<img src='" . $imgPath . "'>";?></div>
            <div class="modalWords"><?php
                echo "<p class='memPos'>" . $eboard['position'] . "</p>";
                echo "<p class='memName'>" . $eboard['name'] . "</p>";
                echo "<p class='memYear'>Class of " . $eboard['year'] . "</p>";
                echo "<p class='memMajor'>Major: " . $eboard['major'] . "</p>";
                if ($eboard['minor'] != NULL) {
                  echo "<p class='memMinor'>Minor: " . $eboard['minor'] . "</p>";
                }
              ?><div class='memDes'><?php
                if ($eboard['description'] != NULL) {
                  echo "<p>" . $eboard['description'] . "</p>";
                }
                if ($eboard['involvement'] != NULL) {
                  echo "<p><strong>Other Involvement:</strong> " . $eboard['involvement'] . "</p>";
                }
              ?></div>
              <?php if (is_admin_logged_in()) { ?>
                <form id="delete_member" action="members.php" method="post" enctype="multipart/form-data">
                  <input type="number" class="hidden" value=<?php echo $eboard['id'] ?> name="id"/>
                  <button name="delete_member" type="submit">Delete</button>
                </form>
              <?php } ?>
            </div>
          </div>
        </div>
      </div><?php
      }

    ?>

  </div>

      <!-- <figure class="group_mems_img"><img src="images/board1.jpg"><figcaption>Meet the wonderful members of our e-Board!</figcaption></figure> -->

  <div class="mem_page_logo_div">
    <img class="mem_page_logo" src="images/transparent_logo.png">
  </div>

  <?php include("includes/footer.php"); ?>
</body>

</html>

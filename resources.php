<?php
// INCLUDE ON EVERY TOP-LEVEL PAGE!
include("includes/init.php");


$title = "Resources";
$valid_edit = true;
$valid_new = true;
$edit_id;
?>
<!DOCTYPE html>
<html lang="en">

<?php include("includes/header.php");

$messages = array();
const MAX_FILE_SIZE = 2000000;


//process deletion
if (isset($_POST['delete'])) {
  //make a form to delete a current resource given by id
  $id = $_POST['delete'][0];
  $sql = "DELETE FROM resources WHERE id = :id";
  $params = array(':id' => $id);
  $results = exec_sql_query($db, $sql, $params);
}

// process edit
if (isset($_POST["make_edits"]) && is_admin_logged_in()) {
  $valid_edit = true;
  $upload_info = $_FILES["icon_file"];
  $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
  $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
  $link = filter_input(INPUT_POST, 'link', FILTER_SANITIZE_STRING);
  $link2 = filter_input(INPUT_POST, 'link2', FILTER_SANITIZE_STRING);
  $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);
  $id = $_POST['id'];

  //error messages are intialized at hidden
  $visibility = "hidden";

  //validate title
  if (trim($title) == "") {
    $valid_edit = FALSE;
    $error1 = "*please enter the resource title";
    $visibility = "visible";
  }
  //validate link
  if (trim($link) == "") {
    $valid_edit = FALSE;
    $error2 = "*please enter a link";
    $visibility = "visible";
  }

  if ($valid_edit) {
    $no_icon = $upload_info['error'] == UPLOAD_ERR_NO_FILE;
    if ($no_icon) {
      $set_updates = "title = :title, description = :description, link = :link, link2 = :link2, type = :type";
      $params = array(
        ':title' => $title,
        ':description' => $description,
        ':link' => $link,
        ':link2' => $link2,
        ':type' => $type
      );
    } else if ($upload_info['error'] == UPLOAD_ERR_OK) {
      $basename = basename($upload_info["name"]);
      $ext = strtolower(pathinfo($basename, PATHINFO_EXTENSION));
      $set_updates = $set_updates . ", ext = :ext'";
      $params = array_merge($params, array(':ext' => $ext));
    }
    $sql = "UPDATE resources SET " . $set_updates . " WHERE id= $id";
    $result = exec_sql_query($db, $sql, $params);
    if (!$no_icon) {
      $new_path = "uploads/resources/$id.$ext";
      move_uploaded_file($upload_info["tmp_name"], $new_path);
      array_push($messages, "upload success");
    } else {
      array_push($messages, "sql query error");
    }
  } else {
    array_push($messages, "upload unsuccesful");
    $edit_id = $id;
  }
}



// process additional content
if (isset($_POST["submit_new_resource"]) && is_admin_logged_in()) {
  $valid_new = true;
  $upload_info = $_FILES["icon_file"];
  $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
  $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
  $link = filter_input(INPUT_POST, 'link', FILTER_SANITIZE_STRING);
  $link2 = filter_input(INPUT_POST, 'link2', FILTER_SANITIZE_STRING);
  $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);

  //error messages are intialized at hidden
  $visibility = "hidden";

  //validate title
  if (trim($title) == "") {
    $valid_new = FALSE;
    $error1 = "*please enter the resource title";
    $visibility = "visible";
  }
  //validate link
  if (trim($link) == "") {
    $valid_new = FALSE;
    $error2 = "*please enter a link";
    $visibility = "visible";
  }

  //valid icon
  if ($upload_info['error'] == UPLOAD_ERR_NO_FILE) {
    $valid_new = FALSE;
    $error3 = "*please upload an image";
    $visiblity = "visible";
  }
  if ($valid_new) {
    if ($upload_info['error'] == UPLOAD_ERR_OK) {
      $basename = basename($upload_info["name"]);
      $ext = strtolower(pathinfo($basename, PATHINFO_EXTENSION));
      $sql = "INSERT INTO resources (ext, title, description, link, link2, type)
   VALUES (:ext, :title, :description, :link, :link2, :type)";
      $params = array(
        ':ext' => $ext,
        ':title' => $title,
        ':description' => $description,
        ':link' => $link,
        ':link2' => $link2,
        ':type' => $type
      );
      $result = exec_sql_query($db, $sql, $params);
      if ($result) {
        $id = $db->lastInsertID('id');
        $new_path = "uploads/resources/$id.$ext";
        move_uploaded_file($upload_info["tmp_name"], $new_path);
        array_push($messages, "upload success");
      } else {
        array_push($messages, "sql query error");
      }
    } else {
      array_push($messages, "upload unsuccessful");
    }
  } else {
    array_push($messages, "form not valid");
  }
}

//get resources from db
$sql = "SELECT * FROM resources WHERE type=:res_type";
$param_a = array('res_type' => "academic");
$param_e = array('res_type' => "external");
$results = exec_sql_query($db, $sql, $param_a);
if ($results) {
  $academic = $results->fetchAll();
}
$results = exec_sql_query($db, $sql, $param_e);
if ($results) {
  $external = $results->fetchAll();
}

// creates a new box for a resource
function create_resource_box($link, $icon, $title, $description, $link2, $citation, $id)
{
  ?>
  <li>
    <div class="resourceBox" id="<?php echo $title ?>">
      <div class="iconField">
        <a href="<?php echo htmlspecialchars($link) ?>" target="_blank">
          <img src=<?php echo $icon ?>>
        </a>
      </div>
      <?php if ($citation != NULL) { ?>
        <div class="citation">
          <p>Icon Source: <a href="<?php echo $citation ?>">
              <?php if (strlen($citation) > 30) {
                echo substr($citation, 0, 30);
              } else {
                echo $citation;
              } ?></a></p>
        </div>
      <?php } ?>
      <div class="textField">
        <div class="title">
          <a href="<?php echo htmlspecialchars($link) ?>" target="_blank">
            <h3> <?php echo htmlspecialchars($title) ?> </h3>
          </a>
        </div>
        <div class="description hideD" id="<?php echo $title ?>">
          <p> <?php echo ($description) ?> </p>
          <?php if ($link2 != NULL) {
            echo '<a href="' . htmlspecialchars($link2) . '"><p>' . htmlspecialchars($link2) . '</p></a>';
          } ?>
        </div>
        <?php if ($description != NULL) { ?>
          <div class="read-more">
            <p class='readBtn'>Read More</p>
            <p class='readBtn hidden'>Read Less</p>
          </div>
        <?php } ?>
      </div>
    </div>
    <?php if (is_admin_logged_in()) { ?>
      <form action="#form_loc" method="post">
        <button class="edit" name="edit[]" type="submit" value="<?php echo $id ?>">Edit</button>
      </form>
      <form action="" method="post" onsubmit="return confirmDelete()">
        <button type="submit" class="delete" name="delete[]" type="submit" value="<?php echo $id ?>">Delete</button>
      </form>
    <?php
  } ?>
  </li>
<?php
}

// create a form to edit existing data
function create_edit_form($id, $ext, $title, $des, $lnk, $lnk2, $type)
{
  global $visibility, $error1, $error2;
  ?>
  <h3>Edit Your Resource<h3>
      <form id="upload" action="resources.php" method="post" enctype="multipart/form-data">
        <ul>
          <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>" />
          <input type="hidden" name="id" value="<?php echo $id; ?>" />
          <input type="hidden" name="ext" value="<?php echo $ext; ?>" />
          <li> <label for="title">Name of resource:
              <span class="<?php echo ($visibility) ?>"><?php echo ($error1) ?></span>
            </label>
            <input type="text" id="title" value="<?php echo $title ?>" name="title"> </li>
          <li><label for="icon_file">Icon:</label>
            <input id="icon_file" type="file" name="icon_file" accept=".jpg, .jpeg, .png"></li>
          <li><label for="description">Description:</label>
            <textarea id="description" name="description"><?php echo $des ?></textarea></li>
          <li><label for="link">Link to resource website:
              <span class="<?php echo ($visibility) ?>"><?php echo ($error2) ?></span>
            </label>
            <input type="url" id="link" value="<?php echo $lnk ?>" name="link"></li>
          <li><label for="type">Type of resource:</label>
            <select id="type" name="type">
              <option <?php if ($type == 'academic') {
                        echo ("selected");
                      } ?> value="academic">Academic</option>
              <option <?php if ($type == 'external') {
                        echo ("selected");
                      } ?> value="external">External</option>
            </select></li>
          <li><label for="link2">Additional link:</label><input url="text" id="link2" value="<?php echo $lnk2 ?>" name="link2"></li>
          <button name="make_edits" type="submit">Edit Resource</button>
          <button name="cancel" href="<?php echo $_SERVER['HTTP_REFERER'] ?>">
            Cancel</button>
        </ul>
      </form>
    <?php } ?>


    <body>
      <?php include("includes/nav.php"); ?>

      <div class="wrapper">
        <div class='topOfPage resources'>
          <h1>Resources</h1>
        </div>

        <div class="container" id="form_loc">
          <?php
          if (isset($_POST['add_rsrc']) || !$valid_new) {
            // make a form to add a resource
            foreach ($messages as $message) {
              echo "<p>" . htmlspecialchars($message) . "</p>";
            } ?>
            <!-- upload form -->
            <h3>Add a New Resource </h3>
            <form id="upload" action="resources.php" method="post" enctype="multipart/form-data">
              <ul>
                <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>" />
                <li><label for="title">Name of resource:
                    <span class="<?php echo ($visibility) ?>"><?php echo ($error1) ?></span>
                  </label><input type="text" id="title" name="title"></li>
                <li><label for="icon_file">Icon:
                    <span class="<?php echo ($visibility) ?>"><?php echo ($error3) ?></span>
                  </label><input id="icon_file" type="file" name="icon_file" accept=".jpg, .jpeg, .png"></li>
                <li><label for="description">Description:</label><textarea id="description" name="description"></textarea></li>
                <li><label for="link">Link to resource website:
                    <span class="<?php echo ($visibility) ?>"><?php echo ($error2) ?></span>
                  </label><input type="url" id="link" name="link"> </li>
                <li><label for="type">Type of resource:</label><select id="type" name="type">
                    <option value="academic">Academic</option>
                    <option value="external">External</option>
                  </select></li>
                <li><label for="link2">Additional link:</label><input url="text" id="link2" name="link2"></li>
              </ul>
              <button name="submit_new_resource" type="submit">Submit New Resource</button>
              <button name="cancel" href="<?php echo $_SERVER['HTTP_REFERER'] ?>">
                Cancel</button>

            </form>
          <?php
        } else if (isset($_POST['edit']) || !$valid_edit) {
          if (!$valid_edit) {
            $id = $edit_id;
          } else {
            $id = $_POST['edit'][0];
          }
          //make a form to edit a current resource given by id
          $sql = "SELECT * FROM resources WHERE id=:id";
          $results = exec_sql_query($db, $sql, array('id' => $id));
          $rsrc_data = $results->fetchAll();
          create_edit_form($rsrc_data[0]['id'], $rsrc_data[0]['ext'], $rsrc_data[0]['title'], htmlspecialchars($rsrc_data[0]['description']), $rsrc_data[0]['link'], $rsrc_data[0]['link2'], $rsrc_data[0]['type']);
        } else { ?>
            <!-- retrieve resources from the database -->
            <div class="cont-resources">
              <!-- loop through all academic resources create that number of boxes -->
              <h2>Academic Resources</h2>
              <ul class="resource-grid">
                <?php
                foreach ($academic as $a) {
                  $icon_src = "uploads/resources/" . $a['id'] . "." . $a['ext'];
                  create_resource_box($a['link'], $icon_src, $a['title'], $a['description'], $a['link2'], $a['citation'], $a['id']);
                } ?>
              </ul>
            </div>
            <!-- loop through all other resources create that number of boxes -->
            <div class="cont-resources">
              <h2>External Resources</h2>
              <ul class="resource-grid">
                <?php
                foreach ($external as $e) {
                  $icon_src = "uploads/resources/" . $e['id'] . "." . $e['ext'];
                  create_resource_box($e['link'], $icon_src, $e['title'], $e['description'], $e['link2'], $e['citation'], $e['id']);
                }

                ?>
              </ul>
            </div>
          <?php } ?>

          <?php if (is_admin_logged_in() && !isset($_POST['add_rsrc']) && !isset($_POST['edit'])) { ?>
            <form action="#form_loc" method="post">
              <button class="add" name="add_rsrc" type="submit">+</button></button>
            </form>
          <?php
        } ?>
          <img class="about_page_logo" src="images/transparent_logo.png">
        </div>
      </div>
      <?php include("includes/footer.php"); ?>
    </body>

    <!-- Load JavaScript -->
    <script type="text/javascript" src="scripts/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="scripts/resources.js"></script>

</html>

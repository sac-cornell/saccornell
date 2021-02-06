<?php
include("includes/init.php");

$title = 'Edit Organization';

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $sql = "SELECT * FROM memberOrgs WHERE id = :id;";
    $params = array(
        ':id' => $id
    );
    $result = exec_sql_query($db, $sql, $params);
    if ($result) {
        $memOrgs = $result->fetchAll();
        if ( count($memOrgs) > 0 ) {
        $memOrg = $memOrgs[0];
        }
    }
}

function print_org_tags($db, $memOrg) {
    $sql = "SELECT DISTINCT tag_name FROM memberOrg_orgTags INNER JOIN orgTags ON memberOrg_orgTags.tag_id = orgTags.id WHERE org_id= :org_id";
    $params = array(
      ':org_id' => $memOrg['id']
    );
    $result = exec_sql_query($db, $sql, $params);
    if ($result) {
        $tags = $result->fetchAll();
    }
    $first = 0;
    foreach($tags as $tag) {
        if ($first > 0) {
            echo ", ";
        }
        $first = 1;
        echo $tag['tag_name'];
    }
}

function add_tag_to_org($db, $memOrg, $tag_name) {
    $sql = "SELECT * FROM orgTags WHERE tag_name = :tag_name;";
    $params = array(
      ':tag_name' => $tag_name
    );
    $result = exec_sql_query($db, $sql, $params);
    if ($result) {
        $tags = $result->fetchAll();
        if ( count($tags) > 0 ) {
          $tag = $tags[0];
        }
      }
    $sql2 = "SELECT * FROM memberOrg_orgTags WHERE tag_id = :tag_id AND org_id = :org_id;";
    $params2 = array(
    ':tag_id' => $tag['id'],
    ':org_id' => $memOrg['id']
    );
    $result2 = exec_sql_query($db, $sql2, $params2)->fetchAll();
    if( count($result2) == 0 ) {
        $sql3 = "INSERT INTO memberOrg_orgTags(org_id, tag_id) VALUES (:org_id, :tag_id);";
        $params3 = array(
            ':org_id' => $memOrg['id'],
            ':tag_id' => $tag['id']
        );
        $result3 = exec_sql_query($db, $sql3, $params3);
    }
  }

  if ( isset($_POST["submit_tag"]) && is_admin_logged_in() ) {
    $new_tag = filter_input(INPUT_POST, 'new_tag', FILTER_SANITIZE_STRING);
    $sql = "SELECT * FROM orgTags WHERE tag_name = :tag_name;";
    $params = array(
      ':tag_name' => $new_tag
    );
    $result = exec_sql_query($db, $sql, $params)->fetchAll();
    if( count($result) == 0 ) {
        $sql2 = "INSERT INTO orgTags(tag_name) VALUES (:tag_name);";
        $params2 = array(
        ':tag_name' => $new_tag
        );
        $result = exec_sql_query($db, $sql2, $params2) -> fetchAll();
        add_tag_to_org($db, $memOrg, $new_tag);
    }
}

if ( isset($_POST["submit_tag2"]) && is_admin_logged_in() ) {
    $existing_tag = filter_input(INPUT_POST, 'existing_tag', FILTER_SANITIZE_STRING);
    add_tag_to_org($db, $memOrg, $existing_tag);
}

if ( isset($_POST["submit_tag3"]) && is_admin_logged_in() ) {
    $applied_tag = filter_input(INPUT_POST, 'applied_tag', FILTER_SANITIZE_STRING);
    $sql = "SELECT * FROM orgTags WHERE tag_name = :tag_name;";
    $params = array(
    ':tag_name' => $applied_tag
    );
    $result = exec_sql_query($db, $sql, $params);
    if ($result) {
        $tags = $result->fetchAll();
        if ( count($tags) > 0 ) {
        $tag = $tags[0];
        }
    }
    $sql2 = "SELECT * FROM memberOrg_orgTags WHERE org_id= :org_id AND tag_id= :tag_id";
    $params2 = array(
    ':tag_id' => $tag['id'],
    ':org_id' => $memOrg['id']
    );
    $result2 = exec_sql_query($db, $sql2, $params2)->fetchAll();
    if( count($result2) > 0 ) {
        $sql3 = "DELETE FROM memberOrg_orgTags WHERE org_id= :org_id AND tag_id= :tag_id;";
        $params3 = array(
        ':tag_id' => $tag['id'],
        ':org_id' => $memOrg['id']
        );
        $result3 = exec_sql_query($db, $sql3, $params3) -> fetchAll();
    }
}

$db->beginTransaction();
if (isset($_POST["editOrg"]) && is_admin_logged_in()) {
    $valid_edit = TRUE;
    $orgTitle = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $orgDescription = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $id = $memOrg['id'];

    $visibility = "hidden";

    if (trim($orgTitle) == "") {
      $valid_edit = FALSE;
      $error1 = "*please enter the organization title";
      $visibility = "visible";
    }
    if (trim($orgDescription) == "") {
      $valid_edit = FALSE;
      $error2 = "*please enter a description";
      $visibility = "visible";
    }

    if ($valid_edit) {
      $set_updates = "name = :name, desc = :desc";
      $params = array(
         ':name' => $orgTitle,
         ':desc' => $orgDescription
      );
      $sql = "UPDATE memberOrgs SET " . $set_updates . " WHERE id= $id";
      $result = exec_sql_query($db, $sql, $params);
    } else {
      array_push($messages, "upload unsuccesful");
      $edit_id = $id;
    }
    $sql = "SELECT * FROM memberOrgs WHERE id = :id;";
    $params = array(
        ':id' => $id
    );

    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $sql = "SELECT * FROM memberOrgs WHERE id = :id;";
    $params = array(
        ':id' => $id
    );
    $result = exec_sql_query($db, $sql, $params);
    if ($result) {
        $memOrgs = $result->fetchAll();
        if ( count($memOrgs) > 0 ) {
        $memOrg = $memOrgs[0];
        }
    }
  }
  $db->commit();

?>
<!DOCTYPE html>
<html lang="en">

<?php include("includes/header.php"); ?>

<body>
<?php include("includes/nav.php"); ?>
    <div class='topOfPage orgs'>
        <h1><?php echo $title; ?></h1>
    </div>
    <div id="edit_org">
        <div id="edit_org_left">
            <h3>Edit this organization: <?php echo htmlspecialchars($memOrg['name']);?><h3>
            <form id="editOrg" action="editorg.php?id=<?php echo $memOrg['id']; ?> " method="post" enctype="multipart/form-data">
                <ul>
                    <li> <label for="title">Name of organization:</label><br />
                        <input type="text" id="title" value="<?php echo $memOrg['name'] ?>" name="title"> </li>
                    <li><label for="description">Description:</label>
                        <textarea id="description" name="description"><?php echo $memOrg['desc'] ?></textarea></li>
                    <button name="editOrg" type="submit">Edit Organization</button>
                    <a href="organizations.php" class="button"> Back to Organizations </a>
                </ul>
            </form>
        </div>
        <div id="edit_org_right">
            <?php if(isset($memOrg) && is_admin_logged_in()) { ?>
                <p> Current tags for this organization: <?php print_org_tags($db, $memOrg) ?></p>
                <h3> Add tags to this organization: </h3>
                    <form id="addNewTag" action="editorg.php?id=<?php echo $memOrg['id']; ?> " method="post" enctype="multipart/form-data">
                        <ul>
                            <li>
                            <label for="new_tag">Create a new tag and add it to this organization: </label> <br />
                            <input id="new_tag" type="text" name="new_tag">
                            </li>
                            <li>
                            <button name="submit_tag" type="submit">Add Tag</button>
                            </li>
                        </ul>
                    </form>
                    <h3> Add an existing tag to this organization: </h3>
                    <form id="addExistingTag" action="editorg.php?id=<?php echo $memOrg['id']; ?> " method="post" enctype="multipart/form-data">
                        <ul>
                            <li>
                            <label for="existing_tag">Select an existing tag and add it to this organization: </label> <br />
                            <select name="existing_tag">
                                <?php $sql = "SELECT DISTINCT tag_name FROM orgTags";
                                $params = array();
                                $result = exec_sql_query($db, $sql, $params);
                                if ($result) {
                                    $tags = $result->fetchAll();
                                }
                                foreach($tags as $tag) {
                                    echo "<option value=" . $tag['tag_name'] . ">" . $tag['tag_name'] . "</option>";
                                }
                                ?>
                            </select>
                            </li>
                            <li>
                            <button name="submit_tag2" type="submit">Add Tag</button>
                            </li>
                        </ul>
                    </form>
                    <h3> Remove an applied tag from this organization: </h3>
                    <form id="removeAppliedTag" action="editorg.php?id=<?php echo $memOrg['id']; ?> " method="post" enctype="multipart/form-data">
                        <ul>
                            <li>
                            <label for="applied_tag">Select an applied tag and remove it from this organization: </label> <br />
                            <select name="applied_tag">
                                <?php $sql = "SELECT DISTINCT tag_name FROM memberOrg_orgTags INNER JOIN orgTags ON memberOrg_orgTags.tag_id = orgTags.id WHERE org_id= :org_id";
                                $params = array(
                                ':org_id' => $memOrg['id']
                                );
                                $result = exec_sql_query($db, $sql, $params);
                                if ($result) {
                                    $tags = $result->fetchAll();
                                }
                                foreach($tags as $tag) {
                                    echo "<option value=" . $tag['tag_name'] . ">" . $tag['tag_name'] . "</option>";
                                }
                                ?>
                            </select>
                            </li>
                            <li>
                            <button name="submit_tag3" type="submit">Remove Tag</button>
                            </li>
                        </ul>
                    </form>
                    <h3> Delete this organization </h3>
                    <form id="deleteOrg" action=<?php echo "organizations.php?" . http_build_query( array( 'id' => $memOrg['id'] ) ); ?>
                    method="post" enctype="multipart/form-data">
                        <button name="submit_delete" type="submit">Delete Organization</button>
                    </form>
                 </div>
        <?php } else {?>
            <h2> Only the Admin can edit organizations. </h2>
        <?php } ?>
    </div>
</body>
<?php include("includes/footer.php"); ?>
</html>

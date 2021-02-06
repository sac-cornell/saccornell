<?php
// INCLUDE ON EVERY TOP-LEVEL PAGE!
include("includes/init.php");
$title = "Member Organizations";
$fullNumber = count(exec_sql_query($db, "SELECT * FROM memberOrgs;")->fetchAll());
function printOrg($id, $name, $desc) {
    echo "<tr>";
    if (is_admin_logged_in()) {
        echo "<td> <a href=\"editorg.php?" . http_build_query( array( 'id' => $id ) ) . "\" class=\"button\"> Edit </a></td>";
    }
    echo "<th>" . htmlspecialchars($name) . "</th>" . "<td>" . htmlspecialchars($desc) . "</td></tr>";
  }
if ( isset($_GET['search']) ) {
    $execute_search = TRUE;
    $search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING);
    $search = trim($search);
    $sql3 = "SELECT * FROM memberOrgs WHERE name LIKE '%' || :search || '%' OR desc LIKE '%' || :search || '%' ORDER BY name;";
    $params3 = array(
    ':search' => $search);
    $result3 = exec_sql_query($db, $sql3, $params3);
    $organizations = $result3->fetchAll();
  } else {
    if ( isset($_POST["submit_tag"])) {
        $search_tag = filter_input(INPUT_POST, 'search_tag', FILTER_SANITIZE_STRING);
        $sql = "SELECT * FROM orgTags WHERE tag_name = :tag_name;";
        $params = array(
        ':tag_name' => $search_tag
        );
        $result = exec_sql_query($db, $sql, $params);
        if ($result) {
            $tags = $result->fetchAll();
            if ( count($tags) > 0 ) {
            $tag = $tags[0];
            }
        }
        $sql2 = "SELECT memberOrgs.id, memberOrgs.name, memberOrgs.desc FROM memberOrgs INNER JOIN memberOrg_orgTags ON memberOrg_orgTags.org_id = memberOrgs.id WHERE memberOrg_orgTags.tag_id= :tag_id ORDER BY name;";
        $params2 = array(
        ':tag_id' => $tag['id']
        );
        $result2 = exec_sql_query($db, $sql2, $params2);
        $organizations = $result2->fetchAll();
    } else {
        $organizations = exec_sql_query($db, "SELECT * FROM memberOrgs ORDER BY name;")->fetchAll();
        $search = NULL;
    }
  }
  if ( isset($_POST["submit_delete"]) && is_admin_logged_in()) {
    $del_org_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $sql = "DELETE FROM memberOrg_orgTags WHERE org_id=:org_id";
    $params = array(
    ':org_id' => $del_org_id
    );
    $result = exec_sql_query($db, $sql, $params)->fetchAll();
    $sql2 = "DELETE FROM memberOrgs WHERE id=:org_id";
    $params2 = array(
    ':org_id' => $del_org_id
    );
    $result2 = exec_sql_query($db, $sql2, $params2)->fetchAll();
    $organizations = exec_sql_query($db, "SELECT * FROM memberOrgs ORDER BY name;")->fetchAll();
    $fullNumber = count($organizations);
  }
  if (isset($_POST["addOrg"]) && is_admin_logged_in()) {
    $valid_new = TRUE;
    $orgTitle = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $orgDescription = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    //error messages are intialized at hidden
    $visibility = "hidden";
    if (trim($orgTitle) == "") {
        $valid_new = FALSE;
        $error1 = "*please enter the organization title";
        $visibility = "visible";
      }
    if (trim($orgDescription) == "") {
        $valid_new = FALSE;
        $error2 = "*please enter a description";
        $visibility = "visible";
    }
    if ($valid_new) {
      if ($upload_info['error'] == UPLOAD_ERR_OK) {
        $sql = "INSERT INTO memberOrgs (name, desc) VALUES (:name, :desc)";
        $params = array(
          ':name' => $orgTitle,
          ':desc' => $orgDescription
        );
        $result = exec_sql_query($db, $sql, $params);
        $organizations = exec_sql_query($db, "SELECT * FROM memberOrgs ORDER BY name;")->fetchAll();
        $fullNumber = count($organizations);
      } else {
        array_push($messages, "upload unsuccessful");
      }
    } else {
      array_push($messages, "form not valid");
    }
  }
?>
<!DOCTYPE html>
<html lang="en">

<?php include("includes/header.php"); ?>

<body>
<?php include("includes/nav.php"); ?>

    <div class='topOfPage orgs'>
        <h1><?php echo htmlspecialchars($title); ?></h1>
    </div>

    <?php if (isset($_POST['add_org'])) { ?>
        <div id="edit_org">
            <h2>Add an organization<h2> <br />
            <p> Fill in both the name and the description, otherwise if you press add, it will not add the incomplete organization. </p>
            <form id="addOrg" action="organizations.php" method="post" enctype="multipart/form-data">
                <ul>
                    <li> <label for="title">Name of organization:</label><br />
                        <input type="text" id="title" name="title"> </li>
                    <li><label for="description">Description:</label>
                        <textarea id="description" name="description"></textarea></li>
                    <button name="addOrg" type="submit">Add Organization</button>
                    <a href="organizations.php" class="button"> Cancel </a>
                </ul>
            </form>
        </div>
    <?php } else { ?>
        <div class="org_page">
            <div id="flexParent">
                <div id="flexChild">
                    <form id="searchForm" method="get" action="organizations.php">
                        <label for="search"> Search:</label><br />
                        <input id="search" type="text" name="search" value="<?php echo htmlspecialchars($search) ?>">
                        <button name="submit_search" type="submit">Go</button>
                    </form>
                </div>
                <div id="flexChild">
                    <form id="searchTag" action="organizations.php" method="post" enctype="multipart/form-data">
                        <ul>
                            <li>
                                <label for="search_tag">Show organizations with the tag: </label> <br />
                                <select name="search_tag">
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
                                <button name="submit_tag" type="submit">Show</button>
                                <button onclick="window.location.href = 'organizations.php';">View All Organizations</button>
                            </li>
                        </ul>
                    </form>
                </div>
            </div>
            <table>
            <?php
                if (count($organizations) > 0) {
                    foreach ($organizations as $org) {
                        printOrg($org['id'], $org['name'], $org['desc']);
                    }
                } else {
                    echo "<p> No organizations found. </p>";
                }
            ?>
            </table>
            <?php
            if (count($organizations) < $fullNumber) { ?>
                <button id="allButton" onclick="window.location.href = 'organizations.php';">View All Organizations</button>
            <?php } ?>

            <?php if (is_admin_logged_in() && !isset($_POST['add_org'])) { ?>
                <form action="" method="post">
                <button class="add" name="add_org" type="submit">+</button>
                </form>
            <?php
            } ?>

            <img class="about_page_logo" src="images/transparent_logo.png">
        </div>
        <?php } ?>

<?php include("includes/footer.php"); ?>

</body>
</html>

<?php
$pages = [
    ['about.php', 'About'],
    ['events.php', 'Events'],
    ['organizations.php', 'Member Organizations'],
    ['members.php', 'Members'],
    ['resources.php', 'Resources'],
    ['contact.php', 'Contact']
];
$current_page = basename($_SERVER['PHP_SELF']);
?>

<header>
    <nav>
        <div id='nav'>
            <div><a href='index.php'><img src='/images/transparent_logo.png'></a></div>
            <div>
                <ul id="navbar">
                    <?php
                    foreach ($pages as $page) {
                        if ($page[0] == $current_page) {
                            echo "<li><a class='current' href='" . $page[0] . "'>" . $page[1] . "</a><li>";
                        } else {
                            echo "<li><a href='" . $page[0] . "'>" . $page[1] . "</a><li>";
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
</header>

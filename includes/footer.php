<footer>
    <div class='flexRight'>
        <!-- Logo from South Asian Council-->
        <div id='footerAbt'>
            <img src="images/transparent_logo.png" class="logo">
            <p>South Asian Council aims to empower all South Asian community members at Cornell University.</p>
        </div>
        <div id='socials'>
            <a href='https://www.facebook.com/SouthAsianCouncilCornell/' target='_blank'>
                <div class='mediaIcon'>
                    <img class='hover' src='/images/fbfill.png'>
                    <img class='top' src='/images/fb.png'>
                </div>
            </a>
            <a href='https://www.instagram.com/sac_cornell/' target='_blank'>
                <div class='mediaIcon'>
                    <img class='hover' src='/images/igfill.png'>
                    <img class='top' src='/images/ig.png'>
                </div>
            </a>
        </div>

        <div id="adminLogin">
        <?php if (is_admin_logged_in()) { ?>
            <form id="logoutForm" ction="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <button name="logout" type="submit">Logout</button>
            <?php } else { ?>
                <h3> Admin Login </h3>
                <form id="loginForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <ul>
                        <li>
                            <label for="username">Username: </label>
                        </li>
                        <li>
                            <input id="username" type="text" name="un" />
                        </li>
                        <li>
                            <label for="pw">Password: </label>
                        </li>
                        <li>
                            <input id="password" type="password" name="pw" />
                        </li>
                        <li>
                            <button name="login" type="submit">Sign In</button>
                        </li>
                    </ul>
                </form>
            <?php } ?>
        </div>
    </div>

    <div class='flexRow'>
        <div class='citation'>
            <p>Icons Source: <a href="https://iconmonstr.com/">iconmonstr</a></p>
            <p>Lustria Font Source: <a href="https://www.1001fonts.com/lustria-font.html">1001 Fonts</a></p>
            <p>Lato Font Source: <a href="https://www.fontsquirrel.com/fonts/lato">Font Squirrel</a></p>
        </div>
    </div>

</footer>

<?php
    session_start();
    include 'connect.php';
    include 'includes/header.php';
?>

<body>
    <div class="body-container">
        <section>
            <h1>About Us</h1>
        </section>

        <section class="content-container">
            <div class="description">
                <img src="images/paul.jpg" alt="Me">
                <h2>Paul Thomas M. Abellana</h2>
                <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                    sed do eiusmod tempor incididunt ut labore et dolore magna
                    aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                    ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    Duis aute irure dolor in reprehenderit in voluptate velit
                    esse cillum dolore eu fugiat nulla pariatur. Excepteur sint
                    occaecat cupidatat non proident, sunt in culpa qui officia
                    deserunt mollit anim id est laborum."
                </p>
            </div>
            <div class="description">
                <img src="images/chavez.jpg" alt="Me">
                <h2>Francis Benedict Y. Chavez</h2>
                <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                    sed do eiusmod tempor incididunt ut labore et dolore magna
                    aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                    ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    Duis aute irure dolor in reprehenderit in voluptate velit
                    esse cillum dolore eu fugiat nulla pariatur. Excepteur sint
                    occaecat cupidatat non proident, sunt in culpa qui officia
                    deserunt mollit anim id est laborum."
                </p>
            </div>
        </section>
    </div>
</body>

<?php
    require_once 'includes/footer.php';
?>
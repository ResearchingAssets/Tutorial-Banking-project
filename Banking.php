<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="https://w7.pngwing.com/pngs/848/762/png-transparent-computer-icons-home-house-home-angle-building-rectangle-thumbnail.png">
    <link rel="stylesheet" href="Banking.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <title>PocketBank</title>
    <script defer src="Banking.js"></script>
</head>

<body class="body-container">
    <div class="lines">
        <div class="left"></div>
        <div class="right"></div>
    </div>
    <header class="header">
        <a href="#" class="Name">PocketBank</a>
        <nav class="navbar">
        <a href="#" class="sign-up-link">Sign up</a>
            <a href="#" class="about-link">About</a>
            <a href="#" class="news-link">News</a>
            <a href="#" class="contact-us-link">Contact us</a>
            <span id="change-icon" onclick="modeChange()">💡</span>
        </nav>
    </header>
    <section class="login-container">
    <form class="login" action="" method="POST">
        <h2>Welcome, user!</h2>
        <p>Please log in.</p>
        <input type="text" placeholder="User Name" name="username-confirm" required/>
        <input type="password" placeholder="Password" name="password-confirm" required/>
        <input type="submit" value="Submit" name="login-submit"/><br>
    </form>

    <?php
    // Initialize an error message variable
    $error_message = "";

    // Database connection settings
    $servername = "localhost";  // Server name (usually localhost for XAMPP)
    $dbusername = "root";       // Default username for XAMPP
    $dbpassword = "";           // Default password for XAMPP (empty)
    $dbname = "bank";           // Database name

    // Create a connection
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    session_start();  // Start the session

// Database connection and login logic

if (isset($_POST['login-submit'])) {
    $username = $_POST['username-confirm'];
    $password = $_POST['password-confirm'];

    // Prepare SQL statement to search for the username and password in the database
    $stmt = $conn->prepare("SELECT * FROM banking WHERE Username = ? AND Password = ?");
    $stmt->bind_param("ss", $username, $password);

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Store the username in a session variable
        $_SESSION['loggedin_username'] = $username;

        // Redirect to the success page
        echo "<br><br><p>Login successful. You will be redirected in 3 seconds.</p>";
            echo "<script>
                setTimeout(function(){
                    window.location.href = 'BankingLoginSuccess.php';
                }, 3000);  // Wait 5 seconds before redirecting
                </script>";
        exit();
    } else {
        echo '<br><br><p>Invalid username or password. Please sign up.</p>';
    }

    $stmt->close();
}
$conn->close();
    ?>
</section>


<section class="sign-up-container">
    <form class="sign-up" method="POST" action="">
        <h2>Welcome, user!</h2>
        <p>Please sign up.</p>
        <input type="text" placeholder="User Name" name="username" required/>
        <input type="password" id="pass" placeholder="Password" name="password" required/>
        <input type="submit" value="Sign up" name="signup-submit"/>
    </form>

    <?php
    // Database connection settings
    $servername = "localhost";  // Server name (usually localhost for XAMPP)
    $dbusername = "root";       // Default username for XAMPP
    $dbpassword = "";           // Default password for XAMPP (empty)
    $dbname = "bank";           // Database name

    // Create a connection
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the sign-up form was submitted
    if (isset($_POST['signup-submit'])) {
        $user = $_POST['username'];
        $pass = $_POST['password'];

        // Prepare SQL statement to insert into the 'banking' table (for user sign-up)
        $stmt = $conn->prepare("INSERT INTO banking (Username, Password) VALUES (?, ?)");
        $stmt->bind_param("ss", $user, $pass);

        // Execute the statement
        if ($stmt->execute()) {
            // If sign-up is successful, insert the username into the 'bankbalance' table
            $stmt->close();

            // Prepare another statement to insert the username into 'bankbalance', leaving balance empty
            $balance_stmt = $conn->prepare("INSERT INTO bankbalance (Username, Balance) VALUES (?, 00.00)");
            $balance_stmt->bind_param("s", $user);

            // Execute the statement for 'bankbalance'
            if ($balance_stmt->execute()) {
                echo "<script>
                alert('Sign-up successful. Please login now.');
                </script>";
            } else {
                echo "Error inserting into bankbalance: " . $balance_stmt->error;
            }

            $balance_stmt->close();
        } else {
            echo "Error signing up: " . $stmt->error;
        }

        // Close the connection
        $conn->close();
    }
    ?>
</section>

    <section class="about">
        <h1 class="name">Hey, we are <span class="colored-name">developers!</span></h1>
        <p class="myself">Being students of class 8 of Narayana School, We, Soumit, Swarnabh, Poojith, Yubaraj, Keshava, and Pratik have contributed to this e-Banking project with all our determination, dedication, and hard work. We believe that this will give satisfactory results.</p>
    </section>

    <section class="news">
        <span class="update-title">Recent updates</span>
    </section>

    <section class="contact-us">
        <h1></h1>
        <div class="contact-container">
            <div class="box">
                <span></span>
                <div class="content">
                    <h2>GMAIL</h2>
                    <p>info.soumit@gmail.com <br>
                        tpspoojithap@gmail.com <br>
                        blyubarajkayal@gmail.com <br>
                        keshavamurry@gmail.com <br>
                        YTindiangaming50@gmail.com <br>
                        alley@gmail.com
                    </p>
                </div>
            </div>
        </div>
        <h3><span class="colored-name">Facing any problems? Contact developers now!</span></h3>
    </section>
</body>
</html>
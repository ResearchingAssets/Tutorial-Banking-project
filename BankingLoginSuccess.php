
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="shortcut icon" href="https://w7.pngwing.com/pngs/848/762/png-transparent-computer-icons-home-house-home-angle-building-rectangle-thumbnail.png">
        <link rel="stylesheet" href="BankingAfter.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <title>PocketBank</title>

        <script defer src="BankingAfter.js"></script>
    </head>

    <body class="body-container">
        <div class="lines">
            <div class="left"></div>
            <div class="right"></div>
        </div>
        <header class="header">
            <a href="#" class="Name">PocketBank</a>
            <nav class="navbar">
                <a href="#" class="banking-options-link">Banking</a>
                <a href="#" class="about-link">About</a>
                <a href="#" class="news-link">News</a>
                <a href="#" class="contact-us-link">Contact us</a>
                <span id="change-icon" onclick="modeChange()">
                    💡
                </span>
            </nav>
        </header>
        <section class="welcome">
        <?php
session_start();  // Start the session

if (isset($_SESSION['loggedin_username'])) {
    $username = $_SESSION['loggedin_username'];

    // Connect to the database
    $servername = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "bank";
    
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    ?>
    <span class="welcomeText">Welcome,</span>&nbsp;
    <span class="usernameText"><?php echo $username . "!<br>" ?></span><br>
    <?php
    
    // Check if the user already has a balance in the database
    $stmt = $conn->prepare("SELECT Balance FROM bankbalance WHERE Username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If balance exists, fetch it
        $row = $result->fetch_assoc();
        $balance = $row['Balance'];

        if ($balance == 0.00) {
            // If balance is 0.00, generate a new balance
            $balance = round(rand(1, 100000) + (rand(0, 99) / 100), 2);
            
            // Insert the generated balance into the database
            $insert_stmt = $conn->prepare("UPDATE bankbalance SET Balance = ? WHERE Username = ?");
            $insert_stmt->bind_param("ds", $balance, $username);
            
            if ($insert_stmt->execute()) {
                echo "";
            } else {
                echo "Error updating balance: " . $insert_stmt->error . "<br>";
            }
            $insert_stmt->close();
        } else {
            echo "";
        }
    } else {
        // If no balance exists, initialize with 0.00
        $balance = 0.00;
        
        // Insert the initialized balance into the database
        $insert_stmt = $conn->prepare("INSERT INTO bankbalance (Username, Balance) VALUES (?, ?)");
        $insert_stmt->bind_param("sd", $username, $balance);
        
        if ($insert_stmt->execute()) {
            echo "Balance successfully initialized in the database.<br>";
        } else {
            echo "Error initializing balance: " . $insert_stmt->error . "<br>";
        }
        $insert_stmt->close();
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Please log in first.";
    exit;
}
?>

<!-- Display the balance in the HTML -->
<span class="balance">Balance: <span class="balance-amount"><?php echo $balance; ?></span></span>

        </section>
        <section class="options">
            <div class="options-grid">
        <button class="grid-item"><span class="text">Transactions</span></button>
        <button class="grid-item"><span class="text">QR Code Scanner</span></button>
        <button class="grid-item"><span class="text">Transaction History</span></button>
        <button class="grid-item"><span class="text">Mini statement</span></button>
        <button class="grid-item"><span class="text">Download transaction history</span></button>
        <button class="grid-item"><span class="text">Download mini statement</span></button>
        </div>
        </section>
        <section class="about">
                    <h1 class="name">
                        Hey, we are
                        <span class="colored-name">
                            developers!
                        </span>
                    </h1>
                    <p class="myself">Being students of class 8 of Narayana School, We, Soumit, Swarnabh, Poojith and Pratik have contributed to this e-Banking project with all our determination, dedication and hard work. We believe that this will give satisfactory result.</p>
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
                    blyubarajkayal@gmail.com
                    </p>
                    </div>
                  </div>
               </div>   
            <h3><span class="colored-name">Facing any problems? Contact developers now!</span></h3>           
        </section>
    </body>
</html>

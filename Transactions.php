<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="shortcut icon" href="https://w7.pngwing.com/pngs/848/762/png-transparent-computer-icons-home-house-home-angle-building-rectangle-thumbnail.png">
        <link rel="stylesheet" href="Transactions.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <title>PocketBank</title>

        <script defer src="Transactions.js"></script>
    </head>
    <body class="body-container">
    <div class="lines">
            <div class="left"></div>
            <div class="right"></div>
        </div>
        <header class="header">
    <div class="Name">
        <a href="#" class="title">PocketBank</a>
        <?php
            session_start(); // Start the session

            if (isset($_SESSION['loggedin_username'])) {
                $username = $_SESSION['loggedin_username'];

                // Database connection details
                $servername = "localhost";
                $dbusername = "root";
                $dbpassword = "";
                $dbname = "bank";

                // Connect to the database
                $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch the balance for the logged-in user
                $stmt = $conn->prepare("SELECT Balance FROM bankbalance WHERE Username = ?");
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $balance = $row['Balance'];

                    // Display username and balance
                    echo "<span class='display'>User: " . htmlspecialchars($username) . " | Balance: " . htmlspecialchars($balance) . "</span>";
                }

                $stmt->close();
                $conn->close();
            }
        ?>
    </div>
            <nav class="navbar">
                <a href="#" class="about-link">About</a>
                <a href="#" class="news-link">News</a>
                <a href="#" class="contact-us-link">Contact us</a>
                <span id="change-icon" onclick="modeChange()">
                    💡
                </span>
            </nav>
        </header>
        <section class="transactions">
        <form class="transactMoney" method="POST" action="">
            <h2>TRANSACTIONS</h2>
            <p>Withdraw or deposit money!</p>
            <input type="number" placeholder="Amount of money" name="AmountOfMoney" required/>
            <div class="dropdown">
                <select id="options" name="transactionType" required>
                <option value="" disabled selected>Select an option</option>
                <option value="withdraw">Withdraw money</option>
                <option value="deposit">Deposit money</option>
            </select>
            <input type="password" id="pass" placeholder="Password" name="password" required/>
            <input type="submit" value="Sign up" name="transaction-submit"/>
        </form>
        <?php

            
        // Check if the user is logged in
        if (!isset($_SESSION['loggedin_username'])) {
            die("You are not logged in.");
        }

        // Database connection details
        $servername = "localhost";
        $dbusername = "root"; // Change if your database username is different
        $dbpassword = ""; // Change if your database password is different
        $dbname = "bank"; // Database name

        // Create a connection to the database
        $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch the balance for the logged-in user
        $username = $_SESSION['loggedin_username'];
        $stmt = $conn->prepare("SELECT Balance FROM bankbalance WHERE Username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $balance = 0; // Default balance
        $maxBalance = 100000;

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $balance = $row['Balance'];
        }

        // Process transaction if form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get the amount and password from the form
            $amountOfMoney = $_POST['AmountOfMoney'] ?? 0; 
            $password = $_POST['password'] ?? ''; 
        
            // Step 1: Verify the password
            $stmt = $conn->prepare("SELECT Password FROM banking WHERE Username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
        
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                
                if ($row['Password'] === $password) {
                    // Step 2: Fetch the current balance
                    $stmt = $conn->prepare("SELECT Balance FROM bankbalance WHERE Username = ?");
                    $stmt->bind_param("s", $username);
                    $stmt->execute();
                    $result = $stmt->get_result();
        
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $currentBalance = $row['Balance'];
        
                        // Step 3: Check if the transaction is valid
                        if ($_POST['transactionType'] === 'withdraw') {
                            // Check if the user has enough balance
                            if ($amountOfMoney > $currentBalance) {
                                echo "<script>alert('Transaction failed due to insufficient funds.');</script>";
                            } else {
                                // Update the balance after withdrawal
                                $newBalance = $currentBalance - $amountOfMoney;
                                $stmt = $conn->prepare("UPDATE bankbalance SET Balance = ? WHERE Username = ?");
                                $stmt->bind_param("is", $newBalance, $username);
                                $stmt->execute();
                                echo "<script>alert('Withdrawal successful. Your new balance is: " . htmlspecialchars($newBalance) . "');</script>";
                            }
                        } elseif ($_POST['transactionType'] === 'deposit') {
                            // Calculate new balance after deposit
                            $newBalance = $currentBalance + $amountOfMoney;
        
                            // Check if the new balance exceeds the maximum limit
                            if ($newBalance > $maxBalance) {
                                echo "<script>alert('Transaction failed. Maximum balance limit of " . number_format($maxBalance) . " exceeded.');</script>";
                            } else {
                                // Update the balance after deposit
                                $stmt = $conn->prepare("UPDATE bankbalance SET Balance = ? WHERE Username = ?");
                                $stmt->bind_param("is", $newBalance, $username);
                                $stmt->execute();
                                echo "<script>alert('Deposit successful. Your new balance is: " . htmlspecialchars($newBalance) . "');</script>"; 
                            }
                        }
        
                        echo "<script>
                        setTimeout(function() {
                            window.location.href = '" . htmlspecialchars($_SERVER['PHP_SELF']) . "';
                        }, 1000); // Redirect after 1000 milliseconds (1 seconds)
                    </script>";
                    } else {
                        echo "<script>alert('No balance information found.');</script>";
                    }
                } else {
                    echo "<script>alert('Invalid password.');</script>";
                }
            } else {
                echo "<script>alert('User not found.');</script>";
            }
        
            // Close the statement
            $stmt->close();
        }
        // Close the connection
        $conn->close();
        ?>
        </section>
        <section class="about">
                    <h1 class="Greetings">
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

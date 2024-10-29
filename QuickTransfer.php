<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="shortcut icon" href="https://w7.pngwing.com/pngs/848/762/png-transparent-computer-icons-home-house-home-angle-building-rectangle-thumbnail.png">
        <link rel="stylesheet" href="QuickTransfer.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <title>PocketBank</title>

        <script defer src="QuickTransfer.js"></script>
    </head>
    <body class="body-container">
    <?php
    session_start(); // Start the session

if (isset($_SESSION['transfer_success'])) {
    echo "<script>alert('" . $_SESSION['transfer_success'] . "');</script>";
    unset($_SESSION['transfer_success']); // Clear the message after showing
}
?>
    <div class="lines">
            <div class="left"></div>
            <div class="right"></div>
        </div>
        <header class="header">
    <div class="Name">
        <a href="#" class="title">PocketBank</a>
        <?php

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
                <a href="BankingLoginSuccess.php" class="home-link">Home</a>
                <a href="#" class="about-link">About</a>
                <a href="#" class="news-link">News</a>
                <a href="#" class="contact-us-link">Contact us</a>
                <span id="change-icon" onclick="modeChange()">
                    💡
                </span>
            </nav>
        </header>
        <section class="QuickTransfer">
        <form class="transactMoney" method="POST" action="" onsubmit="return validateAmount()">
            <h2>QUICK TRANSFER</h2>
            <p>Transfer money right now!</p>
            <input type="text" placeholder="Receiver's Username" name="receiver_username" required/>
            <input type="number" placeholder="Amount of money" name="AmountOfMoney" required/>
            <input type="password" id="pass" placeholder="Password" name="password" required/>
            <input type="submit" value="Transfer!" name="transfer-submit"/>
        </form>
        <?php
        ob_start();
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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['transfer-submit'])) {
    // Get the form inputs
    $receiverUsername = $_POST['receiver_username'];
    $transferAmount = $_POST['AmountOfMoney'];
    $userPassword = $_POST['password'];
    $currentUser = $_SESSION['loggedin_username']; // Current logged-in user

    // 1) Validate the current user's password
    $stmt = $conn->prepare("SELECT Password FROM banking WHERE Username = ?");
    $stmt->bind_param("s", $currentUser);
    $stmt->execute();
    $stmt->bind_result($dbPassword);
    $stmt->fetch();
    $stmt->close();

    if ($userPassword !== $dbPassword) {
        echo "<script>alert('Password is incorrect.');</script>";
    } else {
        // 2) Check if the receiver's username exists in "banking"
        $stmt = $conn->prepare("SELECT Username FROM banking WHERE Username = ?");
        $stmt->bind_param("s", $receiverUsername);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 0) {
            echo "<script>alert('Receiver\'s username not found.');</script>";
        } else {
            $stmt->close();

            // 3) Update balances in "bankbalance"
            // Check current user's balance
            $stmt = $conn->prepare("SELECT Balance FROM bankbalance WHERE Username = ?");
            $stmt->bind_param("s", $currentUser);
            $stmt->execute();
            $stmt->bind_result($currentBalance);
            $stmt->fetch();
            $stmt->close();

            if ($currentBalance < $transferAmount) {
                echo "<script>alert('Insufficient balance!');</script>";
            } else {
                // Deduct amount from current user
                $newSenderBalance = $currentBalance - $transferAmount;
                $stmt = $conn->prepare("UPDATE bankbalance SET Balance = ? WHERE Username = ?");
                $stmt->bind_param("ds", $newSenderBalance, $currentUser);
                $stmt->execute();
                $stmt->close();
            
                // Get receiver's current balance
                $stmt = $conn->prepare("SELECT Balance FROM bankbalance WHERE Username = ?");
                $stmt->bind_param("s", $receiverUsername);
                $stmt->execute();
                $stmt->bind_result($receiverBalance);
                $stmt->fetch();
                $stmt->close();
            
                // Add amount to receiver's balance
                $newReceiverBalance = $receiverBalance + $transferAmount;
                $stmt = $conn->prepare("UPDATE bankbalance SET Balance = ? WHERE Username = ?");
                $stmt->bind_param("ds", $newReceiverBalance, $receiverUsername);
                $stmt->execute();
                $stmt->close();
            
                // Set success message in session
                $_SESSION['transfer_success'] = "Transfer successful!";
                // Set the transaction type
                $transactionType = "Quick Transfer";

                $transactionDate = date('Y-m-d H:i:s'); // Current date and time
                $stmt = $conn->prepare("INSERT INTO transactions (Username, ReceiverUsername, TransactionType, ReceiverBalanceAfter, AmountOfMoney, BalanceAfter, TransactionDate) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssdds", $currentUser, $receiverUsername, $transactionType, $newReceiverBalance, $transferAmount, $newSenderBalance, $transactionDate);
                // Execute the insert
                $stmt->execute();
                $stmt->close();
                
                // PHP redirect to prevent form resubmission
                header("Location: " . htmlspecialchars($_SERVER['PHP_SELF']));
                exit();            
            }
        }
    }
}

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
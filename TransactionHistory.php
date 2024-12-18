<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="shortcut icon" href="https://w7.pngwing.com/pngs/848/762/png-transparent-computer-icons-home-house-home-angle-building-rectangle-thumbnail.png">
        <link rel="stylesheet" href="TransactionHistory.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <title>PocketBank</title>

        <script defer src="TransactionHistory.js"></script>
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
                <a href="BankingLoginSuccess.php" class="home-link">Home</a>
                <a href="#" class="about-link">About</a>
                <a href="#" class="news-link">News</a>
                <a href="#" class="contact-us-link">Contact us</a>
                <span id="change-icon" onclick="modeChange()">
                    💡
                </span>
            </nav>
        </header>
        <section class="TransactionHistory">
        <div class="tableTransaction">
            <h2>Transaction History</h2>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Transaction Type</th>
                        <th>Amount</th>
                        <th>Balance After</th>
                        <th>Receiver Username</th>
                    </tr>
                </thead>
                <tbody>
                 <?php 
            $username = $_SESSION['loggedin_username'];
            $servername = "localhost";
            $dbusername = "root";
            $dbpassword = "";
            $dbname = "bank";
            
            $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            
            $stmt = $conn->prepare("SELECT TransactionDate, TransactionType, AmountOfMoney, BalanceAfter, ReceiverUsername FROM transactions WHERE Username = ? OR ReceiverUsername = ? ORDER BY TransactionDate DESC");
            $stmt->bind_param("ss", $username, $username);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()):
                // Check if the current user is the receiver and if the transaction is a quick transfer
                $isReceiver = ($username === $row['ReceiverUsername']);
                $isQuickTransfer = ($row['TransactionType'] === 'Quick Transfer'); // Adjust this if your type name differs

                // Determine balance after based on user role and transaction type
                if ($isReceiver && $isQuickTransfer) {
                    $balanceAfterDisplay = "N/A"; // or use "" for blank
                } else {
                    $balanceAfterDisplay = htmlspecialchars(number_format($row['BalanceAfter'], 2)); // Use original balance for others
                }
            ?>
            <tr>
                <td><?php echo htmlspecialchars($row['TransactionDate']); ?></td>
                <td><?php echo htmlspecialchars(ucfirst($row['TransactionType'])); ?></td>
                <td><?php echo htmlspecialchars(number_format($row['AmountOfMoney'], 2)); ?></td>
                <td><?php echo $balanceAfterDisplay; ?></td> <!-- Display updated balance or N/A -->
                <td><?php echo htmlspecialchars($row['ReceiverUsername']); ?></td> <!-- Display Receiver's Username -->
            </tr>
            <?php endwhile; ?>
            </tbody>
            </table>
        </div>
        
    </section>
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
                    </p>
                    </div>
                  </div>
               </div>   
            <h3><span class="colored-name">Facing any problems? Contact developers now!</span></h3>           
        </section>
    </body>
</html>
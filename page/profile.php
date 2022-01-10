<!doctype html>
<html lang="en">
    <?php
    session_start();

    $username   = "coconatree";
    $password   = "191200";
    $database   = "DatabasePA01";
    $servername = "localhost:3306";

    $connection =  mysqli_connect(
        $servername,
        $username,
        $password,
        $database
    );

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
    ?>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel = "stylesheet" href = "main.css" type = "text/css"/>
    </head>
    <body>
    <div class = "profile-container">
        <div class = "navbar-profile">
            <a class = "link" href="logout.php"> Logout </a>
            <div class = "filler-div"></div>
            <a class = "link" href="welcome.php"> Welcome </a>
            <br>
        </div>
        <div class = "customer-info">
            <?php
            $CID = $_SESSION["CID"];
            echo $CID;
            $SELECT_USER_INFO = "SELECT * FROM customer WHERE customer.cid = '" .$CID. "';";
            $result = $connection->query($SELECT_USER_INFO);
            $row = $result->fetch_row();
            $result->free_result();
            if(is_array($row)) {
                foreach($row as $elm) {
                    echo $elm . " ";
                }
            }
            ?>
        </div>
        <br>
        <div class = "bought-products">

            <?php

            $SELECT_BUY_HISTORY = "SELECT * FROM product AS prod
                                JOIN (SELECT UNIQUE buy.pid 
                                        FROM buy 
                                        WHERE buy.cid = '" .$CID. "'
                                    ) AS TEMP 
                                    ON TEMP.pid = prod.pid;";

            if ($result = $connection->query($SELECT_BUY_HISTORY)) {
                while($row = $result->fetch_row()) {
                    echo '<div>';
                    echo '<label>'  . $row[0] . '</label>';
                    echo '  ';
                    echo '<label>'  . $row[1] . '</label>';
                    echo '  ';
                    echo '<label>'  . $row[2] . '</label>';
                    echo '  ';
                    echo '<label>'  . $row[3] . '</label>';
                    echo '</div>';
                    echo '<br>';
                }
                $result->free_result();
            }
            ?>
        </div>
        <div class = "fund-container">
            <br>
            <form method="post" action="profile.php">
                <button class = "fund-button" name="fund">Add Funds [ 1000 ]</button>
            </form>

            <?php

            if(isset($_POST["fund"])) {
                $WALLET = $_SESSION["WALLET"];
                $WALLET = $WALLET + 1000;
                $_SESSION["WALLET"] = $WALLET;
                $INCREASE_FUNDS = "UPDATE DatabasePA01.customer SET wallet = " .$WALLET. " WHERE cid = '" .$CID. "';";
                $connection->query($INCREASE_FUNDS);
            }
            ?>
        </div>
        <div class = "fund-container" style = "padding: 15px;">
            <br>
            <form class = "welcome-form" method="post" action="profile.php" >
                <input style = "width: 30%;" placeholder = "product id" class = "amount-input" type = "text",   name = "productId"/>
                <input style = "width: 30%;" palceholder = "amount"     class = "amount-input" type = "number", name = "returnAmount"/>
                <button style = "width: 30%;" class = "fund-button" name = "return"> Return Product </button>
            </form>

            <?php
            if(isset($_POST["return"])) {

                $PID = $_POST["productId"];
                $SELECT_PRODUCT_PRICE = "SELECT product.price FROM product WHERE pid = '".$PID."';";
                $result = $connection->query($SELECT_PRODUCT_PRICE);
                $row -> $result->fetch_row();
                $result->free_result();

                $WALLET = $WALLET + ($row[0] * $_POST["returnAmount"]);
                $_SESSION["WALLET"] = $WALLET;
                $INCREASE_WALLET = "UPDATE customer SET wallet  = '".$WALLET."' WHERE cid = '".$CID."';";
                $result = $connection->query($INCREASE_WALLET);
                $result->free_result();
            }
            echo "Returning products doesn't work !!!";

            $connection->close();
            ?>
        </div>
    </div>
    </body>
</html>

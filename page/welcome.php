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
        <div class = "welcome-container">
            <a href="logout.php">Logout</a>
            <br>

            <?php
            include './product.php';

            $SELECT_ALL_AVAILABLE_PRODUCT = "SELECT * FROM product WHERE 0 < product.stock;";

            if ($result = $connection->query($SELECT_ALL_AVAILABLE_PRODUCT)) {
                $productArray = array();
                while($row = $result->fetch_row()) {
                    $product = new product($row[0], $row[1], $row[2], $row[3]);
                    array_push($productArray, $product);

                    echo '<div class = "card-container">';
                    echo '<form  class = "welcome-form" method = "post" action = "welcome.php">';
                    echo '<label class = "card-element">';
                    echo ' Id : ';
                    echo $product->getPid();
                    echo ' Name: ';
                    echo $product->getPname();
                    echo ' Price: ';
                    echo $product->getPrice();
                    echo ' Stock: ';
                    echo $product->getStock();
                    echo '</label>';
                    echo '<input type="hidden" name="PriceHidden" value=';
                    echo $product->getPrice();
                    echo '>';
                    echo '<input type="hidden" name="PidHidden" value=';
                    echo $product->getPid();
                    echo '>';
                    echo '<input type="hidden" name="StockHidden" value=';
                    echo $product->getStock();
                    echo '>';
                    echo '<div class = "form-element align-center">';
                    echo '<input class = "amount-input" placeholder = "amount" id = "amount" type = "number" name = "amount" />';
                    echo '</div>';
                    echo '<button class = "buy-button" type = "submit" id = "buy" name = "buy"> Buy </button>';
                    echo '</form>';
                    echo '</div>';
                }
                $result->free_result();
            }
            ?>
            <div class = "profile-link">
                <a href="profile.php">Profile</a>
            </div>
            <?php
            if (isset($_POST["buy"])) {

                if (isset($_POST['buy'])) {
                    if (isset($_POST["amount"])){
                        $amount = $_POST["amount"];
                        $stockHidden = $_POST["StockHidden"];
                        if ($amount <= $stockHidden) {

                            $totalPrice = $amount * $_POST["PriceHidden"];
                            $WALLET     = $_SESSION["WALLET"];
                            $amount     = $stockHidden;
                            $_POST['amount'] = $amount;

                            if ($totalPrice <= $WALLET) {
                                $CID = $_SESSION["CID"];
                                $PID = $_POST["PidHidden"];
                                $updatedBalance = $WALLET - $totalPrice;

                                $UPDATE_WALLET = "UPDATE customer SET customer.wallet = " .$updatedBalance. " WHERE customer.cid = '" . $CID . "';";
                                $connection->query($UPDATE_WALLET);


                                $WALLET = $updatedBalance;

                                $BUY_ENTRY = "INSERT INTO buy VALUE (".$CID.", ".$PID. ", ".$amount.");";
                                $connection->query($BUY_ENTRY);
                                echo $BUY_ENTRY;

                                $msg = "<label>Successful</label>";
                            } else {
                                $msg = "<label>Not Enough Funds</label>";
                            }
                        } else {
                            $msg = "<label>Cant Buy More Than The Stock Number</label>";
                        }
                        echo '<div class="mh-50"></div>';
                        echo "<div class = 'error-container'>";
                        echo $msg;
                        echo "</div>";
                    }
                }
            }



            $connection->close();
            ?>
        </div>
    </body>
</html>

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
        <link rel = "stylesheet" href = "./page/main.css" type = "text/css"/>
    </head>
    <body class = "align-center">
        <div class = "align-center custom-container" >
            <div class = "align-center login-form">
                <div class = "mh-50"> </div>
                <form method = "post" action = "index.php">
                    <div class = "form-element align-center">
                        <input placeholder = "username" class = "form-control" id = "username" type = "text" name = "username" />
                    </div>
                    <div class = "mh-50"></div>
                    <div class = "form-element align-center">
                        <input placeholder = "password" class = "form-control" id = "password" type = "password" name = "password" />
                    </div>
                    <div class = "mh-50"></div>
                    <button class = "btn btn-primary" type = "submit" id = "login" name = "login">Login</button>
                </form>
                <div class = "mh-50"> </div>
                <!-- Following class will be used to display errors -->
                <div class = "error-label" >
                    <?php
                        include "./page/customer.php";

                        if (isset($_POST['login'])) {

                            if(isset($_POST["username"]) && isset($_POST["password"])) {

                                $username = $_POST["username"];
                                $password = $_POST["password"];

                                $SELECT_USER_BY_ID = "SELECT * FROM customer WHERE customer.cid = '$password';";

                                if ($result = $connection->query($SELECT_USER_BY_ID)) {
                                    if($result->num_rows == 1) {
                                        $row  = $result->fetch_row();
                                        if (strtolower($row[0]) === strtolower($password)) {
                                            if (strtolower($row[1]) === strtolower($username)) {
                                                $customer = new customer($row[0], $row[1], $row[2], $row[3], $row[4], $row[5]);
                                                $_SESSION["CID"]    = $customer->getCid();
                                                $_SESSION["WALLET"] = $customer->getWallet();
                                                header("Location: page/welcome.php");
                                                die();
                                            } else {
                                                echo "<label>Wrong Username</label>";
                                            }
                                        } else {
                                            echo "<label>Wrong Password</label>";
                                        }
                                    } else {
                                        echo "<label>Check Your Password And Username</label>";
                                    }
                                    $result->free_result();
                                }
                                $connection->close();
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
        <script>

            function FormMiddleware() {
                // This will be the function for validating
            }
            document.getElementById("login").addEventListener("click", (event) => {
                var usernameField = document.getElementById("username")
                var passwordField = document.getElementById("password")

                if (usernameField.value.length === 0 && passwordField.value.length === 0) {
                    alert("Both fields must be present !!!")
                }
            });
        </script>
    </body>
</html>
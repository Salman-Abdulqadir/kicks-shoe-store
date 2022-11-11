<?php
    require_once 'login.php';
    $connection = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);

    session_start();

    if(!$connection)
        die("Unable to connect to MySQL: " . mysqli_connect_errno());

    $request_type = isset($_POST["type"]) ? $_POST["type"] : "";
    $final_result = array();

    //SIMULATION
    // $_POST["first_name"]
    // $_POST["last_name"]
    // $_POST["email"]
    // $_POST["password"]
    // $_POST["date_of_birth"]
    // $_POST["gender"]
    // $_POST["address"]

    // $request_type = "get_user_info";
    switch($request_type){
        case "get_products":
            $final_result = get_products($connection);
            break;
        case "login":
            $final_result = login($connection);
            break;
        case "logout":
            $final_result = logout();
            break;
        case "register":
            $final_result = register($connection);
            break;
        case "add_product":
            $final_result = add_product($connection);
            break;
        case "get_cart":
            $final_result = get_cart($connection);
            break;
        case "delete_cart_item":
            $final_result = delete_cart_item($connection);
            break;
        case "get_user_info":
            $final_result = get_user_info($connection);
            break;
    }
    echo json_encode($final_result);

    //LOGIN FUNCTION 
    function login($connection) {
        if (isset($_POST["username"]) && isset($_POST["password"])) {
            $username = $_POST["username"];
            $password = $_POST["password"];
            $query = "SELECT COUNT(*) AS count, ID AS id, Password AS passwd FROM Users WHERE Email='$username'";
            $result = mysqli_query($connection, $query);
            if(!$result){
                return array("success"=>false);
            }
            $row = mysqli_fetch_array($result);
            if (($row["count"]==1) && ($row["passwd"]==$password)) {
                $_SESSION["user_id"]=$row["id"];
                return array("success"=>true);       
            } else {
                return array("success"=>false);
            }
        } else {
            return array("success"=>false);
        }
    }

    // REGISTERING A USER
    function register($connection) {   
        $email = $_POST["email"];
        $query_email_check = "SELECT COUNT(*) AS count FROM Users WHERE Email='$email'";
        $result_email_check = mysqli_query($connection, $query_email_check);
        if(!$result_email_check){
            return array("success"=>false);
        }
        $row_email_check = mysqli_fetch_array($result_email_check);
        if ($row_email_check["count"]==0) {                
            $first_name =  $_POST["first_name"];
            $last_name = $_POST["last_name"];
            $date_of_birth = $_POST["date_of_birth"];
            $gender = $_POST["gender"];
            $address = $_POST["address"];
            $password = $_POST["password"];

            $query = "INSERT INTO Users (LastName, FirstName, Address, DateOfBirth, Gender, Email, Password)
                        VALUES  ('$last_name', '$first_name', '$address', '$date_of_birth', 
                                '$gender', '$email', '$password')";
            $result = mysqli_query($connection, $query);
            if (!$result) {
                return array("success"=>false);
            } else {
                return array("success"=>true);
            }
        } else {
            return array("success"=>false);
        }       

    }

    //LOG OUT FUNCTION 
    function logout() {
        $_SESSION = array();
        
        // If it's desired to kill the session, also delete the session cookie.
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
            );
        }
        // Finally, destroy the session.
        session_destroy();
        return array("success"=>true); 
    }

    //DELETING A CART ITEM FROM THE CART
    function delete_cart_item($connection){
        if(isset($_SESSION['user_id'])){
            $user_id = $_SESSION["user_id"];
            $product_id = $_POST["product_id"];

            $query = "DELETE FROM cart_item WHERE cart_item.User_id = '$user_id' AND cart_item.Product_id = '$product_id'";
            $result = mysqli_query($connection, $query);
            if(!$result){
                return array("success"=>false);
            }
            return array('success' => true);
        }
        else{
            return array("success"=>false);
        }
    }


    //GETTING THE CART ITEMS OF THE USER
    function get_cart($connection){
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : "";


        $query = "SELECT * FROM cart_item INNER JOIN product ON cart_item.Product_id = product.Product_id WHERE cart_item.User_id = $user_id";
        $result = mysqli_query($connection, $query);

        if(!$result)
            die("Database access failed: " . mysqli_error($connection));
        
        $data = array();
        $total_price = 0;

        //LOOPING THROUGH THE RESULT OF THE QUERY AND EXTRACTING THE INFO FROM EACH ROW
        while($row = mysqli_fetch_array($result)){
            $product_id = $row["Product_id"];
            $brand = $row["Brand"];
            $description = $row["Description"];
            $quantity = $row["Item_quantity"];
            $price = $row["Price"];
            $img_url = $row["Image_url"];
            $total_price += $price;

            //ADDING THE INFO THE DATA ARRAY
            $data[] = array("product_id" => $product_id, "brand" => $brand, "description" => $description, "price" => $price, "img_url" => $img_url, "quantity" => $quantity);
        } 
        return array("cart_items" => $data, "total_price" => $total_price);
        
    }
    
    //ADDING A PRODUCT AS A CART ITEM FOR THE USER
    function add_product($connection){
        if(isset($_SESSION['user_id'])){
            $product_id = $_POST["product_id"];
            $user_id = $_SESSION['user_id'];
            $query = "INSERT INTO cart_item (User_id, Product_id, Item_quantity) VALUES($user_id, $product_id, 1)";
            $result = mysqli_query($connection, $query);
            if(!$result)
                return array("success" => false, "message"=>"failed to add product");
            return array("success" => true);
        }
        return array("success" => false);
    }

    //GETTING THE USERS INFO
    function get_user_info($connection){
        if(isset($_SESSION["user_id"])){
            $user_id = $_SESSION["user_id"];
            $query = "SELECT Users.FirstName, count(*) AS count FROM cart_item INNER JOIN Users ON cart_item.User_id =  Users.ID WHERE User_id = '$user_id'";
            $result = mysqli_query($connection, $query);

            if($result){
                $data = mysqli_fetch_array($result);
                if($data["count"] == 0){
                    $query_username = "SELECT FirstName AS firstname FROM Users WHERE ID = '$user_id'";
                    $username_result = mysqli_query($connection, $query_username);
                    $username = mysqli_fetch_array($username_result)["firstname"];
                    return array("username" => $username);
                }
                return array("username" => $data["FirstName"], "item_count" => $data["count"]);
            }

                
        }
        return array("user" => false, "item_count" => false);
    }

    // CHECKING IS PRODUCT IS ADDED TO USERS CART
    function is_added($connection, $product_id){
        if(isset($_SESSION["user_id"])){
            $user_id = $_SESSION["user_id"];
            
            // CHECKING IF THE THE PRODUCT IS ADDED IN THE USERS CART
            $is_added_query = "SELECT * FROM cart_item WHERE Product_id = '$product_id' AND User_id = '$user_id'";
            $result = mysqli_query($connection, $is_added_query);
            if(!$result){
                return false;
            }
            if(mysqli_num_rows($result) != 1)
                return false;
            return true;
        }
        return false;
    }
    // GETTING ALL THE PRODUCTS
    function get_products ($connection){

        //QUERY THAT WILL SELECT ALL THE PRODUCTS FROM THE DB
        $query = "SELECT * FROM product";
        $result = mysqli_query($connection, $query);

        //IF THE RESULTS HAVE ERROR, END THE CONNECTION WITH THE DB
        if(!$result)
            die("Database access failed: " . mysqli_error($connection));

        //INNIATING THE DATA ARRAY THAT WILL BE RETURNED AND THE NUMBER OF CART ITEMS
        $data = array();
        $cart_count = 0;

        //LOOPING THROUGH THE RESULT OF THE QUERY AND EXTRACTING THE INFO FROM EACH ROW
        while($row = mysqli_fetch_array($result)){
            $product_id = $row["Product_id"];
            $brand = $row["Brand"];
            $description = $row["Description"];
            $price = $row["Price"];
            $quantity = $row["Quantity"];
            $img_url = $row["Image_url"];
            $is_added = is_added($connection, $product_id);
            $cart_count += $is_added ? 1 : 0;

            //ADDING THE INFO THE DATA ARRAY
            $data[] = array("product_id" => $product_id, "brand" => $brand, "description" => $description, "price" => $price,"quantity" => $quantity,"img_url" => $img_url, "is_added" => $is_added);
        }
        return array($data, "cart_count" => $cart_count);
    }



?>
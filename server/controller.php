<?php
    require_once 'login.php';
    $connection = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);

    session_start();

    if(!$connection)
        die("Unable to connect to MySQL: " . mysqli_connect_errno());

    $request_type = isset($_POST["type"]) ? $_POST["type"] : "";
    $final_result = array();

    // //SIMULATION
    // $_POST["brand"] = "Gucci";
    // $_POST["quantity"] = 20;
    // $_POST["price"] = 200;
    // $_POST["description"] = "women's shoe";
    // $_POST["img_url"] = "images/product11.png";
    // // $_POST["gender"]
    // // $_POST["address"]

    // $request_type = "add_product_item";
    // $_POST['brand'] = "Nike";
    // $_POST['category'] = "Men";
    // $_POST['price'] = 120;
    // $_POST['description'] = "fajksl;dfj";
    // $_POST['img_url'] = "sdjfak;sdjf";
    // $_POST['quantity'] = 24;
    
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
        case "decrease_cart_item":
            $final_result = decrease_cart_item($connection);
            break;
        case "delete_cart_item":
            $final_result = delete_cart_item($connection);
            break;
        case "get_user_info":
            $final_result = get_user_info($connection);
            break;
        case "add_to_wishlist":
            $final_result = add_to_wishlist($connection);
            break;
        case "remove_wishlist_item":
            $final_result = remove_wishlist_item($connection);
            break;
        case "get_wish_list":
            $final_result = get_wish_list($connection);
            break;
        case "add_product_item":
            $final_result = add_product_item($connection);
            break;

    }
    echo json_encode($final_result);

    //ADDING A PRODUCT TO THE PRODUCT TABLE
    function add_product_item($connection){
        $brand = $_POST["brand"];
        $price = $_POST["price"];
        $quantity = $_POST["quantity"];
        $img_url = $_POST["img_url"];
        $description = $_POST["description"];
        $category = $_POST["category"];

        $query = "INSERT INTO product (Brand, Description, Price, Quantity, Image_url, Category, Rating, Discount) VALUES ('$brand', '$description', $price, $quantity, '$img_url', '$category', 0, 0)";
        $result = mysqli_query($connection, $query);


        if(!$result)
            return array("success" => false);
        return array("success" => true);
    }
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

        //DELETING CART ITEM FROM THE CART
        function delete_cart_item($connection){
            if(isset($_SESSION['user_id'])){
                $user_id = $_SESSION["user_id"];
                $product_id = $_POST["product_id"];
    
                $query = "UPDATE product SET Quantity = Quantity + (SELECT Item_quantity FROM cart_item WHERE Product_id = '$product_id' AND User_id = '$user_id') WHERE Product_id = '$product_id'; DELETE FROM cart_item WHERE cart_item.User_id = '$user_id' AND cart_item.Product_id = '$product_id'";
                $result = mysqli_multi_query($connection, $query);
                if(!$result){
                    return array("success"=>false);
                }
                return array("success"=>true);
            }
            else{
                return array("success"=>false);
            }
        }

    //DELETING A CART ITEM FROM THE CART
    function decrease_cart_item($connection){
        if(isset($_SESSION['user_id'])){
            $user_id = $_SESSION["user_id"];
            $product_id = $_POST["product_id"];

            $cart_item_query = "SELECT Item_quantity AS quantity FROM cart_item WHERE User_id = $user_id AND Product_id = $product_id";
            $cart_item_result = mysqli_query($connection, $cart_item_query);
            if (!$cart_item_result) {
                return array("success"=>false);
            }
            $row = mysqli_fetch_array($cart_item_result);
            $quantity = $row["quantity"];
            if ($quantity == 1) {
                $query = "DELETE FROM cart_item WHERE cart_item.User_id = '$user_id' AND cart_item.Product_id = '$product_id'; UPDATE product SET Quantity = Quantity + 1 WHERE Product_id = '$product_id'";
                $result = mysqli_multi_query($connection, $query);
                if(!$result){
                    return array("success"=>false);
                }
                return array("success"=>true);
            } else {
                $query = "UPDATE cart_item SET Item_quantity = Item_quantity - 1 WHERE User_id = $user_id AND Product_id = $product_id; UPDATE product SET Quantity = Quantity + 1 WHERE Product_id = '$product_id'";
                $result = mysqli_multi_query($connection, $query);
                if(!$result){
                    return array("success"=>false);
                }
                return array("success"=>true);
            }
        } else {
            return array("success"=>false);
        }
    }

    //DELETING A WISHLIST ITEM FROM THE CART
    function remove_wishlist_item($connection){
        if(isset($_SESSION['user_id'])){
            $user_id = $_SESSION["user_id"];
            $product_id = $_POST["product_id"];

            $query = "DELETE FROM wish_list WHERE wish_list.User_id = '$user_id' AND wish_list.Product_id = '$product_id'";
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

    //GETTING THE WISH LIST OF A USER
    function get_wish_list($connection){
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : "";
        $query = "SELECT * FROM wish_list INNER JOIN product ON wish_list.Product_id = product.Product_id WHERE wish_list.User_id = $user_id";
        $result = mysqli_query($connection, $query);

        if(!$result)
            die("Database access failed: " . mysqli_error($connection));
        
        $data = array();

        //LOOPING THROUGH THE RESULT OF THE QUERY AND EXTRACTING THE INFO FROM EACH ROW
        while($row = mysqli_fetch_array($result)){
            $product_id = $row["Product_id"];
            $brand = $row["Brand"];
            $description = $row["Description"];
            $price = $row["Price"];
            $img_url = $row["Image_url"];
            $category = $row["Category"];

            //ADDING THE INFO THE DATA ARRAY
            $data[] = array("product_id" => $product_id, "brand" => $brand, "description" => $description, "price" => $price, "img_url" => $img_url, "category" => $category);
        } 
        return $data;  
    }
    //GETTING THE CART ITEMS OF THE USER
    function get_cart($connection){

        $user_id = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : "";
        $query = "SELECT * FROM cart_item INNER JOIN product ON cart_item.Product_id = product.Product_id WHERE cart_item.User_id = $user_id";
        $result = mysqli_query($connection, $query);

        if(!$result)
            die("Database access failed: " . mysqli_error($connection));
        
        $data = array();
        $total_price = 0;
        $total_cart_items = 0;

        //LOOPING THROUGH THE RESULT OF THE QUERY AND EXTRACTING THE INFO FROM EACH ROW
        while($row = mysqli_fetch_array($result)){
            $product_id = $row["Product_id"];
            $brand = $row["Brand"];
            $description = $row["Description"];
            $cart_item_quantity = $row["Item_quantity"];
            $product_quantity = $row["Quantity"];
            $price = $row["Price"]*$cart_item_quantity;
            $img_url = $row["Image_url"];
            $category = $row["Category"];
            $total_price += $price;
            $total_cart_items += $cart_item_quantity;

            //ADDING THE INFO THE DATA ARRAY
            $data[] = array("product_id"=>$product_id, "brand"=>$brand, "description"=>$description, "price"=>$price, "img_url"=>$img_url, "cart_item_quantity"=>$cart_item_quantity, "product_quantity"=>$product_quantity, "category" => $category);
        } 
        return array("cart_items" => $data, "total_price" => $total_price, "total_quantity" => $total_cart_items);
    }
    
     //ADDING A PRODUCT AS A CART ITEM FOR THE USER
     function add_product($connection){
        if(isset($_SESSION['user_id'])){
            $product_id = $_POST["product_id"];
            $user_id = $_SESSION['user_id'];
            
            $product_query = "SELECT Quantity AS quantity FROM product WHERE Product_id = $product_id";
            $product_result = mysqli_query($connection, $product_query);
            if (!$product_result) {
                return array("success"=>false);
            }
            $row = mysqli_fetch_array($product_result);
            $quantity = $row["quantity"];

            if ($quantity >= 1) {
                if (is_added($connection, $product_id, "cart_item")) {
                    $query = "UPDATE cart_item SET Item_quantity=Item_quantity+1 WHERE User_id=$user_id AND Product_id=$product_id; UPDATE product SET Quantity = Quantity - 1 WHERE Product_id = '$product_id'";
                    $result = mysqli_multi_query($connection, $query);
                    if(!$result)
                        return array("success" => false, "message"=>"failed to add product");
                    return array("success" => true);
                } else {
                    $query = "INSERT INTO cart_item (User_id, Product_id, Item_quantity) VALUES($user_id, $product_id, 1); UPDATE product SET Quantity = Quantity - 1 WHERE Product_id = '$product_id'";
                    $result = mysqli_multi_query($connection, $query);
                    if(!$result)
                        return array("success" => false, "message"=>"failed to add product");
                    return array("success" => true);
                }
            } else {
                return array("success" => false);
            }
        }
        return array("success" => false);
    }

    //ADDING A PRODUCT AS A WISH LIST ITEM FOR THE USER
    function add_to_wishlist($connection){
        if(isset($_SESSION['user_id'])){
            $product_id = $_POST["product_id"];
            $user_id = $_SESSION['user_id'];
            $query = "INSERT INTO wish_list (User_id, Product_id) VALUES($user_id, $product_id)";
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
            $query = "SELECT Users.FirstName, cart_item.Item_quantity AS quantity FROM cart_item INNER JOIN Users ON cart_item.User_id =  Users.ID WHERE User_id = '$user_id'";
            $result = mysqli_query($connection, $query);
            $item_count = 0;
            $username = "";

            if($result){
                while($data = mysqli_fetch_array($result)) {
                    $item_count += $data["quantity"];
                    $username = $data["FirstName"];
                }
                if($item_count == 0){
                    $query_username = "SELECT FirstName AS fname FROM Users WHERE ID = '$user_id'";
                    $username_result = mysqli_query($connection, $query_username);
                    $username = mysqli_fetch_array($username_result)["fname"];
                    return array("username" => $username, "item_count"=>$item_count);
                }
                return array("username" => $username, "item_count" => $item_count);
            }

                
        }
        return array("username" => false);
    }

    // CHECKING IS PRODUCT IS ADDED TO USERS CART
    function is_added($connection, $product_id, $table){
        if(isset($_SESSION["user_id"])){
            $user_id = $_SESSION["user_id"];
            
            // CHECKING IF THE THE PRODUCT IS ADDED IN THE USERS CART
            $is_added_query = "SELECT * FROM $table WHERE Product_id = '$product_id' AND User_id = '$user_id'";
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
        //FILTERS
        $search_input = isset($_POST["search_input"]) ? $_POST["search_input"] : "";
        $price_filter = isset($_POST["price"])? $_POST["price"]: "";
        $brand_filter = isset($_POST["brand"]) ? $_POST["brand"] : "";
        $category_filter= isset($_POST["category"]) ? $_POST["category"] : "";
        $sort_price = isset($_POST["sort_price"]) ? $_POST["sort_price"] : 'DESC';


        //FILTER QUERIES
        $brand_query = $_POST["brand"] != "" ? "Brand = '$brand_filter'" : true;
        $category_query = $_POST["category"] != "" ? "Category = '$category_filter'" : true;
        $price_query = true;
        if($_POST["price"] != ""){
            switch($_POST["price"]){
                case "low":
                    $price_query = "Price > 0 AND price < 100";
                    break;
                case "medium":
                    $price_query = "Price >= 100 AND price < 500";
                    break;
                case "high":
                    $price_query = "Price >= 500";
                    break;
            }
        }
        
        
        // QUERY THAT WILL SELECT ALL THE PRODUCTS FROM THE DB
        $query = "SELECT * FROM product WHERE $brand_query AND $category_query AND $price_query AND Description LIKE '%$search_input%' ORDER BY Price - (Price * Discount/100) $sort_price";

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
            $discount = $row["Discount"];
            $category = $row["Category"];
            $rating = $row["Rating"];
            $img_url = $row["Image_url"];
            $is_added = is_added($connection, $product_id, "cart_item");
            $is_wishlist_item = is_added($connection, $product_id, "wish_list");
            $cart_count += $is_added ? 1 : 0;

            //ADDING THE INFO THE DATA ARRAY
            $data[] = array("product_id" => $product_id, "brand" => $brand, "description" => $description, "price" => $price,"quantity" => $quantity,"img_url" => $img_url, "is_added" => $is_added, "is_wish" => $is_wishlist_item, "category" => $category, "rating" => $rating, "discount" => $discount);
        }
        return array($data, "cart_count" => $cart_count, "success" => true);
    }



?>
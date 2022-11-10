<?php
    require_once 'login.php';
    $connection = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);

    session_start();

    if(!$connection)
        die("Unable to connect to MySQL: " . mysqli_connect_errno());

    $request_type = isset($_POST["type"]) ? $_POST["type"] : "";
    $final_result = array();

    $_SESSION["user_id"] = '2';
    // $request_type = "delete_cart_item";
    // $_POST["product_id"] = "1";

    switch($request_type){
        case "get_products":
            $final_result = get_products($connection);
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
    }
    echo json_encode($final_result);

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
            $price = $row["Price"];
            $img_url = $row["Image_url"];
            $total_price += $price;

            //ADDING THE INFO THE DATA ARRAY
            $data[] = array("product_id" => $product_id, "brand" => $brand, "description" => $description, "price" => $price, "img_url" => $img_url);
        } 
        return array("cart_items" => $data, "total_price" => $total_price);
        
    }
    
    //ADDING A PRODUCT AS A CART ITEM FOR THE USER
    function add_product($connection){
        if(isset($_SESSION['user_id'])){
            $product_id = $_POST["product_id"];
            $user_id = $_SESSION['user_id'];
            $query = "INSERT INTO cart_item (User_id, Product_id, Quantity) VALUES($user_id, $product_id, 1)";
            $result = mysqli_query($connection, $query);
            if(!$result)
                return array("success" => false, "message"=>"failed to add product");
            return array("success" => true);
        }
        return array("success" => false);
    }

    // GETTING ALL THE PRODUCTS
    function get_products ($connection){
        //QUERY THAT WILL SELECT ALL THE PRODUCTS FROM THE DB
        $query = "SELECT * FROM product";
        $result = mysqli_query($connection, $query);

        //IF THE RESULTS HAVE ERROR, END THE CONNECTION WITH THE DB
        if(!$result)
            die("Database access failed: " . mysqli_error($connection));

        //INNIATING THE DATA ARRAY THAT WILL BE RETURNED
        $data = array();

        //LOOPING THROUGH THE RESULT OF THE QUERY AND EXTRACTING THE INFO FROM EACH ROW
        while($row = mysqli_fetch_array($result)){
            $product_id = $row["Product_id"];
            $brand = $row["Brand"];
            $description = $row["Description"];
            $price = $row["Price"];
            $quantity = $row["Quantity"];
            $img_url = $row["Image_url"];

            //ADDING THE INFO THE DATA ARRAY
            $data[] = array("product_id" => $product_id, "brand" => $brand, "description" => $description, "price" => $price,"quantity" => $quantity,"img_url" => $img_url);
        }
        return $data;
    }



?>
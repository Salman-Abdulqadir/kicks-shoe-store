<?php
    require_once 'login.php';
    $connection = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);

    if(!$connection)
        die("Unable to connect to MySQL: " . mysqli_connect_errno());

    $request_type = isset($_POST["type"]) ? $_POST["type"] : "";
    $final_result = array();

    $request_type = "get_products";

    switch($request_type){
        case "get_products":
            $final_result = get_products($connection);
            break;
    }
    echo json_encode($final_result);
    
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
CREATE TABLE product(
    Product_id INT NOT NULL AUTO_INCREMENT,
    Brand VARCHAR(255) NOT NULL,
    Description VARCHAR(255),
    Price INT NOT NULL,
    Quantity INT NOT NULL,
    Image_url VARCHAR(255) NOT NULL,
    PRIMARY KEY (product_id)
)

INSERT INTO product ("Product_id", "Brand", "Description", "Price", "Quantity", "Image_url")
VALUES (1, "Nike", "Men's Kyrie Infinity Basketball Shoe", 460, 5, "images/product1.png"),
(2, "Nike", "Men's Jordan", 500, 7, "images/product2.png"),
(3, "Nike", "Unisex Air Force 1", 660, 10, "images/product3.png"),
(4, "Addidas", "Tennis shoe ", 360, 4, "images/product4.png"),
(5, "Puma", "Casual Sneakers", 260, 3, "images/product5.png"),
(6, "Mango", "Men's black boots", 160, 2, "images/product6.png"),
(7, "Vance", "black boot collection", 760, 5, "images/product7.png"),
(8, "Nike", "Men's zoom basketball shoes", 860, 5, "images/product8.png"),
(9, "Nike", "Men's Kyrie basketball shoes", 1060, 5, "images/product9.png");
(10, "Nike", "Men's Kyrie basketball shoes", 560, 12, "images/main-nike-pic.png");

-- CART ITEM TABLE
CREATE TABLE cart_item (
    User_id INT NOT NULL,
    Product_id INT NOT NULL,
    Item_quantity INT NOT NULL,
    PRIMARY KEY (User_id, Product_id),
    FOREIGN KEY (User_id) REFERENCES Users(ID),
    FOREIGN KEY (Product_id) REFERENCES product(Product_id)
);

-- WISH LIST TABLE
CREATE TABLE wish_list (
User_id INT NOT NULL,
Product_id INT NOT NULL,
PRIMARY KEY (User_id, Product_id),
FOREIGN KEY (User_id) REFERENCES Users(ID),
FOREIGN KEY (Product_id) REFERENCES product(Product_id)
);
let password_match = false;

//GETTING THE USERS INFO IF THEIR LOGGED IN
function get_user_info(location = "") {
  $.ajax({
    method: "POST",
    url: location ? "server/controller.php" : "../server/controller.php",
    dataType: "json",
    data: { type: "get_user_info" },
    success: (data) => {
      if (data["username"]) {
        $("#cart_count").html(data["item_count"]);

        let logged_in = `<button onclick="logout();" class="btn btn-outline-dark"><i class="fas fa-user-circle"></i> ${data["username"]} | logout</button>`;
        $("#login_btn").html(logged_in);
        console.log("success");
      }
    },
  });
}

// LOGIN FUNCTION
function login() {
  let username = $("#username").val();
  let password = $("#password").val();

  $.ajax({
    method: "POST",
    url: "../server/controller.php",
    dataType: "json",
    data: { type: "login", username: username, password: password },
    success: function (data) {
      if (data["success"]) {
        window.location.href = "../index.html";
      }
    },
  });
}

//LOGOUT FUNCTION
function logout() {
  $.ajax({
    method: "POST",
    url: "../server/controller.php",
    dataType: "json",
    data: { type: "logout" },
    success: function (data) {
      window.location.href = "../index.html";
    },
  });
}

//REGISTERING A USER
function register() {
  if (password_match === true) {
    let first_name = $("#first_name").val();
    let last_name = $("#last_name").val();
    let date_of_birth = $("#date_of_birth").val();
    let gender = $("#gender").val();
    let address = $("#address").val();
    let email = $("#email").val();
    let password = $("#password_register").val();

    $.ajax({
      method: "POST",
      url: "../server/controller.php",
      dataType: "json",
      data: {
        type: "register",
        first_name: first_name,
        last_name: last_name,
        date_of_birth: date_of_birth,
        gender: gender,
        address: address,
        email: email,
        password: password,
      },
      success: function (data) {
        if (data["success"]) {
          window.location.href = "login.html";
        } else {
          $("#confirm_password_text")
            .text("Something went wrong! Please try again.")
            .css("color", "red");
        }
      },
    });
  }
}

// CONFIRMING THE PASSWORDS WHEN A USER REGISTERS
function compare_passwords() {
  let password = $("#password_register").val();
  let confirm_password = $("#confirm_password_register").val();
  if (password !== null || confirm_password !== null) {
    if (password !== confirm_password) {
      $("confirm_password_register").css("border", "1px solid red");
      $("#confirm_password_text")
        .text("Passwords don't match!")
        .css("color", "red");
    } else {
      $("confirm_password_register").css("border", "1px solid green");
      $("#confirm_password_text")
        .text("Passwords match!")
        .css("color", "green");
      password_match = true;
    }
  } else {
    $("#confirm_password_text").hide();
  }
}

//GETTING PRODUCTS WHEN THE STORE PAGE LOADS
function get_products() {
  $.ajax({
    method: "POST",
    url: "../server/controller.php",
    dataType: "json",
    data: { type: "get_products" },
    success: (data) => {
      display_products(data);
      get_user_info();
    },
  });
}

//ADDING A PRODUCT TO THE USER'S CART IF IT IS NOT THERE
function add_product(item) {
  let product_id = $(item).attr("product_id");

  // sending an ajax request to create a cart item for the user
  $.ajax({
    method: "POST",
    url: "../server/controller.php",
    dataType: "json",
    data: {
      type: "add_product",
      product_id,
    },
    success: (data) => {
      if (data["success"]) {
        get_products();
      }
    },
  });
}

//GETTING THE CART ITEMS
function get_cart() {
  $.ajax({
    method: "POST",
    url: "../server/controller.php",
    dataType: "json",
    data: { type: "get_cart" },
    success: (data) => {
      display_cart(data);
      get_user_info();
    },
  });
}

// TOTAL AMOUNT OF THE CART HTML
function subtotal_html(data) {
  let html = "";
  let cart_items = data["cart_items"];

  // ADDING THE NUMBER OF ITEMS
  html += `<div class="flex bordered">
            <h3>${cart_items.length} items</h3>
            <p>price</p>
          </div>
          <div class="order">`;
  for (let index in cart_items) {
    let row = cart_items[index];

    // reading the data from the current row
    let description = row["description"];
    let price = row["price"];
    let quantity = row["quantity"];

    html += `<div class="order-item flex">
    <p>${quantity} X ${description}</p>
    <p>AED ${quantity * price}</p>
  </div>`;
  }
  html += `</div><div class="total-amount flex">
            <h2 class="text-dark">Total Amount</h2>
            <h2 class="text-warning">AED${data["total_price"]}</h2>
          </div>`;
  $(".subtotal").html(html);
}

//DELETE CART ITEM
function delete_cart_item(product_id) {
  $.ajax({
    method: "POST",
    url: "../server/controller.php",
    dataType: "json",
    data: {
      type: "delete_cart_item",
      product_id,
    },
    success: (data) => {
      if (data["success"]) {
        get_cart();
        get_products();
      }
    },
  });
}

//DISPLAYING THE CART
function display_cart(data) {
  let html = "";
  let cart_items = data["cart_items"];
  for (let index in cart_items) {
    let row = cart_items[index];

    // reading the data from the current row
    let product_id = row["product_id"];
    let brand = row["brand"];
    let description = row["description"];
    let price = row["price"];
    let img_url = row["img_url"];

    html += `<div class="item">
        <div class="item-image flex-column">
          <img src="../${img_url}" alt="image_${product_id}" />
        </div>
        <div class="info">
          <h4>${brand}</h4>
          <p>${description}</p>
          <div class="product-quantity">
            <button class="btn btn-outline-warning">-</button>
            <input value="1" type="text" disabled />
            <button class="btn btn-outline-warning">+</button>
          </div>
          <button onclick="delete_cart_item(${product_id})" class="btn btn-outline-danger mt-4">
            Delete <i class="fa fa-trash" aria-hidden="true"></i>
          </button>
        </div>
        <h3 id="price">AED${price}</h3>
      </div>`;
  }
  subtotal_html(data);
  $(".items").html(html);
}
//DISPLAYING THE PRODUCTS AFTER GETTING THEM FROM THE DATABASE
function display_products(data) {
  let html = "";
  let products = data[0];
  for (let index in products) {
    let row = products[index];

    // reading the data from the current row
    let product_id = row["product_id"];
    let brand = row["brand"];
    let description = row["description"];
    let price = row["price"];
    let quantity = row["quantity"];
    let img_url = row["img_url"];
    let is_added = row["is_added"];

    html += `
    <div class="product">
        <div class="product-img">
            <button class="add_to_favorite"><i class="fa-solid fa-heart"></i></button>
            <img src='../${img_url}' alt="product${product_id}" />
        </div>
        <div class="product-info">
            <h3>${brand}</h3>
            <p>${description}</p>
            <h4>${price}AED <span>${
      quantity < 5 ? "only " + quantity + " left!" : " "
    }</span></h4> </div>`;

    // IF THE PRODUCT IS NOT ADD, ADD A BUTTON THAT ALLOWS THE USER TO ADD IT
    if (!is_added)
      html += `<button onclick="add_product(this);" product_id="${product_id}" class=" btn btn-outline-dark add_to_cart">Add to cart  <i class="fa-solid fa-cart-shopping"></i></button></div>`;
    else
      html += `<button type="button" class="btn btn-warning" disabled data-bs-toggle="button" autocomplete="off">added to cart <i class="fa-solid fa-check"></i></button><button onclick="delete_cart_item(${product_id})" class="btn btn-outline-danger mx-2">
      <i class="fa fa-trash" aria-hidden="true"></i>
    </button></div>`;
  }
  $(".latest-products").html(html);
  console.log();
}

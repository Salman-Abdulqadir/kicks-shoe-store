function add_product_admin() {
  let html = `<div class="add-product">
    <h2><i class="fa-solid fa-plus"></i> Add products</h2>
    <div class="add-form">
      <div class="form-row">
        <input type="text" id="brand" placeholder="Enter the brand" />
        <select id="category">
          <option hidden selected value="">Choose Category</option>
          <option value="Men">Men</option>
          <option value="Women">Women</option>
          <option value="Kids">Kids</option>
        </select>
      </div>
      <div class="form-row">
        <input type="number" id="price" placeholder="Enter the price" />
        <input
          type="number"
          id="quantity"
          placeholder="Enter the quantity"
        />
      </div>
      <div class="form-row">
        <input
          type="text"
          id="img_url"
          placeholder="Enter the absolute path of the image"
        />
      </div>
      <textarea
        id="description"
        cols="20"
        rows="5"
        placeholder="Enter the description of the product"
      ></textarea>
      <div class="form-row">
        <button onclick="add_product_item();" id="add-product-btn">
          <i class="fa-solid fa-plus"></i> Add Product
        </button>
        <button id="discard-product-btn">
          <i class="fa-solid fa-trash"></i> Discard
        </button>
      </div>
    </div>
  </div>`;
  $(".content").html(html);
}
//ADDING A PRODUCT TOT HE PRODUCT TABLE
function add_product_item() {
  let brand = $("#brand").val();
  let price = $("#price").val();
  let quantity = $("#quantity").val();
  let img_url = $("#img_url").val();
  let category = $("#category").val();
  let description = $("#description").val();

  //SENDING AN AJAX REQUEST
  $.ajax({
    method: "POST",
    url: "../server/controller.php",
    dataType: "json",
    data: {
      type: "add_product_item",
      brand,
      price,
      quantity,
      img_url,
      description,
      category,
    },
    success: (data) => {
      if (data["success"]) {
        $(".success-message").html("Product Added Successfully!");
        $(".success-message").css(
          "animation",
          "animation: show-message 3s ease-in;"
        );
        $("#brand").val("");
        $("#price").val("");
        $("#quantity").val("");
        $("#img_url").val("");
        $("#description").val("");
      } else {
        alert("failed");
      }
    },
  });
}

function manage_products() {
  $.ajax({
    method: "POST",
    url: "../server/controller.php",
    dataType: "json",
    data: {
      type: "manage_products",
    },
    success: (data) => {
      display_products_admin(data["data"]);
    },
  });
}

function manage_quantity() {
  $.ajax({
    method: "POST",
    url: "../server/controller.php",
    dataType: "json",
    data: {
      type: "manage_quantity",
    },
    success: (data) => {
      display_manage_quantity(data["data"]);
    },
  });
}

function display_products_admin(data) {
  let html =
    "<h2><i class='fa-solid fa-trash'></i> Delete Products</h2><table class='table table-warning table-striped admin-product-table'><tr><th>Product ID</th><th>Brand</th><th>Description</th><th>Price</th><th>Quantity</th><th>Img-URL</th><th>Category</th><th>Rating</th><td></td></tr>";
  for (let index in data) {
    let row = data[index];

    let product_id = row["product_id"];
    let brand = row["brand"];
    let description = row["description"];
    let price = row["price"];
    let quantity = row["quantity"];
    let img_url = row["img_url"];
    let category = row["category"];
    let rating = row["rating"];

    html += `<tr><th>${product_id}</th><td>${brand}</td><td>${description}</td><td>${price}</td><td>${quantity}</td><td>${img_url}</td><td>${category}</td><td>${rating}</td><td><i onclick="delete_product_admin(this);" product-id="${product_id}" class="fa-solid fa-trash delete-product-icon"></i></td></tr>`;
  }
  html += "</table>";
  $(".content").html(html);
}

function display_manage_quantity(data) {
  let html =
    "<h2><i class='fa-solid fa-list-check'></i> Manage</h2> <table class='table table-warning table-striped admin-product-table'><tr><th>Product ID</th><th>Brand</th><th>Description</th><th>Price</th><th>Quantity</th><th>Discount</th></tr>";
  for (let index in data) {
    let row = data[index];

    let product_id = row["product_id"];
    let brand = row["brand"];
    let description = row["description"];
    let price = row["price"];
    let quantity = row["quantity"];
    let discount = row["discount"];

    html += `<tr><th>${product_id}</th><td>${brand}</td><td>${description}</td><td>${price}</td><td><span id="quantity_span_${product_id}" class="editable_quantity" onclick="reveal_quantity_input(this)" product-id="${product_id}">${quantity}</span><input onblur="change_product_quantity(this);" product-id="${product_id}" id="quantity_input_${product_id}" class="quantity-input" type="number"></td><td><span id="discount_span_${product_id}" class="editable_quantity" onclick="reveal_discount_input(this)" product-id="${product_id}">${discount}</span><input onblur="change_discount(this);" product-id="${product_id}" id="discount_input_${product_id}" class="quantity-input" type="number"></td></tr>`;
  }
  html += "</table>";
  $(".content").html(html);
}

function reveal_discount_input(item) {
  let product_id = $(item).attr("product-id");
  $(`#discount_span_${product_id}`).hide();
  $(`#discount_input_${product_id}`).show();
}

function reveal_quantity_input(item) {
  let product_id = $(item).attr("product-id");
  $(`#quantity_span_${product_id}`).hide();
  $(`#quantity_input_${product_id}`).show();
}

function change_discount(item) {
  let product_id = $(item).attr("product-id");
  let discount = $(item).val();
  $.ajax({
    method: "POST",
    url: "../server/controller.php",
    dataType: "json",
    data: {
      type: "change_discount",
      product_id: product_id,
      discount: discount,
    },
    success: (data) => {
      if (data["success"]) {
        manage_quantity();
      }
    },
  });
}

function change_product_quantity(item) {
  let product_id = $(item).attr("product-id");
  let quantity = $(item).val();
  $.ajax({
    method: "POST",
    url: "../server/controller.php",
    dataType: "json",
    data: {
      type: "change_product_quantity",
      product_id: product_id,
      quantity: quantity,
    },
    success: (data) => {
      if (data["success"]) {
        manage_quantity();
      }
    },
  });
}

function delete_product_admin(item) {
  let product_id = $(item).attr("product-id");
  $.ajax({
    method: "POST",
    url: "../server/controller.php",
    dataType: "json",
    data: {
      type: "delete_product_admin",
      product_id: product_id,
    },
    success: (data) => {
      if (data["success"]) {
        manage_products();
      }
    },
  });
}

function manage_users() {
  $.ajax({
    method: "POST",
    url: "../server/controller.php",
    dataType: "json",
    data: {
      type: "manage_users",
    },
    success: (data) => {
      display_users(data["data"]);
    },
  });
}

function display_users(data) {
  let html =
    "<h2><i class='fa-solid fa-trash'></i> Delete User Accounts</h2> <table class='table table-warning table-striped admin-product-table'><tr><th>User ID</th><th>First Name</th><th>Last Name</th><th>Address</th><th>Date of Birth</th><th>Gender</th><th>Email</th><th>Phone Number</th><td></td></tr>";
  for (let index in data) {
    let row = data[index];

    let user_id = row["user_id"];
    let last_name = row["last_name"];
    let first_name = row["first_name"];
    let address = row["address"];
    let date_of_birth = row["date_of_birth"];
    let gender = row["gender"];
    let email = row["email"];
    let phone_num = row["phone_num"];

    html += `<tr><th>${user_id}</th><td>${first_name}</td><td>${last_name}</td><td>${address}</td><td>${date_of_birth}</td><td>${gender}</td><td>${email}</td><td>${phone_num}</td><td><i onclick="delete_user(this);" user-id="${user_id}" class="fa-solid fa-trash delete-product-icon"></i></td></tr>`;
  }
  html += "</table>";
  $(".content").html(html);
}

function delete_user(item) {
  let user_id = $(item).attr("user-id");
  $.ajax({
    method: "POST",
    url: "../server/controller.php",
    dataType: "json",
    data: {
      type: "delete_user",
      user_id: user_id,
    },
    success: (data) => {
      if (data["success"]) {
        manage_products();
      }
    },
  });
}

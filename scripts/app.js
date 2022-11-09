//GETTING PRODUCTS WHEN THE STORE PAGE LOADS
function get_products() {
  $.ajax({
    method: "POST",
    url: "../server/controller.php",
    dataType: "json",
    data: { type: "get_products" },
    success: (data) => {
      display_products(data);
      console.log("success");
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
        alert("success");
      }
    },
  });
}
//DISPLAYING THE PRODUCTS AFTER GETTING THEM FROM THE DATABASE
function display_products(data) {
  html = "";
  for (let index in data) {
    let row = data[index];

    // reading the data from the current row
    let product_id = row["product_id"];
    let brand = row["brand"];
    let description = row["description"];
    let price = row["price"];
    let quantity = row["quantity"];
    let img_url = row["img_url"];

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
    }</span></h4>
        </div>
        <button onclick="add_product(this);" product_id="${product_id}" class=" btn btn-outline-dark add_to_cart">Add to cart  <i class="fa-solid fa-cart-shopping"></i></button>

    </div>
    `;
  }
  $(".latest-products").html(html);
}

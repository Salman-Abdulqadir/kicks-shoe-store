function check_out() {
  $.ajax({
    method: "POST",
    url: "../server/controller.php",
    dataType: "json",
    data: {
      type: "check_out",
    },
    success: (data) => {
      display_checkout(data);
      get_user_info();
    },
  });
}

function display_checkout(data) {
  let html = "";
  let delivery_html = "";
  let total_price_html = "";
  let cart_items = data["cart_items"];

  for (let index in cart_items) {
    let row = cart_items[index];

    // reading the data from the current row
    let product_id = row["product_id"];
    let brand = row["brand"];
    let description = row["description"];
    let price = row["price"];
    let img_url = row["img_url"];
    let quantity = row["cart_item_quantity"];

    html += `<div class="checkout-item-list">
                  <div class="image-flex">
                    <img src="../${img_url}" alt="image_${product_id}">
                    <span class="badge bg-warning bg-lg checkout-badge">${quantity}</span>
                  </div>
                  <div class="checkout-info">
                    <h6>${brand}</h6>
                    <p>${description}</p>
                  </div>
                  <h6 id="price">AED${price}</h6>
                </div>`;
  }

  total_price_html += `<div class="checkout-total">
                            <p class="checkout-text">delivery charge: </p>
                            <p>AED${data["delivery_charge"]}</p>
                          </div>
                          <div class="checkout-total">
                            <p class="checkout-text">vat(5%): </p>
                            <p>AED${data["vat"]}</p>
                          </div>
                          <div class="checkout-total">
                            <p class="checkout-text">total price (VAT Inc.): </p>
                            <p>AED${data["total_price"]}</p>
                          </div>`;
  delivery_html += `<tr><th>Name</th>
                        <td>${data["full_name"]}</td></tr>
                      <tr><th>Phone Number: </th>
                        <td id="phone_number">${data["phone_number"]}</td>
                        <td id="new_phone_num"><input type="text" required></td>
                        <td id="edit_phone_button"><i onclick="edit_phone_num();" class="fa-solid fa-pen-to-square"></i></td>
                        <td id="change_phone_button"> <button onclick="change_phone_number();">Change</button></td>
                      </tr>
                      <tr><th>Deliver to: </th>
                        <td id="address">${data["address"]}</td>
                        <td id="new_address"><input type="text" required></td>
                        <td id="edit_address_button"><i onclick="edit_address();" class="fa-solid fa-pen-to-square"></i></td>
                        <td id="change_address_button"><button onclick="change_address();">Change</button></td>
                      </tr>`;
  $(".items-checkout").html(html);
  $("#delivery-details").prepend(delivery_html);
  $(".vat_total_price").html(total_price_html);
}

let isError1 = false;

function change_phone_number() {
  let phone_num = $("#new_phone_num>input").val();
  $.ajax({
    method: "POST",
    url: "../server/controller.php",
    dataType: "json",
    data: {
      type: "change_phone_number",
      phone_number: phone_num,
    },
    success: (data) => {
      if (data["success"]) {
        check_out();
        $("#change_phone_button").closest("tr").hide();
        $("#change_address_button").closest("tr").hide();
        $(".error_message_details").closest("tr").hide();
        isError1 = false;
      } else {
        if (!isError1) {
          $("#change_phone_button")
            .closest("tr")
            .after(
              `<tr><td></td><td class="error_message_details"><span class="badge bg-danger">${data["error_message"]}</span></td></tr>`
            );
          isError1 = true;
        }
      }
    },
  });
}

let isError = false;

function change_address() {
  let address = $("#new_address>input").val();
  $.ajax({
    method: "POST",
    url: "../server/controller.php",
    dataType: "json",
    data: {
      type: "change_address",
      address: address,
    },
    success: (data) => {
      if (data["success"]) {
        check_out();
        $("#change_phone_button").closest("tr").hide();
        $("#change_address_button").closest("tr").hide();
        $(".error_message_details").closest("tr").hide();
        isError = false;
      } else {
        if (!isError) {
          // check_out();
          $("#change_address_button")
            .closest("tr")
            .after(
              `<tr><td></td><td class="error_message_details"><span class="badge bg-danger">${data["error_message"]}</span></td></tr>`
            );
          isError = true;
        }
      }
    },
  });
}

function edit_phone_num() {
  $("#phone_number").hide();
  $("#edit_phone_button").hide();
  $("#new_phone_num").show();
  $("#change_phone_button").show();
}

function edit_address() {
  $("#address").hide();
  $("#edit_address_button").hide();
  $("#new_address").show();
  $("#change_address_button").show();
}

function card_details() {
  if ($("#payment_type").val() == "card") {
    let html = "";
    html += `<tr class="card_detail_collapsible"><th>Card Details: </th>
               <td><input class"card_number" type="text" placeholder="Card number"></td></tr>
               <tr class="card_detail_collapsible"><td></td>
                <td>
                  <input class="card_extra_info" type="text" placeholder="Expiration date">
                  <input class="card_extra_info" type="text" placeholder="CVV">
                </td></tr>`;
    $("#delivery-details").append(html);
  } else {
    $(".card_detail_collapsible").hide();
  }
}

function place_order() {
  let payment_type = $("#payment_type").val();
  let shipping_address = $("#address").text();
  $.ajax({
    method: "POST",
    url: "../server/controller.php",
    dataType: "json",
    data: {
      type: "place_order",
      payment_type: payment_type,
      shipping_address: shipping_address,
    },
    success: (data) => {
      if (data["success"]) {
        window.location.href = "order_confirmation.php";
      }
    },
  });
}

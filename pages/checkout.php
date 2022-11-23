<?php

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- STYLES -->
    <link rel="stylesheet" href="../styles/login.css" />
    <link rel="stylesheet" href="../styles/style.css?99" />
    <link rel="stylesheet" href="../styles/checkout.css?" />
    <link rel="stylesheet" href="../styles/footer.css" />

    <!-- HEADER ICON -->
    <link
      rel="shortcut icon"
      href="./images/header_icon.ico"
      type="image/x-icon"
    />
    <!-- FONTAWESOME LINK -->

    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
      integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <!-- GOOGLE FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;800&family=Poppins:wght@400;500;700&display=swap"
      rel="stylesheet"
    />
    <!-- Bootstrap Links -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

    <!-- AJAX AND JQUERY-->
    <script
      src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
      integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
      integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
      crossorigin="anonymous"
    ></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- javascript script -->

    <style>
      h3,
      h1 {
        color: black;
      }
      div h1 {
        padding: 1rem;
        font-size: 1.5rem;
        color: white;
        background: linear-gradient(90deg, #ffba00 0%, #ff6c00 100%);
      }
    </style>
    <title>Checkout</title>
  </head>
  <body onload="check_out();">
    <header>
      <nav class="flex">
        <a href="../index.php"
          ><img src="../images/logo.png" alt="logo" class="logo"
        /></a>
        <ul class="links flex">
          <li><a href="../index.php">Home</a></li>
          <li><a href="./shop.php">Shop</a></li>
          <li><a href="./contacts.php">Contact</a></li>
          <li>
            <a href="./cart.php">
              <i class="fa-solid fa-cart-shopping">
                <span class="badge bg-dark" id="cart_count">0</span></i
              >
            </a>
          </li>
          <li id="login_btn"><a href="./login.php">Login</a></li>
        </ul>
        <div class="burger">
          <div class="line1"></div>
          <div class="line2"></div>
          <div class="line3"></div>
        </div>
      </nav>
    </header>
    
    <main>
      <section class="third-section third-section-modify">
        <div class="container-fluid">
          <div class="row checkout-div">
            <h1 class="chechout-header">Checkout</h1>
            <div class="col-lg-8 col-sm-12 details-container">
              <h2>Delivery Details</h2>
              <table class="table table-borderless details-table">
                <thead>
                  <tr>
                    <th colspan="3">
                    </th>
                  </tr>
                </thead>
                <tbody id="delivery-details">
                  <tr>
                    <th>Select Payment Method</th>
                    <td>
                      <select onchange="card_details();" name="payment_type" id="payment_type">
                        <option value="" disabled selected hidden>Pay with</option>
                        <option value="card">Card</option>
                        <option value="cash">Cash</option>
                      </select>
                    </td>
                    <td></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="col-lg-4 col-sm-12 items-container">
              <h2>Items</h2>
              <div class="items-checkout"></div>
            </div>
            <div class="col-lg-12">
              <div class="col-lg-4 col-sm-12 place-order-area">
                <div class="vat_total_price"></div>
                <button onclick="place_order();" class="login-button">Place Order</button>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
    <?php include "footer.html" ?>
  </body>
  <script src="../scripts/animations.js"></script>
  <script src="../scripts/app.js?97"></script>
  <script src="../scripts/checkout.js"></script>
</html>
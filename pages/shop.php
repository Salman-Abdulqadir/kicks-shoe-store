<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- STYLES -->
    <link rel="stylesheet" href="../styles/login.css" />
    <link rel="stylesheet" href="../styles/style.css?11" />
    <link rel="stylesheet" href="../styles/footer.css" />

    <!-- HEADER ICON -->
    <link
      rel="shortcut icon"
      href="../images/header_icon.ico"
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
    <script src="../scripts/app.js?10"></script>
    <style>
      h3,
      h1 {
        color: black;
        font-weight: 400;
      }
    </style>
    <title>shop</title>
  </head>
  <body onload="get_products();">
    <header>
      <nav class="flex">
        <a href="#"><img src="../images/logo.png" alt="logo" class="logo" /></a>
        <ul class="links flex">
          <li><a href="../index.html">Home</a></li>
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
    <main class="shop-main">
      <section class="product-section">
        <div class="filters">
          <h3>Browse Categories</h3>
          <select onchange="get_products();" name="" id="category-filter">
            <option value="">All</option>
            <option value="Men">Men</option>
            <option value="Women">Women</option>
            <option value="Kids">Kids</option>
          </select>
          <h3><i class="fa-solid fa-filter"></i> Filters</h3>
          <label for="">Brand</label>
          <select onchange="get_products();" id="brands-filter">
            <option value="">All</option>
            <option value="Nike">Nike</option>
            <option value="Addidas">Addidas</option>
            <option value="Puma">Puma</option>
            <option value="Mango">Mango</option>
            <option value="Vance">Vance</option>
          </select>
          <label for="">Price</label>
          <select onchange="get_products();" name="" id="price-filter">
            <option value="">All</option>
            <option value="low">0 - 99 AED</option>
            <option value="medium">100 - 500 AED</option>
            <option value="high">500 AED and above</option>
          </select>
        </div>

        <div class="products">
          <div onkeyup="get_products();" class="search-product">
            <input
              type="text"
              id="search-product-input"
              placeholder="Search products..."
            />
            <button>
              <i class="fa-solid fa-magnifying-glass"></i>
            </button>
          </div>
          <div class="showing-result flex">
            <h3>Showing: <span id="filter-result">All Products</span></h3>
            <div>
              <label>Sort by Price</label>
              <select
                onchange="get_products();"
                id="sort_price"
                class="btn btn-outline-dark mx-3"
              >
                <option value="DESC">High to Low</option>
                <option value="ASC">Low to High</option>
              </select>
              <button
                id="toggle-filter-btn"
                class="btn btn-outline-dark"
                onclick="filter_toggle();"
              >
                <i class="fa-solid fa-sliders"></i> Show Filter
              </button>
            </div>
          </div>
          <div class="latest-products"></div>
        </div>
      </section>
    </main>
    <footer id="footer">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-3 col-md-6 col-sm-12">
            <h6>About Us</h6>
            <p>
              Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
              eiusmod tempor incididunt ut labore dolore magna aliqua.
            </p>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-12">
            <h6>Newsletter</h6>
            <p>Stay upto-date with our latest</p>
            <form
              class="newsletter-form d-flex flex-row"
              action=""
              method="post"
            >
              <input
                class="form-control"
                type="text"
                name="newsletter_email"
                placeholder="Enter email here"
                onfocus="this.placeholder = ''"
                onblur="this.placeholder = 'Enter email here'"
              />
              <button class="click-btn btn btn-default">
                <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
              </button>
            </form>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-12">
            <h6>Instagram Feed</h6>
            <ul class="insta-feed d-flex flex-wrap">
              <li>
                <img src="../images/insta1.webp" alt="insta-feed picture" />
              </li>
              <li>
                <img src="../images/insta2.webp" alt="insta-feed picture" />
              </li>
              <li>
                <img src="../images/insta3.webp" alt="insta-feed picture" />
              </li>
              <li>
                <img src="../images/insta4.webp" alt="insta-feed picture" />
              </li>
              <li>
                <img src="../images/insta5.webp" alt="insta-feed picture" />
              </li>
              <li>
                <img src="../images/insta6.webp" alt="insta-feed picture" />
              </li>
              <li>
                <img src="../images/insta7.webp" alt="insta-feed picture" />
              </li>
              <li>
                <img src="../images/insta8.webp" alt="insta-feed picture" />
              </li>
            </ul>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-12">
            <h6>Follow Us</h6>
            <p>Let us be social</p>
            <div class="footer-socials">
              <a href="#"><i class="fa fa-facebook"></i></a>
              <a href="#"><i class="fa fa-twitter"></i></a>
              <a href="#"><i class="fa fa-dribbble"></i></a>
              <a href="#"><i class="fa fa-behance"></i></a>
            </div>
          </div>
        </div>
        <div
          class="footer-copyright d-flex justify-content-center align-items-center flex-wrap"
        >
          <p>
            Copyright ©2022 All rights reserved |
            <a href="index.html" target="_blank">Kicks</a>
          </p>
        </div>
      </div>
    </footer>
    <script src="../scripts/animations.js?8"></script>
  </body>
</html>

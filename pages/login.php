<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <!-- STYLES -->
    <link rel="stylesheet" href="../styles/login.css" />
    <link rel="stylesheet" href="../styles/style.css?3" />
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
    <script src="../scripts/app.js?14"></script>
  </head>
  <body onload="get_user_info();">
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
    <section id="top">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12 col-sm-12">
            <!-- <img class="top-gradient" src="images/gradient.webp" alt="background-image" width="1500" height="380"> -->
            <div class="top-background-gradient"></div>
            <div class="top-header">
              <h1>Login/Register</h1>
              <div class="top-nav">
                <a href="login.html">Login</a>
                <i class="fa fa-arrows-h home-page-link"></i>
                <a href="signup.php">Register</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="login-form">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-12 image-area">
            <img src="../images/keyboard.png" alt="image not available" />
            <div class="hover-text">
              <h4>New to our website?</h4>
              <p>
                Become one of our member and enjoy all our deals and offers. You
                don't want to miss them!
              </p>
              <a href="signup.php" class="login-button">Create an Account</a>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12">
            <h3>LOG IN TO ENTER</h3>
            <div class="row">
              <div class="form-box" action="" method="post">
                <div class="col-md-12">
                  <input
                    class="login-input"
                    type="text"
                    id="username"
                    name="name"
                    placeholder="Username"
                    onfocus="this.placeholder = ''"
                    onblur="this.placeholder = 'Username'"
                  />
                </div>
                <div class="col-md-12">
                  <input
                    class="login-input"
                    id="password"
                    type="password"
                    name="password"
                    placeholder="Password"
                    onfocus="this.placeholder = ''"
                    onblur="this.placeholder = 'Password'"
                  />
                </div>
                <div class="col-md-12">
                  <input
                    class="login-checkbox"
                    type="checkbox"
                    name="remember_me"
                  />
                  <label class="login-checkbox" for="rememeber_me"
                    >Keep me logged in</label
                  >
                </div>
                <div class="col-md-12">
                  <button onclick="login();" class="login-button">
                    <strong>LOG IN</strong>
                  </button>
                  <a href="">Forgot Password?</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <?php include "footer.html"?>
    <script src="scripts/animations.js"></script>
  </body>
</html>

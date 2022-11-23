<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Bootstrap Links -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

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
    <script src="../scripts/admin.js?3"></script>

    <!-- STYLE -->
    <link rel="stylesheet" href="../styles/admin.css?23" />

    <title>Admin Dashboard</title>
  </head>
  <body>
    <main>
      <section class="admin-options">
        <h1><i class="fa-solid fa-gear"> </i> Dashboard</h1>
        <div class="option">
          <h2>Products</h2>
          <ul class="products">
            <li onclick="add_product_admin();"><i class="fa-solid fa-add"></i> Add Products</li>
            <li onclick="manage_products();"><i class="fa-solid fa-trash"></i> Delete Products</li>
            <li onclick="manage_quantity();"><i class="fa-solid fa-list-check"></i> Manage Quantity</li>
          </ul>
        </div>
        <div class="option">
          <h2>Manage Users</h2>
          <ul class="products">
            <li onclick="manage_users();"><i class="fa-solid fa-trash"></i> Delete User Accounts</li>
          </ul>
        </div>
      </section>
      <section class="content">
        <h1 class="title">Admin Dashboard</h1>
        <img src="../images/logo.png" width="600" alt="" srcset="">
        
      </section>
    </main>
  </body>
</html>

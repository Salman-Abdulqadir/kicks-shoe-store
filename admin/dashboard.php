<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

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
    <script src="../scripts/app.js?13"></script>

    <!-- STYLE -->
    <link rel="stylesheet" href="../styles/admin.css?3" />

    <title>Admin Dashboard</title>
    <style>
      .success-message {
        padding: 1rem;
        background-color: lightgreen;
        border-radius: 5px;
        transform: translateY(-200%);
      }
      @keyframes show-message {
        0% {
          opacity: 1;
          transform: translateY(-200%);
        }
        50% {
          opacity: 1;
          transform: translateY(0);
        }
        100% {
          opacity: 0;
          transform: translateY(-200%);
        }
      }
    </style>
  </head>
  <body>
    <main>
      <section class="admin-options">
        <h1><i class="fa-solid fa-gear"> </i> Dashboard</h1>
        <div class="option">
          <h2>Products</h2>
          <ul class="products">
            <li><i class="fa-solid fa-add"></i> Add Products</li>
            <li><i class="fa-solid fa-trash"></i> Delete Products</li>
            <li><i class="fa-solid fa-list-check"></i> Manage Quantity</li>
          </ul>
        </div>
        <div class="option">
          <h2>Manage Users</h2>
          <ul class="products">
            <li><i class="fa-solid fa-trash"></i> Delete User Accounts</li>
          </ul>
        </div>
      </section>
      <section class="content">
        <div class="add-product">
          <h2 class="success-message"></h2>
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
        </div>
      </section>
    </main>
  </body>
</html>

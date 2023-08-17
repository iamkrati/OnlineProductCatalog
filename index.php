<?php

include_once('conn.php');

if (isset($_POST['submit'])) {
  $p_name = $_POST['name'];
  $p_desc = $_POST['description'];
  $p_price = $_POST['price'];
  $p_category = $_POST['category'];

  // Validate and sanitize user input
  $p_name = mysqli_real_escape_string($conn, $p_name);
  $p_desc = mysqli_real_escape_string($conn, $p_desc);
  $p_category = mysqli_real_escape_string($conn, $p_category);

  $image = $_FILES["image"];
  $image_name = mysqli_real_escape_string($conn, $image["name"]);
  $image_tmp = $image["tmp_name"];
  $upload_directory = "uploads/";

  // Generate a unique image name to avoid overwriting existing files
  $unique_image_name = uniqid() . '_' . $image_name;
  $uploaded_image_path = $upload_directory . $unique_image_name;

  if (move_uploaded_file($image_tmp, $uploaded_image_path)) {

    $sql = "INSERT INTO Products (name, description, price, image_url) 
              VALUES ('$p_name', '$p_desc', '$p_price', '$uploaded_image_path')";

    if (mysqli_query($conn, $sql)) {

      $cat_query = "SELECT id FROM Products WHERE image_url = '$uploaded_image_path'";
      $cat_result = mysqli_query($conn, $cat_query);
      if ($cat_result && mysqli_num_rows($cat_result) > 0) {
        $cat_row = mysqli_fetch_assoc($cat_result);
        $product_id = $cat_row['id'];
        $cat_name = mysqli_real_escape_string($conn, $_POST['category']);
        $sql1 = "INSERT INTO Categories (id, name) VALUES ('$product_id', '$cat_name')";
        if (mysqli_query($conn, $sql1)) {
          // Product added successfully
          echo '<script>
              alert("Product added successfully");
              </script>';
        } else {
          // Error occurred while inserting data
          echo "Error: " . mysqli_error($conn);
        }
        ;
      }

    } else {
      // Error occurred while inserting data
      echo "Error: " . mysqli_error($conn);
    }
  } else {
    // Error occurred while uploading image
    echo '<script>
      alert("Error uploading image.");
      </script>';
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add New Product</title>
  <link href="./add_product.css" rel="stylesheet">
</head>

<body>
  <div class="container">
    <h2>Add New Product</h2>
    <form method="post" id="productForm" enctype="multipart/form-data">
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" required>

      <label for="description">Description:</label>
      <textarea id="description" name="description" rows="4" required></textarea>

      <label for="price">Price:</label>
      <input type="number" id="price" name="price" required>

      <label for="category">Category:</label>
      <select id="category" name="category" required>
        <option value="books">Books</option>
        <option value="electronics">Electronics</option>
        <option value="clothing">Clothing</option>
        <!-- Add more options as needed -->
      </select>

      <label for="image">Image:</label>
      <input type="file" id="image" name="image" accept="image/*" required>

      <button type="submit" name="submit">Add Product</button>
    </form>
  </div>

</body>

</html>
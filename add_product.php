<?php include "../includes/auth.php"; ?>

<form action="" method="POST" enctype="multipart/form-data">
<input type="text" name="name" placeholder="Product Name">
<input type="number" name="price" placeholder="Price">
<input type="file" name="image">
<textarea name="desc"></textarea>

<button>Add</button>
</form>

<?php
include "../config/db.php";

if($_POST){
  $name = $_POST['name'];
  $price = $_POST['price'];
  $desc = $_POST['desc'];

  $img = $_FILES['image']['name'];
  move_uploaded_file($_FILES['image']['tmp_name'], "../assets/uploads/".$img);

  $conn->query("INSERT INTO products (name,price,image,description)
  VALUES ('$name','$price','$img','$desc')");
}
?>
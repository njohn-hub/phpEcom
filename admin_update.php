
<?php

@include 'config.php';

$id = $_GET['edit'];

if(isset($_POST['update_product'])){
$product_name = $_POST['product_name'];
$product_price = $_POST['product_price'];
$product_image= $_FILES['product_image']['name'];
$product_image_tmp_name= $_FILES['product_image']['tmp_name'];
$product_image_folder= 'uploaded_image/' .$product_image;

if(empty($product_image) || empty($product_name) || empty($product_price)){
    $message[] = 'please fill out all fields';
}else{
    $update = "UPDATE products SET name='$product_name', price='$product_price',
    image='$product_image' WHERE id = $id" ; 
    $upload = mysqli_query($conn, $update);
    if($upload){
        move_uploaded_file($product_image_tmp_name, $product_image_folder);
        header('location:admin_page.php');
    }else {
        $message[] = 'could not add the product. Try again later';
    }
};

};

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin update</title>

        <!-- fontawesome link  -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- fontawesome link  -->

    <!-- css file link  -->
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <!-- css file link  -->

</head>
<body>

<?php 

if(isset($message)){
    foreach($message as $message){
        echo '<span class="message">'.$message.'</span>';
    }
}

?>

<div class="container">

<div class="admin-product-form-container centered">

    <?php 
    
    $select = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
    while($row = mysqli_fetch_assoc($select)){

    

    ?>

<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
    <h3>update a product</h3>
    <input type="text" placeholder="enter product name" 
    value="<?php $row['name']; ?>"
     name="product_name" class="box">
    <input type="number" placeholder="enter product price"
    value="<?php $row['price']; ?>"
     name="product_price" class="box">
     <input type="file" accept="image/png, image/jpeg, image/jpg"
     name="product_image" class="box" id="">
     <input type="submit" value="update a product" class="btn" name="update_product" >
    <a href="admin_page.php" class="btn" >go back</a>
</form>

<?php } ?>

</div>

</div>
    
</body>
</html>
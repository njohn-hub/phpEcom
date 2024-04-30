<?php 

@include 'config.php';

    if(isset($_POST['add_product'])){
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image= $_FILES['product_image']['name'];
    $product_image_tmp_name= $_FILES['product_image']['tmp_name'];
    $product_image_folder= 'uploaded_image/' .$product_image;

    if(empty($product_image) || empty($product_name) || empty($product_price)){
        $message[] = 'please fill out all fields';
    }else{
        $insert = "INSERT INTO products(name, price, image) 
        VALUES('$product_name', '$product_price', '$product_image')";
        $upload = mysqli_query($conn, $insert);
        if($upload){
            move_uploaded_file($product_image_tmp_name, $product_image_folder);
            $message[] = 'new product added';   
        }else {
            $message[] = 'could not add the product. Try again later';
        }
    };

};

if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM products WHERE id = $id");
    header('location:admin_page.php');
};

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin page</title>

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

        <div class="admin-product-form-container">

            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                <h3>add a new product</h3>
                <input type="text" placeholder="enter product name"
                 name="product_name" class="box">
                <input type="number" placeholder="enter product price"
                 name="product_price" class="box">
                 <input type="file" accept="image/png, image/jpeg, image/jpg"
                 name="product_image" class="box" id="">
                 <input type="submit" value="add a product" class="btn" name="add_product" >

            </form>

        </div>
        <?php 
    $select = mysqli_query($conn, "SELECT * FROM products");
?>

<div class="product-display">
    <table class="product-display-table">
        <thead>
            <tr>
                <th>Product Image</th>
                <th>Product Name</th>
                <th>Product Price</th>
                <th colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                while($row = mysqli_fetch_assoc($select)){
            ?>
                <tr>
                    <td><img src="uploaded_image/<?php echo $row['image']; ?>" height="100" width="150" alt=""></td>
                    <td><?php echo $row['name']; ?></td>
                    <td>$<?php echo $row['price']; ?></td>
                    <td>
                        <a href="admin_update.php?edit=<?php echo $row['id']; ?>" class="btn" >
                            <i class="fas fa-edit"></i> edit
                        </a>
                        <a href="admin_page.php?delete=<?php echo $row['id']; ?>" class="btn" >
                            <i class="fas fa-trash"></i> delete
                        </a>
                    </td>
                </tr>
            <?php 
                }
            ?>
 

        </table>

        </div>

    </div>

</body>

</html>
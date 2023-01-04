<?php
include 'crud_functions_product.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $price = isset($_POST['price']) ? $_POST['price'] : '';
    $rrp = isset($_POST['rrp']) ? $_POST['rrp'] : '';
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : '';
    $img = isset($_POST['img']) ? $_POST['img'] : '';
    // Insert new record into the products table
    $stmt = $pdo->prepare('INSERT INTO products VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$id, $name, $price, $rrp, $quantity, $img]);
    // Output message
    $msg = 'Added Successfully!';
}
?>

<?=template_header('Add Product')?>

<div class="content update">
    <h2>Add a Product</h2>
    <form action="crud_create_product.php" method="post">
        <label for="id">ID</label>
        <input type="text" name="id" placeholder="26" value="auto" id="id">
        <label for="name">Name</label>
        <input type="text" name="name" placeholder="Name" id="name" required>
        <label for="price">Price</label>
        <input type="number" step="0.01" name="price" placeholder="Price" id="price" required>
        <label for="rpp">Recommended Retail Price</label>
        <input type="number" step="0.01" name="rpp" placeholder="Rpp" id="rpp" required>
        <label for="quantity">Quantity</label>
        <input type="number" name="quantity" placeholder="Quantity" id="quantity" required>
        <label for="img">Image File Name</label>
        <input type="text" name="img" placeholder="Image" id="img" required>
        <input type="submit" value="Add">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
<?php
include 'crud_functions_price.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the product id exists, for example update.php?id=1 will get the product with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the crud_create_price.php, but instead we update a record and not insert
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $price = isset($_POST['price']) ? $_POST['price'] : '';
        $rrp = isset($_POST['rrp']) ? $_POST['rrp'] : '';
        $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : '';
        $img = isset($_POST['img']) ? $_POST['img'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE products SET id = ?, name = ?, price = ?, rrp = ?, quantity = ?, img = ? WHERE id = ?');
        $stmt->execute([$id, $name, $price, $rrp, $quantity, $img, $_GET['id']]);
        $msg = 'Price Updated Successfully!';
    }
    // Get the products from the products table
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$product) {
        exit('Product doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Update Product')?>

<div class="content update">
    <h2>Product ID #<?=$product['id']?></h2>
    <form action="crud_update_price.php?id=<?=$product['id']?>" method="post">
        <label for="id">ID</label>
        <input type="text" name="id" placeholder="1" value="<?=$product['id']?>" id="id" readonly>
        <label for="name">Name</label>
        <input type="text" name="name" placeholder="name" value="<?=$product['name']?>" id="name" readonly>
        <label for="price">Price</label>
        <input type="number" step="0.01" name="price" placeholder="Price" value="<?=$product['price']?>" id="price">
        <label for="rrp">Recommended Retail Price</label>
        <input type="number" step="0.01" name="rrp" placeholder="rrp" value="<?=$product['rrp']?>" id="rrp">
        <input type="number" name="quantity" placeholder="Quantity" value="<?=$product['quantity']?>" id="quantity" hidden>
        <input type="text" name="img" placeholder="Image" value="<?=$product['img']?>" id="img" hidden>
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
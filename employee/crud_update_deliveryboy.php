<?php
include 'crud_functions_deliveryboy.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the deliveryboy id exists, for example update.php?id=1 will get the deliveryboy with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the crud_create_deliveryboy.php, but instead we update a record and not insert
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $username = isset($_POST['username']) ? $_POST['username'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE deliveryboy_signed SET id = ?, username = ?, password = ?, email = ? WHERE id = ?');
        $stmt->execute([$id, $username, $password, $email, $_GET['id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the deliveryboy from the deliveryboy_signed table
    $stmt = $pdo->prepare('SELECT * FROM deliveryboy_signed WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $deliveryboy = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$deliveryboy) {
        exit('Delivery Boy doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Update Delivery Boy')?>

<div class="content update">
    <h2>Delivery Boy ID #<?=$deliveryboy['id']?></h2>
    <form action="crud_update_deliveryboy.php?id=<?=$deliveryboy['id']?>" method="post">
        <label for="id">ID</label>
        <input type="text" name="id" placeholder="1" value="<?=$deliveryboy['id']?>" id="id" readonly>
        <label for="name">Username</label>
        <input type="text" name="username" placeholder="Username" value="<?=$deliveryboy['username']?>" id="username">
        <label for="password">Password</label>
        <input type="password" name="password" placeholder="Password" value="<?=$deliveryboy['password']?>" id="password">
        <label for="email">Email</label>
        <input type="text" name="email" placeholder="Email" value="<?=$deliveryboy['email']?>" id="email">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
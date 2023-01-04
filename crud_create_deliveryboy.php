<?php
include 'crud_functions_deliveryboy.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    // Insert new record into the deliveryboy_signed table
    $stmt = $pdo->prepare('INSERT INTO deliveryboy_signed VALUES (?, ?, ?, ?)');
    $stmt->execute([$id, $username, $password, $email]);
    // Output message
    $msg = 'Added Successfully!';
}
?>

<?=template_header('Add Delivery Boy')?>

<div class="content update">
    <h2>Add a Delivery Boy</h2>
    <form action="crud_create_deliveryboy.php" method="post">
        <label for="id">ID</label>
        <input type="text" name="id" placeholder="26" value="auto" id="id">
        <label for="username">Username</label>
        <input type="text" name="username" placeholder="Username" id="username" required>
        <label for="password">Password</label>
        <input type="password" name="password" placeholder="Password" id="password" required>
        <label for="email">Email</label>
        <input type="text" name="email" placeholder="Email" id="email" required>
        <input type="submit" value="Add">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
<?php
include 'crud_functions_deliveryboy.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check that the deliveryboy ID exists
if (isset($_GET['id'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM deliveryboy_signed WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $deliveryboy = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$deliveryboy) {
        exit('Delivery boy doesn\'t exist with that ID!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM deliveryboy_signed WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'Delivery Boy has been deleted!';
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: crud_read_deliveryboy.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Delete Delivery Boy')?>

<div class="content delete">
    <h2>Delivery Boy ID #<?=$deliveryboy['id']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
    <p>Are you sure you want to delete delivery boy #<?=$deliveryboy['id']?>?</p>
    <div class="yesno">
        <a href="crud_delete_deliveryboy.php?id=<?=$deliveryboy['id']?>&confirm=yes">Yes</a>
        <a href="crud_delete_deliveryboy.php?id=<?=$deliveryboy['id']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>
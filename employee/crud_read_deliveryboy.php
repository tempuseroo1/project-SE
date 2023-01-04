<?php
include 'crud_functions_deliveryboy.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 5;

$stmt = $pdo->prepare('SELECT * FROM deliveryboy_signed ORDER BY id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$deliveryboys = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of deliveryboys, this is so we can determine whether there should be a next and previous button
$num_deliveryboys = $pdo->query('SELECT COUNT(*) FROM deliveryboy_signed')->fetchColumn();
?>

<?=template_header('Delivery Boy List')?>

<div class="content read">
	<h2>List of Delivery Boys</h2>
	<a href="crud_create_deliveryboy.php" class="create-employee">Add a Delivery Boy</a>
	<table>
        <thead>
            <tr>
                <td>Username</td>
                <td>Password</td>
                <td>Email</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($deliveryboys as $deliveryboy): ?>
            <tr>
                <td><?=$deliveryboy['username']?></td>
                <td><?=$deliveryboy['password']?></td>
                <td><?=$deliveryboy['email']?></td>
                <td class="actions">
                    <a href="crud_update_deliveryboy.php?id=<?=$deliveryboy['id']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="crud_delete_deliveryboy.php?id=<?=$deliveryboy['id']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="crud_read_deliveryboy.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_deliveryboys): ?>
		<a href="crud_read_deliveryboy.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>
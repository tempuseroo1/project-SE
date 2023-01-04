<?php
include 'crud_functions_employee.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 5;

$stmt = $pdo->prepare('SELECT * FROM employee_signed ORDER BY id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of employees, this is so we can determine whether there should be a next and previous button
$num_employees = $pdo->query('SELECT COUNT(*) FROM employee_signed')->fetchColumn();
?>

<?=template_header('Employee List')?>

<div class="content read">
	<h2>List of Employees</h2>
	<a href="crud_create_employee.php" class="create-employee">Add an Employee</a>
	<table>
        <thead>
            <tr>
                <td>Username</td>
                <td>Password</td>
                <td>Email</td>
                <td>Department</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employees as $employee): ?>
            <tr>
                <td><?=$employee['username']?></td>
                <td><?=$employee['password']?></td>
                <td><?=$employee['email']?></td>
                <td><?=$employee['department']?></td>
                <td class="actions">
                    <a href="crud_update_employee.php?id=<?=$employee['id']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="crud_delete_employee.php?id=<?=$employee['id']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="crud_read_employee.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_employees): ?>
		<a href="crud_read_employee.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>
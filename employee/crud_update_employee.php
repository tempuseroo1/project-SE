<?php
include 'crud_functions_employee.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the employee id exists, for example update.php?id=1 will get the employee with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the crud_create_employee.php, but instead we update a record and not insert
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $username = isset($_POST['username']) ? $_POST['username'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $department = isset($_POST['department']) ? $_POST['department'] : '';
        // Update the record
        $stmt = $pdo->prepare('UPDATE employee_signed SET id = ?, username = ?, password = ?, email = ?, department = ? WHERE id = ?');
        $stmt->execute([$id, $username, $password, $email, $department, $_GET['id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the employee from the employee_signed table
    $stmt = $pdo->prepare('SELECT * FROM employee_signed WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $employee = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$employee) {
        exit('Employee doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Update Employee')?>

<div class="content update">
    <h2>Employee ID #<?=$employee['id']?></h2>
    <form action="crud_update_employee.php?id=<?=$employee['id']?>" method="post">
        <label for="id">ID</label>
        <input type="text" name="id" placeholder="1" value="<?=$employee['id']?>" id="id" readonly>
        <label for="name">Username</label>
        <input type="text" name="username" placeholder="Username" value="<?=$employee['username']?>" id="username">
        <label for="password">Password</label>
        <input type="password" name="password" placeholder="Password" value="<?=$employee['password']?>" id="password">
        <label for="email">Email</label>
        <input type="text" name="email" placeholder="Email" value="<?=$employee['email']?>" id="email">
        <label for="department">Department</label>
        <input type="text" name="department" placeholder="Department" value="<?=$employee['department']?>" id="department">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
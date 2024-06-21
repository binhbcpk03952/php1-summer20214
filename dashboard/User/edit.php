<?php
// include_once('../../DBUntil.php');

$dbHelper = new DBUntil();
$errors = [];
$id = $_GET['id'];

// Ensure ID is numeric
if (!is_numeric($id)) {
    die("Invalid ID");
}

// Fetch the user data based on ID
$detail = $dbHelper->select("SELECT * FROM users WHERE maKh = ?", array($id));
$detail = $detail[0];
function isCheckEmail($email, $id) {
    global $dbHelper;
    $result = $dbHelper->select("SELECT email FROM users WHERE email = ? AND maKh != ?", [$email, $id]);
    return count($result) > 0;
}

function isCheckUsername($username, $id) {
    global $dbHelper;
    $result = $dbHelper->select("SELECT username FROM users WHERE username = ? AND maKh != ?", [$username, $id]);
    return count($result) > 0;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['username']) || empty($_POST['username'])) {
        $errors['username'] = "Username is required <br>";
        if (isCheckUsername($_POST['username'], $id)) {
            $errors['username'] = "Username is ton tai <br>";
        }
    }
    if (!isset($_POST['email']) || empty($_POST['email'])) {
        $errors['email'] = "Email is required";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }
    elseif(isCheckEmail($_POST['email'], $id)) {
        $errors['email'] = "Email is ton tai";
    }
    if (!isset($_POST['password']) || empty($_POST['password'])) {
        $errors['password'] = "Password is required <br>";
    } elseif (strlen($_POST['password']) < 6) {
        $errors['password'] = "Password must be at least 6 characters long";
    }
    if (!isset($_POST['role']) || empty($_POST['role'])) {
        $errors['role'] = "Role is required ";
    }
    if (!isset($_POST['status']) || empty($_POST['status'])) {
        $errors['status'] = "Status is required <br>";
    }
    if (!isset($_POST['phone']) || empty($_POST['phone'])) {
        $errors['phone'] = "Phone is required <br>";
    } elseif (!is_numeric($_POST['phone'])) {
        $errors['phone'] = "Phone must be a number <br>";
    } elseif (strlen($_POST['phone']) != 10) {
        $errors['phone'] = "Phone must be 10 digits long<br>";
    }
    if (!isset($_POST['address']) || empty($_POST['address'])) {
        $errors['address'] = "Address is required <br>";
    }

    if (count($errors) === 0) {
        $data = [
            'sdt' => $_POST['phone'],
            'diachi' => $_POST['address'],
            'username' => $_POST['username'],
            'password' => $_POST['password'],
            'role' => $_POST['role'],
            'status' => $_POST['status'],
            'email' => $_POST['email'],
        ];

        $isUpdate = $dbHelper->update('users', $data, "maKh = $id");
        if ($isUpdate) {
            header("Location: master.php?view=user_list");
            exit();
        } else {
            $errors['database'] = "Failed to update user";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit User</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div class="container mt-3">
        <h2>Edit User</h2>
        <form class="user" action="master.php?view=user_update&id=<?php echo htmlspecialchars($id); ?>" method="POST">
            <div class="form-group">
                <input type="text" class="form-control form-control-user" id="exampleInputUsername" placeholder="Username" name="username" value="<?php echo htmlspecialchars($detail['username']); ?>">
                <?php if (isset($errors['username'])) echo "<span>{$errors['username']}</span>"; ?>
            </div>
            <div class="form-group">
                <input type="email" class="form-control form-control-user" id="exampleInputEmail" placeholder="Email Address" name="email" value="<?php echo htmlspecialchars($detail['email']); ?>">
                <?php if (isset($errors['email'])) echo "<span>{$errors['email']}</span>"; ?>
            </div>
            <div class="form-group">
                <input type="text" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" name="password" value="<?php echo htmlspecialchars($detail['password']); ?>">
                <?php if (isset($errors['password'])) echo "<span>{$errors['password']}</span>"; ?>
            </div>
            <div class="form-group">
                <input type="text" class="form-control form-control-user" id="exampleInputStatus" placeholder="Status" name="status" value="<?php echo htmlspecialchars($detail['status']); ?>">
                <?php if (isset($errors['status'])) echo "<span>{$errors['status']}</span>"; ?>
            </div>
            <div class="form-group">
                <input type="text" class="form-control form-control-user" id="exampleInputAddress" placeholder="Address" name="address" value="<?php echo htmlspecialchars($detail['diachi']); ?>">
                <?php if (isset($errors['address'])) echo "<span>{$errors['address']}</span>"; ?>
            </div>
            <div class="form-group">
                <input type="text" class="form-control form-control-user" id="exampleInputPhone" placeholder="Phone" name="phone" value="<?php echo htmlspecialchars($detail['sdt']); ?>">
                <?php if (isset($errors['phone'])) echo "<span>{$errors['phone']}</span>"; ?>
            </div>
            <div>
                <select class="mb-3 form-control form-control-user" name="role">
                    <option value="">Select Role</option>
                    <option value="admin" <?php if ($detail['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                    <option value="user" <?php if ($detail['role'] == 'user') echo 'selected'; ?>>User</option>
                </select>
                <?php if (isset($errors['role'])) echo "<span>{$errors['role']}<br></span>"; ?>
            </div>
            <button type="submit" class="btn btn-primary btn-user btn-block">
                Update Account
            </button>
        </form>
    </div>

</body>

</html>
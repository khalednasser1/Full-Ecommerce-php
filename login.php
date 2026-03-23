<?php include 'includes/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow border-0">
                <div class="card-body p-4">
                    <h3 class="text-center mb-4 fw-bold">Login to TechGear</h3>
                    <form action="login.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Enter username" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                        </div>
                        <button type="submit" name="login" class="btn btn-dark w-100 py-2">Login Now</button>
                    </form>
                    <div class="text-center mt-3">
                        <span>New user? <a href="register.php" class="text-primary">Create account</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['login'])) {
    $user = $_POST['username'];
    $pass = md5($_POST['password']);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->execute([$user, $pass]);
    $data = $stmt->fetch();

    if ($data) {
        $_SESSION['user_id'] = $data['id'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['role'] = $data['role']; // Store if admin or user
        
        echo "<script>window.location='index.php';</script>";
    } else {
        echo "<script>alert('Invalid Username or Password!');</script>";
    }
}
include 'includes/footer.php';
?>
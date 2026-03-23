<?php include 'includes/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Create Account</h3>
                    <form action="register.php" method="POST">
                        <div class="mb-3">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" name="register" class="btn btn-primary w-100">Register</button>
                    </form>
                    <p class="mt-3 text-center">Already have an account? <a href="login.php">Login here</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['register'])) {
    $user = $_POST['username'];
    $pass = md5($_POST['password']); // Using md5 for simplicity in your project

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'user')");
        $stmt->execute([$user, $pass]);
        echo "<script>alert('Registration Successful! Please Login.'); window.location='login.php';</script>";
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Error: Username might already exist!</div>";
    }
}
include 'includes/footer.php';
?>
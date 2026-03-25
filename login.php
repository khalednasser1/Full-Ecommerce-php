<?php 
include 'includes/db.php';
include 'includes/header.php'; 
// session_start(); 

if (isset($_POST['login'])) {
    $email = htmlspecialchars($_POST['email']);
    $pass  = md5($_POST['password']);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $stmt->execute([$email, $pass]);
    $data = $stmt->fetch();

    if ($data) {
        $_SESSION['user_id']  = $data['id'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['role']     = $data['role'];


        header('Location: index.php');
        exit;
    } 
}


?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow border-0" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <h3 class="text-center mb-4 fw-bold">Login to TechGear</h3>

                    <form action="login.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Email Address</label>
                            <input type="email" name="email" class="form-control shadow-none" placeholder="name@example.com" required style="border-radius: 10px;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Password</label>
                            <input type="password" name="password" class="form-control shadow-none" placeholder="••••••••" required style="border-radius: 10px;">
                        </div>
                        <button type="submit" name="login" class="btn btn-dark w-100 py-2 mt-2" style="border-radius: 50px; font-weight: 600;">
                            Login Now <i class="fas fa-sign-in-alt ms-1"></i>
                        </button>
                    </form>
                    <div class="text-center mt-3">
                        <span class="small text-muted">New user? <a href="register.php" class="text-primary fw-bold text-decoration-none">Create account</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
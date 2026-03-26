<?php 
include 'includes/db.php'; 
include 'includes/header.php'; 

// 1. Logic: Registration Process
if (isset($_POST['register'])) {
    $user  = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $pass  = md5($_POST['password']); // التشفير اللي احنا شغالين بيه

    
      
        $stmt = $pdo->prepare("INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, 'user')");
        
        if ($stmt->execute([$user, $pass, $email])) {
            echo "<script>alert('Account Created Successfully! Go to Login.'); window.location='login.php';</script>";
            exit;
        }
    
}
?>

<style>
    body { background-color: #f5f5f7; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
    .auth-card {
        border: none;
        border-radius: 24px;
        background: #fff;
        box-shadow: 0 20px 40px rgba(0,0,0,0.06);
        padding: 40px;
        margin-top: 60px;
    }
    .form-label { font-weight: 600; color: #1d1d1f; margin-bottom: 8px; }
    .form-control {
        border-radius: 12px;
        padding: 12px 15px;
        border: 1px solid #d2d2d7;
        background: #fbfbfd;
        transition: all 0.2s ease-in-out;
    }
    .form-control:focus {
        border-color: #0071e3;
        box-shadow: 0 0 0 4px rgba(0, 113, 227, 0.1);
        background: #fff;
    }
    .btn-auth {
        border-radius: 50px;
        padding: 14px;
        font-weight: 700;
        background-color: #0071e3;
        border: none;
        margin-top: 20px;
    }
    .btn-auth:hover { background-color: #0077ed; transform: scale(1.01); }
</style>

<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card auth-card">
                <div class="text-center mb-4">
                    <h2 class="fw-bold">Create Account</h2>
                    <p class="text-muted">Start your journey with us</p>
                </div>

                

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label small">Username</label>
                        <input type="text" name="username" class="form-control shadow-none" placeholder="ex: Khaled_2026" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small">Email Address</label>
                        <input type="email" name="email" class="form-control shadow-none" placeholder="name@example.com" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small">Password</label>
                        <input type="password" name="password" class="form-control shadow-none" placeholder="••••••••" required>
                    </div>

                    <button type="submit" name="register" class="btn btn-primary btn-auth w-100">
                        Sign Up <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                </form>

                <div class="text-center mt-4">
                    <p class="mb-0 text-muted small">Already have an account? 
                        <a href="login.php" class="text-primary fw-bold text-decoration-none">Log in here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
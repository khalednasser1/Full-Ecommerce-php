<?php 
session_start();
include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TechGear | Your Tech Store</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="style.css">
  <style>
    :root {
        --nav-bg: rgba(33, 37, 41, 0.95); /* شفافية بسيطة */
        --accent-color: #0071e3;
    }.navbar {
        background: var(--nav-bg) !important;
        backdrop-filter: blur(10px); /* تأثير الزجاج الضبابي */
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding: 15px 0;
        transition: all 0.3s ease;
    }

    .navbar-brand {
        font-size: 1.5rem;
        letter-spacing: -0.5px;
    }

    .nav-link {
        font-weight: 500;
        color: rgba(255,255,255,0.8) !important;
        margin: 0 10px;
        transition: all 0.3s ease;
        position: relative;
    }

    .nav-link:hover {
        color: #fff !important;
    }
    .cart-icon-wrapper {
        position: relative;
        display: inline-block;
    }

    .cart-badge {
        position: absolute;
        top: -8px;
        right: -12px;
        background: var(--accent-color);
        font-size: 0.7rem;
        padding: 3px 6px;
        border-radius: 50%;
        border: 2px solid #212529;
    }
    .user-welcome {
        font-size: 0.9rem;
        font-weight: 500;
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container"> 
      <a class="navbar-brand fw-bold" href="http://localhost/Khaled%20Abd%20Elnasser%20Mohammed/index.php">TechGear <i class="fas fa-microchip text-success"></i></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto">
          <li class="nav-item"><a class="nav-link " href="http://localhost/Khaled%20Abd%20Elnasser%20Mohammed/index.php">Home</a></li>
          <li class="nav-item">
            <a class="nav-link" href="cart.php">
              <span class="cart-icon-wrapper">
                <i class="fas fa-shopping-bag"></i>
                <span class="cart-badge shadow-sm">
                  <?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>
                </span>
              </span>
            </a>
          </li> 
         
          <li class="nav-item"><a class="nav-link text-warning" href="./admin/admin.php"><i class="fas fa-sliders-h"></i></a></li>
          
        </ul>
        <div class="d-flex align-items-center">
          <?php if (isset($_SESSION['user_id'])): ?>
            <span class="text-white me-3">Welcome, <span class="text-warning user-welcome"><?= $_SESSION['username'] ?></span> ! </span>
            <a href="http://localhost/Khaled%20Abd%20Elnasser%20Mohammed/logout.php" class="btn btn-danger btn-sm rounded-pill">Logout <i class="fas fa-sign-out-alt"></i></a>
          <?php else: ?>
            <a href="login.php" class="btn btn-light btn-sm">Login</a>
            <a href="register.php" class="btn btn-light btn-sm m-1">Register</a>
          <?php endif; ?>
        </div>
        <form action="index.php" method="GET" class="d-flex ms-auto">
          <div class="input-group input-group-sm shadow-sm rounded-pill overflow-hidden">
            <input type="text" name="q" class="form-control border-0 ps-3" placeholder="Search..." value="<?php echo htmlspecialchars($_GET['q'] ?? ''); ?>">
            <button class="btn btn-primary px-3" type="submit">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </form>
      </div>
    </div>
  </nav>
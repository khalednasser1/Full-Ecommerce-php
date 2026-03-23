<?php include 'includes/header.php'; ?>

<div class="container my-5 py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">Contact Us</h2>
        <p class="text-muted">Have a question? We'd love to hear from you.</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6 mb-5">
            <div class="card border-0 shadow-sm p-4">
                <form action="#" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" placeholder="Enter your name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control" placeholder="name@example.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Message</label>
                        <textarea class="form-control" rows="4" placeholder="How can we help you?" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Send Message</button>
                </form>
            </div>
        </div>

        <div class="col-md-4 offset-md-1">
            <div class="mb-4">
                <h5 class="fw-bold"><i class="fas fa-map-marker-alt text-primary me-2"></i> Our Location</h5>
                <p class="text-muted">123 Business Street, Cairo, Egypt</p>
            </div>
            <div class="mb-4">
                <h5 class="fw-bold"><i class="fas fa-phone-alt text-primary me-2"></i> Phone Number</h5>
                <p class="text-muted">+20 123 456 789</p>
            </div>
            <div class="mb-4">
                <h5 class="fw-bold"><i class="fas fa-envelope text-primary me-2"></i> Email Support</h5>
                <p class="text-muted">support@yourbrand.com</p>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
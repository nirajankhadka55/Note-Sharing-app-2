<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About NoteShare</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="container header">
        <a href="index.php" class="brand">NoteShare</a>
        <div class="nav">
            <a href="about.php" style="color: var(--primary);">About</a>
            <a href="login.php">Login</a>
            <a href="signup.php" class="btn-nav-primary">Sign Up</a>
        </div>
    </nav>

    <!-- Page Header -->
    <div class="container" style="text-align: center; padding: 60px 0 20px;">
        <h1 style="font-size: 48px; font-weight: 800; color: #111827; margin-bottom: 16px;">About Us</h1>
        <p style="font-size: 20px; color: #6b7280; max-width: 600px; margin: 0 auto;">"Struggling to find reliable study materials shouldn't be part of the learning process. NoteShare was designed to solve the clutter of modern education by organizing the world's best student-generated content into one searchable hub. Whether you’re preparing for a final exam or mastering a new professional skill, our platform connects you with high-quality, peer-reviewed notes that simplify complex topics and save you hours of research time.".</p>
    </div>

    <!-- How It Works Section -->
    <section class="how-it-works">
        <div class="container">
            <h2 class="section-title">How It Works</h2>
            <div class="steps-grid">
                <div class="step-card scroll-hidden">
                    <div class="step-number">1</div>
                    <h3>Sign Up</h3>
                    <p>Create your free account in seconds. No credit card required.</p>
                </div>
                <div class="step-card scroll-hidden" style="transition-delay: 100ms;">
                    <div class="step-number">2</div>
                    <h3>Create Notes</h3>
                    <p>Use our simple editor to write down your ideas and attach files.</p>
                </div>
                <div class="step-card scroll-hidden" style="transition-delay: 200ms;">
                    <div class="step-number">3</div>
                    <h3>Share Instantly</h3>
                    <p>Toggle visibility to Public and share your unique link with anyone.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; <?= date('Y') ?> NoteShare. All rights reserved.</p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>

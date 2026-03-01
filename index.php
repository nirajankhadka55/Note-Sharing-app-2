<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NoteShare - Share Your Thoughts Securely</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="container header">
        <a href="index.php" class="brand">NoteShare</a>
        <div class="nav">
            <a href="about.php">About</a>
            <a href="login.php">Login</a>
            <a href="signup.php" class="btn-nav-primary">Sign Up</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero">

        <div class="container hero-content">
            <h1 class="hero-title" id="typing-text"></h1>
            <p class="hero-subtitle">The simplest way to keep your notes organized and share them with the world. Secure, fast, and free.</p>
            <div class="hero-actions">
                <a href="signup.php" class="btn-hero">Get Started for Free</a>
                <a href="public_notes.php" class="btn-hero-outline">Explore Public Notes</a>
            </div>
        </div>
    </header>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="features-grid">
                <div class="feature-card scroll-hidden">
                    <div class="feature-icon">📝</div>
                    <h3>Simple Note Taking</h3>
                    <p>Write down your thoughts in a clean, distraction-free environment designed for focus.</p>
                </div>
                <div class="feature-card scroll-hidden" style="transition-delay: 100ms;">
                    <div class="feature-icon">🔒</div>
                    <h3>Secure & Private</h3>
                    <p>Your personal notes are private by default. You control what you share and who sees it.</p>
                </div>
                <div class="feature-card scroll-hidden" style="transition-delay: 200ms;">
                    <div class="feature-icon">🌍</div>
                    <h3>Share with the World</h3>
                    <p>Publish your notes with a single click to share your knowledge with the community.</p>
                </div>
            </div>
        </div>
    </section>



    <!-- Testimonials Section -->
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; <?= date('Y') ?> NoteShare. All rights reserved.</p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>

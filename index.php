<?php
// -----------------------------------------------------
// Simple config reader (no external libraries needed)
// -----------------------------------------------------
$configFile = __DIR__ . '/config.cfg';
$config = [];

if (file_exists($configFile)) {
    $lines = file($configFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $section = '';
    foreach ($lines as $line) {
        $line = trim($line);
        if (strpos($line, ';') === 0 || empty($line)) {
            continue; // comment or empty
        }
        if (preg_match('/^\[(.+)\]$/', $line, $matches)) {
            $section = $matches[1];
            continue;
        }
        if (strpos($line, '=') !== false) {
            list($key, $value) = array_map('trim', explode('=', $line, 2));
            $config[$section][$key] = $value;
        }
    }
}

// Default values if config is missing or broken
$videoUrl    = $config['media']['video_url']     ?? '/static/hero.mp4';
$fallbackImg = $config['media']['fallback_image'] ?? '/static/poster.jpg';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Aare Labs – Shaping the Future of AI</title>
  <link rel="stylesheet" href="style.css?v=<?= filemtime('style.css') ?>">
</head>
<body>
  <div id="bg-video-container">
    <video autoplay muted playsinline id="bg-video" preload="auto">
      <source src="<?= htmlspecialchars($videoUrl) ?>" type="video/mp4">
      <!-- Fallback image shown if video cannot play -->
      <img id="bg-fallback" src="<?= htmlspecialchars($fallbackImg) ?>" alt="Background fallback image">
    </video>
  </div>

  <div id="overlay"></div>

  <main>
    <h1>Welcome to the Future</h1>
    <p>Based in Oxford, UK, we grow companies shaping the future of AI products and services.</p>

    <!-- Portfolio Section -->
    <section class="portfolio-section">
      <div class="portfolio-container">
        <h2 class="portfolio-title">Our Portfolio</h2>
        <div class="portfolio-box">
          <a href="https://inagentic.ai" 
             target="_blank" 
             rel="noopener noreferrer" 
             class="btn">
            InAgentic Ltd
          </a>
          <p class="company-description">
            InAgentic.ai empowers companies to accelerate digital transformation by integrating cutting-edge Agentic AI solutions.
          </p>
        </div>
      </div>
    </section>
  </main>

  <footer>
    © <?= date('Y') ?> • Aare Labs Ltd – Companies are wholly owned subsidiaries of Aare Labs Ltd.
  </footer>

  <!-- Video fallback handling + seamless loop -->
  <script>
    const video = document.getElementById('bg-video');
    const fallback = document.getElementById('bg-fallback');

    // Hide fallback when video is ready
    video.addEventListener('canplay', () => {
      fallback.style.opacity = '0';
    });

    video.addEventListener('error', () => {
      fallback.style.opacity = '1';
    });

    // Seamless loop – prevents jump/stutter at restart
    video.addEventListener('timeupdate', function() {
      // Restart ~0.2–0.4 seconds before actual end (adjust threshold if needed)
      if (this.duration - this.currentTime < 0.3) {
        this.currentTime = 0;
        this.play().catch(() => {}); // silent catch for autoplay policies
      }
    });

    // Optional: fallback restart on 'ended' (for browsers that don't fire timeupdate reliably)
    video.addEventListener('ended', function() {
      this.currentTime = 0;
      this.play().catch(() => {});
    });
  </script>
</body>
</html>

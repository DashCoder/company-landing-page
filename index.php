<?php
// -----------------------------------------------------
//  Simple config reader (no external libraries needed)
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
$videoUrl     = $config['media']['video_url']     ?? 'https://assets.mixkit.co/videos/preview/mixkit-set-of-plateaus-26070-large.mp4';
$fallbackImg  = $config['media']['fallback_image'] ?? 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Video Landing Page</title>
  <link rel="stylesheet" href="style.css?v=<?= filemtime('style.css') ?>">
</head>
<body>

  <div id="bg-video-container">
    <video autoplay muted loop playsinline id="bg-video">
      <source src="<?= htmlspecialchars($videoUrl) ?>" type="video/mp4">
      <!-- Fallback image shown if video cannot play -->
      <img id="bg-fallback" src="<?= htmlspecialchars($fallbackImg) ?>" alt="Background fallback">
    </video>
  </div>

  <div id="overlay"></div>

  <main>
    <h1>Welcome to the Future</h1>
    <p>Based in Oxford UK, we grow companies shaping the future of AI products and services.</p>
    
  <!-- Portfolio Section -->
  <section class="portfolio-section">
    <div class="portfolio-container">
      <h2 class="portfolio-title">Our Portfolio</h2>
      <div class="portfolio-box">
        
        <a href="https://inagentic.ai" target="_blank" rel="noopener noreferrer" class="company-link">
          <div class="company-name">InAgentic Ltd</div>
          <div class="company-description">InAgentic.ai empowers companies to accelerate digital transformation by integrating cutting-edge Agentic AI solutions.</div>
        </a>

        <p>Companies are wholly owned subsidiaries of Aare Labs Ltd.</p>

      </div>
    </div>
  </section>
      
  </main>

  <footer>
    © <?= date('Y') ?> • Built with a looping video background
  </footer>

  <!-- Optional: hide fallback after video can play (better UX) -->
  <script>
    const video = document.getElementById('bg-video');
    const fallback = document.getElementById('bg-fallback');

    video.addEventListener('canplay', () => {
      fallback.style.opacity = '0';
    });

    video.addEventListener('error', () => {
      fallback.style.opacity = '1';
    });

    // Some mobile browsers need user interaction to autoplay → we use muted + playsinline
  </script>

</body>
</html>

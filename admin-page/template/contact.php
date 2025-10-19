<?php
// Self-contained contact form handler (saves to MySQL and returns 'OK' on POST)
if (strcasecmp($_SERVER['REQUEST_METHOD'] ?? '', 'POST') === 0) {
  // Database configuration — adjust for your localhost
  $db_host  = 'localhost';
  $db_name  = 'desa_bungi';
  $db_user  = 'root';
  $db_pass  = '';
  $db_table = 'contact_messages';

  $name    = trim($_POST['name']   ?? '');
  $email   = trim($_POST['email']  ?? '');
  $subject = trim($_POST['subject']?? '');
  $phone   = trim($_POST['phone']  ?? '');
  $message = trim($_POST['message']?? '');

  $inj = ["\r","\n","%0a","%0d"];
  $name = str_replace($inj, ' ', $name);
  $email = str_replace($inj, '', $email);
  $subject = str_replace($inj, ' ', $subject);
  $phone = str_replace($inj, ' ', $phone);

  try {
    $pdo = new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8mb4", $db_user, $db_pass, [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    $pdo->exec("CREATE TABLE IF NOT EXISTS `{$db_table}` (
      `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `name` VARCHAR(150) NOT NULL,
      `email` VARCHAR(190) NOT NULL,
      `subject` VARCHAR(190) NOT NULL,
      `phone` VARCHAR(60) NULL,
      `message` TEXT NOT NULL,
      `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    $stmt = $pdo->prepare("INSERT INTO `{$db_table}` (`name`,`email`,`subject`,`phone`,`message`) VALUES (:name,:email,:subject,:phone,:message)");
    $stmt->execute([
      ':name' => $name,
      ':email' => $email,
      ':subject' => $subject,
      ':phone' => $phone !== '' ? $phone : null,
      ':message' => $message,
    ]);
  } catch (Throwable $e) {
    header('Content-Type: text/plain');
    echo 'Failed to save your message. Check DB settings.';
  }
  header('Content-Type: text/plain');
  echo 'OK';
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<?php 

include "call.php";

?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Contact - Desa Bungi</title>
  <meta name="description" content="Contact form">
  <meta name="keywords" content="contact, form">

  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&family=Poppins:wght@300;400;500;600;700;800;900&family=Raleway:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

  <link href="assets/css/main.css" rel="stylesheet">

 </head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-end">

      <a href="index.php" class="logo d-flex align-items-center me-auto">
        <h1 class="sitename">Desa Bungi</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="page2.php">Topografi</a></li>
          <li><a href="page3.php">Batas Wilayah</a></li>
          <li><a href="page4.php">Pertumbuhan Penduduk</a></li>
          <li><a href="contact.php" class="active">Contact</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

    </div>
  </header>

  <main class="main">

    <section id="hero" class="hero section">
      <div class="upcoming-event hero-banner">
        <div class="container">
          <div class="row align-items-center justify-content-center text-center">
            <div class="col-lg-10 hero-content" data-aos="fade-up" data-aos-delay="100">
              <h1>Hubungi Kami</h1>
            </div>
          </div>
        </div>
      </div>

      <div class="hero-wrapper py-5">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-8">
              <div class="contact-form-container">
                <h2 class="mb-4">Kirim Pesan</h2>
                <form action="contact.php" method="post" class="php-email-form">
                  <div class="row gy-3">
                    <div class="col-md-6">
                      <label class="form-label" for="name">Nama</label>
                      <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label" for="email">Email</label>
                      <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label" for="phone">Telepon (opsional)</label>
                      <input type="text" name="phone" id="phone" class="form-control">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label" for="subject">Subjek</label>
                      <input type="text" name="subject" id="subject" class="form-control" required>
                    </div>
                    <div class="col-12">
                      <label class="form-label" for="message">Pesan</label>
                      <textarea name="message" id="message" class="form-control" rows="6" required></textarea>
                    </div>
                    <div class="col-12">
                      <div class="loading">Loading</div>
                      <div class="error-message"></div>
                      <div class="sent-message">Pesan Anda telah terkirim. Terima kasih!</div>
                    </div>
                    <div class="col-12">
                      <button type="submit" class="btn btn-primary">Kirim</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

  </main>

  <footer id="footer" class="footer position-relative light-background">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index.php" class="logo d-flex align-items-center">
            <span class="sitename">College</span>
          </a>
          <div class="footer-contact pt-3">
            <p>A108 Adam Street</p>
            <p>New York, NY 535022</p>
            <p class="mt-3"><strong>Phone:</strong> <span>+1 5589 55488 55</span></p>
            <p><strong>Email:</strong> <span>info@example.com</span></p>
          </div>
          <div class="social-links d-flex mt-4">
            <a href=""><i class="bi bi-twitter-x"></i></a>
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Useful Links</h4>
          <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">About us</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Terms of service</a></li>
            <li><a href="#">Privacy policy</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Our Services</h4>
          <ul>
            <li><a href="#">Web Design</a></li>
            <li><a href="#">Web Development</a></li>
            <li><a href="#">Product Management</a></li>
            <li><a href="#">Marketing</a></li>
            <li><a href="#">Graphic Design</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Hic solutasetp</h4>
          <ul>
            <li><a href="#">Molestiae accusamus iure</a></li>
            <li><a href="#">Excepturi dignissimos</a></li>
            <li><a href="#">Suscipit distinctio</a></li>
            <li><a href="#">Dilecta</a></li>
            <li><a href="#">Sit quas consectetur</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Nobis illum</h4>
          <ul>
            <li><a href="#">Ipsam</a></li>
            <li><a href="#">Laudantium dolorum</a></li>
            <li><a href="#">Dinera</a></li>
            <li><a href="#">Trodelas</a></li>
            <li><a href="#">Flexo</a></li>
          </ul>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>Ac <span>Copyright</span> <strong class="px-1 sitename">MyWebsite</strong> <span>All Rights Reserved</span></p>
      <div class="credits">
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div>
    </div>

  </footer>

  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <div id="preloader"></div>

  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/js/main.js"></script>

  </body>
  </html>

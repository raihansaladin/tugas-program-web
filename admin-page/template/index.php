<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Corona Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="assets/vendors/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/vendors/owl-carousel-2/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/vendors/owl-carousel-2/owl.theme.default.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="assets/images/favicon.png" />
  </head>
  <body>
    <?php
    require_once 'call.php';

    //Query data untuk dashboard
    $total_petani = $db->query('SELECT COUNT(*) as total FROM petani')->fetch_assoc()['total'];
    $total_tamu = $db->query('SELECT COUNT(*) as total FROM tamu')->fetch_assoc()['total'];
    $total_uraian = $db->query('SELECT COUNT(*) as total FROM uraian')->fetch_assoc()['total'];
    $total_produksi = $db->query('SELECT SUM(produksi_thn) as total FROM petani')->fetch_assoc()['total'];

    //Data tamu terbaru
    $tamu_terbaru = $db->query('SELECT * FROM tamu ORDER BY id_tamu DESC LIMIT 5');
    ?>

    <div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
      <?php include 'partials/_sidebar.php'; ?>
      
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_navbar.html -->
         <?php include 'partials/_navbar.php' ?>
        
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            
            <div class="row">
              <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0"><?php echo $total_petani; ?></h3>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Total Petani</h6>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0"><?php echo number_format($total_produksi); ?></h3>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Total Produksi</h6>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0"><?php echo $total_tamu; ?></h3>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Total Tamu</h6>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0"><?php echo $total_uraian; ?></h3>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Total Konten Uraian</h6>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex flex-row justify-content-between">
                      <h4 class="card-title mb-1">Informasi Desa</h4>
                    </div>
                    <div class="row">
                      <div class="col-12">
                        <div class="preview-list">
                          <?php 
                          $info_desa = $db->query('SELECT * FROM uraian ORDER BY id_uraian');
                          $icons = ['primary', 'success', 'info', 'danger', 'warning', 'primary', 'success'];
                          $i = 0;
                          while($info = $info_desa->fetch_assoc()):
                          ?>
                          <div class="preview-item border-bottom">
                            <div class="preview-thumbnail">
                              <div class="preview-icon bg-<?php echo $icons[$i]; ?>">
                                <i class="mdi mdi-file-document"></i>
                              </div>
                            </div>
                            <div class="preview-item-content d-sm-flex flex-grow">
                              <div class="flex-grow">
                                <h6 class="preview-subject"><?php echo htmlspecialchars($info['judul']); ?></h6>
                                <p class="text-muted mb-0"><?php 
                                  $desc = strip_tags($info['uraian_singkat']);
                                  echo strlen($desc) > 255 ? substr($desc, 0, 255) . '...' : $desc;
                                ?></p>
                              </div>
                            </div>
                          </div>
                          <?php 
                          $i++;
                          endwhile; 
                          ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Bagian Tabel Tamu -->
              <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex flex-row justify-content-between">
                      <h4 class="card-title">Tabel Tamu</h4>
                    </div>
                    <div class="preview-list">
                      <?php
                      $tamu_baru = $db->query('SELECT * FROM tamu ORDER BY id_tamu');
                      $counter = 0;
                      
                      while($tamu = $tamu_baru->fetch_assoc()):
                        $counter++;
                      ?>
                      <div class="preview-item border-bottom">
                        <div class="preview-item-content d-flex flex-grow">
                          <div class="flex-grow">
                            <div class="d-flex d-md-block d-xl-flex justify-content-between">
                              <h6 class="preview-subject"><?php echo htmlspecialchars($tamu['nama']); ?></h6>
                            </div>
                            <p class="text-muted">
                              <strong>Alamat:</strong> <?php echo htmlspecialchars($tamu['alamat']); ?><br>
                              <strong>Email:</strong> <?php echo htmlspecialchars($tamu['email']); ?><br>
                              <strong>Organisasi:</strong> <?php echo htmlspecialchars($tamu['organisasi']); ?>
                            </p>
                            <p class="text-muted">Pesan: <?php echo htmlspecialchars($tamu['pesan']); ?></p>
                          </div>
                        </div>
                      </div>
                      <?php endwhile; ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Galeri Desa -->
            <div class="row">
              <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Galeri Desa</h4>
                    <div class="row">
                      <?php
                      // Gambar-gambar desa yang tersedia
                      $gambar_desa = ['team1.jpg', 'team2.jpg', 'team3.jpg', 'team4.jpg', 'rumput.jpg', 'wilayah.jpg'];
                      $gambar_count = 0;
                      
                      foreach($gambar_desa as $gambar):
                          if(file_exists($gambar)):
                              $gambar_count++;
                      ?>
                      <div class="col-md-4 mb-3">
                        <div class="gallery-item">
                          <img src="<?php echo $gambar; ?>" 
                              alt="Gambar Desa Bungi"
                              style="width: 100%; height: 200px; object-fit: cover; border-radius: 5px;">
                        </div>
                      </div>
                      <?php 
                          endif;
                      endforeach; 
                      
                      // Jika tidak ada gambar, tampilkan pesan
                      if ($gambar_count == 0):
                      ?>
                      <div class="col-12 text-center text-muted">
                        <p>Belum ada gambar tersedia</p>
                      </div>
                      <?php endif; ?>
                    </div>
                    
                    <div class="d-flex py-3 mt-3">
                      <div class="preview-list w-100">
                        <div class="preview-item p-0">
                          <div class="preview-thumbnail">
                            <img src="assets/images/faces/face12.jpg" class="rounded-circle" alt="Admin">
                          </div>
                          <div class="preview-item-content d-flex flex-grow">
                            <div class="flex-grow">
                              <h6 class="preview-subject">Admin Desa</h6>
                              <p class="text-muted">Dokumentasi Desa Bungi</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    <p class="text-muted mt-2"><?php echo $gambar_count; ?> gambar dokumentasi</p>
                  </div>
                </div>
              </div>
            </div>

          </div>
          <!-- content-wrapper ends -->
          
          <!-- partial:partials/_footer.html -->
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © bootstrapdash.com 2020</span>
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Free <a href="https://www.bootstrapdash.com/bootstrap-admin-template/" target="_blank">Bootstrap admin templates</a> from Bootstrapdash.com</span>
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    
    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="assets/vendors/chart.js/Chart.min.js"></script>
    <script src="assets/vendors/progressbar.js/progressbar.min.js"></script>
    <script src="assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
    <script src="assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="assets/vendors/owl-carousel-2/owl.carousel.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/misc.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="assets/js/dashboard.js"></script>
    <!-- End custom js for this page -->
  </body>
</html>
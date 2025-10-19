<?php
// Koneksi database
$con = mysqli_connect("localhost", "root", "", "desa_bungi");

// Handle form submit untuk tambah data tamu
if (isset($_POST['add_tamu'])) {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    $organisasi = $_POST['organisasi'];
    $pesan = $_POST['pesan'];
    
    $qry = "INSERT INTO tamu (nama, alamat, email, organisasi, pesan) 
            VALUES ('$nama', '$alamat', '$email', '$organisasi', '$pesan')";
    mysqli_query($con, $qry);
}

// Handle form submit tambah data admin
if (isset($_POST['add_admin'])) {
    $username = $_POST['username'];
    $email = $_POST['email_admin'];
    $password = md5($_POST['password']); // Hash password dengan MD5
    
    $qry = "INSERT INTO admin (username, email, password) 
            VALUES ('$username', '$email', '$password')";
    mysqli_query($con, $qry);
}

// Handle form submit tambah data petani
if (isset($_POST['add_petani'])) {
    $namaP = $_POST['nama'];
    $bentangan = $_POST['bentangan'];
    $produksi_mt = ($_POST['produksi_mt']);
    $mt = $_POST['mt'];
    $produksi_thn = ($_POST['produksi_thn']);
    
    $qry = "INSERT INTO petani (nama, bentangan, produksi_mt, mt, produksi_thn) 
            VALUES ('$namaP', '$bentangan', '$produksi_mt', $mt, $produksi_thn)";
    mysqli_query($con, $qry);
}

// Handle form submit untuk edit data tamu
if (isset($_POST['edit_tamu'])) {
    $id_tamu = $_POST['id_tamu'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    $organisasi = $_POST['organisasi'];
    $pesan = $_POST['pesan'];
    
    $qry = "UPDATE tamu 
            SET nama='$nama', alamat='$alamat', email='$email', 
                organisasi='$organisasi', pesan='$pesan' 
            WHERE id_tamu='$id_tamu'";
    mysqli_query($con, $qry);
}

// Handle form submit untuk edit data admin
if (isset($_POST['edit_admin'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email_admin'];
    
    // Jika password diisi, update password juga
    if (!empty($_POST['password'])) {
        $password = md5($_POST['password']);
        $qry = "UPDATE admin 
                SET username='$username', email='$email', 
                    password='$password' 
                WHERE id='$id'";
    } else {
        $qry = "UPDATE admin 
                SET username='$username', email='$email'
                WHERE id='$id'";
    }
    mysqli_query($con, $qry);
}

// Handle form submit untuk edit data petani
if (isset($_POST['edit_petani'])) {
    $id_p = $_POST['IDPetani'];
    $namaP = $_POST['nama'];
    $bentangan = $_POST['bentangan'];
    $produksi_mt = ($_POST['produksi_mt']);
    $mt = $_POST['mt'];
    $produksi_thn = ($_POST['produksi_thn']);
    
    $qry = "UPDATE petani 
            SET nama='$namaP', bentangan='$bentangan', produksi_mt='$produksi_mt', 
                mt='$mt', produksi_thn='$produksi_thn' 
            WHERE IDPetani='$id_p'";
    mysqli_query($con, $qry);
}

// Handle delete data tamu
if (isset($_GET['delete_tamu'])) {
    $id_tamu = $_GET['delete_tamu'];
    $qry = "DELETE FROM tamu WHERE id_tamu='$id_tamu'";
    mysqli_query($con, $qry);
}

// Handle delete data admin
if (isset($_GET['delete_admin'])) {
    $id = $_GET['delete_admin'];
    $qry = "DELETE FROM admin WHERE id='$id'";
    mysqli_query($con, $qry);
}

// Handle delete data petani
if (isset($_GET['delete_petani'])) {
    $id_p = $_GET['delete_petani'];
    $qry = "DELETE FROM petani WHERE IDPetani='$id_p'";
    mysqli_query($con, $qry);
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Corona Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../../assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../../assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="../../assets/vendors/select2/select2.min.css">
    <link rel="stylesheet" href="../../assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="../../assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="../../assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:../../partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
          <a class="sidebar-brand brand-logo" href="../../index.php"><img src="../../assets/images/logo.svg" alt="logo" /></a>
          <a class="sidebar-brand brand-logo-mini" href="../../index.php"><img src="../../assets/images/logo-mini.svg" alt="logo" /></a>
        </div>
        <ul class="nav">
          <li class="nav-item profile">
            <div class="profile-desc">
              <div class="profile-pic">
                <div class="count-indicator">
                  <img class="img-xs rounded-circle " src="../../assets/images/faces/face15.jpg" alt="">
                  <span class="count bg-success"></span>
                </div>
                <div class="profile-name">
                  <h5 class="mb-0 font-weight-normal">Admin</h5>
                  <span>Gold Member</span>
                </div>
              </div>
              <a href="#" id="profile-dropdown" data-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a>
              <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list" aria-labelledby="profile-dropdown">
                <a href="#" class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-settings text-primary"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1 text-small">Account settings</p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-onepassword  text-info"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1 text-small">Change Password</p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-calendar-today text-success"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1 text-small">To-do list</p>
                  </div>
                </a>
              </div>
            </div>
          </li>
          <li class="nav-item nav-category">
            <span class="nav-link">Navigation</span>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="../../index.php">
              <span class="menu-icon">
                <i class="mdi mdi-speedometer"></i>
              </span>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          
          <li class="nav-item menu-items">
            <a class="nav-link" href="../../pages/forms/basic_elements.php">
              <span class="menu-icon">
                <i class="mdi mdi-playlist-play"></i>
              </span>
              <span class="menu-title">Crud Table</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="../../pages/forms/contacts.php">
              <span class="menu-icon">
                <i class="mdi mdi-account-box"></i>
              </span>
              <span class="menu-title">Contacts</span>
            </a>
          </li>
        
        </ul>
      </nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:../../partials/_navbar.html -->
        <nav class="navbar p-0 fixed-top d-flex flex-row">
          <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
            <a class="navbar-brand brand-logo-mini" href="../../index.php"><img src="../../assets/images/logo-mini.svg" alt="logo" /></a>
          </div>
          <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
              <span class="mdi mdi-menu"></span>
            </button>
            <ul class="navbar-nav w-100">
              <li class="nav-item w-100">
                <form class="nav-link mt-2 mt-md-0 d-none d-lg-flex search">
                  <input type="text" class="form-control" placeholder="Search products">
                </form>
              </li>
            </ul>
            <ul class="navbar-nav navbar-nav-right">
              <li class="nav-item dropdown d-none d-lg-block">
                
               
              <li class="nav-item nav-settings d-none d-lg-block">
                <a class="nav-link" href="#">
                  <i class="mdi mdi-view-grid"></i>
                </a>
              </li>
              <li class="nav-item dropdown border-left">
                <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                  <i class="mdi mdi-email"></i>
                  <span class="count bg-success"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
                  <h6 class="p-3 mb-0">Messages</h6>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <img src="../../assets/images/faces/face4.jpg" alt="image" class="rounded-circle profile-pic">
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject ellipsis mb-1">Mark send you a message</p>
                      <p class="text-muted mb-0"> 1 Minutes ago </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <img src="../../assets/images/faces/face2.jpg" alt="image" class="rounded-circle profile-pic">
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject ellipsis mb-1">Cregh send you a message</p>
                      <p class="text-muted mb-0"> 15 Minutes ago </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <img src="../../assets/images/faces/face3.jpg" alt="image" class="rounded-circle profile-pic">
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject ellipsis mb-1">Profile picture updated</p>
                      <p class="text-muted mb-0"> 18 Minutes ago </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <p class="p-3 mb-0 text-center">4 new messages</p>
                </div>
              </li>
              <li class="nav-item dropdown border-left">
                <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
                  <i class="mdi mdi-bell"></i>
                  <span class="count bg-danger"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                  <h6 class="p-3 mb-0">Notifications</h6>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-calendar text-success"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Event today</p>
                      <p class="text-muted ellipsis mb-0"> Just a reminder that you have an event today </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-settings text-danger"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Settings</p>
                      <p class="text-muted ellipsis mb-0"> Update dashboard </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-link-variant text-warning"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Launch Admin</p>
                      <p class="text-muted ellipsis mb-0"> New admin wow! </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <p class="p-3 mb-0 text-center">See all notifications</p>
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
                  <div class="navbar-profile">
                    <img class="img-xs rounded-circle" src="../../assets/images/faces/face15.jpg" alt="">
                    <p class="mb-0 d-none d-sm-block navbar-profile-name">Admin</p>
                    <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                  </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropdown">
                  <h6 class="p-3 mb-0">Profile</h6>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-settings text-success"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Settings</p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-logout text-danger"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Log out</p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <p class="p-3 mb-0 text-center">Advanced settings</p>
                </div>
              </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
              <span class="mdi mdi-format-line-spacing"></span>
            </button>
          </div>
        </nav>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Crud </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Crud</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Crud Table</li>
                </ol>
              </nav>
            </div>

            <!-- Form untuk CRUD Tamu -->
            <div class="row">
              <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">
                      <?php 
                      if (isset($_GET['edit_tamu'])) {
                          echo "Edit Data Tamu";
                      } else {
                          echo "Tambah Data Tamu";
                      }
                      ?>
                    </h4>
                    <p class="card-description"> Form data tamu desa </p>
                    <form class="forms-sample" method="POST" action="">
                      <?php
                      // Jika mode edit tamu, ambil data yang akan diedit
                      if (isset($_GET['edit_tamu'])) {
                          $id_edit = $_GET['edit_tamu'];
                          $data_edit = mysqli_query($con, "SELECT * FROM tamu WHERE id_tamu='$id_edit'");
                          $row_edit = mysqli_fetch_array($data_edit);
                          
                          echo "<input type='hidden' name='id_tamu' value='$row_edit[id_tamu]'>";
                      }
                      ?>
                      
                      <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama lengkap"
                               value="<?php echo isset($row_edit) ? $row_edit['nama'] : ''; ?>" required>
                      </div>
                      
                      <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                               value="<?php echo isset($row_edit) ? $row_edit['email'] : ''; ?>" required>
                      </div>
                      
                      <div class="form-group">
                        <label for="organisasi">Organisasi</label>
                        <input type="text" class="form-control" id="organisasi" name="organisasi" placeholder="Organisasi"
                               value="<?php echo isset($row_edit) ? $row_edit['organisasi'] : ''; ?>">
                      </div>
                      
                      <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="2" placeholder="Alamat lengkap" required><?php echo isset($row_edit) ? $row_edit['alamat'] : ''; ?></textarea>
                      </div>
                      
                      <div class="form-group">
                        <label for="pesan">Pesan</label>
                        <textarea class="form-control" id="pesan" name="pesan" rows="4" placeholder="Pesan atau keterangan" required><?php echo isset($row_edit) ? $row_edit['pesan'] : ''; ?></textarea>
                      </div>
                      
                      <?php if (isset($_GET['edit_tamu'])): ?>
                        <button type="submit" name="edit_tamu" class="btn btn-primary mr-2">Update</button>
                        <a href="basic_elements.php" class="btn btn-dark">Cancel</a>
                      <?php else: ?>
                        <button type="submit" name="add_tamu" class="btn btn-primary mr-2">Submit</button>
                        <button type="reset" class="btn btn-dark">Cancel</button>
                      <?php endif; ?>
                    </form>
                  </div>
                </div>
              </div>

              <!-- Tabel Data Tamu -->
              <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Daftar Tamu</h4>
                    <div class="table-responsive">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $data = mysqli_query($con, "SELECT * FROM tamu ORDER BY id_tamu DESC");
                          while($row = mysqli_fetch_array($data)) {
                              echo "
                              <tr>
                                <td>$row[id_tamu]</td>
                                <td>$row[nama]</td>
                                <td>$row[email]</td>
                                <td>
                                  <a href='basic_elements.php?edit_tamu=$row[id_tamu]' class='btn btn-sm btn-warning'>Edit</a>
                                  <a href='basic_elements.php?delete_tamu=$row[id_tamu]' class='btn btn-sm btn-danger'>Hapus</a>
                                </td>
                              </tr>
                              ";
                          }
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Form untuk CRUD Admin -->
<div class="row">
  <div class="col-md-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">
          <?php 
          if (isset($_GET['edit_admin'])) {
              echo "Edit Data Admin";
          } else {
              echo "Tambah Data Admin";
          }
          ?>
        </h4>
        <p class="card-description"> Form data Admin</p>
        <form class="forms-sample" method="POST" action="">
          <?php
          // Jika mode edit admin, ambil data yang akan diedit
          if (isset($_GET['edit_admin'])) {
              $id_edit_admin = $_GET['edit_admin'];
              $data_edit_admin = mysqli_query($con, "SELECT * FROM admin WHERE id='$id_edit_admin'");
              $row_edit_admin = mysqli_fetch_array($data_edit_admin);
              
              echo "<input type='hidden' name='id' value='$row_edit_admin[id]'>";
          }
          ?>
          
          <div class="form-group">
            <label for="username_admin">Username</label>
            <input type="text" class="form-control" id="username_admin" name="username" placeholder="Username"
                   value="<?php echo isset($row_edit_admin) ? $row_edit_admin['username'] : ''; ?>" required>
          </div>
          
          <div class="form-group">
            <label for="email_admin">Email address</label>
            <input type="email" class="form-control" id="email_admin" name="email_admin" placeholder="Email"
                   value="<?php echo isset($row_edit_admin) ? $row_edit_admin['email'] : ''; ?>" required>
          </div>
          
          <div class="form-group">
            <label for="password_admin">Password</label>
            <input type="password" class="form-control" id="password_admin" name="password" placeholder="Password"
                   value="">
            <small class="text-muted"><?php echo isset($row_edit_admin) ? "Kosongkan jika tidak ingin mengubah password" : ""; ?></small>
          </div>
          
          <?php if (isset($_GET['edit_admin'])): ?>
            <button type="submit" name="edit_admin" class="btn btn-primary mr-2">Update</button>
            <a href="basic_elements.php" class="btn btn-dark">Cancel</a>
          <?php else: ?>
            <button type="submit" name="add_admin" class="btn btn-primary mr-2">Submit</button>
            <button type="reset" class="btn btn-dark">Cancel</button>
          <?php endif; ?>
        </form>
      </div>
    </div>
  </div>  

              <!-- Tabel Data Admin -->
              <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Daftar Admin</h4>
                    <div class="table-responsive">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $data = mysqli_query($con, "SELECT * FROM admin ORDER BY id DESC");
                          while($row = mysqli_fetch_array($data)) {
                              echo "
                              <tr>
                                <td>$row[id]</td>
                                <td>$row[username]</td>
                                <td>$row[email]</td>
                                <td>
                                  <a href='basic_elements.php?edit_admin=$row[id]' class='btn btn-sm btn-warning'>Edit</a>
                                  <a href='basic_elements.php?delete_admin=$row[id]' class='btn btn-sm btn-danger'>Hapus</a>
                                </td>
                              </tr>
                              ";
                          }
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Form untuk CRUD petani -->
<div class="row">
  <div class="col-md-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">
          <?php 
          if (isset($_GET['edit_petani'])) {
              echo "Edit Data Petani";
          } else {
              echo "Tambah Data Petani";
          }
          ?>
        </h4>
        <p class="card-description"> Form data Petani Desa </p>
        <form class="forms-sample" method="POST" action="">
          <?php
          // Jika mode edit petani, ambil data yang akan diedit
          if (isset($_GET['edit_petani'])) {
              $id_edit_petani = $_GET['edit_petani'];
              $data_edit_petani = mysqli_query($con, "SELECT * FROM petani WHERE IDPetani='$id_edit_petani'");
              $row_edit_petani = mysqli_fetch_array($data_edit_petani);
              
              echo "<input type='hidden' name='IDPetani' value='$row_edit_petani[IDPetani]'>";
          }
          ?>
          
          <div class="form-group">
            <label for="nama_petani">Nama</label>
            <input type="text" class="form-control" id="nama_petani" name="nama" placeholder="Nama lengkap"
                   value="<?php echo isset($row_edit_petani) ? $row_edit_petani['nama'] : ''; ?>" required>
          </div>
          
          <div class="form-group">
            <label for="bentangan">Bentangan</label>
            <input type="number" class="form-control" id="bentangan" name="bentangan" placeholder="Bentangan"
                   value="<?php echo isset($row_edit_petani) ? $row_edit_petani['bentangan'] : ''; ?>" required>
          </div>
          
          <div class="form-group">
            <label for="produksi_mt">Produksi per MT</label>
            <input type="number" class="form-control" id="produksi_mt" name="produksi_mt" placeholder="Produksi per MT"
                   value="<?php echo isset($row_edit_petani) ? $row_edit_petani['produksi_mt'] : ''; ?>" required>
          </div>
          
          <div class="form-group">
            <label for="mt">MT</label>
            <input type="number" class="form-control" id="mt" name="mt" placeholder="MT"
                   value="<?php echo isset($row_edit_petani) ? $row_edit_petani['mt'] : ''; ?>" required>
          </div>
          
          <div class="form-group">
            <label for="produksi_thn">Produksi per Tahun</label>
            <input type="number" class="form-control" id="produksi_thn" name="produksi_thn" placeholder="Produksi per Tahun"
                   value="<?php echo isset($row_edit_petani) ? $row_edit_petani['produksi_thn'] : ''; ?>" required>
          </div>
          
          <?php if (isset($_GET['edit_petani'])): ?>
            <button type="submit" name="edit_petani" class="btn btn-primary mr-2">Update</button>
            <a href="basic_elements.php" class="btn btn-dark">Cancel</a>
          <?php else: ?>
            <button type="submit" name="add_petani" class="btn btn-primary mr-2">Submit</button>
            <button type="reset" class="btn btn-dark">Cancel</button>
          <?php endif; ?>
        </form>
      </div>
    </div>
  </div>

              <!-- Tabel Data Petani -->
              <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Daftar Petani</h4>
                    <div class="table-responsive">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Bentangan</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $data = mysqli_query($con, "SELECT * FROM petani ORDER BY IDPetani DESC LIMIT 10");
                          while($row = mysqli_fetch_array($data)) {
                              echo "
                              <tr>
                                <td>$row[IDPetani]</td>
                                <td>$row[nama]</td>
                                <td>$row[bentangan]</td>
                                <td>
                                  <a href='basic_elements.php?edit_petani=$row[IDPetani]' class='btn btn-sm btn-warning'>Edit</a>
                                  <a href='basic_elements.php?delete_petani=$row[IDPetani]' class='btn btn-sm btn-danger'>Hapus</a>
                                </td>
                              </tr>
                              ";
                          }
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
          <!-- content-wrapper ends -->
          <!-- partial:../../partials/_footer.html -->
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
    <script src="../../assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="../../assets/vendors/select2/select2.min.js"></script>
    <script src="../../assets/vendors/typeahead.js/typeahead.bundle.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../../assets/js/off-canvas.js"></script>
    <script src="../../assets/js/hoverable-collapse.js"></script>
    <script src="../../assets/js/misc.js"></script>
    <script src="../../assets/js/settings.js"></script>
    <script src="../../assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="../../assets/js/file-upload.js"></script>
    <script src="../../assets/js/typeahead.js"></script>
    <script src="../../assets/js/select2.js"></script>
    <!-- End custom js for this page -->
  </body>
</html>

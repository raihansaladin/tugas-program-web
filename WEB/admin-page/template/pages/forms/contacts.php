<?php
// Koneksi database (selaras dengan basic_elements.php)
$con = mysqli_connect("localhost", "root", "", "desa_bungi");

// Tabel yang digunakan oleh contact.php
$TABLE = 'contact_messages';

// Tambah data pesan (opsional, agar CRUD lengkap)
if (isset($_POST['add_message'])) {
    $name    = $_POST['name'];
    $email   = $_POST['email'];
    $subject = $_POST['subject'];
    $phone   = $_POST['phone'];
    $message = $_POST['message'];

    $qry = "INSERT INTO $TABLE (name, email, subject, phone, message) VALUES ('$name', '$email', '$subject', " .
           (strlen(trim($phone)) ? "'$phone'" : "NULL") . ", '$message')";
    mysqli_query($con, $qry);
}

// Edit data pesan
if (isset($_POST['edit_message'])) {
    $id      = $_POST['id'];
    $name    = $_POST['name'];
    $email   = $_POST['email'];
    $subject = $_POST['subject'];
    $phone   = $_POST['phone'];
    $message = $_POST['message'];

    $set_phone = strlen(trim($phone)) ? "phone='$phone'" : "phone=NULL";
    $qry = "UPDATE $TABLE SET name='$name', email='$email', subject='$subject', $set_phone, message='$message' WHERE id='$id'";
    mysqli_query($con, $qry);
}

// Hapus data pesan
if (isset($_GET['delete_message'])) {
    $id = $_GET['delete_message'];
    $qry = "DELETE FROM $TABLE WHERE id='$id'";
    mysqli_query($con, $qry);
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Contacts Messages</title>
    <link rel="stylesheet" href="../../assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../../assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="shortcut icon" href="../../assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <!-- Sidebar (inline seperti basic_elements.php agar path asset benar) -->
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

      <div class="container-fluid page-body-wrapper">
        <nav class="navbar p-0 fixed-top d-flex flex-row">
          <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
            <a class="navbar-brand brand-logo-mini" href="../../index.php"><img src="../../assets/images/logo-mini.svg" alt="logo" /></a>
          </div>
          <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
              <span class="mdi mdi-menu"></span>
            </button>
            <ul class="navbar-nav navbar-nav-right">
              <li class="nav-item nav-settings d-none d-lg-block">
                <a class="nav-link" href="#"><i class="mdi mdi-view-grid"></i></a>
              </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
              <span class="mdi mdi-format-line-spacing"></span>
            </button>
          </div>
        </nav>

        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Contact Messages </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="../../index.php">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Contacts</li>
                </ol>
              </nav>
            </div>

            <div class="row">
              <!-- Form CRUD pesan (edit/tambah) -->
              <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">
                      <?php echo isset($_GET['edit_message']) ? 'Edit Pesan' : 'Tambah Pesan'; ?>
                    </h4>
                    <p class="card-description"> Form data pesan dari contact.php</p>
                    <form class="forms-sample" method="POST" action="">
                      <?php
                      if (isset($_GET['edit_message'])) {
                          $id_edit = $_GET['edit_message'];
                          $data_edit = mysqli_query($con, "SELECT * FROM $TABLE WHERE id='$id_edit'");
                          $row_edit = mysqli_fetch_array($data_edit);
                          echo "<input type='hidden' name='id' value='".$row_edit['id']."'>";
                      }
                      ?>
                      <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nama lengkap" value="<?php echo isset($row_edit) ? htmlspecialchars($row_edit['name']) : ''; ?>" required>
                      </div>
                      <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo isset($row_edit) ? htmlspecialchars($row_edit['email']) : ''; ?>" required>
                      </div>
                      <div class="form-group">
                        <label for="subject">Subjek</label>
                        <input type="text" class="form-control" id="subject" name="subject" placeholder="Subjek" value="<?php echo isset($row_edit) ? htmlspecialchars($row_edit['subject']) : ''; ?>" required>
                      </div>
                      <div class="form-group">
                        <label for="phone">Telepon (opsional)</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Telepon" value="<?php echo isset($row_edit) ? htmlspecialchars($row_edit['phone']) : ''; ?>">
                      </div>
                      <div class="form-group">
                        <label for="message">Pesan</label>
                        <textarea class="form-control" id="message" name="message" rows="4" placeholder="Pesan" required><?php echo isset($row_edit) ? htmlspecialchars($row_edit['message']) : ''; ?></textarea>
                      </div>

                      <?php if (isset($_GET['edit_message'])): ?>
                        <button type="submit" name="edit_message" class="btn btn-primary mr-2">Update</button>
                        <a href="contacts.php" class="btn btn-dark">Cancel</a>
                      <?php else: ?>
                        <button type="submit" name="add_message" class="btn btn-primary mr-2">Submit</button>
                        <button type="reset" class="btn btn-dark">Cancel</button>
                      <?php endif; ?>
                    </form>
                  </div>
                </div>
              </div>

              <!-- Tabel daftar pesan -->
              <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Daftar Pesan Masuk</h4>
                    <div class="table-responsive">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Subjek</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $data = mysqli_query($con, "SELECT id, name, subject, created_at FROM $TABLE ORDER BY id DESC");
                          while ($row = mysqli_fetch_array($data)) {
                              echo "<tr>"
                                  . "<td>".$row['id']."</td>"
                                  . "<td>".htmlspecialchars($row['name'])."</td>"
                                  . "<td>".htmlspecialchars($row['subject'])."</td>"
                                  . "<td>".htmlspecialchars($row['created_at'])."</td>"
                                  . "<td>"
                                  . "<a href='contacts.php?edit_message=".$row['id']."' class='btn btn-sm btn-warning'>Edit</a> "
                                  . "<a href='contacts.php?delete_message=".$row['id']."' class='btn btn-sm btn-danger'>Hapus</a>"
                                  . "</td>"
                                  . "</tr>";
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

          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright Ac bootstrapdash.com 2020</span>
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Free <a href="https://www.bootstrapdash.com/bootstrap-admin-template/" target="_blank">Bootstrap admin templates</a> from Bootstrapdash.com</span>
            </div>
          </footer>
        </div>
      </div>
    </div>

    <script src="../../assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="../../assets/js/off-canvas.js"></script>
    <script src="../../assets/js/hoverable-collapse.js"></script>
    <script src="../../assets/js/misc.js"></script>
    <script src="../../assets/js/settings.js"></script>
    <script src="../../assets/js/todolist.js"></script>
  </body>
  </html>


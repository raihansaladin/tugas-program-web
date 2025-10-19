<?php

// Configure your DB here if needed
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'desa_bungi';

function db_connect($host, $user, $pass, $name) {
    $mysqli = new mysqli($host, $user, $pass, $name);
    $mysqli->set_charset('utf8mb4');
    return $mysqli;
}

$db = db_connect($DB_HOST,$DB_USER,$DB_PASS,$DB_NAME);
$img = $db->query('SELECT photo FROM uraian ORDER BY id_uraian');
$desc = $db->query('SELECT uraian_singkat FROM uraian ORDER BY id_uraian');
$leng = $db->query('SELECT uraian_lengkap FROM uraian ORDER BY id_uraian');

# Panggil gambar
$imgs = [];
while ($row = $img->fetch_assoc()) { 
	$imgs[] = htmlspecialchars($row['photo'],ENT_QUOTES, 'UTF-8');
}

# panggil deskripsi
$descs = [];
while ($row = $desc->fetch_assoc()) { 
	$descs[] = htmlspecialchars_decode($row['uraian_singkat'],ENT_QUOTES);
}
# panggil deskripsi
$lengs = [];
while ($row = $leng->fetch_assoc()) { 
	$lengs[] = htmlspecialchars_decode($row['uraian_lengkap'],ENT_QUOTES);
}
?>
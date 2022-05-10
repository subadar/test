<?php
define('NISN_URL',"http://semarangkota.dapodik.org/siswa.php");

require_once 'nisn.calss.php';

$data_nisn = get_nisndata('0064564633'); //cari data siswa dg NISN 0041411454
echo '<pre>';
print_r($data_nisn);
echo '</pre>';
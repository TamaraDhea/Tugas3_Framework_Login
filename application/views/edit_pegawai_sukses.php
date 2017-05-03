<!-- <?php 

	// echo "Sukses Update Data";
	// echo "</br>";
	// echo anchor('pegawai/update/'.$this->uri->segment(3), 'Update Data Lagi');
 ?> -->

 <?php
echo '<script language="javascript">';
echo 'alert ("Anda berhasil update")';
echo '</script>';
?>

<?php
redirect('pegawai','refresh');
?>
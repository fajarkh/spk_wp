<?php
include_once 'header.php';
include_once 'includes/nilai.inc.php';
$pro3 = new Nilai($db);
$stmt3 = $pro3->readAll();
include_once 'includes/alternatif.inc.php';
$pro1 = new Alternatif($db);
$stmt1 = $pro1->readAll();
$stmt4 = $pro1->readAll();
include_once 'includes/kriteria.inc.php';
$pro2 = new Kriteria($db);
$stmt2 = $pro2->readAll();
include_once 'includes/bobot.inc.php';
$pro5 = new Bobot($db);
$stmt5 = $pro5->readAll();
?>
		<div class="row">
		  <div class="col-xs-12 col-sm-12 col-md-3">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    <h3 class="panel-title">Kriteria-Kriteria</h3>
			  </div>
			  <div class="panel-body">
			    <ol>
			    	<?php
					while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
					?>
				  	<li><?php echo $row2['nama_kriteria'] ?></li>
				  	<?php
					}
				  	?>
				</ol>
			  </div>
			</div>
		  </div>
		  <div class="col-xs-12 col-sm-12 col-md-3">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    <h3 class="panel-title">Bobot Kriteria</h3>
			  </div>
			  <div class="panel-body">
			    <ol class="list-unstyled">
			    	<?php
					while ($row5 = $stmt5->fetch(PDO::FETCH_ASSOC)){
					?>
				  	<li><?php echo $row5['hasil_bobot'] ?></li>
				  	<?php
					}
				  	?>
				</ol>
			  </div>
			</div>
		  </div>
		  <div class="col-xs-12 col-sm-12 col-md-3">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    <h3 class="panel-title">Alternatif Produk</h3>
			  </div>
			  <div class="panel-body">
			    <ol>
			    	<?php
					while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){
					?>
				  	<li><?php echo $row1['nama_alternatif'] ?></li>
				  	<?php
					}
				  	?>
				</ol>
			  </div>
			</div>
		  </div>

		</div>

<!-- keterangan luas kolam -->		
		  <div class="col-xs-12 col-sm-12 col-md-4">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    <h3 class="panel-title">Luas Kolam</h3>
			  </div>
			  <div class="panel-body">
			    	
<table style="width:100%">
  <tr>
    <th>Luas Kolam</th>
    <th>Nilai Bobot</th>
    <th>Keterangan</th>
  </tr>
  <tr>
    <td>Luas Kolam < 50 m<sup>2</sup></td>
    <td>1</td>
    <td>Sangat rendah</td>
  </tr>
  <tr>
    <td>50 - 99 m<sup>2</sup></td>
    <td>2</td>
    <td>Rendah</td>
  </tr>
  <tr>
    <td>100 - 149 m<sup>2</sup></td>
    <td>3</td>
    <td>Cukup</td>
  </tr>
  <tr>
    <td>150 - 200 m<sup>2</sup></td>
    <td>4</td>
    <td>Tinggi</td>
  </tr>
  <tr>
    <td>Luas kolam > 200 m<sup>2</sup></td>
    <td>5</td>
    <td>Sangat tinggi</td>
  </tr>

</table>
			  </div>
			</div>
		  </div>
<!-- end keterangan luas kolam -->
<!-- keterangan suhu -->		
		  <div class="col-xs-12 col-sm-12 col-md-4">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    <h3 class="panel-title">Suhu</h3>
			  </div>
			  <div class="panel-body">
			    	
<table style="width:100%">
  <tr>
    <th>Suhu</th>
    <th>Nilai Bobot</th>
    <th>Keterangan</th>
  </tr>
  <tr>
    <td>Suhu < 10&#8451; </td>
    <td>1</td>
    <td>Sangat Rendah</td>
  </tr>
  <tr>
    <td>10 - 20&#8451; </td>
    <td>2</td>
    <td>Rendah</td>
  </tr>
  <tr>
    <td>21 - 30&#8451; </td>
    <td>3</td>
    <td>Cukup</td>
  </tr>
  <tr>
    <td>31 - 40&#8451; </td>
    <td>4</td>
    <td>Tinggi</td>
  </tr>
  <tr>
    <td>Suhu > 40&#8451; </td>
    <td>5</td>
    <td>Sangat tinggi</td>
  </tr>

</table>
			  </div>
			</div>
		  </div>
<!-- end keterangan suhu -->
<!-- keterangan Ph Air -->		
		  <div class="col-xs-12 col-sm-12 col-md-4">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    <h3 class="panel-title">Ph Air</h3>
			  </div>
			  <div class="panel-body">
			    	
<table style="width:100%">
  <tr>
    <th>Ph Air</th>
    <th>Nilai Bobot</th>
    <th>Keterangan</th>
  </tr>
  <tr>
    <td>0 - 3 </td>
    <td>1</td>
    <td>Sangat rendah</td>
  </tr>
  <tr>
    <td>4 - 6 </td>
    <td>2</td>
    <td>Rendah</td>
  </tr>
  <tr>
    <td>7 - 9 </td>
    <td>3</td>
    <td>Cukup</td>
  </tr>
  <tr>
    <td>10 - 11 </td>
    <td>4</td>
    <td>Tinggi</td>
  </tr>
  <tr>
    <td>12 - 14 </td>
    <td>5</td>
    <td>Sangat tinggi</td>
  </tr>

</table>
			  </div>
			</div>
		  </div>
<!-- end keterangan Ph Air -->
	</div>

  	</body>
</html>
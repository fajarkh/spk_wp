<?php
include_once '../admin/header.php';
include_once '../includes/kriteria.inc.php';
$kriteria = new Kriteria($db);
$stmt = $kriteria->readAll();

?>

<?php
while ($row_kriteria = $stmt->fetch(PDO::FETCH_ASSOC)) {  ?>

  <div class="col-xs-12 col-sm-12 col-md-4">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><?php echo $row_kriteria['nama_kriteria'] ?></h3>
      </div>
      <div class="panel-body">

        <table style="width:100%">
          <tr>
            <th>Keterangan</th>
            <th>Nilai Bobot</th>
          </tr>

          <?php
          $macam = explode(", ", $row_kriteria['macam']);
          $nilai = explode(", ", $row_kriteria['nilai']);
          $combined = array_combine($nilai, $macam);

          foreach ($combined as $key => $value) { ?>
            <tr>
              <td><?php echo $value; ?></td>
              <td><?php echo $key; ?></td>
            </tr>

          <?php } ?>

        </table>
      </div>
    </div>
  </div>

<?php } ?>
</body>

</html>
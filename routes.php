<?php
if (window.location.href.indexOf("new-pay-2") > -1) {
?>
<div class="SET">
  <BR>
  <BR>
  <h3>Upload Route File:</h3>
  <form method="POST" enctype="multipart/form-data">
    <div class="form-group">
      <input type="file" class="input" name="excel"><BR>
      <input type="submit" class="btn button" value="Upload" name="submit">
    </div>
  </form>
  <?php
  if (isset($_FILES['excel']['name'])) {
    include "xlsx.php";
    if ($con) {
      $excel = SimpleXLSX::parse($_FILES['excel']['tmp_name']);
      echo "<pre>";
      print_r($excel->dimension(2));
      print_r($excel->sheetNames());
      for ($sheet = 0; $sheet < sizeof($excel->sheetNames()); $sheet++) {
        $rowcol = $excel->dimension($sheet);
        $i = 0;
        if ($rowcol[0] != 1 && $rowcol[1] != 1) {
          foreach ($excel->rows($sheet) as $key => $row) {
            if ($i == 0) {
            } else {
              echo "ROUTENUMBER: " . $row[4] . "<br>";
              echo "ROUTETYPE: " . $row[5] . "<br>";
              echo "HOUR: " . $row[6] . "<br>";
              echo "MILESCOUNT: " . $row[8] . "<br>";
            }
            echo "<br>";
            $i++;
          }
        }
      }
    }
  }
  ?>
</div>
<?php
}
?>

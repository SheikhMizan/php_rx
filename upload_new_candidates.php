<?php
ini_set('display_errors', 1);
global $wpdb;
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<div class="container">
  <div class="row">
    <div class="col-md-6 ero">
      <br>
      <form action="#" method="POST" enctype="multipart/form-data">
        <h3 style="text-align:left">Upload New Candidates:</h3>
        <div class="form-group">
          <label for="labl">Upload File:</label>
          <input type="file" class="input form-control" name="excel">
          <label for="labl" class="input form-control snob">
            <small>File Types: .xlsx .csv</small>
          </label>
        </div>
        <input type="submit" class="btn button" name="submit">
      </form>
    </div>
  </div>
</div>

<style>
  .ero {
    box-shadow: 0 3px 6px rgb(0 0 0 / 16%), 0 3px 6px rgb(0 0 0 / 23%);
  }
  label.snob {
    border: 0;
    margin-bottom: 0;
    padding-bottom: 0px !IMPORTANT;
    height: 0;
  }

  input.btn.button {
    background-color: #579AF6 !important;
    border: 1px solid darkgreen;
    margin-top: 8px;
    color: #fff;
  }
</style>

<?php
if (isset($_FILES['excel']['name'])) {
  include "xlsx.php";
  if ($con) {
    $excel = SimpleXLSX::parse($_FILES['excel']['tmp_name']);
    echo "<pre>";
    for ($sheet = 0; $sheet < sizeof($excel->sheetNames()); $sheet++) {
      $rowcol = $excel->dimension($sheet);
      $i = 0;
      if ($rowcol[0] != 1 && $rowcol[1] != 1) {
        foreach ($excel->rows($sheet) as $key => $row) {
          if ($i != 0) {
            $usernameFull = esc_html($row[0]);
            $phone = esc_html($row[1]);
            $depot = esc_html($row[2]);
            $location = esc_html($row[3]);
            $jobloc = esc_html($row[4]);
            $date = new DateTime($row[5]);
            $dateFormatted = $date->format('d-m-Y');

            echo $usernameFull . " - ";
            echo $phone . " - ";
            echo $depot . " - ";
            echo $location . " - ";
            echo $jobloc . " - ";
            echo "DATE: " . $dateFormatted . "<br>";

            $user_id = username_exists($usernameFull);
            if ($user_id) {
              $user = get_userdata($user_id);
              $user_roles = $user->roles;
              if (!in_array('applicant', $user_roles)) {
                wp_delete_user($user_id);
              }
            }

            $random_password = wp_generate_password();
            $user_id = wp_create_user($usernameFull, $random_password);

            update_user_meta($user_id, 'indeed_depot', $depot);
            update_user_meta($user_id, 'indeed_location', $location);
            update_user_meta($user_id, 'indeed_phone', $phone);
            update_user_meta($user_id, 'indeed_joblocation', $jobloc);
            update_user_meta($user_id, 'indeed_date', $dateFormatted);

            $user = new WP_User($user_id);
            $user->set_role('indeed-applicants');

            $table = $wpdb->prefix . 'bookly_customers';
            $userid = $user_id;
            $words = str_word_count($usernameFull, 1);
            $userfirst = $words[0];
            $userlast = $words[1] . ' ' . $words[2];
            if (!$location) {
              $location = ' ';
            }

            $data = array(
              'id' => $userid,
              'wp_user_id' => $userid,
              'full_name' => $usernameFull,
              'first_name' => $userfirst,
              'last_name' => $userlast,
              'phone' => $phone,
              'country' => $location,
              'additional_address' => $location,
              'email' => ''
            );

            $count = $wpdb->get_var("SELECT COUNT(*) FROM $table WHERE wp_user_id = '$userid'");

            if (!$count) {
              $wpdb->insert($table, $data);
              $my_id = $wpdb->insert_id;
            }
          }

          echo "<br>";
          $i++;
        }
      }
    }

    echo '<br><a href="indeed-customers-filter" style="background-color:#579AF6;color:#fff" class="btn button">Go To Uploaded Candidates</a>';
  }
}
?>

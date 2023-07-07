<?php
   /* Template Name: Customer Filters */
   ?>
<?php if (
   current_user_can("director") ||
   current_user_can("administrator")
   ) { ?>
<?php
   $url = "http://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
   if (isset($_GET["sE"])) {
       $userid = $_GET["sE"];
       $user = new WP_User(intval($userid));
       $reset_key = get_password_reset_key($user);
       $wc_emails = WC()
           ->mailer()
           ->get_emails();
       $wc_emails["WC_Email_Customer_Reset_Password"]->trigger(
           $user->user_login,
           $reset_key
       );
   }
   if (isset($_GET["noA"])) {
       $userid = $_GET["noA"];
       update_user_meta($userid, "indstat-" . $userid, "No Answer");
       $ifnew = $_GET["ifn"];
       if ($ifnew == "true") {
           $url = "https://example.co.uk/indeed-customers-filter/?updated&stat=n";
           header("Location: " . $url);
       } else {
           $url = "https://example.co.uk/indeed-customers-filter/?updated";
           header("Location: " . $url);
       }
   }
   if (isset($_GET["de"])) {
       wp_delete_user($_GET["de"]);
       $ifnew = $_GET["ifn"];
       $depot = $_GET["depot"];
       if ($ifnew == "true") {
           $url =
               "https://example.co.uk/indeed-customers-filter/?stat=n&status=&depot=" .
               $depot;
           header("Location: " . $url);
       } else {
           $url = "https://example.co.uk/indeed-customers-filter/";
           header("Location: " . $url);
       }
   }
   if (isset($_GET["resetpass"])) {
       $driverid = $_GET["se"];
       $depot = $_GET["depot"];
       $driverid = get_user_by("id", $driverid);
       $user_login = $driverid->user_login;
       retrieve_password($user_login);
       $ifnew = $_GET["ifn"];
       if ($ifnew == "true") {
           $url =
               "https://example.co.uk/indeed-customers-filter/?sent=Email Sent&stat=n&status=&depot=" .
               $depot;
           header("Location: " . $url);
       } else {
           $url = "https://example.co.uk/indeed-customers-filter/?sent=Email Sent";
           header("Location: " . $url);
       }
   }
   ?>
<div class="container-fluid">
<?php if (!empty($_GET["depot"]) || !empty($_GET["status"])) {
   $args = [
       "role__in" => ["indeed-applicants", "xsxss1ss"],
       "orderby" => "user_nicename",
       "order" => "ASC",
   ];
   $userst = get_users($args);
   } elseif (!empty($_GET["dri"])) {
   $number = 20;
   $paged = get_query_var("paged");
   $args = [
       "role__in" => ["indeed-applicants", "xsxss1ss"],
       "orderby" => "user_nicename",
       "order" => "ASC",
       "offset" => $paged ? ($paged - 1) * $number : 0,
       "search" => "*" . $_GET["dri"] . "*",
       "number" => $number,
   ];
   $userst = get_users($args);
   $total_users = count_users();
   $total_users = $total_users["total_users"];
   } elseif (!empty($_GET["ddri"])) {
   $number = 20;
   $paged = get_query_var("paged");
   $args = [
       "role__in" => ["indeed-applicants", "xsxss1ss"],
       "orderby" => "user_nicename",
       "order" => "ASC",
       "offset" => $paged ? ($paged - 1) * $number : 0,
       "meta_query" => [
           "relation" => "OR",
           [
               "key" => "indeed_date",
               "value" => $_GET["ddri"],
               "compare" => "==",
           ],
           [
               "key" => "indeed_depot",
               "value" => $_GET["depot"],
               "compare" => "==",
           ],
           [
               "key" => "indeed_location",
               "value" => $_GET["cal"],
               "compare" => "==",
           ],
       ],
       "number" => $number,
   ];
   $userst = get_users($args);
   $total_users = count_users();
   $total_users = $total_users["total_users"];
   } elseif (!empty($_GET["cal"])) {
   $number = 20;
   $paged = get_query_var("paged");
   $args = [
       "role__in" => ["indeed-applicants", "xsxss1ss"],
       "orderby" => "user_nicename",
       "order" => "ASC",
       "offset" => $paged ? ($paged - 1) * $number : 0,
       "meta_query" => [
           "relation" => "AND",
           [
               "key" => "indeed_location",
               "value" => $_GET["cal"],
               "compare" => "==",
           ],
       ],
       "number" => $number,
   ];
   $userst = get_users($args);
   $total_users = count_users();
   $total_users = $total_users["total_users"];
   } else {
   $number = 20;
   $paged = get_query_var("paged");
   $args = [
       "role__in" => ["indeed-applicants", "xsxss1ss"],
       "orderby" => "user_nicename",
       "order" => "ASC",
       "offset" => $paged ? ($paged - 1) * $number : 0,
       "number" => $number,
   ];
   $userst = get_users($args);
   $total_users = count_users();
   $total_users = $total_users["total_users"];
   } ?>
<a href="https://example.co.uk/wp-admin/" class="btn btn-primary cfredm">Home</a>
<a href="<?php echo "//{$_SERVER["HTTP_HOST"]}{$_SERVER["REQUEST_URI"]}"; ?>"  class="btn btn-primary cfredm btn btn-primary btn-sm submitbtn">Save</a>  
<?php if (strpos($url, "stat=n") !== false) { ?>
<a href="https://example.co.uk/indeed-customers-filter/?stat=n&depot=&status="  class="btn btn-primary  btn-sm submbtn">Clear Search Filters</a> 
<?php } else { ?>
<a href="https://example.co.uk/indeed-customers-filter/?s=n&depot=&status="  class="btn btn-primary  btn-sm submbtn">Clear Search Filters</a> 
<?php } ?>
<br>
<?php
   $driver = $_GET["driver"];
   $depot = $_GET["depot"];
   $status = $_GET["status"];
   $stat = $_GET["stat"];
   if (!$stat) {
       $stat = "";
   }
   if (!$status) {
       $status = "";
   }
   if (!$depot) {
       $depot = "";
   }
   $url = "http://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
   if (strpos($url, "stat=n") !== false) {
       $newc = "true";
       echo "<h3>New Candidates</h3>";
   } else {
       echo "<h3>Existing Candidates</h3>";
   }
   ?>
<div class="row filterSm">
   <div class="col-md  ero">
      <label style="float:left; margin-right:5px;">Driver Name:</label>
      <input id="input1" type="text" onkeyup="filterTable()" class="w3-input form-control" style="width:140px" placeholder="Search..">
      <?php if ($newc) { ?>
      <a class="polashi btn btn-primary" style="margin-left:5px;" href="https://example.co.uk/indeed-customers-filter/?stat=n&depot=<?php echo $depot; ?>&status=<?php echo $status; ?>&dri=">Search</a>
      <?php } else { ?>
      <a class="polashi btn btn-primary" style="margin-left:5px;" href="https://example.co.uk/indeed-customers-filter/?s=n&depot=<?php echo $depot; ?>&status=<?php echo $status; ?>&dri=">Search</a>
      <?php } ?>
      <style>
         input#input1 {
         float: left;
         }
      </style>
      <script>
         jQuery(".polashi").on("click", function(e) {
         e.preventDefault();
         var input = jQuery("#input1").val();
         var hreff = jQuery(this).attr("href") + input; 
         window.location = hreff;
         })
      </script>
   </div>
   <div class="col-md ero">
      <label style="float:left; margin-right:5px;">Date :</label>
      <input  id="input2" type="text" onkeyup="filterTable()" class="w3-input form-control" style="width:140px; float:left;" placeholder="Search..">
      <?php if ($newc) { ?>
      <a class="xolashi btn btn-primary" style="margin-left:5px;" href="https://example.co.uk/indeed-customers-filter/?stat=n&depot=<?php echo $depot; ?>&status=<?php echo $status; ?>&ddri=">Search</a>
      <?php } else { ?>
      <a class="xolashi btn btn-primary" style="margin-left:5px;" href="https://example.co.uk/indeed-customers-filter/?s=n&depot=<?php echo $depot; ?>&status=<?php echo $status; ?>&ddri=">Search</a>
      <?php } ?>
      <style>
         input#input1 {
         float: left;
         }
      </style>
      <script>
         jQuery(".xolashi").on("click", function(e) {
         e.preventDefault();
         var input = jQuery("#input2").val();
         var hreff = jQuery(this).attr("href") + input; 
         window.location = hreff;
         })
      </script>
   </div>
   <style>
      .row.filterSm .ero {
      width: 307px;
      float: left;
      }.row.filterSm {
      margin-left: 2px;
      }
   </style>
   <a  href="#" style="float:right" eid="'.$user->ID.'" class="btn btn-primary btn-sm closer">Close</a> 
   <table id="myTable" class="wp-list-table striped table-striped table xq widefat fixed table-view-list posts mien">
      <select class="indStat hide" style="display:none" date="'.$indate.'" ei="'.$user->ID.'">
         <option> Change Status </option>
         <option value="CONTACT REQ">CONTACT REQ.</option>
         <option value="CONTACT REQ 1">CONTACT REQ. (C1)  </option>
         <option value="CONTACT REQ 2">CONTACT REQ. (C2)  </option>
         <option value="CONTACT REQ 3">CONTACT REQ. (C3)  </option>
         <option value="CONTACT REQ 4">CONTACT REQ. (C4)  </option>
         <option value="REQUESTED CALL BACK"> REQUESTED CALL BACK </option>
         <option value="INDUCTION BOOKED">INDUCTION BOOKED </option>
         <option value="MISSED IND 1"> MISSED IND. (1)</option>
         <option value="UNRESPONSIVE"> UNRESPONSIVE </option>
         <option value="MISSING CONTACT INFO"> MISSING CONTACT INFO  </option>
         <option value="NOT INTERESTED">  NOT INTERESTED   </option>
         <option value="NOT ELIGIBLE"> NOT ELIGIBLE   </option>
         <option value="No Answer">  No Answer  </option>
         <option value="INVALID NUMBER">  INVALID NUMBER   </option>
      </select>
      <thead>
         <tr>
            <th>  Name </th>
            <th>  Email </th>
            <th>  Depot </th>
            <th>  Date </th>
            <th>  Phone </th>
            <th>  Candidate Location </th>
            <th>  Job Location </th>
            <th>  Status </th>
            <th>  Action </th>
         </tr>
      </thead>
      <tbody>
         <?php foreach ($userst as $user) {
            $post_id = $user->ID;
            $uid = $user->ID;
            $uid = get_userdata($uid);
            $depot = $uid->roles;
            $esx = $depot[0];
            $depot = $depot[0];
            $a = "1";
            $depuser = $user->ID;
            $user_id = $user->ID;
            $user_info = get_userdata($depuser);
            $username = $user_info->display_name;
            $nail = $user_info->user_email;
            $xdepot = get_user_meta($user_id, "indeed_depot", true);
            $inlocation = get_user_meta($user_id, "indeed_location", true);
            $inphone = get_user_meta($user_id, "indeed_phone", true);
            $injobloc = get_user_meta($user_id, "indeed_joblocation", true);
            $indate = get_user_meta($user_id, "indeed_date", true);
            $instat = get_user_meta($user_id, "indstat-" . $user_id, true);
            $indEmail = get_user_meta($user_id, "indEmail-" . $user_id, true);
            $driver = $_GET["driver"];
            $depot = $_GET["depot"];
            $status = $_GET["status"];
            $stat = $_GET["stat"];
            if ($depot && $status) {
                if ($status == $instat && $depot == $xdepot) {
                    echo '
               <tr i="' .
                        $user->ID .
                        '" datavan="' .
                        $ifown .
                        '">
            
                 <td> ' .
                        $username .
                        ' </td>
                 <td>
                 <input type="email" date="' .
                        $indate .
                        '" ei="' .
                        $user->ID .
                        '" class="indEmail" name="emailIndeed" placeholder="Email"><br>
                 Current Email - ' .
                        $nail .
                        ' </td>
                 <td> ' .
                        $xdepot .
                        ' </td>
                 <td> ' .
                        $indate .
                        ' </td>
                 <td> <a href="tel:' .
                        $inphone .
                        '">' .
                        $inphone .
                        '</a> </td>
                 <td> ' .
                        $inlocation .
                        ' </td>
                 <td> ' .
                        $injobloc .
                        ' </td>
                 <td> 
              
                 
                  <br>  Status - ' .
                        $instat .
                        ' </td>
            <td><a class="btn btn-primary btn-sm" href="https://example.co.uk/indeed-customers-filter/?noA=' .
                        $user->ID .
                        "&ifn=" .
                        $newc .
                        "&depot=" .
                        $date .
                        "&status=" .
                        $status .
                        '" stat="No Answer" userid="' .
                        $user->ID .
                        '">No Answer</a></td>  
            
                 <td><a class="btn btn-primary stat-change btn-sm" href="javascript:void(0)" data-toggle="modal"  stat="Book Induction"  userid="' .
                        $user->ID .
                        '" data-target="#schT">Book Induction</a></td>    
                 
                       
                 <td><a class="btn btn-primary stat-change btn-sm" stat="Sent Application"  userid="' .
                        $user->ID .
                        '" href="https://example.co.uk/indeed-customers-filter/?sE=' .
                        $user->ID .
                        "&depot=" .
                        $date .
                        "&status=" .
                        $status .
                        '">Send Application</a></td>
                 <td><a class="btn btn-primary stat-change btn-sm" stat="Book Call Back"  userid="' .
                        $user->ID .
                        '" href="javascript:void(0)" data-toggle="modal" data-target="#schT">Book Call Back</a></td>
            
                 <td><a  stat="Not Eligible"  userid="' .
                        $user->ID .
                        '" href="https://example.co.uk/indeed-customers-filter/?de=' .
                        $user->ID .
                        "&depot=" .
                        $depot .
                        "&ifn=" .
                        $newc .
                        '" eid="' .
                        $user->ID .
                        "&depot=" .
                        $date .
                        "&status=" .
                        $status .
                        '" class="btn stat-change btn-primary btn-sm deleter">Not Eligible</a>  </td>
                 
                    <td><a class="btn btn-primary stat-change btn-sm" href="javascript:void(0)"  stat=" "  userid="' .
                        $user->ID .
                        '">Clear Status</a></td>    
            </tr>    ';
                }
            } elseif ($depot) {
                if ($depot == $xdepot) {
                    echo '
               <tr i="' .
                        $user->ID .
                        '" datavan="' .
                        $ifown .
                        '">
            
                 <td> ' .
                        $username .
                        ' </td>
                 <td>
                 <input type="email" date="' .
                        $indate .
                        '" ei="' .
                        $user->ID .
                        '" class="indEmail" name="emailIndeed" placeholder="Email"><br>
                 Current Email - ' .
                        $nail .
                        ' </td>
                 <td> ' .
                        $xdepot .
                        ' </td>
                 <td> ' .
                        $indate .
                        ' </td>
                 <td> <a href="tel:' .
                        $inphone .
                        '">' .
                        $inphone .
                        '</a> </td>
                 <td> ' .
                        $inlocation .
                        ' </td>
                 <td> ' .
                        $injobloc .
                        ' </td>
                 <td> 
              
                 
                  <br>  Status - ' .
                        $instat .
                        ' </td>
            <td><a class="btn btn-primary btn-sm" href="https://example.co.uk/indeed-customers-filter/?noA=' .
                        $user->ID .
                        "&ifn=" .
                        $newc .
                        "&depot=" .
                        $date .
                        "&status=" .
                        $status .
                        '" stat="No Answer" userid="' .
                        $user->ID .
                        '">No Answer</a>
            
                <a class="btn btn-primary stat-change btn-sm" href="javascript:void(0)" data-toggle="modal"  stat="Book Induction"  userid="' .
                        $user->ID .
                        '" data-target="#schT">Book Induction</a>  
                 
                       
              <a class="btn btn-primary stat-change btn-sm" stat="Sent Application"  userid="' .
                        $user->ID .
                        '" href="https://example.co.uk/indeed-customers-filter/?sE=' .
                        $user->ID .
                        "&depot=" .
                        $date .
                        "&status=" .
                        $status .
                        '">Send Application</a>
               <a class="btn btn-primary stat-change btn-sm" stat="Book Call Back"  userid="' .
                        $user->ID .
                        '" href="javascript:void(0)" data-toggle="modal" data-target="#schT">Book Call Back</a>
            
                 <a  stat="Not Eligible"  userid="' .
                        $user->ID .
                        '" href="https://example.co.uk/indeed-customers-filter/?de=' .
                        $user->ID .
                        "&depot=" .
                        $depot .
                        "&ifn=" .
                        $newc .
                        '" eid="' .
                        $user->ID .
                        "&depot=" .
                        $date .
                        "&status=" .
                        $status .
                        '" class="btn stat-change btn-primary btn-sm deleter">Not Eligible</a> 
                 
                  <a class="btn btn-primary stat-change btn-sm" href="javascript:void(0)"  stat=" "  userid="' .
                        $user->ID .
                        '">Clear Status</a></td>    
            </tr>    ';
                }
            } elseif ($status) {
                if ($status == $instat) {
                    echo '
               <tr i="' .
                        $user->ID .
                        '" datavan="' .
                        $ifown .
                        '">
            
                 <td> ' .
                        $username .
                        ' </td>
                 <td>
                 <input type="email" date="' .
                        $indate .
                        '" ei="' .
                        $user->ID .
                        '" class="indEmail" name="emailIndeed" placeholder="Email"><br>
                 Current Email - ' .
                        $nail .
                        ' </td>
                 <td> ' .
                        $xdepot .
                        ' </td>
                 <td> ' .
                        $indate .
                        ' </td>
                 <td> <a href="tel:' .
                        $inphone .
                        '">' .
                        $inphone .
                        '</a> </td>
                 <td> ' .
                        $inlocation .
                        ' </td>
                 <td> ' .
                        $injobloc .
                        ' </td>
                 <td> 
              
                 
                  <br>  Status - ' .
                        $instat .
                        ' </td>
            <td><a class="btn btn-primary btn-sm" href="https://example.co.uk/indeed-customers-filter/?noA=' .
                        $user->ID .
                        "&ifn=" .
                        $newc .
                        "&depot=" .
                        $date .
                        "&status=" .
                        $status .
                        '" stat="No Answer" userid="' .
                        $user->ID .
                        '">No Answer</a></td>  
            
                 <td><a class="btn btn-primary stat-change btn-sm" href="javascript:void(0)" data-toggle="modal"  stat="Book Induction"  userid="' .
                        $user->ID .
                        '" data-target="#schT">Book Induction</a></td>    
                 
                       
                 <td><a class="btn btn-primary stat-change btn-sm" stat="Sent Application"  userid="' .
                        $user->ID .
                        '" href="https://example.co.uk/indeed-customers-filter/?sE=' .
                        $user->ID .
                        "&depot=" .
                        $date .
                        "&status=" .
                        $status .
                        '">Send Application</a></td>
                 <td><a class="btn btn-primary stat-change btn-sm" stat="Book Call Back"  userid="' .
                        $user->ID .
                        '" href="javascript:void(0)" data-toggle="modal" data-target="#schT">Book Call Back</a></td>
            
                 <td><a  stat="Not Eligible"  userid="' .
                        $user->ID .
                        '" href="https://example.co.uk/indeed-customers-filter/?de=' .
                        $user->ID .
                        "&depot=" .
                        $depot .
                        "&ifn=" .
                        $newc .
                        '" eid="' .
                        $user->ID .
                        "&depot=" .
                        $date .
                        "&status=" .
                        $status .
                        '" class="btn stat-change btn-primary btn-sm deleter">Not Eligible</a>  </td>
                 
                    <td><a class="btn btn-primary stat-change btn-sm" href="javascript:void(0)"  stat=" "  userid="' .
                        $user->ID .
                        '">Clear Status</a></td>    
            </tr>    ';
                }
            } else {
                echo '
               <tr i="' .
                    $user->ID .
                    '" datavan="' .
                    $ifown .
                    '">
            
                 <td> ' .
                    $username .
                    ' </td>
                 <td>
                 <input type="email" date="' .
                    $indate .
                    '" ei="' .
                    $user->ID .
                    '" class="indEmail" name="emailIndeed" placeholder="Email"><br>
                 Current Email - ' .
                    $nail .
                    ' </td>
                 <td> ' .
                    $xdepot .
                    ' </td>
                 <td> ' .
                    $indate .
                    ' </td>
                 <td> <a href="tel:' .
                    $inphone .
                    '">' .
                    $inphone .
                    '</a> </td>
                 <td> ' .
                    $inlocation .
                    ' </td>
                 <td> ' .
                    $injobloc .
                    ' </td>
                 <td> 
              
                 
                  <br>  Status - ' .
                    $instat .
                    ' </td>
            <td><a class="btn btn-primary btn-sm" href="https://example.co.uk/indeed-customers-filter/?noA=' .
                    $user->ID .
                    "&ifn=" .
                    $newc .
                    '" stat="No Answer" userid="' .
                    $user->ID .
                    '">No Answer</a></td>  
            
                 <td><a class="btn btn-primary stat-change btn-sm" href="javascript:void(0)" data-toggle="modal"  stat="Book Induction"  userid="' .
                    $user->ID .
                    '" data-target="#schT">Book Induction</a></td>    
                 
                       
                 <td><a class="btn btn-primary stat-change btn-sm" stat="Sent Application"  userid="' .
                    $user->ID .
                    '" href="https://example.co.uk/indeed-customers-filter/?sE=' .
                    $user->ID .
                    '">Send Application</a></td>
                 <td><a class="btn btn-primary stat-change btn-sm" stat="Book Call Back"  userid="' .
                    $user->ID .
                    '" href="javascript:void(0)" data-toggle="modal" data-target="#schT">Book Call Back</a></td>
            
                 <td><a  stat="Not Eligible"  userid="' .
                    $user->ID .
                    '" href="https://example.co.uk/indeed-customers-filter/?de=' .
                    $user->ID .
                    "&depot=" .
                    $depot .
                    "&ifn=" .
                    $newc .
                    '" eid="' .
                    $user->ID .
                    '" class="btn stat-change btn-primary btn-sm deleter">Not Eligible</a>  </td>
                 
                    <td><a class="btn btn-primary stat-change btn-sm" href="javascript:void(0)"  stat=" "  userid="' .
                    $user->ID .
                    '">Clear Status</a></td>    
            </tr>    ';
            }
            } ?>
      </tbody>
   </table>
   <span class="ete">
   <?php if ($total_users > $number) {
      $pl_args = [
          "base" => add_query_arg("paged", "%#%"),
          "format" => "",
          "total" => ceil($total_users / $number),
          "current" => max(1, $paged),
      ];
      echo paginate_links($pl_args);
      } ?>
   </span>
   <style>
      span.ete {
      margin-left: 9px;
      }
   </style>
   <a href="<?php echo "//{$_SERVER["HTTP_HOST"]}{$_SERVER["REQUEST_URI"]}"; ?>" style="float:left" class="btn btn-primary btn-sm submitbtn">Save</a>  
   <a href="https://example.co.uk/indeed-users/" style="float:left; margin-left:5px;" class="btn btn-primary btn-sm submitbtn">Add New</a>
   <span style="margin-left:5px;"><?php echo $_GET["sent"]; ?></span>
   <div id="framerx" style="clear:both;">
      <iframe src="" height="800"  style="width:100%;" frameborder="0" ></iframe>
   </div>
   <!-- Latest compiled and minified JavaScript -->
   <script src="https://mottie.github.io/tablesorter/js/jquery.tablesorter.js"></script>
   <script src="https://mottie.github.io/tablesorter/addons/pager/jquery.tablesorter.pager.js"></script>
   <script src="https://mottie.github.io/tablesorter/js/jquery.tablesorter.widgets.js"></script>
   <script>
      jQuery("span.page-numbers.dots").next().hide()
   </script>
   <div class="modal fade" id="schT" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
               <iframe id="EE" src="https://example.co.uk/wp-admin/admin.php?page=bookly-appointments#detyfgyy"  height="700"  style="width:100%;border:none;" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share" allowFullScreen="true"></iframe>
            </div>
         </div>
      </div>
   </div>
   <script>
      jQuery(document).ready(function(){
      
      
        jQuery("input").on("keyup", function() {
          var urle = "https://example.co.uk/indeed-customers-filter/?depot=" + jQuery(this).val();
            jQuery(".submitbtn").attr("href", urle);
        });
      
          
           jQuery("#myTable").tablesorter({
          dateFormat : "ddmmyyyy", 
        });
           
          
           jQuery('.indEmail').on('change', function() {
                  var indEmail = jQuery(this).val();
                  var userid = jQuery(this).attr('ei');
                  var dateis = jQuery(this).attr('date');
                     if (  userid && indEmail ){
      jQuery.ajax({
          url: '/wp-admin/admin-ajax.php',
              data: {
                  'action':'update_view_pref',
                  'viewPref' : 'newViewPreference',
                  'userid' : userid,
                  'dateis' : dateis,
                  'indEmail' : indEmail
              },
              success:function(data) {
                  //console.log(data);
                console.log("success!"); 
              },
              error: function(errorThrown){
                  //console.log(errorThrown);
                  //console.log("fail");
              }
      });
         };
                   });
           
                       jQuery(".closer").hide();
            jQuery(".booker").click(function() {
               var userid = jQuery(this).attr('eid');
                jQuery("table#myTable").hide();
                jQuery(".submitbtn").hide();
         jQuery(".closer").show();
             var url = 'https://example.co.uk/wp-admin/admin.php?page=bookly-appointments';
             var url2 = '&uid='+userid;
             var url = url + url2;
             jQuery("#framerx iframe").attr("src", ' ');
             jQuery("#framerx iframe").attr("src", url);
             
             jQuery("#framerx").show();
             
            });
           
            jQuery(".closer").click(function() {
                jQuery(".submitbtn").show();
                jQuery("table#myTable").show();
                jQuery("#framerx").hide();
      
            });
           
           
          
      });
      
   </script> 
   <script>
      function performReset() {
      document.getElementById("input1").value = "";
      document.getElementById("input2").value = "";
      document.getElementById("input3").value = "";
      document.getElementById("input4").value = "";
      document.getElementById("input5").value = "";
      filterTable(event, 0);
      }
      
      function filterTable(event, index) {
      var filter = event.target.value.toUpperCase();
      var rows = document.querySelector("#myTable tbody").rows;
      for (var i = 0; i < rows.length; i++) {
      var firstCol = rows[i].cells[0].textContent.toUpperCase();
      var secondCol = rows[i].cells[3].textContent.toUpperCase();
      var thirdCol = rows[i].cells[2].textContent.toUpperCase();
      var forthCol = rows[i].cells[7].textContent.toUpperCase();
      var fifcol = rows[i].cells[5].textContent.toUpperCase();
      if ((firstCol.indexOf(filter) > -1 && index == 0) || (secondCol.indexOf(filter) > -1 && index == 1) || (thirdCol.indexOf(filter) > -1 && index == 2) || (forthCol.indexOf(filter) > -1 && index == 3) || (fifcol.indexOf(filter) > -1 && index == 4 ) ) {
        rows[i].style.display = "";
      } else {
        rows[i].style.display = "none";
        
      }      
      }
      }
      
      document.querySelectorAll('input.w3-input').forEach(function(el,idx){
      el.addEventListener('keyup', function(e){
      filterTable(e, idx);
      }, false);
      });
      
           jQuery("#input1,#input2,#input3,#input4,#input5").keyup(function() {
               
              setTimeout(function() {
              jQuery("#myTable tbody tr").each(function(){
              if(jQuery(this).is(":visible")) {
              
              }else{
              jQuery(this).remove();
              }
              })
              }, 2000);
               
       
           });
      
      function gup( name, url ) {
          if (!url) url = location.href;
          name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
          var regexS = "[\\?&]"+name+"=([^&#]*)";
          var regex = new RegExp( regexS );
          var results = regex.exec( url );
          return results == null ? ' ' : results[1];
      }
      
      var ntwkndr = gup('depot');
       jQuery('select#browsers option[value="' + ntwkndr + '"]').attr('selected', 'selected'); 
      var ntwkndr = gup('status');
      ntwkndr = ntwkndr.replace(/%20/g, " ");
       jQuery('select#ipsat option[value="' + ntwkndr + '"]').attr('selected', 'selected');
      var ntwkndr = gup('cal');
       jQuery('select#browsersx option[value="' + ntwkndr + '"]').attr('selected', 'selected');
      jQuery("#myTable tr").each(function(){
        var text = jQuery(this).text();
        
      if (text.indexOf('DEH1') !== -1 ) {
       jQuery(this).remove();
      }
      });
      
   </script>
</div>
<?php } else {$url = "https://example.uk/wp-admin";
   header("Location: " . $url);} ?>
<?php get_footer(); ?>

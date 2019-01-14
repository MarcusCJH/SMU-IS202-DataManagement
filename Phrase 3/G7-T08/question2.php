<html>
    <head>
        <!-- CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,dt-1.10.8/datatables.min.css"/>
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <Title> Find My Bus - Question 2</title>
    </head>
    <body>
    
    
        <nav class="navbar navbar-default" role="navigation">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    

  </div>
  

  <div class="navbar-collapse collapse">
    <ul class="nav nav-justified">
        <li><a href="question1.php">Question 1</a></li>
        <li><a href="question2.php">Question 2</a></li>
        <li><a href="question3.php">Question 3</a></li>
    </ul>
  </div>
</nav>


<center><img src ="img/logo_larc.png"> <font size ="10">|</font><img src ="img/logo_busroute.png">
<hr width =100%>

<form method="post" action="">
         
         <select name="day" class="form-control" style= "width:170px;text-align-last:center;" onchange="this.form.submit()">
            <option disabled selected value> -- Select Day -- </option> 
            <option value="1">Monday</option>
            <option value="2">Tuesday</option>
            <option value="3">Wednesday</option>
            <option value="4">Thursday</option>
            <option value="5">Friday</option>
            <option value="6">Saturday</option>
            <option value="7">Sunday</option>
         </select>
      </form>
      </center>
<hr width = 100%> 
<?php

if(isset($_POST['day']))
{
    
    $day = $_POST['day'];
    
    if($day == 1)
    {
        print "<H3> Showing staff working on: Monday</h3><br>";
    }
    else if($day == 2)
    {
        print "<H3> Showing staff working on: Tuesday</h3><br>";
    }
    else if($day == 3)
    {
        print "<H3> Showing staff working on: Wednesday</h3><br>";
    }
    else if($day == 4)
    {
        print "<H3> Showing staff working on: Thursday</h3><br>";
    }
    else if($day == 5)
    {
        print "<H3> Showing staff working on: Friday</h3><br>";
    }
    else if($day == 6)
    {
        print "<H3> Showing staff working on: Saturday</h3><br>";
    }
    else if($day == 7)
    {
        print "<H3> Showing staff working on: Sunday</h3><br>";
    }

    
    $conn = mysqli_connect("127.0.0.1","root","","findmybus");
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    
    // Query 
    $paraQuery =
    "select d.staffID,d.nric,d.drivername,d.licensenumber 
    from driver_offdays dod, driver d 
    where dod.staffid = d.staffid and dod.offday != ?
    ORDER BY d.drivername,staffID asc";

    // prepare statement
    $stmt = mysqli_prepare($conn, $paraQuery);

     // perform query
    mysqli_stmt_execute($stmt);

    //bind statement
      
    
    mysqli_stmt_bind_param($stmt, 'd',$day);
    
    
    
    // perform query
    mysqli_stmt_execute($stmt);
    
    // bind result variables
    mysqli_stmt_bind_result($stmt, $staff_IDR, $nric_R, $drivername_R, $licensenumber_r);
    

    
    
    print "<table class="."table table-striped table-bordered"." id="."mydata".">";
    print "<thead>";
    print "<TR><TH>Staff ID</TH><TH>NRIC</TH><TH>Driver Name</TH><TH>License Number</TH></TR>";
    print "</thread>";
    print "<tfoot>";
    print "<TR><TH>Staff ID</TH><TH>NRIC</TH><TH>Driver Name</TH><TH>License Number</TH></TR>";
    print "</tfoot>";
    print "<tbody>";
    while(mysqli_stmt_fetch($stmt)) {
        print "<tr>";
        print"<td>".$staff_IDR."</td><td>".$nric_R."</td><td>".$drivername_R."</td><td>".$licensenumber_r."</td>";
        print "</tr>";
    }        
    print "</tbody>";
    print "</table>";
    
    // close statement
    mysqli_stmt_close($stmt);
    
    // close connection
    mysqli_close($conn);
    
}
 
?>  
        <!-- Script -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/r/bs-3.3.5/jqc-1.11.3,dt-1.10.8/datatables.min.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(document).ready(function() {
                $('#mydata').DataTable( {
                    "order": [[ 2, "asc" ]]
                } );
        } );
        </script>
    </body>
</html>
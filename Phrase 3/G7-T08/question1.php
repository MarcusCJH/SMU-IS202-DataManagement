<html>
    <head>
        <!-- CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,dt-1.10.8/datatables.min.css"/>
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <Title> Find My Bus - Question 1</title>
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
    <select name="service_No" class="form-control" style="width:170px;text-align-last:center;" onchange="this.form.submit()">
    <option disabled selected value> -- Select Service -- </option> 
<?php
    $conn = mysqli_connect("127.0.0.1","root","","findmybus");
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }

    $query = "SELECT distinct servicenumber from service;";
    $result = mysqli_query($conn,$query);

    while($row = mysqli_fetch_array($result))
    {  
        print "<option value='" . $row['servicenumber'] . "'>" . $row['servicenumber'] . "</option>";
    }
    mysqli_close($conn);
?>
         </select>
      </form>
        </center>
<hr width = 100%>
<?php

if(isset($_POST['service_No']))
{
    $service_No = $_POST['service_No'];
    print "<H3> Service Number: ".$service_No."</h3><br>";
    
    $conn = mysqli_connect("127.0.0.1","root","","findmybus");
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    
    // Query 
    $paraQuery1 =
    "select br.stopnumber,bs.locationdesc,br.stoporder
from bus_stop bs, bus_route br 
where bs.stopnumber = br.stopnumber and br.routenumber = 1 and br.servicenumber = ? 
order by br.routenumber,br.stoporder asc";

    // prepare statement
    $stmt1 = mysqli_prepare($conn, $paraQuery1);

     // perform query
    mysqli_stmt_execute($stmt1);

    //bind statement
      
    
    mysqli_stmt_bind_param($stmt1, 's',$service_No);
    
    
    
    // perform query
    mysqli_stmt_execute($stmt1);
    
    // get result get rows
    mysqli_stmt_store_result($stmt1);
    $count1 = mysqli_stmt_num_rows($stmt1);
    
    if($count1 >0)
    {
        // bind result variables
        mysqli_stmt_bind_result($stmt1, $stopNumber_R, $locationDesc_R, $stopOrder_R);
        print "<H2>Route 1</H2>";
        print "<table class="."table table-striped table-bordered"." id="."route1".">";
        print "<thead>";
        print "<TR><TH>Stop Number</TH><TH>Stop location description</TH><TH>Stop order</TH></TR>";
        print "</thread>";
        print "<tfoot>";
        print "<TR><TH>Stop Number</TH><TH>Stop location description</TH><TH>Stop order</TH></TR>";
        print "</tfoot>";
        print "<tbody>";
        while(mysqli_stmt_fetch($stmt1)) {
            print "<tr>";
            print"<td>".$stopNumber_R."</td><td>".$locationDesc_R."</td><td>".$stopOrder_R."</td>";
            print "</tr>";
        }        
        print "</tbody>";
        print "</table>";
        print "<hr width = 100%>";
    }
    
    // Query 
    $paraQuery2 =
    "select br.stopnumber,bs.locationdesc,br.stoporder
from bus_stop bs, bus_route br 
where bs.stopnumber = br.stopnumber and br.routenumber = 2 and br.servicenumber = ? 
order by br.routenumber,br.stoporder asc";

    // prepare statement
    $stmt2 = mysqli_prepare($conn, $paraQuery2);

     // perform query
    mysqli_stmt_execute($stmt2);

    //bind statement    
    mysqli_stmt_bind_param($stmt2, 's',$service_No);
    
    
    
    // perform query
    mysqli_stmt_execute($stmt2);
    
    // get result get rows
    mysqli_stmt_store_result($stmt2);
    $count2 = mysqli_stmt_num_rows($stmt2);
    
    if($count2 >0)
    {
        // bind result variables
        mysqli_stmt_bind_result($stmt2, $stopNumber_R, $locationDesc_R, $stopOrder_R);
        print "<h2>Route 2</H2>";
        print "<table class="."table table-striped table-bordered"." id="."route2".">";
        print "<thead>";
        print "<TR><TH>Stop Number</TH><TH>Stop location description</TH><TH>Stop order</TH></TR>";
        print "</thread>";
        print "<tfoot>";
        print "<TR><TH>Stop Number</TH><TH>Stop location description</TH><TH>Stop order</TH></TR>";
        print "</tfoot>";
        print "<tbody>";
        while(mysqli_stmt_fetch($stmt2)) {
            print "<tr>";
            print"<td>".$stopNumber_R."</td><td>".$locationDesc_R."</td><td>".$stopOrder_R."</td>";
            print "</tr>";
        }        
        print "</tbody>";
        print "</table>";
    }
    
    
    
    // close statement
    mysqli_stmt_close($stmt1);
    mysqli_stmt_close($stmt2);
    
    // close connection
    mysqli_close($conn);
}
?>    
        <!-- Script -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/r/bs-3.3.5/jqc-1.11.3,dt-1.10.8/datatables.min.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(document).ready(function() {
                $('#route1').DataTable( {
                    "order": [[ 2, "asc" ]]
                } );
            } );
            $(document).ready(function() {
                $('#route2').DataTable( {
                    "order": [[ 2, "asc" ]]
                } );
        } );
        </script>
    </body>
</html>
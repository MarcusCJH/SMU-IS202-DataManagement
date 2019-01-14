<html>
    <head>
        <!-- CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,dt-1.10.8/datatables.min.css"/>
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <Title> Find My Bus - Question 3</title>
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


<center><img src ="img/logo_larc.png"> <font size ="10">|</font><img src ="img/logo_busroute.png"></center>
<hr width = 100%> 
<center>


<form method= "post" action="" class="form-inline">
    
    <div class="form-group">
    <input type="text" class="form-control" name="serviceStop" placeholder="Search Service | Stops">
  </div>
  <button type="submit" class="btn btn-default">Get Service | Stop info</button>
</form>
</center>
<hr width = 100%> 

<?php
    if(isset($_POST['serviceStop']))
    {
        $input = $_POST['serviceStop'];
        if(strlen($input) >0)
        {
            print "<h3>Query for: ".$input."</h3><br>";
            $convertInput = '%'.$input.'%';
            
            $conn = mysqli_connect("127.0.0.1","root","","findmybus");
            if (mysqli_connect_errno()) {
                printf("Connect failed: %s\n", mysqli_connect_error());
                exit();
            }
            
            // First Table
            // Query 
            $paraQuery1 =
            "SELECT r.ServiceNumber,s.frequency,s.starttime, r.RouteNumber, bs1.LocationDesc,bs2.LocationDesc
            From Route r
            INNER JOIN Service s on (s.servicenumber = r.serviceNumber)
            INNER JOIN Bus_Stop bs1 On (bs1.StopNumber = r.StartBusStop)
            INNER JOIN Bus_Stop bs2 ON (bs2.StopNumber = r.EndBusStop)
            WHERE r.serviceNumber like ?
            ORDER BY r.ServiceNumber";

            // prepare statement
            $stmt1 = mysqli_prepare($conn, $paraQuery1);

             // perform query
            mysqli_stmt_execute($stmt1);

            //bind statement
              
            
            mysqli_stmt_bind_param($stmt1, 's',$convertInput);
            
            
            
            // perform query
            mysqli_stmt_execute($stmt1);
            
            // get result get rows
            mysqli_stmt_store_result($stmt1);
            $count1 = mysqli_stmt_num_rows($stmt1);
            
            if($count1 >0)
            {
                // bind result variables
                mysqli_stmt_bind_result($stmt1, $serviceNumber_R, $frequency_R, $startTime_R, $routeNumber_R,$startLocationDesc_R,$endLocationDesc_R);
                

                
                print "<H2>Service Result</H2>";
                print "<table class="."table table-striped table-bordered"." id="."firstTable".">";
                print "<thead>";
                print "<TR><TH>Service Number</TH><TH>Frequency</TH><TH>First Bus Start Time</TH><TH>Route Number</TH><TH>Start Stop Description</TH><TH>End Stop Description</TH></TR>";
                print "</thread>";
                print "<tfoot>";
                print "<TR><TH>Service Number</TH><TH>Frequency</TH><TH>First Bus Start Time</TH><TH>Route Number</TH><TH>Start Stop Description</TH><TH>End Stop Description</TH></TR>";
                print "</tfoot>";
                print "<tbody>";
                while(mysqli_stmt_fetch($stmt1)) {
                    print "<tr>";
                    print"<td>".$serviceNumber_R."</td><td>".$frequency_R."</td><td>".$startTime_R."</td><td>".$routeNumber_R."</td><td>".$startLocationDesc_R."</td><td>".$endLocationDesc_R."</td>";
                    print "</tr>";
                }        
                print "</tbody>";
                print "</table>";
                
                print "<hr width = 100%>";
            }
            
            
            
            // Second Table From here
            
            // Query 
            $paraQuery2 =
            "select distinct br.stopnumber,bs.address, count(br.servicenumber)
            from bus_stop bs,bus_route br
            where bs.stopnumber = br.stopnumber and br.stopNumber like ?
            group by br.stopnumber
            order by br.stopnumber";

            // prepare statement
            $stmt2 = mysqli_prepare($conn, $paraQuery2);

             // perform query
            mysqli_stmt_execute($stmt2);

            //bind statement
              
            
            mysqli_stmt_bind_param($stmt2, 's',$convertInput);
            
            
            
            // perform query
            mysqli_stmt_execute($stmt2);
            
            // get result get rows
            mysqli_stmt_store_result($stmt2);
            $count2 = mysqli_stmt_num_rows($stmt2);
            
            if($count2 >0)
            {
                // bind result variables
                mysqli_stmt_bind_result($stmt2, $stopNumber_R, $address_R, $count_R);
                

                
                print "<H2>Stop Result</H2>";
                print "<table class="."table table-striped table-bordered"." id="."secondTable".">";
                print "<thead>";
                print "<TR><TH>Stop Number</TH><TH>Stop Address</TH><TH>Service Number served</TH></TR>";
                print "</thread>";
                print "<tfoot>";           
                print "<TR><TH>Stop Number</TH><TH>Stop Address</TH><TH>Service Number served</TH></TR>";
                print "</tfoot>";
                print "<tbody>";
                while(mysqli_stmt_fetch($stmt2)) {
                    print "<tr>";
                    print"<td>".$stopNumber_R."</td><td>".$address_R."</td><td>".$count_R."</td>";
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
            
    }
?>
        <!-- Script -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/r/bs-3.3.5/jqc-1.11.3,dt-1.10.8/datatables.min.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(document).ready(function() {
    $('#firstTable').DataTable();
} );
            $(document).ready(function() {
    $('#secondTable').DataTable();
} );


        </script>   
    </body>
</html>
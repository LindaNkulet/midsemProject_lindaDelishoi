        <!DOCTYPE html>
      <html>
        <head>
        <meta charset="utf-8">
        <meta charset="utf-8" />
        <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
        <link rel="icon" type="image/png" href="../assets/img/favicon.png" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>AshesiMoney by Linda<</title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no;" />

        <link rel="stylesheet"  href="css/jquery.mobile.structure.css" />
        <link rel="stylesheet" href="css/jquery.mobile.theme.css" />

        
        <script>
          var userAgent = navigator.userAgent + '';
          if (userAgent.indexOf('iPhone') > -1) {
            document.write('<script src="js/lib/cordova-iphone.js"></sc' + 'ript>');
            var mobile_system = 'iphone';
          } else if (userAgent.indexOf('Android') > -1) {
            document.write('<script src="js/lib/cordova-android.js"></sc' + 'ript>');
            var mobile_system = 'android';
          } else {
            var mobile_system = '';
          }
        </script>
        
        <script src="js/lib/jquery.js"></script>
        <!-- your scripts here -->
        <script src="js/app/app.js"></script>
        <script src="js/app/bootstrap.js"></script>
        <script src="js/lib/jquery.mobile.js"></script>

      <!--sETTING THE DIMENSIONS OF THE MAP-->
        <style>
             table, td, th {
      border: 1px solid black;
       padding: 15px;
  }

  table {
      border-collapse: collapse;
      width: 100%;
  }

  th {
      text-align: left;
      background-color: #4CAF50;
      color: white;
  }
  tr:hover {background-color: #f5f5f5;}
  ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    color: #4CAF50;
    overflow: hidden;
    background-color: #dddddd;
}

li {
    float: left;
}
}

li a {
    display: block;
    padding: 8px;
}
li a, .dropbtn {
    display: inline-block;
    color: #4CAF50;
    text-align: center;
    padding: 20px 18px;
    text-decoration: none;
}

li a:hover, .dropdown:hover .dropbtn {
    background-color: #f9f9f9;
}

li.dropdown {
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    text-align: left;
}

.dropdown-content a:hover {background-color: #f1f1f1}

.dropdown:hover .dropdown-content {
    display: block;
}

input[type=text] {
    width: 70%;
    box-sizing: border-box;
    border: 2px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    background-color: #f5f5f5;
    background-position: 10px 10px; 
    background-repeat: no-repeat;
    padding: 7px ;
    margin-left: 60%;
    margin-top: 2%;
}
          </style>

<!--padding: 12px 20px 12px 40px;-->

        </head>
        <body>
          
          <div data-role="page">

          	<!-- <div data-role="header">
          		<h3>ASHESI MONEY</h3>
          	</div><!-- /header -->

          	<div data-role="content">
            <div data-role="navbar" >
            <ul>
              <li  ><h3>ASHESI MONEY SERVICES</h3></li>
              <li style="float:right"><a class="active" href="#logout">LOGOUT</a></li>
              <li><input class="searchbar" placeholder="Search..." type="text" autocomplete="off"  id="autocomplete_search" value="search"/></li>
              
              </ul>
              
            </div>
   <div id="table" class="transactions-table" style="overflow-x:auto;">          
           <?php

// php populate html table from mysql database

$hostname = "localhost";
$username = "root";
$password = "";
$databaseName = "mobileweb_project";


// connect to mysql
$connect = mysqli_connect($hostname, $username, $password, $databaseName,3307);

// mysql select query

$query = "SELECT * FROM transactions";


// result for method one
$result1 = mysqli_query($connect, $query);

$dataRow = "";

 
  while($row1 = mysqli_fetch_array($result1)):;
      $dataRow =$dataRow. "<tr>
                <td> ".$row1[0]." </td>
                <td> ".$row1[1]." </td>
                <td> ".$row1[2]." </td>
                <td> ".$row1[3]." </td>
                <td> ".$row1[4]." </td>
                <td> ".$row1[5]." </td>
            </tr>";
    endwhile;
    ?>
<table border="1">
	<td>TransactionID</td>
	<td>msisdn</td>
	<td>Transaction type</td>
	<td>Receipeint's no.</td>
	<td>Amount</td>
	<td>Date</td>

    <?php

echo "$dataRow";
?>
</table>

</div><!-- /content -->


            <footer class="page-footer">
                <div class="container">
                  <div class="row">
                    <div class="col l6 s12">
                    <a href="#">Ashesi Money</a>, simple,easy and efficient mobile money service
                      <p class="grey-text text-lighten-4">@copyright AshesiMoneyLinda.All Rights Reserved. </p>
                    </div>
                  </div>
                </div>
              </footer>       

          </div><!-- /page -->
        </body>
      </html>
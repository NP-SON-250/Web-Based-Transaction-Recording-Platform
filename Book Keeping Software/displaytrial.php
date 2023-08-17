<?php
$failmessage="";
$successmessage="";
$failentrymessage="";

$totDebit=0;
$totCredit=0;

require 'connector.php';
session_start();
$id=$_SESSION["BusinessId"];
$bsname=$_SESSION["LegalName"];

if(!isset($_SESSION["BusinessName"])){
    header("location:login.php");
}else
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TransacBooks</title>
    <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"><span id="logo">Transac</span>Books</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="MainPage.php" id="home">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link " aria-current="page" href="makejournal.php" id="home">Make Journal Entries</a>
          </li>
		  <li class="nav-item">
            <a class="nav-link" aria-current="page" href="purchaseorder.php" id="home">Purchase Order</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="salesorder.php" id="home">Sales Order</a>
          </li>
          <li class="nav-item dropdown"id="home">
                <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Reports
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="displayjournal.php" >Journal Entry</a></li>
                  <li><a class="dropdown-item" href="displayledger.php">General Ledger</a></li>
                  <li><a class="dropdown-item active" aria-current="page" href="displaytrial.php">Trial Balance</a></li>
                  <li><a class="dropdown-item" href="displayincome.php">Income Statement</a></li>
                  <li><a class="dropdown-item" href="displaybalance.php">Balance Sheet</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="#">Others</a></li>
                </ul>
              </li>
              <b><li class="nav-item" style="font-size: 30px; margin-top: 2px;margin-left: 50px;"><?php echo $bsname?></li></b>
        </ul>
        <a href="logout.php"><button class="btn btn-outline-none text-dark">Logout</button></a>
      </div>
    </div>
</nav>
<div class="container">
    <div class="row justfy-content-center my-5 mx-0">
        <div class="col-md-3 mx-0" id="register">
        <div class="text-center">
        <h2 id="formheading">BANK INFO</h2>
        <center><hr id="headinghr"></center>
        </div>
        <?php
        $que=mysqli_query($conn,"SELECT * FROM accounts WHERE BusinessId='$id' AND AccName LIKE '%Bank%' OR '%bank%'");
        if (mysqli_num_rows($que) > 0) {
            // output data of each row
            ?>
            <table class="table" style="opacity: 0.5;">
                <thead>
                    <tr>
                        <th scope="col">Bank Name</th>
						<th scope="col">Balances</th>
                    </tr>
                </thead>
                <?php
                 while($result = mysqli_fetch_assoc($que)) {
                    ?>
                <tbody>
                <tr>
				  <td><?php echo $result['BankName'];?></td>
				  <td><?php echo $result['AccBalance'];?> Rwf</td>
                               
                </tr> 
                </tbody>
                <?php 
            }
          } else {
            echo "Please, Create Bank Account";
          }
            ?>

            </table>
    </div>
        <div class="col-md-9 mx-0" id="register">
        <div class="text-center">
        <b><h5 style="color:blue; font-size: 20px;"><?php echo $bsname;?></h5></b>
        <h2 id="formheading">TRIAL BALANCE REPORT </h2>
        <center><hr id="headinghr"></center>
        </div>
        <center><table class="table table-hover" style="opacity: 0.5;">
    <tr>
               <th>Details</th>
               <th>Dr</th>
               <th>Cr</th>
               
               
           </tr>
        <?php

        $accountnames =mysqli_query($conn,"SELECT AccName FROM accounts WHERE BusinessId = '$id' AND NOT AccBalance='0'");
        while($namerow=mysqli_fetch_assoc($accountnames)){
         $Name=$namerow['AccName'];
         ?>
         
        
        
                  <?php
                  $debitsum1=mysqli_query($conn,"SELECT SUM(Amount) AS Total1 FROM journal WHERE BusinessId='$id' AND DAccount='$Name'");
                  $debitrow = mysqli_fetch_assoc($debitsum1);
                  $creditsum2=mysqli_query($conn,"SELECT SUM(Amount) AS Total2 FROM journal WHERE BusinessId='$id' AND CAccount='$Name'");
                  $creditrow = mysqli_fetch_assoc($creditsum2);
                  $total1 = $debitrow["Total1"];
                  $total2 = $creditrow["Total2"];
                  ?>
              <tr>
                  <td><?php echo $Name;?></td>

                  <?php
                  $total=0;
                  if($total1 > $total2){
                    $total= $total1-$total2;
                    $totDebit+=$total;
                    ?>
                    <td ><?php echo $total;?></td>
                    <td></td>
                    <?php
                    
                  }
                  elseif($total1 < $total2){
                    $total= $total2-$total1;
                    $totCredit+=$total;
                    
                    ?>
                    <td></td>
                    <td><?php echo $total;?></td>
                    
                    
                    <?php
                    
                  }
                  else{
                    echo "";
                  }
                  ?>
                  
                  
                </tr>
                
                <?php
      }
        ?>
        <tfoot style="background: white;">
        <tr>
          
                  <td style="background:transparent; border:none;"><b>Total</b></td>
                  <td id="val" style="background:transparent; border:none;"><b><b><u><?php echo $totDebit;?></u></b></b></td>
                  <td id="val1" style="background:transparent; border:none;"><b><b><u><?php echo $totCredit;?></u></b></td>
                </tr>
          </tfoot>
    </table></center>
        </div>
        
    </div>
</div>

<div class="container-fluid mx-0" id="footer">
  <div class="row justfy-content-center my-5">
    <div class="col md-3 mx-3">
      <h4 class="powered">Powered <span id="by">By:</span></h4>
      <p  id="pimage" class="text-light mx-5"><span id="logo">Transac</span>Books||<img src="./logo.png" alt="Logo"></p>
    </div>
    <div class="col md-3 mx-3">
    <h4 class="powered">Quick Links:</h4>
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link text-light" aria-current="page" href="#" id="home">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light" aria-current="page" href="makejournal.php" id="home">Make Journal Entries</a>
          </li>
        </ul>
    </div>
    <div class="col md-3 mx-0" id="social">
    <h4 class="powered">Get Intouch:</h4>
    <p class="text-secondary">
      Question Or Feedback? We'd <br>Like To Here From Your.

    </p>
    <a href="https://www.instagram.com"><img src="./instagram.png" alt="Instagram"></a>
    <a href="https://www.facebook.com"><img src="./facebook.png" alt="Face book"></a>

    </div>
    <div class="col md-3 mx-0" id="social">
    <p  id="pimage" class="text-light mx-5"><span class="text-secondary">Copyright</span> <span id="logo">Transac</span>Books(2023) <span class="text-secondary">
      All Right Reserved.</span></p>

    </div>
  </div>
</div>
  <script src="js/bootstrap.bundle.js"></script>
  <script src="js/script.js"></script>
</body>
</html>
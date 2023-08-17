<?php
$failmessage="";
$successmessage="";
$failentrymessage="";
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
            <a class="nav-link " aria-current="page" href="salesorder.php" id="home">Sales Order</a>
          </li>
          <li class="nav-item dropdown"id="home">
                <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Reports
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="displayjournal.php" >Journal Entry</a></li>
                  <li><a class="dropdown-item active" aria-current="page" href="displayledger.php">General Ledger</a></li>
                  <li><a class="dropdown-item" href="displaytrial.php">Trial Balance</a></li>
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
            <table class="table table-hover" style="opacity: 0.5;">
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
        <h2 id="formheading">GENERAL LEDGER REPORT </h2>
        <center><hr id="headinghr"></center>
        </div>
        <?php
$accselect =mysqli_query($conn,"SELECT AccName FROM accounts WHERE BusinessId = '$id'AND NOT AccBalance='0'");
if(mysqli_num_rows($accselect) > 0){
while($com=mysqli_fetch_assoc($accselect)){
 $Name=$com['AccName'];
 ?>
 <center><table class="table" style="opacity: 0.5;>
   <tr  style=" text-light; font-size: 20px;">
    
   <center><h6><?php echo $Name ?></h6></center>
   
</tr>
   <tr>
       <th>Date</th>
       <th>Details</th>
       <th>Dr</th>
       <th>Cr</th>
       
       
   </tr>
 <?php
$query =mysqli_query($conn,"SELECT * FROM journal WHERE BusinessId = '$id' AND DAccount='$Name'");


$ledgerData = array();
if(mysqli_num_rows($query) > 0){
 
  while($ret=mysqli_fetch_assoc($query)){

      ?>
      <tr>
      <td><?php echo $ret['Dates'];?></td>
          <td>By&nbsp;<?php echo $ret['CAccount']?></td>
          <td><?php echo $ret['Amount']?></td>
          <td></td>

        </tr>
      <?php

  }

}
$query1 =mysqli_query($conn,"SELECT * FROM journal WHERE BusinessId = '$id' AND CAccount='$Name'");

if(mysqli_num_rows($query1) > 0){
 
  while($retr=mysqli_fetch_assoc($query1)){

      ?>
      <tr>
      <td><?php echo $retr['Dates'];?></td>
          <td>By&nbsp;<?php echo $retr['DAccount']?></td>
          <td></td>
          <td><?php echo $retr['Amount']?></td>

        </tr>
      <?php

  }

}?>
<tr>
          <?php
          $sum1=mysqli_query($conn,"SELECT SUM(Amount) AS Total1 FROM journal WHERE BusinessId='$id' AND DAccount='$Name'");
          $ro = mysqli_fetch_assoc($sum1);
          $sum2=mysqli_query($conn,"SELECT SUM(Amount) AS Total2 FROM journal WHERE BusinessId='$id' AND CAccount='$Name'");
          $roo = mysqli_fetch_assoc($sum2);
          $total1 = $ro["Total1"];
          $total2 = $roo["Total2"];
          ?>
          <td></td>
          <td><b>Balance</b></td>
          

          <?php
          $balance=0;
          if($total1 > $total2){
            $balance= $total1-$total2;
            ?>
            <td></td>
            <td><b><?php echo $balance;?></b></td>
            <?php
            
          }
          elseif($total1 < $total2){
            $balance= $total2-$total1;
            ?>
            <td><b><?php echo $balance;?></b></td>
            
            <td></td>
            <?php
            
          }
          else{
            ?>
            <td><b><?php echo $balance;?>&nbsp;Rwf</b></td>
            <td><b><?php echo $balance;?>&nbsp;Rwf</b></td>
            
            <td></td>
            <?php
          }
          ?>
          
          
          
        </tr>
        <?php
}
}else{
    echo "All Accounts Are 0 In Balance, Please, Make Journal Transactions";
}
?>
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
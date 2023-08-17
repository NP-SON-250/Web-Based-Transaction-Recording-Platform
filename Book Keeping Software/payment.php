<?php
$failmessage="";
$successmessage="";
require 'connector.php';
session_start();
$id=$_SESSION["BusinessId"];
$bsname=$_SESSION["LegalName"];

if(!isset($_SESSION["BusinessName"])){
    header("location:login.php");
}else
	
if($_SERVER['REQUEST_METHOD'] == 'GET' ){
	
	$PorderId =$_GET["PorderId"];

//  SELECT query for selected row from table
$stmt ="SELECT * FROM purchaseorder WHERE BusinessId  =$id AND PorderId = $PorderId";
$result = $conn->query($stmt);
$row = $result->fetch_assoc();
if(!$row){
	header("location:/purchaseorder.php");
		exit;
}
$BusinessId =$row["BusinessId"];
$ProdName =$row["ProdName"];
$ProdQuantity =$row["ProdQuantity"];
$Unitofmeasure =$row["Unitofmeasure"];
$TotalAmount =$row["TotalAmount"];
}
else{
	
}

	
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
            <a class="nav-link active" aria-current="page" href="purchaseorder.php" id="home">Purchase Order</a>
          </li>
          <li class="nav-item">
            <a class="nav-link " aria-current="page" href="salesorder.php" id="home">Sales Order</a>
          </li>
          <li class="nav-item dropdown"id="home">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Reports
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="displayjournal.php" >Journal Entry</a></li>
                  <li><a class="dropdown-item" href="displayledger.php">General Ledger</a></li>
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
	<div class="col-md-3 " id="register">
      <div class="text-center">
      <h2 id="formheading">Receve Stock</h2>
      <center><hr id="headinghr"></center>
	    <center><p style="color:red;"><?php if($failmessage) {echo $failmessage;}?></h2></center>
        <center><p style="color:black;"><?php if($successmessage) {echo $successmessage;}?></h2></center>
    </div>
        <form action="purchaseorder.php" method = "POST">
		  <input type="hidden" id="BusnameId" name="BusnameId" value="<?php echo $id?>">
          <label for="ProdName" class="form-label" id="formlabel">Product Name</label>
          <input type="text" id="ProdName" name="ProdName" class="form-control" 
		  value="<?php echo $ProdName;?>" readonly="true" style="cursor: no-drop;" required>
          <label for="ProdQuantity" class="form-label" id="formlabel">Product Quantity</label>
          <input type="text" id="ProdQuantity" name="ProdQuantity"  class="form-control" 
		  value="<?php echo $ProdQuantity;?>" readonly="true" style="cursor: no-drop;" required>
          <label for="Unitofmeasure" class="form-label" id="formlabel">Unit Of Measurement</label>
         <input type="text" id="Unitofmeasure" name="Unitofmeasure"  class="form-control" 
		 value="<?php echo $Unitofmeasure;?>" readonly="true" style="cursor: no-drop;" required>
		   <label for="TotalAmount" class="form-label" id="formlabel">Total Amount</label>
          <input type="number" id="TotalAmount" name="TotalAmount"  class="form-control" 
		  value="<?php echo $TotalAmount;?>" readonly="true" style="cursor: no-drop;"required>
		  <label for="PaidAmount" class="form-label" id="formlabel">Paid Amount</label>
          <input type="number" id="PaidAmount" name="PaidAmount"  class="form-control" 
		  value="<?php echo $PaidAmount;?>" readonly="true" style="cursor: no-drop;"required>
          <center><button class="btn btn-outline-dark text-success my-3" style="font-size: 16px; 
          font-weight: 700; width: 50%;" name="Submit">Proceed To Pay</button></center>
        </form>
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
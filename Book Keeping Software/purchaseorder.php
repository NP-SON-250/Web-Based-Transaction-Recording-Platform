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
$vendnamequery =mysqli_query($conn, "SELECT * FROM vendors WHERE BusinessId ='$id'");

if(isset($_POST["submit"])){
    $VendName = $_POST["VendName"];
    $VendEmail = $_POST["VendEmail"];
    //checking if the fields are not left empty
    if(!empty($VendName) || !empty($VendEmail) ){
        if(mysqli_connect_error()){
            die('Connect Error(' .mysqli_connect_errno(). ')'. mysqli_connect_error());


        }else{
            $SELECT = "SELECT VendName From vendors Where VendName = ? Limit 1";
            $INSERT = "INSERT INTO vendors(BusinessId ,VendName,VendEmail)
             Values(?,?,?)";
            
            //prepare statement

            $stmnt = $conn->prepare($SELECT);
            $stmnt->bind_param("s", $VendName);
            $stmnt->execute();
            $stmnt->bind_result($VendName);
            $stmnt->store_result();
            $rnum = $stmnt->num_rows;

            
            //checking whether there is no row with vendors' Name and Legal Name provided

            if($rnum==0 ){
                $stmnt->close();

                $stmnt = $conn->prepare($INSERT);
                $stmnt->bind_param("iss", $id,$VendName,$VendEmail);
                $stmnt->execute();
                echo"<script> alert('New Vendor Added Successfuly!!');</script>";
                ?>
        <script type="text/javascript">
        window.location.href="purchaseorder.php"</script>
        <?php
            }else{
                echo"<script> alert('Vendor Name Already Exisit!!');</script>";
                ?>
        <script type="text/javascript">
        window.location.href="purchaseorder.php"</script>
        <?php
            }
            $stmnt->close();
            $conn->close();

        }
    }
        else{
            echo"All Fields Are Required";
            die();
        }
      }	

	  if(isset($_POST["order"])){
  $orderdate = $_POST["orderdate"];
  $VendName = $_POST["VendName"];
  $ProductName = $_POST["ProdName"];
  $ProdQuantity = $_POST["ProdQuantity"];
  $Unitofmeasure = $_POST["Unitofmeasure"];
  $UnitPrice = $_POST["UnitPrice"];
  $SellingPrice = $_POST["SellingPrice"];
  $TotalAmount = $_POST["TotalAmount"];
  
  $sql= "INSERT INTO purchaseorder VALUE(null,'$id','$orderdate','$VendName','$ProductName','$ProdQuantity',
  '$Unitofmeasure','$UnitPrice','$SellingPrice','$TotalAmount','0')";
  
  
  if(mysqli_query($conn,$sql)){
      header("location:purchaseorder.php");
      $successmessage ="Order Request Sent!!";
      
  }
  else{
      $failmessage ="Please Try Again!!";
  }
      
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
        
	<div class="col-md-2 mx-0" id="register">
        <div class="text-center">
        <h2 id="formheading">Add Vendors</h2>
        <center><hr id="headinghr"></center>
        </div>
        <form action="purchaseorder.php" method="POST">
        <input type="hidden" id="BusnameId" name="BusnameId" value="<?php echo $id?>">
            <label for="VendName" class="form-label" id="formlabel" 
               >Vendor Name</label>
            <input type="text" class="form-control" id="VendName" name="VendName" 
         required>
            <label for="VendEmail" class="form-label" id="formlabel" 
               >Vendor Email</label>
            <input type="email" class="form-control" id="VendEmail" name="VendEmail" 
             required>
            
            <center><button class="btn btn-outline-dark text-success my-3" style="font-size: 16px; 
          font-weight: 700; width: 50%;" name="submit">Submit</button></center>
        </form>
        </div>
        <div class="col-md-3 " id="register">
      <div class="text-center">
      <h2 id="formheading">Make Purchase</h2>
      <center><hr id="headinghr"></center>
	    <center><p style="color:red;"><?php if($failmessage) {echo $failmessage;}?></h2></center>
        <center><p style="color:black;"><?php if($successmessage) {echo $successmessage;}?></h2></center>
    </div>
        <form action="purchaseorder.php" method = "POST">
		  <input type="hidden" id="BusnameId" name="BusnameId" value="<?php echo $id?>">
          <label for="orderdate" class="form-label" id="formlabel">Order Date</label>
          <input type="Date" id="orderdate" name="orderdate" class="form-control" required>
          <label for="VendName" class="form-label" id="formlabel">Vendor Name</label>
          <select name="VendName" id="VendName" class="form-control">
<option >  </option>
<?php

if(mysqli_num_rows($vendnamequery) > 0){
$name=0;
while($namerows = mysqli_fetch_assoc($vendnamequery)){
$venname=$namerows['VendName'];
?>
<option value="<?php echo $venname; ?>">
<?php echo $venname; ?></option>
<?php
$name++;		
}
}
?>
</select>
          <label for="ProdName" class="form-label" id="formlabel">Product Name</label>
          <input type="text" id="ProdName" name="ProdName" class="form-control" required>
          <label for="ProdQuantity" class="form-label" id="formlabel">Product Quantity</label>
          <input type="text" id="ProdQuantity" name="ProdQuantity"  class="form-control" required>
          <label for="Unitofmeasure" class="form-label" id="formlabel">Unit Of Measurement</label>
         <select name="Unitofmeasure" id="Unitofmeasure" class="form-control">
         <option >  </option>
		 <option value="Kgs"> Kgs </option>
		 <option value="Sacks"> Sacks </option>
		 <option value="Litters"> Litters </option>
		 <option value="Boxes"> Boxes </option>
		 </select>
          <label for="UnitPrice" class="form-label" id="formlabel">Unit Price</label>
          <input type="number" id="UnitPrice" name="UnitPrice"  class="form-control" required>
		   <label for="SellingPrice" class="form-label" id="formlabel">Selling Price</label>
          <input type="number" id="SellingPrice" name="SellingPrice"  class="form-control" required>
		   <label for="TotalAmount" class="form-label" id="formlabel">Total Amount</label>
          <input type="number" id="TotalAmount" name="TotalAmount"  class="form-control" onclick="updateResult();" readonly required>
          <center><button class="btn btn-outline-dark text-success my-3" style="font-size: 16px; 
          font-weight: 700; width: 50%;" name="order">Make Order</button></center>
        </form>
      </div>
	  <div class="col-md-7 mx-0" id="register">
        <div class="text-center">
        <b><h5 style="color:blue; font-size: 20px;"><?php echo $bsname;?></h5></b>
        <h2 id="formheading">All Purchase Orders </h2>
        <center><hr id="headinghr"></center>
        </div>
        
		
	<center><table class="table" style="opacity: 0.5;">
	<thead>
	       <tr>
                        
    <th>Nme</th>
    <th>Qty</th>
	<th>U/M</th>
	<th>Amnt</th>
	<th>Paid</th>
	<th></th>
	
	       </tr>
	</thead>
	<tbody>
	<?php
$id=$_SESSION["BusinessId"];
$purchaseorder ="SELECT * FROM purchaseorder WHERE BusinessId='$id'";
$result = $conn->query($purchaseorder);
if(!$result){
	die("Connection Error".$conn->error);
}
      while($row = $result->fetch_assoc()){
		  echo "
		 <tr>
		  <td> $row[ProdName]</td>
	      <td>$row[ProdQuantity]</td>
          <td>$row[Unitofmeasure]</td>
		  <td>$row[TotalAmount]</td>
		  <td>$row[PaidAmount]</td>
          <td >
		    <a class='btn btn-primary btn-sm text-light' href='payment.php?PorderId =$row[PorderId]'>Payment</a>
          </td>
		  </tr>
		  ";
	  }
    ?>
    </tbody>
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
  <script>
        const ProdQuantity = document.getElementById("ProdQuantity");
        const UnitPrice = document.getElementById("UnitPrice");
        const TotalAmount = document.getElementById("TotalAmount");
		// Function to update the result based on input values
		function updateResult() {
            const quant = parseFloat(ProdQuantity.value);
            const unit = parseFloat(UnitPrice.value);
			const prod = quant*unit;

            if (!isNaN(prod)) {
                TotalAmount.value = prod;
            } else {
                TotalAmount.value = '';
            }
        }

        // Add event listeners to input fields
        ProdQuantity.addEventListener("input", updateResult());
        UnitPrice.addEventListener("input", updateResult());</script>
</body>
</html>
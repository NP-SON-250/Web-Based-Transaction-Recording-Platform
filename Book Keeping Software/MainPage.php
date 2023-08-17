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

if(isset($_POST["Addbank"])){
    $BusnameId = $_POST["BusnameId"];
    $accname = $_POST["accoutname"];
    $Description = $_POST["description"];
    $bankname = $_POST["bankname"];
    $acctype = $_POST["accounttype"];
	
    
    $unique=mysqli_query($conn,"SELECT * FROM accounts WHERE AccName='$accname' AND BusinessId='$id'");
        if (mysqli_num_rows($unique) > 0) {
            $failmessage ="Bank Account Already Registered!!!!";
        }
    
        else{
    
        
    $sql= "INSERT INTO accounts VALUE(null,'$BusnameId','$accname','$Description','$bankname','$acctype','0')";
    
    
    if(mysqli_query($conn,$sql)){
        header("location:MainPage.php");
        $successmessage ="Bank Account Registered Successfuly!!";
        
    }
    else{
        $failmessage ="Please Try Again!!";
    }
        }
    }
    if(isset($_POST["deposit"])){
        $id = $_POST["BusnameId"];
        $date = $_POST["date"];
        $Acc1 = $_POST['deposeon'];
        $Acc2 = $_POST['deposefrom'];
        $Des= $_POST['Description'];
        $Am= $_POST['deposeamount'];
		
      
        try{
          
          if($Acc1!=$Acc2 ){  
            $blnceL ="";
		    $AccL ="";
		    $blnce ="";
		    $Acc ="";
            $sl1=mysqli_query($conn,"SELECT * FROM accounts WHERE BusinessId='$id' AND AccType='Liability'  AND AccName='$Acc1'");  
            $sct1 = mysqli_fetch_assoc($sl1);
                    $blnceL = $sct1["AccBalance"];
                    $AccL = $sct1["AccName"];
    
          $sl=mysqli_query($conn,"SELECT * FROM accounts WHERE BusinessId='$id' AND AccType='Asset'  AND AccName='$Acc2'");
          $sct = mysqli_fetch_assoc($sl);
                    $blnce = $sct["AccBalance"];
                    $Acc = $sct["AccName"];
    
          
    
    
          if($blnce >=0 && $Acc2!=$Acc && $blnceL >=0 && $Acc1!=$AccL){
    
            $insert=mysqli_query($conn, "INSERT INTO journal VALUE(null,'$id','$date','$Acc1','$Acc2','$Des','$Am')");
            header("location:./MainPage.php");
        
    
          }
          elseif($blnceL >=0 && $Acc2==$AccL || $blnceL >=$Am && $Acc1==$AccL){
    
            $insrt=mysqli_query($conn, "INSERT INTO journal VALUE(null,'$id','$date','$Acc1','$Acc2','$Des','$Am')");
            header("location:./MainPage.php");
    
          }
          elseif($blnce >=0 && $Acc1==$Acc || $blnce >=$Am && $Acc2==$Acc){
            $insrt=mysqli_query($conn, "INSERT INTO journal VALUE(null,'$id','$date','$Acc1','$Acc2','$Des','$Am')");
            header("location:./MainPage.php");
    
            
          }
    
    
          elseif($blnceL<$Am && $Acc1==$AccL){
            echo "<script> window.alert('Please,Debited Account Balance Is not enough!.') </script>";
            
          }
    
          elseif($blnce< $Am && $Acc2==$Acc){
            echo "<script> window.alert('Please,Credited Account Balance Is not enough!.') </script>";
            
          }
         
        
      }
    
        else{
          echo "<script> window.alert('Please, select different accounts.') </script>";
        }
    
    }
        catch(Exception $e){
            
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
            <a class="nav-link active" aria-current="page" href="#" id="home">Home</a>
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
        <div class="col-md-4 mx-0" id="register">
        <div class="text-center">
        <h2 id="formheading">CREATE BANK </h2>
        <center><hr id="headinghr"></center>
        <center><p style="color:red;"><?php if($failmessage) {echo $failmessage;}?></h2></center>
        <center><p style="color:black;"><?php if($successmessage) {echo $successmessage;}?></h2></center>
        </div>
        <form action="MainPage.php" method="POST">
        <input type="hidden" id="BusnameId" name="BusnameId" value="<?php echo $id?>">
            <label for="AccountName" class="form-label" id="formlabel" 
               >Account Name</label>
            <input type="text" class="form-control" id="accountname" name="accoutname" 
            value="Bank" readonly required>
            <label for="description" class="form-label" id="formlabel" 
               >Description</label>
            <input type="text" class="form-control" id="accountname" name="description" 
            value="Current" readonly required>
            <label for="bankname" class="form-label" id="formlabel" 
               >Bank Name</label>
            <input type="text" class="form-control" id="accountname" name="bankname" required>
            <label for="accounttype" class="form-label" id="formlabel" 
               >Account Type</label>
            <input type="text" class="form-control" id="accountname" name="accounttype" 
            value="Asset" readonly required>
            <center><button class="btn btn-outline-dark text-success my-3" style="font-size: 16px; 
          font-weight: 700; width: 50%;" name="Addbank">Create Bank</button></center>
        </form>
        </div>
        <div class="col-md-4 mx-0" id="register">
        <div class="text-center">
        <h2 id="formheading">MAKE DEPOSIT</h2>
        <center><hr id="headinghr"></center>
        </div>
        <form action="MainPage.php" method="POST">
        <input type="hidden" id="BusnameId" name="BusnameId" value="<?php echo $id?>">
            <label for="date" class="form-label" id="formlabel" 
               >Deposing Date</label>
            <input type="date" class="form-control" id="date" name="date" 
         required>
            <label for="debitaccount" class="form-label" id="formlabel" 
               >Deposit On</label>
            <input type="text" class="form-control" id="deposeon" name="deposeon" 
            value="Bank" readonly required>
            <label for="creditaccount" class="form-label" id="formlabel" 
               >Deposited From</label>
            <input type="text" class="form-control" id="from" name="deposefrom"
            value="Capital" readonly required>
            <label for="Description" class="form-label" id="formlabel" 
               >Description</label>
            <input type="text" class="form-control" id="Description" name="Description" 
             required>
             <label for="deposeamount" class="form-label" id="formlabel" 
               >Amount</label>
            <input type="number" class="form-control" id="deposeamount" name="deposeamount" 
             required>
            <center><button class="btn btn-outline-dark text-success my-3" style="font-size: 16px; 
          font-weight: 700; width: 50%;" name="deposit">Deposit</button></center>
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
<?php
$other=0;
$Expense=0;

$Fixed=0;
$Equity=0;

$allAssets=0;
$allLiab=0;

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
                  <li><a class="dropdown-item" href="displayledger.php">General Ledger</a></li>
                  <li><a class="dropdown-item" href="displaytrial.php">Trial Balance</a></li>
                  <li><a class="dropdown-item" href="displayincome.php">Income Statement</a></li>
                  <li><a class="dropdown-item active" aria-current="page" href="displaybalance.php">Balance Sheet</a></li>
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
        <center><table class="table" id="income" style="opacity: 0.5;">
        <tr>
								<th>Details</th>
								<th>Amount</th>
                </tr>
        <?php
        $income=mysqli_query($conn,"SELECT * FROM accounts WHERE BusinessId='$id' AND AccName LIKE '%sales%' AND accType='Income'");
        
            // output data of each row
            
            $resincome = mysqli_fetch_assoc($income)
                ?>
                <tr>
								<td><?php echo $resincome['AccName'];?></td>
								<td><?php echo $resincome['AccBalance'];?></td>
                                
                </tr>  
                              
             <?php 
            
            
        $in=mysqli_query($conn,"SELECT * FROM accounts WHERE BusinessId='$id' AND AccName ='Sales Return'");
      
            // output data of each row
            
            $resReturn = mysqli_fetch_assoc($in)
                ?>
                <tr>
								<td><?php echo $resReturn['AccName'];?></td>
								<td>(<?php echo $resReturn['AccBalance'];?>)</td>
                                
                </tr>  
                              
             <?php 
             
            ?>
            
            <tr>
                  
                  <td><b>Net Sales</b></td>
                  <td><b><u><?php echo $totNet=$resincome['AccBalance']-$resReturn['AccBalance'];?></u></b></td>
        
                </tr>
                <?php
          $pur=mysqli_query($conn,"SELECT * FROM accounts WHERE BusinessId='$id' AND AccName ='Purchase'");
      
          // output data of each row
          
          $respur = mysqli_fetch_assoc($pur)
              ?>
              <tr>
              <td><?php echo $respur ['AccName'];?></td>
              <td><?php echo $respur ['AccBalance'];?></td>
                              
              </tr>  
                            
           <?php 
           $purRet=mysqli_query($conn,"SELECT * FROM accounts WHERE BusinessId='$id' AND AccName ='Purchase Return'");
      
           // output data of each row
           
           $respurRet = mysqli_fetch_assoc($purRet)
               ?>
               <tr>
               <td><?php echo $respurRet ['AccName'];?></td>
               <td><?php echo $respurRet ['AccBalance'];?></td>
                               
               </tr>  
               <tr>
                
                <td><b>Cost Of Goods Sold</b></td>
                <td><b><u>(<?php echo $totcost=$respur['AccBalance']-$respurRet['AccBalance'];?>)</u></b></td>
      
              </tr>
          
          <tr>
                
                <td><b>Gross Profit</b></td>
                <td><b><u><?php echo $gross=$totNet-$totcost;?></u></b></td>
      
              </tr>
              <?php 
           $Oincome=mysqli_query($conn,"SELECT * FROM accounts WHERE BusinessId='$id' AND AccType='Income' AND NOT AccName IN('Sales','Purchase Return')");
      
           // output data of each row
           
           while($resOincome = mysqli_fetch_assoc($Oincome)){
               ?>
               <tr>
               <td><?php echo $resOincome ['AccName'];?></td>
               <td><?php echo $resOincome ['AccBalance'];?></td>
               <?php
               $other+= $resOincome ['AccBalance'];
               ?>
                               
               </tr> 
               
               
               <tr>
               <?php
            }
            ?> 
                
                <td><b>Income Before Expenses</b></td>
                <td><b><u><?php
                echo $IncBef=$gross+$other;
                ?></u></b></td>
      
              </tr>
              <?php 
           $IncEX=mysqli_query($conn,"SELECT * FROM accounts WHERE BusinessId='$id' AND AccType='Expense'");
      
           // output data of each row
           
           while($resIncEX = mysqli_fetch_assoc($IncEX)){
               ?>
               <tr>
               <td><?php echo $resIncEX ['AccName'];?></td>
               <td><?php echo $resIncEX ['AccBalance'];?></td>
               <?php
               $Expense+= $resIncEX ['AccBalance'];
               ?>
                               
               </tr> 
               
               
               <tr>
               <?php
            }
            ?> 
                
                <td><b>Net Profit</b></td>
                <td><b><u><?php
                $NetPro=$IncBef-$Expense;
                

                if($NetPro<0){
                  echo "(".$NetPro.")";
                }
                elseif($NetPro>0){
                  echo $NetPro;
                }
                else{
                  echo $NetPro."  Break Even Point!";
                }
                ?></u></b></td>
      
              </tr>

    </table></center>
        <div class="text-center">
        <b><h5 style="color:blue; font-size: 20px;"><?php echo $bsname;?></h5></b>
        <h2 id="formheading">BALANCE SHEET REPORT </h2>
        <center><hr id="headinghr"></center>
        </div>
        <center><table class="table table-hover" style="opacity: 0.5;">
        <thead>
            <tr>
			<th>Assets</th>
			<th>Amounts</th>
            </tr>
		</thead>
      <tbody>
      <tr>
        <td ><b>Fixed Assets</b></td>
        <td></td>
    </tr>
    <?php
        $Asset=mysqli_query($conn,"SELECT * FROM accounts WHERE BusinessId='$id' AND AccType='Asset' AND Description='Fixed'");
        
            // output data of each row
            
            while($blance = mysqli_fetch_assoc($Asset)) {
              $AssName=$blance['AccName'];
              $AssBlnce=$blance['AccBalance']; 
              $Fixed +=$AssBlnce;
              ?>  
              <tr>
                    <td ><?php echo $AssName;?></td>
                    <td ><?php echo $AssBlnce;?></td>
            </tr>
                    <?php
              
            }
            ?>

            <tr>
        <td ><b>Total Fixed Assets</b></td>
        <td ><b><u><?php echo $Fixed;?></u></b></td>
          </tr>

          <tr>
        <td ><b>Current Assets</b></td>
        <td ></td>
          </tr>

          <?php
        $cAsset=mysqli_query($conn,"SELECT * FROM accounts WHERE BusinessId='$id' AND AccType='Asset' AND Description='Current'");
        
            // output data of each row
            
            while($cblance = mysqli_fetch_assoc($cAsset)) {
              $AssNamecu=$cblance['AccName'];
              $AssBlncecu=$cblance['AccBalance']; 
              $allAssets +=$AssBlncecu;
              ?>
              <tr>
              <td ><?php echo $AssNamecu;?></td>
                    <td ><?php echo $AssBlncecu;?></td>
            </tr>
              <?php
            }
            ?>

            <tr>
                <td ><b>Total Assets</b></td>
                <td ><b><u><?php echo $totAssets =$Fixed + $allAssets;?></u></b></td>
          </tr>
    </tbody>

    
    <thead>
        <tr>
          <th>Liabilities</th>
          <th>Amounts</th>
        </tr>
			</thead>
      <tbody>
      </tr>
              <td ><b>Equity</b></td>
              <td ></td>
      
          </tr>
      <?php
            $Liab=mysqli_query($conn,"SELECT * FROM accounts WHERE BusinessId='$id' AND AccType='Liability' AND Description='Equity'");
            
            // output data of each row
            
            while($Lblance = mysqli_fetch_assoc($Liab)) {
              $LiabName=$Lblance['AccName'];
              $LiabBlnce=$Lblance['AccBalance'];
              $Equity +=$LiabBlnce;
              ?>
              <tr>
              <td ><?php echo $LiabName;?></td>
                    <td ><?php echo $LiabBlnce;?></td>  
                </tr>
              <?php
              
          }
            ?>  
            <tr>
              <td>Net Profit</td>
              <td><?php echo $NetPro;?></td>
            </tr>
            <tr>
        
        <td ><b>Total Equity</b></td>
        <td ><b><u><?php echo $Equity +=$NetPro;?></u></b></td>

          </tr>

          <tr>
              <td ><b>Other Liabilities</b></td>
              <td ></td>

          </tr>
          <?php
            $cLiab=mysqli_query($conn,"SELECT * FROM accounts WHERE BusinessId='$id' AND AccType='Liability' AND Description='Liability'");
            
            // output data of each row
            
            while($cLblance = mysqli_fetch_assoc($cLiab)) {
              $LiabNamecu=$cLblance['AccName'];
              $LiabBlncecu=$cLblance['AccBalance'];
              $allLiab +=$LiabBlncecu;
            ?>
            <tr>
            <td ><?php echo $LiabNamecu;?></td>
                    <td ><?php echo $LiabBlncecu;?></td>  
                </tr> 
            <?php
          }
            ?>
                
                <td ><b>Total Equity and Liabilities</b></td>
                <td ><b><u><?php echo $totLiab=$Equity + $allLiab;?></u></b></td>

            </tr>

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
</body>
</html>
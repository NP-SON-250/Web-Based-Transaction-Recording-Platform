<?php
$message ="";
require 'connector.php';

if(isset($_POST["login"])){
    $busname = $_POST['BusinessName'];
    $pin = $_POST['pin'];
    

    $query = "SELECT * FROM users WHERE BusinessName = '$busname' and BusinessPin = '$pin'";
    $result = $conn->query($query);
    

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        session_start();
        $_SESSION["loggedin"] = true;
        $_SESSION["LegalName"] = $row['LegalName'];
        $_SESSION["BusinessName"] = $row['BusinessName'];
        $_SESSION["BusinessPin"] = $row['BusinessPin'];
        $_SESSION["BusinessId"] = $row['BusinessId'];
        $_SESSION["StartingDate"] = $row['StartingDate'];
        $_SESSION["ClosingDate"] = $row['ClosingDate'];
        $_SESSION["Address"] = $row['Address'];
            header("location:./MainPage.php");
        
    }
    else{
        $message ="Credentials Not Match!!";
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
            <a class="nav-link active" aria-current="page" href="index.php" id="home">Home</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container" id="register">
    <div class="text-center">
        <h2 id="formheading">Login Here</h2>
        <center><hr id="headinghr"></center>
        <center><p style="color:red;"><?php if($message) {echo $message;}?></h2></center>
    </div>
    <div class="row justfy-content-center my-5">
        <center><div class="col-md-4">
            <form action="login.php" method="POST">
                <label for="BusinessName" class="form-label" id="formlabel"
                >Business Name</label>
                <input type="text" class="form-control" id="businessname" name="BusinessName" required>
                <label for="LoginPin" class="form-label" id="formlabel"
                >Login Pin</label>
                <input type="password" class="form-control" id="pin" name="pin" required>
                <center><span class="eyes" onclick = "determine()">
                        <p id="show" style="color: blue; cursor: pointer;" >Hide Password</p>
                        <p id="hide" style="color: blue; cursor: pointer;">Show Password</p>
                      </span></center>
                <center><button class="btn btn-outline-dark text-success my-3" style="font-size: 16px; 
          font-weight: 700; width: 50%;" name="login">Login</button></center>

            </form>
        </div></center>
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
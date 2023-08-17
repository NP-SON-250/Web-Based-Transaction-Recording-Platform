<?php
    include ("connector.php");
    session_start();
    if(isset($_POST["register"])){
    $legalname = $_POST["legalname"];
    $busname = $_POST["businessname"];
    $pin = $_POST["pin"];
    $address = $_POST["Address"];
    $stdate = $_POST["startdate"];
    $closedate = $_POST["closedate"];
    //checking if the fields are not left empty
    if(!empty($legalname) || !empty($busname) || 
    !empty($pin) ||!empty($address) ||!empty($stdate) ){
        if(mysqli_connect_error()){
            die('Connect Error(' .mysqli_connect_errno(). ')'. mysqli_connect_error());


        }else{
            $SELECT = "SELECT BusinessName From users Where BusinessName = ? Limit 1";
            $SELECTE = "SELECT LegalName From users Where LegalName = ? Limit 1";
            $INSERT = "INSERT INTO users(LegalName,BusinessName,BusinessPin,Address,StartingDate,ClosingDate)
             Values(?,?,?,?,?,?)";
            
            //prepare statement

            $stmnt = $conn->prepare($SELECT);
            $stmnt->bind_param("s", $busname);
            $stmnt->execute();
            $stmnt->bind_result($busname);
            $stmnt->store_result();
            $rnum = $stmnt->num_rows;

            //prepare statement2

            $stmnte = $conn->prepare($SELECTE);
            $stmnte->bind_param("s", $legalname);
            $stmnte->execute();
            $stmnte->bind_result($legalname);
            $stmnte->store_result();
            $rnumb = $stmnte->num_rows;

            //checking whether there is no row with Business Name and Legal Name provided

            if($rnum==0 && $rnumb==0 ){
                $stmnt->close();

                $stmnt = $conn->prepare($INSERT);
                $stmnt->bind_param("ssssss", $legalname,$busname,$pin,$address,$stdate,$closedate);
                $stmnt->execute();
                echo"<script> alert('Business Registered Successfuly!!');</script>";
                ?>
        <script type="text/javascript">
        window.location.href="login.php"</script>
        <?php
            }else{
                echo"<script> alert('Business Name or Legal Name Already Used!!');</script>";
                ?>
        <script type="text/javascript">
        window.location.href="index.php"</script>
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
        </ul>
        <a href="login.php"><button class="btn btn-outline-none text-dark">Login</button></a>
      </div>
    </div>
  </nav>


  <div class="container" >
    <div class="row justfy-content-center my-5">
      <div class="col-md-8">
        <div id="carouselExampleCaptions" class="carousel slide">
          <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0"
             class="active" aria-current="true" aria-label="slide 1">Slide 1</button>
             <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="slide 2">Slide 2</button>
             <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="slide 3">Slide 3</button>
          </div>
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="./laptopwithgoodview.jpeg" class="d-block w-100" alt="first">
              <div class="carousel-caption d-none d-sm-block">
              <h4>First member</h4>
              <p>Alexis HAKIZIMANA</p>
            </div>
            </div>
            <div class="carousel-item">
              <img src="./computerandcar.jpeg" class="d-block w-100" alt="first">
              <div class="carousel-caption d-none d-sm-block">
              <h4>Second member</h4>
              <p>Alexis HAKIZIMANA</p>
            </div>
            </div>
            <div class="carousel-item">
              <img src="./darklaptopone.jpeg" class="d-block w-100" alt="first">
              <div class="carousel-caption d-none d-sm-block">
              <h4>Third member</h4>
              <p>Alexis HAKIZIMANA</p>
            </div>
            </div>
          </div>
        </div>
      </div>
   
      <div class="col-md-4 " id="register">
      <div class="text-center">
      <h2 id="formheading">Register New Business</h2>
      <center><hr id="headinghr"></center>
    </div>
        <form action="index.php" method = "POST">
          <label for="legalname" class="form-label" id="formlabel">Legal Name</label>
          <input type="text" id="legalname" name="legalname" class="form-control" required>
          <label for="BusinessName" class="form-label" id="formlabel">Business Name</label>
          <input type="text" id="businessname" name="businessname"  class="form-control" required>
          <label for="Loginpin" class="form-label" id="formlabel">Login Pin</label>
          <input type="text" id="pin" name="pin" class="form-control" required>
          <label for="Address" class="form-label" id="formlabel">Address</label>
          <input type="text" id="Address" name="Address"  class="form-control" required>
          <label for="StartingDate" class="form-label" id="formlabel">Starting Date</label>
          <input type="date" id="startdate" name="startdate" class="form-control" required>
          <label for="ClosingDate" class="form-label" id="formlabel">Closing Date</label>
          <input type="date" id="closedate" name="closedate"  class="form-control" required>
          <center><button class="btn btn-outline-dark text-success my-3" style="font-size: 16px; 
          font-weight: 700; width: 50%;" name="register">Register</button></center>
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
</body>

</html>
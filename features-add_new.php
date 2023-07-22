<?php 
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  header("location: concessionaire.php");
  exit;
}

require_once "config.php";

if(isset($_POST['submit']))
{
    $space_id = $_POST['space_id'];
    $dimesion_length = $_POST['dimension_length'];
    $dimesion_width = $_POST['dimension_width'];
    $dimesion_height = $_POST['dimension_height'];
    $capacity = $_POST['capacity'];
    $lights = $_POST['lights'];
    $sinks = $_POST['sinks'];
    $windows = $_POST['windows'];
    $sockets = $_POST['sockets'];

    $stmt = $con->prepare("CALL add_space_features(?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sdddiiiii", $space_id, $dimesion_length, $dimesion_width, $dimesion_height, $capacity, $lights, $sinks, $windows, $sockets);
    $stmt->execute();
    $result = $stmt->get_result();
    $message = $result->fetch_assoc()['message'];
    echo "<script>alert('$message');</script>";
    $stmt->close();
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Space Features</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="profile.css">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  </head>
  <body>
    
  <div class="topnav" id="myTopnav">
        <label class="logo-container">
            <img src="img/logo.png" alt="logo" class="logo">
          <span class="logo-text">PUPconcessionaire</span>
        </label> 
        <a href="admin-dashboard.php">Home</a>
        <a href="adminprofile.php">Profile</a>
        <a href="client-accounts.php">Accounts</a>
        <a href="client-list.php">Clients</a>
        <a href="student-list.php">Students</a>
        <a href="assignedspace-index.php">Assigned</a>
        <a href="clientreqs-index.php">Requirements</a>
        <a href="feature-index.php" class="active">Spaces</a>
        <a href="conspace-index.php">Rents</a>
        <a href="merchtype-index.php">Merchandise Type</a>
        <a href="bills.php">Bills</a>
        <a href="admin-change-password.php">Change Password</a>
        <a href="logout.php">LogOut</a>
        <a class="icon" onclick="myFunction()">
          <i class="fa fa-bars"></i>
        </a>
    </div>
    <section class="vh-100" style=" padding-top: 0px;">

    <div class='profile_form' class="container d-flex justify-content-center"  class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
            <form class='form' action="" method="post">
            <h2>Space Feature Information</h2>
                <div class='form_group' class="row mb-3">
                    <div class="col">
                        <label class="form-label">Space ID</label>
                        <input type="text" class="form-control" name="space_id" placeholder="L001">
                    </div>    
                
                    <div class="col">
                        <label class="form-label">Length (M)</label>
                        <input type="text" class="form-control" name="dimension_length" placeholder="10">
                    </div>

                    <div class="col">
                        <label class="form-label">Width (M)</label>
                        <input type="text" class="form-control" name="dimension_width" placeholder="10">
                    </div>
                </div>

                <div class='form_group' class="row mb-3">
                    <div class="col">
                        <label class="form-label">Height (M)</label>
                        <input type="text" class="form-control" name="dimension_height" placeholder="10">
                    </div>
                    
                    <div class="col">
                        <label class="form-label">Capacity</label>
                        <input type="text" class="form-control" name="capacity" placeholder="10">
                    </div>
                    
                    <div class="col">
                        <label class="form-label">No. Lights</label>
                        <input type="text" class="form-control" name="lights" placeholder="10">
                    </div>
                </div>
                
                <div class='form_group' class="row mb-3">
                    <div class="col">
                        <label class="form-label">No. Sinks</label>
                        <input type="text" class="form-control" name="sinks" placeholder="1">
                    </div>
                
                    <div class="col">
                        <label class="form-label">No. Windows</label>
                        <input type="text" class="form-control" name="windows" placeholder="5">
                    </div>

                    <div class="col">
                        <label class="form-label">No. Sockets</label>
                        <input type="text" class="form-control" name="sockets" placeholder="4">
                    </div>
                </div>

                <div class='form_buttons'>
                    <button class='save' type="submit" class="btn" name="submit">Submit</button>
                    <button>
                        <a class='cancel' href="feature-index.php" class="btn btn-danger">Cancel</a>
                    </button>
                </div>
            </form>
        </div>
    </div>
    </section>
    <!-- Bootstrap -->   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  </body>
  <script>
    /* Toggle between adding and removing the "responsive" class to topnav when the user clicks on the icon */
function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}
</script>
</html>
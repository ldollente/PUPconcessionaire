<?php 
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  header("location: concessionaire.php");
  exit;
}

require_once "config.php";

if(isset($_GET['delid']))
{
    $did = $_GET['delid'];
    
    $stmt = mysqli_prepare($con, "CALL delete_merch_type(?)");
    mysqli_stmt_bind_param($stmt, "i", $did);
    mysqli_stmt_execute($stmt);
    
    echo "<script>alert('Deleted successfully!');</script>";
    echo "<script>window.location='merchtype-index.php';</script>";
    mysqli_stmt_close($stmt);
}

?>

<!doctype html>
<html lang="en">
    <head>
        <title>Merchandise Type</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="styles.css">
        <style>
                    input[type="text"] {
        padding: 10px;
        border: none;
        border-radius: 5px;
        width: 300px;
        font-size: 16px;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }
        button[name="submit"] {
        padding: 10px;
        border: none;
        border-radius: 5px;
        margin-left: 10px;
        background-color: #007bff;
        color: #fff;    
        font-size: 16px;
        cursor: pointer;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }
        button[name="submit"]:hover {
        background-color: #0069d9;
        }

        </style>
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
        <a href="feature-index.php">Spaces</a>
        <a href="conspace-index.php">Rents</a>
        <a href="merchtype-index.php" class="active">Merchandise Type</a>
        <a href="bills.php">Bills</a>
        <a href="admin-change-password.php">Change Password</a>
        <a href="logout.php">LogOut</a>
        <a class="icon" onclick="myFunction()">
          <i class="fa fa-bars"></i>
        </a>
    </div>
    <div> 
        <div class="wrapper" style="padding-left: 85px; padding-right: 85px;">
            <div class="container-fluid">
        <div class="row">
        <div class="col-md-12">
                <div>
                <form action="merchtype-index.php" method="post" style="margin-top:50px;">
                    <input
                        type="text"
                        placeholder="Search merch id"
                        name="search"
                        required>
                    <button type="submit" name="submit">Search</button>
                </form>
                    <?php
                        // require_once "config.php";

                        if (isset($_POST['submit'])) {
                            $connection_string = new mysqli("localhost", "root", "", "pupconcessionaire");
                            
                            $searchString = mysqli_real_escape_string($connection_string, trim(htmlentities($_POST['search'])));

                            if ($connection_string->connect_error) {
                                echo "Failed to connect to Database";
                                exit();
                            }

                            if ($searchString === "" || !ctype_alnum($searchString) || $searchString < 3) {
                                echo "Invalid search string";
                                exit();
                            }

                            $searchString = "%$searchString%";

                            $sql = "SELECT * FROM merch_type WHERE merch_id LIKE ?";

                            // Prepare, bind, and execute the query
                            $prepared_stmt = $connection_string->prepare($sql);
                            $prepared_stmt->bind_param('s', $searchString);
                            $prepared_stmt->execute();

                            // Fetch the result
                            $result = $prepared_stmt->get_result();


                            if($result->num_rows > 0){
                                echo '<table class="table table-bordered table-striped">';
                                    echo "<thead>";
                                        echo "<tr>";
                                            echo "<th>Merchandise ID</th>";
                                            echo "<th>Merchandise Type</th>";
                                            echo "<th>Action</th>";
                                        echo "</tr>";
                                    echo "</thead>";
                                    echo "<tbody>";
                                    while($row = $result->fetch_array()){
                                        echo "<tr>";
                                            echo "<td>" . $row['merch_id'] . "</td>";
                                            echo "<td>" . $row['merch_type'] . "</td>";
                                            echo "<td>";
                                                echo '<a href="update-merchtype.php?id='. $row['merch_id'] .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                                echo '<a href="merchtype-index.php?id='. $row['merch_id'] .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                            echo "</td>";
                                        echo "</tr>";
                                    }
                                    echo "</tbody>";                            
                                echo "</table>";
                                // Free result set
                                $result->free();
                            } else{
                                echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                            }
                        } 
                    ?>
                </div>
                <div class="mt-5 mb-3 clearfix" style="padding:10px">
                <h2 class="pull-left">List of Records</h2>
                <a href="create-merchtype.php" class="btn btn-info pull-right" style="padding:10px; color: white;"><i class="fa fa-plus" style="font-size: 18px;"></i> Create Merch Type</a>
            </div>
        </div>
        </div>
            
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-light table-striped text-center" style="padding:10px">
                                <thead style='background-color: maroon; color: white;' >
                            <tr>
                                <th scope="col">Merchandise ID</th>
                                <th scope="col">Merchandise Type</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php
                                require_once "config.php";
                                $sql = mysqli_query($con, "SELECT * FROM `merch_type`");
                                    $count = 1;
                                    $row = mysqli_num_rows($sql);
                                    if($row > 0)
                                    {
                                        while ($row = mysqli_fetch_array($sql))
                                        {                              
                            ?> 

                            <tr>
                                <td><?php echo $row['merch_id'];?></td>
                                <td><?php echo $row['merch_type'];?></td>
                                <td>
                                    <a href="update-merchtype.php?editid=<?php echo htmlentities($row['merch_id']);?>" class="link-dark" class="mr-3" title="Update Record" data-toggle="tooltip"><span style="font-size: 23px; color: #00ACC1;" class="fa fa-pencil"></span></a>
                                    <a href="merchtype-index.php?delid=<?php echo htmlentities($row['merch_id']);?>" class="link-dark" title="Delete Record" data-toggle="tooltip"><span style="font-size: 23px; color: #00ACC1;" class="fa fa-trash"></span></a>
                                </td>
                            </tr>
                            <?php
                                        $count = $count+1;
                                        }
                                    }
                            ?>
                        </tbody>
                    </table>
                    </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
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
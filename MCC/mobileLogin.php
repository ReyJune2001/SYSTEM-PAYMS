<!--LOGIN PAGE (2)-->
<?php
$login_admin = 0;
$login_user = 0;
$invalid = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'connect.php';
    $Username = $_POST['Username'];
    $Password = $_POST['Password'];

    // Check if the login credentials match an admin account
    $admin_sql = "SELECT * FROM `tbl_user` WHERE Username = '$Username' AND password = '$Password' AND Level = 'Admin'";
    $admin_result = mysqli_query($con, $admin_sql);

    // Check if the login credentials match a user account
    $user_sql = "SELECT * FROM `tbl_user` WHERE Username = '$Username' AND password = '$Password' AND Level = 'Operator'";
    $user_result = mysqli_query($con, $user_sql);


    if ($admin_result && mysqli_num_rows($admin_result) > 0) {
        // Admin login successful
        session_start();
        $_SESSION['Username'] = $Username;
        $_SESSION['Level'] = 'Admin';  // Set a session variable to identify the user level
        $login_admin = 1;
        header('location:dataEntry.php');
        exit();
    } elseif ($user_result && mysqli_num_rows($user_result) > 0) {
        // User login successful
        session_start();
        $_SESSION['Username'] = $Username;
        $_SESSION['Level'] = 'Operator';  // Set a session variable to identify the user level
        $login_user = 1;
        header('location:mobileDashboard.php');
        exit();
    } else {
        // Invalid credentials
        $invalid = 1;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="icon" href="IMAGES/faviconlogo.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">

    <!-- Bootstrap JavaScript link (popper.js is required) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-LFMJ0oUpaM3ZgZtnlqqA3F7l3Bo0IVwjt/4iz9o3fmmI9AXkFtfIIQcuxp1xZOz0"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <!-- Bootstrap JavaScript bundle (includes Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>

    <title>Login page</title>
    <style>
        * {
            font-family: 'Noto+Serif+Makasar';
        }

        /*logo*/

        .logo {
            position: absolute;
            top: 20px;
            /* Adjust the top position as needed */
            left: 20px;
            /* Adjust the left position as needed */

        }

        /*Input fields*/
        .form-outline {
            margin-bottom: 40px;
            margin-left: 160px;
            padding-right: 160px;


        }

        .input-group .input-group-text {
            border-radius: 50px;
            /* Apply border-radius to the span element containing the icon */
        }

        .input-group input.form-control {
            border-radius: 50px;
        }

        /*Login button*/
        .btn {
            width: 100%;
            height: 45px;
            font-size: 23px;
            border-radius: 50px;
        }


        body {
            height: 100vh;
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url(IMAGES/background2.jpg);
            background-size: cover;
            font-family: sans-serif;
            font-size: 24PX;
            display: flex;
            flex-direction: column;

        }


        header {
            background-color: transparent;
            text-align: center;
            padding: 2em 0 2em 0;
            color: white;
            font-size: 50px;
            margin-top: 40px;
            padding-bottom: 0px;
        }

        .main {
            display: flex;
            flex: 1;
        }

        main {
            background-color: transparent;
            padding: 3em 0 3em 0;
            flex: 1 1 150px;
            color: white;
            padding-top: 40px;

        }



        footer {
            background-color: transparent;
            text-align: center;
            padding: 1em 0 1em 0;
            color: white;

        }

        .wrapper {
            background-color: black;
        }

        /* Responsive styles */
        @media screen and (max-width: 425px) {
            main {
                padding-top: 10px;
                /* Adjust top padding */
                padding-bottom: 10px;
                /* Adjust bottom padding */

                color: white;
                padding-left: 0;
                /* Reset left padding */
                padding-right: 0;
                /* Reset right padding */

            }

            body {
                background-size: cover;
                /* Ensure the background image fits within the screen dimensions on smaller devices */
                height: 100%;
                /* Ensure the background image covers the entire screen on smaller devices */
            }

            .form-outline {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                margin: 0 auto;
                padding: 5px;
                padding-bottom: 0px;

            }

            .form-outline form {
                padding: 0;
                /* Remove padding from the form */
            }

            form {
                display: absolute;
                height: 66vh;

            }




            .form-outline .input-group,
            .form-outline .text-center {
                width: 60%;
                /* Adjust width of input group and text center */
                margin: 10px auto;
                /* Center horizontally */


            }

            form {
                display: absolute;
                padding-top: 0px;
            }

            .form-outline .form-control {
                width: 70%;
                /* Set width of form controls to 100% */

            }


            .btn {
                width: 100%;
                /* Adjust width of button */
                height: 30px;
                margin: 0px auto;
                font-size: 18px;
                /* Center horizontally */
            }

            .logo {
                width: 150px;
                top: 60px;
                left: 30%;
            }

            header {
                margin-top: 80px;
                font-size: 25px;

                /* Adjust font size of header */

                display: flex;
                flex-direction: column;
                align-items: center;
                /* Center the form horizontally */
               
            }

            footer {
                font-size: 10px;
            }


        }

        @media screen and (max-width: 768px) {
            .form-outline {
                margin-left: 15px;
                margin-right: 15px;
            }

            form {
                padding: 3em 0 5em 0;
            }

            #errormodal {
            
            /* Adjust this value as needed */
            transform: translateY(-50%, -50%);
            height: 50%;
        }


        }
    </style>
</head>

<body>

    <?php
    /* if($login){
     echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
   <strong>Congratulations!</strong> You are successfully login.
  </div>';
     }
  ?>*/

    if ($invalid) {
        // Trigger the modal using JavaScript
        echo '<script>
      document.addEventListener("DOMContentLoaded", function() {
          var myModal = new bootstrap.Modal(document.getElementById("errormodal"));
          myModal.show();
      });
    </script>';
    }
    ?>

    <!-- Pop-up Modal -->
    <div class="modal fade custom-modal" id="errormodal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header" style="background-color: #dc3545; color: white;">
                    <h5 class="modal-title center-modal-title">ERROR</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <h5>Invalid Credentials...</h5>
                </div>
            </div>
        </div>
    </div>

    <header>
        <!--For Logo-->
        <img src="IMAGES/logo.jpg" alt="Registration Image" width="100" height="50" class="logo">

        PAINT AND ACETATE YIELD MONITORING SYSTEM

    </header>


    <main>
        <h3 style="text-align:center;">Good Day!</h3>
        <form action="mobileLogin.php" method="post">

            <div class="form-outline">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" class="form-control form-control-sm" placeholder="Username" name="Username"
                        required />
                </div>
            </div>


            <div class="form-outline">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" class="form-control form-control-sm" placeholder="Password" name="Password"
                        required />
                </div>
            </div>

            <div class="form-outline">
                <div class="text-center">
                    <button class="btn btn-primary btn-block fa-lg gradient-custom-2" type="submit">
                        Login
                    </button>
                </div>
            </div>
        </form>
    </main>

    <footer>Copyright © All rights reserved ~ MCC Interns 2023</footer>
</body>

</html>
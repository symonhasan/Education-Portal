<?php
    include('db_con.php');

    $Error_No = 0;
    $fl = 0;

    session_start();
    if( !empty( $_SESSION['error'] ) && !empty( $_SESSION['fl'] ) ){
        $Error_No = $_SESSION['error'];
        $fl = $_SESSION['fl'];
    }
    session_destroy();
    session_start();

    $Error_No = 0;

if( isset($_POST['signin_btn']) ){


   if(!empty($_POST['signin_username']) && !empty($_POST['signin_password']))
    {
            // All OK
        $user_email=$_POST['signin_username'];
		$user_password=$_POST['signin_password'];

        $user_query = mysqli_query(mysqli_connect('localhost','root','','datacenter'),"select * from user_login");

        while( $row = mysqli_fetch_array($user_query) )
        {
            if($row['username']==$user_email && $row['password']==$user_password)
            {
                $_SESSION['server_id'] = $row['server_id'];
                $Error_No = -1;
                break;
            }

        }

       if( $Error_No==-1 )
       {
           header('Location: login_dash.php');
       }
       else
           $Error_No = -2;
    }
    else if( !empty($_POST['signin_username']) && empty($_POST['signin_password']) )
    {
        // password empty
        $Error_No = 1;
    }
    else if( empty($_POST['signin_username']) && !empty($_POST['signin_password']) )
    {
        //username empty
        $Error_No = 2;
    }
    else
    {
        // both empty
        $Error_No = 3;
    }

}

if( isset($_POST['signup_btn']) ){

    $a = $_POST['signup_first_name'];
    $b = $_POST['signup_last_name'];
    $c = $_POST['signup_email'];
    $d = $_POST['signup_contact'];

    $e = $_POST['signup_username'];
    $f = $_POST['signup_password'];

/*        !empty($_POST['signup_first_name'])
        !empty($_POST['signup_last_name'])
        !empty($_POST['signup_email'])
        !empty($_POST['signup_username'])
        !empty($_POST['signup_password'])
        !empty($_POST['signup_retype_password'])
        !empty($_POST['signup_contact'])
    */

    $server_id = 0;

    $user_query = mysqli_query(mysqli_connect('localhost','root','','datacenter'),"select * from user_info order by server_id asc");
    while( $row = mysqli_fetch_array($user_query) )
    {
            $server_id = $row['server_id'];
    }

    $server_id = $server_id + 1;

   if( !empty($_POST['signup_first_name']) && !empty($_POST['signup_last_name']) &&  !empty($_POST['signup_email']) && !empty($_POST['signup_username']) &&  !empty($_POST['signup_password']) && !empty($_POST['signup_retype_password']) && !empty($_POST['signup_contact']) && $_POST['signup_password']==$_POST['signup_retype_password'] )
    {
            // All OK

       $query = "INSERT INTO user_info(server_id,first_name,last_name,email,contact_no) values ($server_id,'$a','$b', '$c','$d')";
		mysqli_query(mysqli_connect('localhost','root','','datacenter'),$query);

    $query = "INSERT INTO user_login(server_id,username,password) values ($server_id,'$e','$f')";
 mysqli_query(mysqli_connect('localhost','root','','datacenter'),$query);

       $Error_No = -3;

    }
    else
    {
        // field empty
        $Error_No = 4;
    }

}
?>
<html>

<head>

    <title>Virtual Class</title>

    <!-- Bootstrap CDN -->

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- Custom CSS -->


      <link rel="stylesheet" href="CSS/home.css">


    <!-- Font -->

    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">

    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">


</head>

<body style="background-color: #cfccd6;">

    <!-- Page Header -->

    <div class="jumbotron text-center">
        <h1>Education Portal</h1>
        <p>Smart way to learn</p>
    </div>

    <!-- Navigation Bar -->

    <nav class="navbar navbar-default navbar-fixed-top" style="margin-right : 20px;">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Home</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#about">About</a></li>
                    <li><a href="#features">Features</a></li>
                    <li><a href="index_bc.php">Browse Class</a></li>
                    <li><a href="" data-toggle="modal" data-target="#signinmodal">Sign In</a></li>
                    <!--
                    <li><a href="#l4">Link 4</a></li>
                    <li><a href="#l5">Link 5</a></li>
-->
                </ul>
            </div>
        </div>
    </nav>

    <div class="row">
        <div class="container">
            <div class="col-sm-4 col-sm-offset-4">
     <?php

                        if( $Error_No == 1  ){
                            echo '<div class="alert alert-warning text-center">
                                      <strong>Please</strong> provide your <strong>password</strong>
                            </div>';
                        }
                        else if( $Error_No == 2  ){
                            echo '<div class="alert alert-warning text-center">
                                      <strong>Please</strong> provide your <strong>username</strong>
                            </div>';
                        }
                        else if( $Error_No == 3  ){
                            echo '<div class="alert alert-warning text-center">
                                      <strong>Fields</strong> are required<strong> to login</strong>
                            </div>';
                        }
                        else if( $Error_No == -2  ){
                            echo '<div class="alert alert-danger text-center">
                                      <strong>Invalid Username Or Password</strong>
                            </div>';
                        }
                        else if( $Error_No == 4  ){
                            echo '<div class="alert alert-warning text-center">
                                      <strong>Fields</strong> Can not Be <strong>Empty!!</strong>
                            </div>';


                        }
                        else if( $Error_No == -3  ){
                            echo '<div class="alert alert-success text-center">
                                      <strong>Success</strong> Please <span> <a href="" data-toggle="modal" data-target="#signinmodal">Sign In </a> </span><strong>To Continue</strong>
                            </div>';


                        }
                        else if( $Error_No==32 && $fl = 1 )
                        {
                            echo '<div class="alert alert-success text-center">
                                              <strong>Success</strong> Please Sign In<strong>With New Username Or Password Continue</strong>
                                    </div>';
                        }

    ?>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
          <?php
          $user_query = mysqli_query(mysqli_connect('localhost','root','','datacenter'),"Select * from class as C,user_info as UI Where C.server_id=UI.server_id and C.privacy='public'" );


        while( $row = mysqli_fetch_array($user_query) )
        {
          /* ef271b */

            $ec = 0;
            $cld = $row['class_id'];
            $q = mysqli_query(mysqli_connect('localhost','root','','datacenter'),"Select * from enroll_count where class_id=$cld" );

            while( $r = mysqli_fetch_array( $q ) )
            {
              $ec = $r['member'];
            }

          echo '<div class="col-sm-4">';
              echo '<img src="CSS/Image/book.jpg" alt="class photo" style="width:100%; border-radius: 2%;">';
              echo '<h3 style="color: #197bbd; font-family: Montserrat, sans-serif; letter-spacing: 3px; ">'.$row['title'].'</h3>';
              echo '<h4 style="color: #ef271b; font-family: Montserrat, sans-serif; letter-spacing: 2px; ">Instructor : <em>'.$row['first_name'].' '.$row['last_name'].'</em></h4>';
              echo '<h4 style="color: #ef271b; font-family: Montserrat, sans-serif; letter-spacing: 2px; ">Mail : <em>'.$row['email'].'</em></h4>';
              echo '<h4 style="color: #0eb1d2; font-family: Montserrat, sans-serif; letter-spacing: 2px; ">Enrolled User: <em>'.$ec.'</em></h4>';
              echo '<div class="text-center">';
              echo '<button class="btn btn-primary text-center" data-toggle="modal" data-target="#signinmodal">Enroll Now</button>';
              echo '</div>';
              echo '<br>';

              /*echo '<form action="" method="POST">

                  <div class="form-group text-center">
                      <button data-toggle="modal" data-target="#signinmodal" name="enroll_btn" class="btn btn-primary"><span><i class="fas fa-plus"></i></span> Enroll</button>
                  </div>

              </form>';
*/
          echo '</div>';
        }
          ?>
        </div>
    </div>





    <!-- Sign IN Modal -->
    <div class="modal fade" id="signinmodal" tabindex="-1" role="dialog" aria-labelledby="Signin" aria-hidden="true" style="margin-top:8%;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header modal-primary">
                    <h4 class="modal-title text-center signinmodaltitle" id="exampleModalCenterTitle">Sign In</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <br>

                    <form action="" method="POST">
                        <div class="form-group si_usernamebox">
                            <input type="text" class="form-control no-border" name="signin_username" placeholder="Email or Username">
                        </div>
                        <div class="form-group si_passwordbox">
                            <input type="password" class="form-control no-border" name="signin_password" placeholder="Password">
                        </div>

                        <div class="form-group text-center">
                            <button type="submit" name="signin_btn" class="btn btn-primaryp">Sign In</button>
                        </div>
                        <div class="text-center">
                            <a href="" data-dismiss="modal" data-toggle="modal" data-target="#signupmodal"> Don't have any account? Sign Up </a>
                        </div>
                    </form>
                    <br>
                    <div class="modal-footer">
                        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="signin_btn" class="btn btn-primaryp">Sign In</button>
                        -->

                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Sign UP Modal -->
    <div class="modal fade" id="signupmodal" tabindex="-1" role="dialog" aria-labelledby="SignUP" aria-hidden="true" style="margin-top:3%;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header modal-primary">
                    <h4 class="modal-title text-center signinmodaltitle" id="exampleModalCenterTitle">Sign Up</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <br>

                    <form action="" method="POST">
                        <div class="form-group si_usernamebox">
                            <input type="text" class="form-control no-border" name="signup_first_name"placeholder="First Name">
                        </div>
                        <div class="form-group si_usernamebox">
                            <input type="text" class="form-control no-border" name="signup_last_name"placeholder="Last Name">
                        </div>
                        <div class="form-group si_usernamebox">
                            <input type="email" class="form-control no-border" name="signup_email" placeholder="Email">
                        </div>
                        <div class="form-group si_usernamebox">
                            <input type="text" class="form-control no-border" name="signup_username" placeholder="Username">
                        </div>
                        <div class="form-group si_passwordbox">
                            <input type="password" class="form-control no-border" name="signup_password" placeholder="New Password">
                        </div>
                        <div class="form-group si_passwordbox">
                            <input type="password" class="form-control no-border" name="signup_retype_password" placeholder="Retype Password">
                        </div>
                        <div class="form-group si_usernamebox">
                            <input type="text" class="form-control no-border" name="signup_contact" placeholder="Contact No">
                        </div>

                        <div class="form-group text-center">
                            <button type="submit" name="signup_btn" class="btn btn-primaryp">Sign Up</button>
                        </div>
                    </form>
                    <br>
                    <div class="modal-footer">
                        <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primaryp">Sign Up</button>-->

                    </div>
                </div>
            </div>
        </div>
    </div>

        <footer class="container-fluid text-center custom-bg-fotter">
            <a href="index.php" title="To Top">
                <span class="glyphicon glyphicon-chevron-up"></span>
            </a>
            <p>A Service Made By <strong>UAP_INFINITY</strong></p>
        </footer>



</body>

</html>

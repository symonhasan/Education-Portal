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

<body>

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
                                      <strong>Success</strong> Please Sign In<strong>To Continue</strong>
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

    <!-- Container (About Section) -->
    <div id="about" class="container-fluid">
        <div class="row">
            <div class="col-sm-8 text-center">
                <h2>About Education Portal</h2><br>
                <h4>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</h4><br>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                <br><button class="btn btn-primarysignup text-center" data-toggle="modal" data-target="#signupmodal">Signup Now</button>


            </div>
            <div class="col-sm-4">
                <span class="glyphicon glyphicon-education logo"></span>
            </div>
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



        <!-- Features Slide -->
        <div id="features" class="container-fluid text-center bg-grey">
            <h2>Features</h2>
            <div id="myCarousel" class="carousel slide text-center" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                    <div class="item active">
                        <h4>"This company is the best. I am so happy with the result!"<br><span style="font-style:normal;">Michael Roe, Vice President, Comment Box</span></h4>
                    </div>
                    <div class="item">
                        <h4>"One word... WOW!!"<br><span style="font-style:normal;">John Doe, Salesman, Rep Inc</span></h4>
                    </div>
                    <div class="item">
                        <h4>"Could I... BE any more happy with this company?"<br><span style="font-style:normal;">Chandler Bing, Actor, FriendsAlot</span></h4>
                    </div>
                </div>

                <!-- Left and right controls -->
                <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>



        <div class="container">
            <h3 class="text-center">Feedback</h3>
            <br>
            <div class="row test">
                <div class="col-md-4">
                    <p>Fan? Drop a note.</p>
                    <p><span class="glyphicon glyphicon-map-marker"></span>Chicago, US</p>
                    <p><span class="glyphicon glyphicon-phone"></span>Phone: +00 1515151515</p>
                    <p><span class="glyphicon glyphicon-envelope"></span>Email: mail@mail.com</p>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <input class="form-control" id="name" name="name" placeholder="Name" type="text" required>
                        </div>
                        <div class="col-sm-6 form-group">
                            <input class="form-control" id="email" name="email" placeholder="Email" type="email" required>
                        </div>
                    </div>
                    <textarea class="form-control" id="comments" name="comments" placeholder="Comment" rows="5"></textarea>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <button class="btn pull-right" type="submit">Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<!--
<div class="text-center">
  <a href="" class="btn btn-default btn-rounded mb-4" data-toggle="modal" data-target="#modalLoginForm">Launch
    Modal Login Form</a>
</div>
-->


        <footer class="container-fluid text-center custom-bg-fotter">
            <a href="index.php" title="To Top">
                <span class="glyphicon glyphicon-chevron-up"></span>
            </a>
            <p>A Service Made By <strong>UAP_INFINITY</strong></p>
        </footer>

        <script>
            $(document).ready(function() {
                // Add smooth scrolling to all links in navbar + footer link
                $(".navbar a, footer a[href='#myPage']").on('click', function(event) {

                    // Make sure this.hash has a value before overriding default behavior
                    if (this.hash !== "") {

                        // Prevent default anchor click behavior
                        event.preventDefault();

                        // Store hash
                        var hash = this.hash;

                        // Using jQuery's animate() method to add smooth page scroll
                        // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
                        $('html, body').animate({
                            scrollTop: $(hash).offset().top
                        }, 900, function() {

                            // Add hash (#) to URL when done scrolling (default click behavior)
                            window.location.hash = hash;
                        });
                    } // End if
                });
            })

        </script>

</body>

</html>

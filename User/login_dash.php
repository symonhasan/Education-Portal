<?php
 session_start();
    $first_name = "";
    $last_name = "";
    $email = "";
    $contact_no = "";
    $fb_handle = "";
    $tw_handle = "";

    $user_query = mysqli_query(mysqli_connect('localhost','root','','datacenter'),"select * from user_info");
    $server_id = $_SESSION['server_id'];

    while( $row = mysqli_fetch_array($user_query) )
    {
                    if( $row['server_id']==$server_id )
                    {
                        echo "<strong>";
                        echo $row['first_name']." ".$row['last_name'];
                        echo "</strong>";
                        $first_name = $row['first_name'];
                        $last_name = $row['last_name'];
                        $email = $row['email'];
                        $contact_no = $row['contact_no'];

                        break;
                    }

                }

    $user_query = mysqli_query(mysqli_connect('localhost','root','','datacenter'),"select * from user_handle");
    $server_id = $_SESSION['server_id'];

    while( $row = mysqli_fetch_array($user_query) )
    {
                    if( $row['server_id']==$server_id )
                    {
                        if( $row['f_handle'] != NULL )
                        {
                            $fb_handle =  $row['f_handle'];
                        }
                        if( $row['t_handle'] != NULL )
                        {
                            $tw_handle =  $row['t_handle'];
                        }

                        break;
                    }

                }

    $err = 0; $succ = 0;



    $server_id = $_SESSION['server_id'];
    $user_query = mysqli_query(mysqli_connect('localhost','root','','datacenter'),"select * from user_login where server_id = '$server_id'");
    while( $row = mysqli_fetch_array($user_query) )
    {
            $p = $row['password'];
        break;

    }

    /* Update */
    if( isset($_POST['ep_btn']) && !empty( $_POST['ep_opassword'] ) && !empty($_POST['ep_cpassword']) )
    {


        if( $_POST['ep_opassword'] == $_POST['ep_cpassword'] && $_POST['ep_opassword']==$p)
        {
            if( !empty($_POST['ep_fname'] ) )
            {
                $a = $_POST['ep_fname'];


                $user_query = mysqli_query(mysqli_connect('localhost','root','','datacenter'),"Update user_info set first_name='$a' where server_id='$server_id'");
                if( $user_query )
                {
                    $succ = 1;
                }
                else
                {
                    $err = 1;
                }

            }
            if( !empty($_POST['ep_lname'] ) )
            {
                $b = $_POST['ep_lname'];
                $user_query = mysqli_query(mysqli_connect('localhost','root','','datacenter'),"Update user_info set last_name='$b' where server_id='$server_id'");
                if( $user_query )
                {
                    $succ = 2;
                }
                else
                {
                    $err = 2;
                }
            }
            if( !empty($_POST['ep_email'] ) )
            {
                $c = $_POST['ep_email'];
                $user_query = mysqli_query(mysqli_connect('localhost','root','','datacenter'),"Update user_info set email='$c' where server_id='$server_id'");
                if( $user_query )
                {
                    $succ = 3;
                }
                else
                {
                    $err = 3;
                }
            }
            if( !empty($_POST['ep_contact'] ) )
            {
                $d = $_POST['ep_contact'];
                $user_query = mysqli_query(mysqli_connect('localhost','root','','datacenter'),"Update user_info set contact_no='$d' where server_id='$server_id'");
                if( $user_query )
                {
                    $succ = 4;
                }
                else
                {
                    $err = 4;
                }
            }
            if( !empty($_POST['ep_fhandle'] ) )
            {
                $e = $_POST['ep_fhandle'];
                $user_query = mysqli_query(mysqli_connect('localhost','root','','datacenter'),"Update user_handle set f_handle='$e' where server_id='$server_id'");
                if( $user_query )
                {
                    $succ = 5;
                }
                else
                {
                    $err = 5;
                }
            }
            if( !empty($_POST['ep_thandle'] ) )
            {
                $f = $_POST['ep_thandle'];
                $user_query = mysqli_query(mysqli_connect('localhost','root','','datacenter'),"Update user_handle set t_handle='$f' where server_id='$server_id'");
                if( $user_query )
                {
                    $succ = 6;
                }
                else
                {
                    $err = 6;
                }
            }
            if( !empty($_POST['ep_username'] ) )
            {
                $g = $_POST['ep_username'];
                $user_query = mysqli_query(mysqli_connect('localhost','root','','datacenter'),"Update user_login set username='$g' where server_id='$server_id'");
                if( $user_query )
                {
                    $succ = 7;
                    $_SESSION['error'] = 32;
                    $_SESSION['fl'] = 1;
                }
                else
                {
                    $err = 7;
                }
            }
            if( !empty($_POST['ep_npassword'] ) )
            {
                $h = $_POST['ep_npassword'];
                $user_query = mysqli_query(mysqli_connect('localhost','root','','datacenter'),"Update user_login set password='$h' where server_id='$server_id'");
                if( $user_query )
                {
                    $succ = 8;
                    $_SESSION['error'] = 32;
                    $_SESSION['fl'] = 1;

                }
                else
                {
                    $err = 8;
                }
            }
            if( $succ== 7 || $succ== 8 )
                exit(header("Location: index.php"));

        }
        else
        {
            $err = -64;
        }
    }
    else if( isset($_POST['ep_btn']) && ( empty( $_POST['ep_opassword'] ) || empty($_POST['ep_cpassword']) ) )
    {
            $err = -32;
    }
    else {

    }

    /*********** CREATE CLASS **************/

    if( isset($_POST['cc_btn'] ) )
    {
              $err = 0;
            if( !empty( $_POST['cc_title'] ) && !empty( $_POST['cc_tag'] ) && !empty( $_POST['cc_privacy'] ) )
            {
              $a = $_POST['cc_title'];
              $b = $_POST['cc_tag'];
              $c = $_POST['cc_privacy'];

              if( $_POST['cc_privacy'] == "Invitation Only" )
                  $c = 'Invite';

              $c = strtolower( $c );


              $user_query = mysqli_query(mysqli_connect('localhost','root','','datacenter'),"select * from class order by class_id asc");
              $cl_id = 1;

              while( $row = mysqli_fetch_array($user_query) )
              {
                $cl_id = $row['class_id'];
              }
              $cl_id = $cl_id + 1;

              $server_id = $_SESSION['server_id'];
              $user_query = mysqli_query(mysqli_connect('localhost','root','','datacenter'),"INSERT INTO class(class_id,title,privacy,server_id) Values($cl_id,'$a','$c','$server_id')" );

              if( $user_query )
              {
                $err = 12;
              }
              else {
                $err = -12;
              }

              $len = strlen( $b );
              $b = strtolower( $b );
              $str = trim($b);

              $tok = strtok($str, " ,");

              while ($tok !== false) {

                    $user_query = mysqli_query(mysqli_connect('localhost','root','','datacenter'),"INSERT INTO class_tag(class_id,tag) Values($cl_id,'$tok')" );
                  $tok = strtok(" ,");
              }

              $cnt  = 0;
              $user_query = mysqli_query(mysqli_connect('localhost','root','','datacenter'),"INSERT INTO enroll_count(class_id,member) Values($cl_id,$cnt)" );


            }
            else {
                  $err = -10;
            }
    }



?>
<html>

<head>
    <title>Dashboard</title>
    <!-- Bootstrap CDN -->

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <!-- Custom CSS -->

    <link rel="stylesheet" href="CSS/login_dash.css">


    <!-- Font -->

    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">

    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">

    <link href="https://use.fontawesome.com/releases/v5.0.11/css/all.css" rel="stylesheet">


</head>

<body style="margin-right : 20px;">

    <!--
    <div class="nav-side-menu">
        <div class="brand" style="font-family: Montserrat, sans-serif;">
            Welcome


        </div>
        <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>

        <div class="menu-list">

            <ul id="menu-content" class="menu-content collapse out">
                <li>
                    <a href="#">
                        <i class="fas fa-tachometer-alt fa-lg"></i> Dashboard
                    </a>
                </li>

                <li class="active">
                    <a href="#">
                        <i class="fas fa-user-tie fa-lg"></i> Profile
                    </a>
                </li>

                <li data-toggle="collapse" data-target="#products" class="collapsed">
                    <a href="#"><i class="fab fa-studiovinari fa-lg"></i> Class <span class="arrow"></span></a>
                </li>
                <ul class="sub-menu collapse" id="products">
                    <li class="active" data-toggle="modal" data-target="#createclass"><a href="#">Create A Class</a></li>
                    <li><a href="#">Enroll In A Class</a></li>
                    <li><a href="#">Browse Class</a></li>
                    <li><a href="#">Class List</a></li>
                </ul>


                <li data-toggle="collapse" data-target="#service" class="collapsed">
                    <a href="#"><i class="fab fa-fort-awesome-alt fa-lg"></i> Services <span class="arrow"></span></a>
                </li>
                <ul class="sub-menu collapse" id="service">
                    <li>New Service 1</li>
                    <li>New Service 2</li>
                    <li>New Service 3</li>
                </ul>


                <li data-toggle="collapse" data-target="#new" class="collapsed">
                    <a href="#"><i class="fab fa-pagelines fa-lg"></i> New <span class="arrow"></span></a>
                </li>
                <ul class="sub-menu collapse" id="new">
                    <li>New New 1</li>
                    <li>New New 2</li>
                    <li>New New 3</li>
                </ul>

                <li>
                    <a href="#">
                        <i class="fa fa-users fa-lg"></i> Users
                    </a>
                </li>

                <li>
                    <a href="index.php">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </div> -->

    <!-- Nav Bar -->

    <div class="container">
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand active" href="login_dash.php">
                        <?php
                        echo '<i class="fas fa-user-tie fa-lg"></i>';
                        echo " ".$first_name." ".$last_name;
                        ?>
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#"><i class="fas fa-globe"></i>Notification</a></li>
                        <li><a href="" data-toggle="modal" data-target="#createclass">Create Class</a></li>
                        <li><a href="login_dash_bc.php">Browse Class</a></li>
                        <li><a href="login_dash_search.php"><i class="fas fa-search"></i>Search</a></li>



                        <li>
                            <a href="index.php">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </li>

                    </ul>

                </div>
            </div>
        </nav>
    </div>

    <br><br><br><br>

    <!-- eroor -->

    <div class="row">
        <div class="container">
            <br>
            <div class="col-sm-4 col-sm-offset-4">
                <?php

                        if( $err > 0 && $err != 12 ){
                            echo '<div class="alert alert-danger text-center">
                                      <strong>Error</strong> Can not Possible to update
                            </div>';
                        }
                        if( $err == -32  ){
                            echo '<div class="alert alert-danger text-center">
                                      <strong>* </strong> Field Are Required to Update
                            </div>';
                        }
                        if( $err == -64  ){
                            echo '<div class="alert alert-danger text-center">
                                      Password Did not matched
                            </div>';
                        }
                        if( $err == -12 )
                        {
                          echo '<div class="alert alert-danger text-center">
                                    Server Error !!
                          </div>';
                        }
                        if( $err == 12 )
                        {
                          echo '<div class="alert alert-success text-center">
                                    Class Created Successfully
                          </div>';
                        }
                        if( $err == -10 )
                        {
                          echo '<div class="alert alert-warning text-center">
                                    All Fields Are Required
                          </div>';
                        }
                        /*if( $succ == 8 || $succ == 7 )
                        {
                            $_SESSION['error'] = -32;
                            exit(header("Location: /index.php"));
                        }*/


    ?>
            </div>
        </div>
    </div>

    <!-- Profile Card -->

    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <div class="card">
                    <img src="CSS/Image/art-backlight-blur-249203.jpg" alt="John" style="width:100%; border-radius: 0%;">
                    <?php
                        echo '<h2 style="font-family: Montserrat, sans-serif;">'.$first_name.' '.$last_name.'</h2>';
                        echo '<p class="card_title">'.$email.'</p>';
                        echo '<p style="font-family: Montserrat, sans-serif;">'.$contact_no.'</p>';
                        echo '<div style="margin: 24px 0px;" class="card_a">
                            <a href="https://www.facebook.com/'.$fb_handle.'" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://www.twitter.com/'.$tw_handle.'" style="padding-left: 10px;" target="_blank"><i class="fab fa-twitter"></i></a>
                        </div>';
                    ?>
                    <p><button class="card_button" data-toggle="modal" data-target="#editprofile">Edit Profile</button></p>
                </div>
            </div>
        </div>

    </div>

    <!-- Create Class Modal -->

    <div class="modal fade" id="createclass" tabindex="-1" role="dialog" aria-labelledby="Create Class" aria-hidden="true" style="margin-top: 8%;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header cc_modal-primary">
                    <h4 class="modal-title text-center create_class_title" id="exampleModalCenterTitle">Create Class</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <br>
                    <form action="" method="POST">

                        <div class="form-group cc_inputbox">
                            <input type="text" class="form-control no-border" name="cc_title" placeholder="Class Name">
                        </div>
                        <div class="form-group cc_inputbox">
                            <input type="text" class="form-control no-border" name="cc_tag" placeholder="Tag Separated By Comma">
                        </div>

                        <div class="form-group cc_inputbox">
                            <label for="cc_privacy" style="font-family: Montserrat, sans-serif; color: #d36135;"><i class="fas fa-user-secret"></i> Privacy</label>
                            <select class="form-control" name="cc_privacy" style="border-style: none;box-shadow: none;">
                                <option>Public</option>
                                <option>Invitation Only</option>
                            </select>
                        </div>

                        <div class="form-group text-center">
                            <button type="submit" name="cc_btn" class="btn ccbtn-primaryp">Create</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

    <!--- Edit Profile Modal -->

    <div class="modal fade" id="editprofile" tabindex="-1" role="dialog" aria-labelledby="Edit Profile" aria-hidden="true" style="margin-top:3%;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header modal-primary">
                    <h4 class="modal-title text-center edit_profile_title" id="exampleModalCenterTitle">Edit Profile</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <br>
                    <div class="text-center">
                        <p style="color: dark gray; font-family : Montserrat, sans-serif;"><strong>*</strong> fields are required to update an information</p>
                    </div>
                    <form action="" method="POST">

                        <div class="form-group ep_usernamebox">
                            <input type="text" class="form-control no-border" name="ep_fname" placeholder="First Name">
                        </div>
                        <div class="form-group ep_usernamebox">
                            <input type="text" class="form-control no-border" name="ep_lname" placeholder="Last Name">
                        </div>
                        <div class="form-group ep_usernamebox">
                            <input type="text" class="form-control no-border" name="ep_email" placeholder="Email">
                        </div>
                        <div class="form-group ep_usernamebox">
                            <input type="text" class="form-control no-border" name="ep_contact" placeholder="Contact No">
                        </div>
                        <div class="form-group ep_usernamebox">
                            <input type="text" class="form-control no-border" name="ep_fhandle" placeholder="Facebook Username">
                        </div>
                        <div class="form-group ep_usernamebox">
                            <input type="text" class="form-control no-border" name="ep_thandle" placeholder="Twitter Username">
                        </div>
                        <div class="form-group ep_usernamebox">
                            <input type="text" class="form-control no-border" name="ep_username" placeholder="Username">
                        </div>
                        <div class="form-group ep_passwordbox">
                            <input type="password" class="form-control no-border" name="ep_npassword" placeholder="New Password">
                        </div>
                        <div class="form-group ep_passwordbox">
                            <input type="password" class="form-control no-border" name="ep_opassword" placeholder="Current Password *">
                        </div>
                        <div class="form-group ep_passwordbox">
                            <input type="password" class="form-control no-border" name="ep_cpassword" placeholder="Confirm Password *">
                        </div>

                        <div class="form-group text-center">
                            <button type="submit" name="ep_btn" class="btn btn-primaryp">Update</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

</body>

</html>

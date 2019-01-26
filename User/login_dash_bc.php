<?php
 session_start();
    $first_name = "";
    $last_name = "";
    $email = "";
    $contact_no = "";
    $fb_handle = "";
    $tw_handle = "";

    /************ Data Fetch ****************/

    $user_query = mysqli_query(mysqli_connect('localhost','root','','datacenter'),"select * from user_info");
    $server_id = $_SESSION['server_id'];

    while( $row = mysqli_fetch_array($user_query) )
    {
                    if( $row['server_id']==$server_id )
                    {
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
    /**************** End of Data Fetch *****************************/


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

    /********* Enroll Class Page *******************/

    if( isset( $_POST['enroll_enter_btn'] ) )
    {
        $_SESSION['class_id'] = $_POST['enroll_enter_btn'];
        header('Location: class_enroll.php');
    }

    /******** Created Class Page **********************/

    if( isset( $_POST['create_btn'] ) )
    {
        $_SESSION['class_id'] = $_POST['create_btn'];
        header('Location: class_ins.php');
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

<body style="margin-right: 20px;">

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

    <br><br>

    <!-- eroor -->

    <div class="row">
        <div class="container">
            <br>
            <div class="col-sm-4 col-sm-offset-4">

            </div>
        </div>
    </div>

    <!--- Enrolled Class ---------------------->

    <div classs="container" style="margin: 0px 20px;">
          <div class="row">
                <div class="col-sm-4">
                      <h3 style="margin-left: 20px; color: #197bbd; font-family: Montserrat, sans-serif; letter-spacing: 3px;">Enrolled Class</h3>
                </div>
          </div>
          <div class="row">
                <?php
                      $svid = $_SESSION['server_id'];


                      $user_query = mysqli_query(mysqli_connect('localhost','root','','datacenter'),"Select * from enroll_user as EU , class as C, user_info as UI where EU.class_id=C.class_id and EU.server_id=$svid and UI.server_id=C.server_id" );



                      while( $row = mysqli_fetch_array( $user_query) )
                      {

                        $ec = 0;
                        $cld = $row['class_id'];
                        $q = mysqli_query(mysqli_connect('localhost','root','','datacenter'),"Select * from enroll_count where class_id='$cld'" );

                        while( $r = mysqli_fetch_array( $q ) )
                        {
                              $ec = $r['member'];
                        }
                        echo '<div class="col-sm-4" style=" background-color: #fffffa;">';
                            echo '<img src="CSS/Image/book.jpg" alt="class photo" style="width:100%; border-radius: 2%;">';
                            echo '<h3 style="color: #197bbd; font-family: Montserrat, sans-serif; letter-spacing: 3px; ">'.$row['title'].'</h3>';
                            echo '<h4 style="color: #ef271b; font-family: Montserrat, sans-serif; letter-spacing: 2px; ">Instructor : <em>'.$row['first_name'].' '.$row['last_name'].'</em></h4>';
                            echo '<h4 style="color: #ef271b; font-family: Montserrat, sans-serif; letter-spacing: 2px; ">Mail : <em>'.$row['email'].'</em></h4>';
                            echo '<h4 style="color: #0eb1d2; font-family: Montserrat, sans-serif; letter-spacing: 2px; ">Enrolled User: <em>'.$ec.'</em></h4>';

                            echo '<form action="" method="POST">

                                <div class="form-group text-center">
                                    <button type="hidden" name="enroll_enter_btn" value="'.$row['class_id'].'" class="btn srch_btn-primaryp"><span><i class="fas fa-arrow-circle-right"></i></span> Enter</button>
                                </div>

                            </form>';

                        echo '</div>';
                      }
                 ?>
          </div>
    </div>

    <!--- Created Class ------------------->


        <div classs="container" style="margin: 0px 20px;">
              <div class="row">
                    <div class="col-sm-4">
                          <h3 style="margin-left: 20px; color: #197bbd; font-family: Montserrat, sans-serif; letter-spacing: 3px;">Your Class</h3>
                    </div>
              </div>
              <div class="row">
                    <?php
                          $svid = $_SESSION['server_id'];


                          $user_query = mysqli_query(mysqli_connect('localhost','root','','datacenter'),"Select * from class as C, user_info as UI where  UI.server_id=$svid and UI.server_id=C.server_id" );



                          while( $row = mysqli_fetch_array( $user_query) )
                          {

                            $ec = 0;
                            $cld = $row['class_id'];
                            $q = mysqli_query(mysqli_connect('localhost','root','','datacenter'),"Select * from enroll_count where class_id='$cld'" );

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

                                echo '<form action="" method="POST">

                                    <div class="form-group text-center">
                                        <button type="hidden" name="create_btn" value="'.$row['class_id'].'" class="btn srch_btn-primaryp"><span><i class="fas fa-arrow-circle-right"></i></span> Enter</button>
                                    </div>

                                </form>';

                            echo '</div>';
                          }
                     ?>
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



</body>

</html>

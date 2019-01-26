<?php
    session_start();
    $first_name = "";
    $last_name = "";
    $email = "";
    $contact_no = "";
    $fb_handle = "";
    $tw_handle = "";

    $class_name = "";

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

                $class_id = $_SESSION['class_id'];

                /************ Data Fetch ****************/

                $user_query = mysqli_query(mysqli_connect('localhost','root','','datacenter'),"select * from class as C,user_info as UI where C.server_id=UI.server_id and class_id = $class_id");


                while( $row = mysqli_fetch_array($user_query) )
                {
                        $class_name = $row['title'];
                        $class_insfn = $row['first_name'];
                        $class_insln = $row['last_name'];
                }
    /**************** End of Data Fetch *****************************/

    /************** Forum post Insert *******************************/

    if( isset( $_POST['fp_btn'] ) ){
    $pid = 0;
    $user_query = mysqli_query(mysqli_connect('localhost','root','','datacenter'),"Select * From class_post order by post_id asc" );

    while( $row = mysqli_fetch_array( $user_query ) )
    {
      $pid = $row['post_id'];
    }
    $pid = $pid + 1;

    $class_id = $_SESSION['class_id'];
    $p = $_POST['fp_box'];

    $user_query = mysqli_query(mysqli_connect('localhost','root','','datacenter'),"INSERT INTO class_post(class_id,post_id,post) VALUES ('$class_id','$pid','$p')" );

    if($user_query)
    {
      $page = $_SERVER['PHP_SELF'];
      $sec = "10";
      header("Refresh: $sec; url=$page");
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

<body style="margin-right: 20px;  background-color: #cfccd6;">

    <!-- Nav Bar -->

    <div class="container">
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">

                    <a class="navbar-brand active" href="login_dash.php">
                        <?php
                        echo " ".$class_name;
                        echo '<sub style="Montserrat, sans-serif;"> by '.$first_name.' '.$last_name.'</sub>';
                        ?>
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#"><i class="fas fa-globe"></i>Notification</a></li>
                        <li><a href="class_ins.php"><i class="fas fa-newspaper"></i> News Feed</a></li>
                        <li><a href="class_forum_ins.php"><i class="fab fa-forumbee"></i> Forum</a></li>
                        <li><a href="login_dash_bc.php"><i class="fab fa-dashcube"></i> Dashboard</a></li>


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



    <!--- NEWS FEED ---->

    <div class="container">
      <div class="row">
          <div class="col-sm-3">

          </div>
          <div class="col-sm-7">

            <form method="post" action="">
              <div class="form-group" style="border: none; border-bottom: 1px solid gray;">
                <textarea class="form-control" name="fp_box" rows="5" placeholder="Write Post"></textarea>
              </div>

              <div class="form-group text-right">
                  <button type="submit" name="fp_btn" class="btn btn-primary">Post</button>
              </div>
            </form>
            <?php
              $class_id = $_SESSION['class_id'];

              $user_query = mysqli_query(mysqli_connect('localhost','root','','datacenter'),"select * from class_post where class_id=$class_id order by post_id desc");

              while( $row = mysqli_fetch_array( $user_query) ){
                echo '<div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12" style="background-color: #ffffff; border-radius: 10px; padding-bottom: 5px;">';
                            echo '<h5 style="font-family: Montserrat, sans-serif;letter-spacing: 2px; padding: 5px 0px; color: #444554"><span><i class="fas fa-user"></i></span> '.$first_name.' '.$last_name.'</h5>';
                            echo $row['post'];
                        echo '</div>
                    </div>
                </div>';
                echo '<br>';
              }
            ?>
          </div>
      </div>

    </div>



</body>

</html>

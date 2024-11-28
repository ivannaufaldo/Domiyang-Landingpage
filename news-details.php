<?php 
  session_start();
  include('includes/config.php');

  //Genrating CSRF Token
  if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
  }

  if(isset($_POST['submit'])){
    //Verifying CSRF Token
    if (!empty($_POST['csrftoken'])) {
      if (hash_equals($_SESSION['token'], $_POST['csrftoken'])) {
        $name=$_POST['name'];
        $email=$_POST['email'];
        $comment=$_POST['comment'];
        $postid=intval($_GET['nid']);
        $st1='0';
        $query=mysqli_query($con,"insert into tblcomments(postId,name,email,comment,status) values('$postid','$name','$email','$comment','$st1')");
        if($query):
          echo "<script>alert('comment successfully submit. Comment will be display after admin review ');</script>";
          unset($_SESSION['token']);
        else :
          echo "<script>alert('Something went wrong. Please try again.');</script>";  
      endif;
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Berita</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/modern-business.css" rel="stylesheet">


    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="generator" content="Mobirise v5.7.8, mobirise.com" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, minimum-scale=1"
    />
    <link
      rel="shortcut icon"
      href="assets/images/coat-of-arms-of-pekalongan-regency.svg-1.png"
      type="image/x-icon"
    />
    <meta name="description" content="" />

    <title>Berita Point</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-grid.min.css" />
    <link
      rel="stylesheet"
      href="assets/bootstrap/css/bootstrap-reboot.min.css"
    />
    <link rel="stylesheet" href="assets/animatecss/animate.css" />
    <link rel="stylesheet" href="assets/dropdown/css/style.css" />
    <link rel="stylesheet" href="assets/socicon/css/styles.css" />
    <link rel="stylesheet" href="assets/theme/css/style.css" />
    <link
      rel="preload"
      href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&display=swap"
      as="style"
      onload="this.onload=null;this.rel='stylesheet'"
    />
    <noscript
      ><link
        rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&display=swap"
    /></noscript>
    <link
      rel="preload"
      href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700,800,300i,400i,500i,600i,700i,800i&display=swap"
      as="style"
      onload="this.onload=null;this.rel='stylesheet'"
    />
    <noscript
      ><link
        rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700,800,300i,400i,500i,600i,700i,800i&display=swap"
    /></noscript>
    <link
      rel="preload"
      href="https://fonts.googleapis.com/css?family=Noto+Sans+JP:100,300,400,500,700,900&display=swap"
      as="style"
      onload="this.onload=null;this.rel='stylesheet'"
    />
    <noscript
      ><link
        rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Noto+Sans+JP:100,300,400,500,700,900&display=swap"
    /></noscript>
    <link
      rel="preload"
      as="style"
      href="assets/mobirise/css/mbr-additional.css"
    />
    <link
      rel="stylesheet"
      href="assets/mobirise/css/mbr-additional.css"
      type="text/css"
    />

    <style>
      body{
        background-color : #F7F7F7;
        margin-top:-45px;
        font-family: Arial, Helvetica, sans-serif;
      }
      .btn {
        float: right;
      }
      .card{
        background-color:white;
        padding:10px;
      }
      .card-footer{
        background-color:white;
        text-align: right;
      }
    </style>
  </head>

  <body>
    <!-- Navigation -->
    <?php include('includes/page2.php');?>

    <!-- Page Content -->
    <div class="container">     
      <div class="row" style="margin-top: 4%">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

          <!-- Blog Post -->
          <?php
            $pid=intval($_GET['nid']);
            $query=mysqli_query($con,"select tblposts.PostTitle as posttitle,tblposts.PostImage,tblcategory.CategoryName as category,tblcategory.id as cid,tblsubcategory.Subcategory as subcategory,tblposts.PostDetails as postdetails,tblposts.PostingDate as postingdate,tblposts.PostUrl as url from tblposts left join tblcategory on tblcategory.id=tblposts.CategoryId left join  tblsubcategory on  tblsubcategory.SubCategoryId=tblposts.SubCategoryId where tblposts.id='$pid'");
            while ($row=mysqli_fetch_array($query)) {
          ?>

          <div class="card mb-4">
            <div class="card-body">
              <h2 class="card-title"><?php echo htmlentities($row['posttitle']);?></h2>
              <p><b>Kategori : </b> <a href="category.php?catid=<?php echo htmlentities($row['cid'])?>"><?php echo htmlentities($row['category']);?></a> |
                <b>Sub Kategori : </b><?php echo htmlentities($row['subcategory']);?> <b>| di post pada </b><?php echo htmlentities($row['postingdate']);?></p>
                <hr />
              <img class="img-fluid rounded" src="admin/postimages/<?php echo htmlentities($row['PostImage']);?>" alt="<?php echo htmlentities($row['posttitle']);?>">  
              <p class="card-text"><?php $pt=$row['postdetails'];
                  echo  (substr($pt,0));?></p> 
            </div>
            <div class="card-footer text-muted"></div>
          </div>
          <?php } ?>
        </div>
        
        <!-- Sidebar Widgets Column -->
        <?php include('includes/sidebar.php');?>
      </div>
      <!-- /.row -->
      
      <!---Comment Section --->
      <div class="row" style="margin-top: -30px">
        <div class="col-md-8">
          <div class="card my-4">
            <h5 class="card-header" style="Background-color:white">Tulis komentar anda disini :</h5>
            <div class="card-body">
              <form name="Comment" method="post" >
                <input type="hidden" name="csrftoken" value="<?php echo htmlentities($_SESSION['token']); ?>" />
                <div class="form-group">
                  <input type="text" name="name" class="form-control" placeholder="Nama" required style="font-size:13px">
                </div>
                <div class="form-group">
                  <input type="email" name="email" class="form-control" placeholder="email" required style="font-size:13px">
                </div>
                <div class="form-group">
                  <textarea class="form-control" name="comment" rows="3" placeholder="Tulis komen anda di sini" required style="font-size:13px"></textarea>
                </div>
                <button type="submit" class="btn btn-primary" name="submit" style="font-size:15px;padding:10px">Submit</button>
              </form>
            </div>
          </div>

          <!---Comment Display Section --->

          <?php 
            $sts=1;
            $query=mysqli_query($con,"select name,comment,postingDate from  tblcomments where postId='$pid' and status='$sts'");
            while ($row=mysqli_fetch_array($query)) {
          ?>
          <div class="media mb-3" style="background-color:white; padding:15px">
            <img class="d-flex mr-3 rounded-circle" src="images/usericon.png" alt="" style="width:35px;height:35px">
            <div class="media-body">
              <h5 class="mt-0 mb-0"><?php echo htmlentities($row['name']);?> <br />
                <span style="font-size:12px;"><b>at</b> <?php echo htmlentities($row['postingDate']);?></span>
              </h5>
              <?php echo htmlentities($row['comment']);?>            
            </div>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>

      <?php include('includes/footer.php');?>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>
</html>

<?php 
session_start();
include('includes/config.php');

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
     if (isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }
        $no_of_records_per_page = 8;
        $offset = ($pageno-1) * $no_of_records_per_page;


        $total_pages_sql = "SELECT COUNT(*) FROM tblposts";
        $result = mysqli_query($con,$total_pages_sql);
        $total_rows = mysqli_fetch_array($result)[0];
        $total_pages = ceil($total_rows / $no_of_records_per_page);


      //Card 
      $query=mysqli_query($con,"select tblposts.id as pid,tblposts.PostTitle as posttitle,tblposts.PostImage,tblcategory.CategoryName as category,tblcategory.id as cid,tblsubcategory.Subcategory as subcategory,tblposts.PostDetails as postdetails,tblposts.PostingDate as postingdate,tblposts.PostUrl as url from tblposts left join tblcategory on tblcategory.id=tblposts.CategoryId left join  tblsubcategory on  tblsubcategory.SubCategoryId=tblposts.SubCategoryId where tblposts.Is_Active=1 order by tblposts.id desc  LIMIT $offset, $no_of_records_per_page");
        while ($row=mysqli_fetch_array($query)) {?>
          <div class="card mb-4">
            <img class="card-img-top" src="admin/postimages/<?php echo htmlentities($row['PostImage']);?>" alt="<?php echo htmlentities($row['posttitle']);?>">
            <div class="card-body">
              <h2 class="card-title"><?php echo htmlentities($row['posttitle']);?></h2>
                <!-- <p><b>Category : </b> <a href="category.php?catid=<?php echo htmlentities($row['cid'])?>"><?php echo htmlentities($row['category']);?></a> </p> -->
                <a href="news-details.php?nid=<?php echo htmlentities($row['pid'])?>" class="btn btn-primary" >Baca Berita &rarr;</a>
            </div>
            <div class="card-footer text-muted">
              Posted on <?php echo htmlentities($row['postingdate']);?> 
            </div>
          </div>
        <?php } ?>
       

      

          <!-- Pagination -->


    <ul class="pagination justify-content-center mb-4">
        <li class="page-item"><a href="?pageno=1"  class="page-link">First</a></li>
        <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?> page-item">
            <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>" class="page-link">Prev</a>
        </li>
        <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?> page-item">
            <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?> " class="page-link">Next</a>
        </li>
        <li class="page-item"><a href="?pageno=<?php echo $total_pages; ?>" class="page-link">Last</a></li>
    </ul>

        </div>

        <!-- Sidebar Widgets Column -->
      <?php include('includes/sidebar.php');?>
      </div>
      <!-- /.row -->

    </div>
    <!-- /.container -->

    <!-- Footer -->
      <?php include('includes/footer.php');?>


    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

 
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/smoothscroll/smooth-scroll.js"></script>
    <script src="assets/ytplayer/index.js"></script>
    <script src="assets/dropdown/js/navbar-dropdown.js"></script>
    <script src="assets/theme/js/script.js"></script>
  </body>

</html>

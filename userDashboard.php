<?php
   session_start();
   include 'connect.php';
    if (!isset($_SESSION['username'])){
      header('location:login.php');
    }
    include("includes/header.php");
    include("userApi.php");

?>
<title>TeknoEvents Events</title>
<style>
input[type="submit"]{
  width: 90%;
  height: 40px;
  border-radius: 10px;
  font-size: 15px;
  
}
input[type="submit"]:hover{
    color: white;
    background-color: black;
    transition: .2s;
}
.all-events {
  position:relative;
  padding-bottom: 4%;
}

.all-events input[type="submit"]{
  position: absolute;
  bottom: 10px;
  left: 50%;
  transform: translateX(-50%);
}

</style>
<div id="content-placeholder">
  <?php
      allEvents();
  ?>
</div>

<?php require_once 'includes/footer.php';?>


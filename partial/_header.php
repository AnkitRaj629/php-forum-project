<?php
include 'partial/_dbconnect.php';
echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container-fluid">
  <a class="navbar-brand" href="/forum">iDiscuss</a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="/forum">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="about.php">About</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Categories
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">';
        $sql="SELECT category_name,category_id FROM `categories` ";
        $result=mysqli_query($conn,$sql);
        while($row=mysqli_fetch_assoc($result)){
          $id=$row['category_id'];
          echo '<li><a class="dropdown-item" href="http://localhost/forum/threadlist.php?catid='.$id.'">'.$row["category_name"].'</a></li>';
        }
        echo '
        </ul>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="contact.php" tabindex="-1" >Contacts</a>
      </li>
    </ul>
    <div class="d-flex justify-content-end">';
     session_start();
 if(isset($_SESSION['loggedin'])&& $_SESSION['loggedin']==true){
    echo '<form class="d-flex">
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-success" type="submit">Search</button>
      <p class="text-light mx-2 my-1">'.$_SESSION['useremail'].'</p>
      <a href="partial/_logout.php" class="btn btn-outline-success mx-2">Logout</a>
      </form>';
 }
 else{
      echo'<form class="d-flex">
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-success" type="submit">Search</button>
      </form>
      <button class="btn btn-outline-success mx-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
      <button class="btn btn-outline-success ml-1"  data-bs-toggle="modal" data-bs-target="#signupModal">Signup</button>';
 }

  echo'</div>
  </div>
</div>
</nav>
';
include 'partial/_loginmodal.php';
include 'partial/_signupmodal.php';

if(isset($_GET['signupsuccess'])&& $_GET['signupsuccess']=="true")
{
  echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
  <strong>Success</strong> You can now log in
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
if(isset($_GET['signupsuccess'])&& $_GET['signupsuccess']=="false"){
  
  echo '<div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
  <strong>Failed</strong> '.$_GET['error'].'
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
if(isset($_GET['loginsuccess'])&& $_GET['loginsuccess']=="true")
{
  echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
  <strong>Success</strong> You have logged in
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
if(isset($_GET['loginsuccess'])&& $_GET['loginsuccess']=="false"){
  
  echo '<div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
  <strong>Failed</strong> '.$_GET['error'].'
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
?>
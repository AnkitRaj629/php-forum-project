<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>idiscuss-coding Forum</title>
</head>
<style>
    #ques{
        min-height:400px;
    }
    #user{
        font-weight: bold;
    }
</style>
<body>
    <?php include 'partial/_header.php';?>
    <?php include 'partial/_dbconnect.php';?>
    <?php
    $id=$_GET['catid'];
    $sql="SELECT * FROM `categories` WHERE category_id=$id";
    $result=mysqli_query($conn,$sql);
    while($row=mysqli_fetch_assoc($result)){
        $catname=$row['category_name'];
        $catdesc=$row['category_discription'];
    }
    ?>

    <?php
    $showalert=false;
    $method=$_SERVER['REQUEST_METHOD'];
    if($method=='POST'){
        // insert thread into db
        $th_title=$_POST['title'];
        $th_desc=$_POST['desc'];
        $sno=$_POST['sno'];
        $sql="INSERT INTO `threads` ( `thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$th_title', '$th_desc', '$id', '$sno', current_timestamp())";
        $result=mysqli_query($conn,$sql);
        $showalert=true;
        if($showalert){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success</strong> Your thread has been added please wait for comunnity to reply.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
    }
    ?>

    <div class="container my-3">
        <div class="jumbotron bg-light">
            <h1 class="display-4">Welcome to <?php echo "$catname"; ?> forum</h1>
            <p class="lead"> <?php echo "$catdesc"; ?></p>
            <hr class="my-4">
            <p>This is peer to peer forum for sharing knowledge with each other.
                Do not spam.
                Do Not Bump Posts.
                Do Not Offer to Pay for Help.
                Do Not Offer to Work For Hire.
                Do Not Post About Commercial Products.
                Do Not Create Multiple Accounts (Sockpuppets)
                When creating links to other resources.</p>
            <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a>
        </div>
    </div>
    
<?php
 if(isset($_SESSION['loggedin'])&& $_SESSION['loggedin']==true){
  echo  '<div class="container">
    <form action="'.$_SERVER["REQUEST_URI"] .'" method="post">
    <h1 class="py-2">Start a Discussions</h1>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Problem Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">

            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Elaborate your concern</label>
                <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
            </div>
            <input type="hidden" name="sno" value="'.$_SESSION["sno"].'">
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>';
}
else{
    echo '<div class="container">
    <h1 class="py-2">Start a Discussions</h1>
    <p>You need to logged-in to start a diccusion.</p>
</div>
';
}
?>

    <div class="container" id="ques">

        <h1 class="py-2">Browse Questions</h1>

        <?php
                    $id=$_GET['catid'];
                    $sql="SELECT * FROM `threads` WHERE thread_cat_id= $id";
                    $result=mysqli_query($conn,$sql);
                    $noresult=true;
                    while($row=mysqli_fetch_assoc($result)){
                        $noresult=false;
                        $id=$row['thread_id'];
                        $title=$row['thread_title'];
                        $desc=$row['thread_desc'];
                        $thread_time=$row['timestamp'];
                        $thread_user_id=$row['thread_user_id'];
                        $sql2="SELECT user_email FROM `users` WHERE sno=$thread_user_id";
                        $result2=mysqli_query($conn,$sql2);
                        $row2=mysqli_fetch_assoc($result2);

                        
                        echo '<div class="d-flex my-3">
                                <img src="img/user.jpg" width="34px" height="34px" class="mr-3" alt="...">
                                <div class="media-body flex-column mx-2 ">
                                <p class="my-0 "id="user">Asked By  '.$row2['user_email'].' at '.$thread_time.'</p>
                                <h5 class="mt-0"><a href="thread.php?threadid='.$id.'" class="text-dark">'.htmlspecialchars($title).'</a></h5>
                                <p>'.htmlspecialchars($desc).'</p>
                            </div>
                        </div>';
                }
                if($noresult){
                    echo '<div class="jumbotron jumbotron-fluid bg-light">
                    <div class="container">
                      <p class="display-4">No thread found</p>
                      <p class="lead">Be the first person to ask a question.</p>
                    </div>
                  </div>';
                }
        ?>

      

    </div>



    <?php include 'partial/_footer.php';?>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>
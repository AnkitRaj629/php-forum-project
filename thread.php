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
    #user{
        font-weight: bold;
    }
</style>
<body>
    <?php include 'partial/_header.php';?>
    <?php include 'partial/_dbconnect.php';?>
    
    <?php
    $id=$_GET['threadid'];
    $sql="SELECT * FROM `threads` WHERE thread_id=$id";
    $result=mysqli_query($conn,$sql);
    while($row=mysqli_fetch_assoc($result)){
        $title=$row['thread_title'];
        $desc=$row['thread_desc'];
        $thread_user_id=$row['thread_user_id'];
        $sql2="SELECT user_email FROM `users` WHERE sno=$thread_user_id";
        $result2=mysqli_query($conn,$sql2);
        $row2=mysqli_fetch_assoc($result2);
        $posted_by=$row2['user_email'];
    }
    ?>

<?php
    $showalert=false;
    $method=$_SERVER['REQUEST_METHOD'];
    if($method=='POST'){
        // insert comment into db
        
            
            $comment = mysqli_real_escape_string($conn, $_POST['comment']);
            
            $sno=$_POST['sno'];
            $sql="INSERT INTO `comment` (`coment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ('$comment', '$id', '$sno', current_timestamp())";
            $result=mysqli_query($conn,$sql);
            $showalert=true;
            if($showalert){
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success</strong> Your Comment has been added.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
            }
        
    }
    ?>

    <div class="container my-3">
        <div class="jumbotron">
            <h1 class="display-4"> <?php echo "$title"; ?> </h1>
            <p class="lead"> <?php echo "$desc"; ?></p>
            <hr class="my-4">
            <p>This is peer to peer forum for sharing knowledge with each other.
                Do not spam.
                Do Not Bump Posts.
                Do Not Offer to Pay for Help.
                Do Not Offer to Work For Hire.
                Do Not Post About Commercial Products.
                Do Not Create Multiple Accounts (Sockpuppets)
                When creating links to other resources.</p>
            <p>Posted by: <em><?php echo $posted_by; ?></em></p>
        </div>
    </div>
    
<?php
 if(isset($_SESSION['loggedin'])&& $_SESSION['loggedin']==true){
  echo  '<div class="container">
    <form action="'.$_SERVER["REQUEST_URI"].'" method="post">
    <h1 class="py-2">Post your Comment here</h1>
          
    <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Type your comment</label>
        <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
        <input type="hidden" name="sno" value="'.$_SESSION["sno"].'">
    </div>
    <button type="submit" class="btn btn-success">Post</button>
</form>
</div>';
 }
 else{
    echo '<div class="container">
    <h1 class="py-2">Post your comment here</h1>
    <p>You need to logged-in to post a comment.</p>
</div>';
 }
?>

<div class="container">
    
    <h1 class="py-2">Discussions</h1>
    
    <?php
                    $id=$_GET['threadid'];
                    $sql="SELECT * FROM `comment` WHERE thread_id= $id";
                    $result=mysqli_query($conn,$sql);
                    $noresult=true;
                    while($row=mysqli_fetch_assoc($result)){
                        $noresult=false;
                        $id=$row['comment_id'];
                        $content=$row['coment_content'];
                        $comment_time=$row['comment_time'];
                        $thread_user_id=$row['comment_by'];
                        $sql2="SELECT user_email FROM `users` WHERE sno=$thread_user_id";
                        $result2=mysqli_query($conn,$sql2);
                        $row2=mysqli_fetch_assoc($result2);
                    
                        
                        echo '<div class="d-flex my-3">
                        <img src="img/user.jpg" width="34px" height="34px" class="mr-3" alt="...">
                        <div class="media-body flex-column mx-2 ">
                        <p class="my-0 "id="user">By '.$row2['user_email'].' at '.$comment_time.'</p>

                        '.htmlspecialchars($content).'
                        </div>
                        </div>';
                }
                if($noresult){
                    echo '<div class="jumbotron jumbotron-fluid bg-light">
                    <div class="container">
                    <p class="display-4">No comment found</p>
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
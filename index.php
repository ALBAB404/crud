
<?php 

$db = mysqli_connect('localhost','root','','user_management');

?>

<!-- create -->

<?php
$errormsg = '';

if (isset($_POST['saveinfo'])) {
    $name = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $upass = sha1($pass);

    $sql2 = "INSERT INTO users (name,email,pass) VALUE ('$name','$email','$upass')";

    $res3 = mysqli_query($db,$sql2);
    
    if (empty($name)) {
        $errormsg = 'oi ghor filup kor';
    }




}


?>


<!-- delete  -->

<?php

if (isset($_GET['del_id'])) {
    $delID = $_GET['del_id'];
   $sql3 =  "DELETE FROM users where id ='$delID'";
   $res3 = mysqli_query($db,$sql3);


}


?>


<!-- update  -->

<?php

 if(isset($_POST['upinfo'])) {
    $name = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $role = $_POST['role'];
    $status = $_POST['status'];
    $id = $_POST['up_id'];

    
    if (!empty($pass)) {
        $upass = sha1($pass);
        $sql5 = "UPDATE users SET name='$name',email='$email',pass='$upass',role='$role',status='$status' WHERE id = '$id' ";
    }
    if (empty($pass)) {
       
        $sql5 = "UPDATE users SET name='$name',email='$email',role='$role',status='$status' WHERE id = '$id' ";
    }

    $res5 = mysqli_query($db,$sql5);
    
    
}

?>





<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> User Management</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>

    <div class="users m-4">
        <div class="row g-0">
            <div class="col-md-4">
                <h3> Add a new user</h3>

                <form class="my-5"method = "POST">
                       <div class="mb-3">
                        <label for="username" class="form-label">Enter your name</label>
                        <input type="text" name="username" class="form-control" id="username" placeholder="Fullname">
                        <?php
                        echo "<small class = 'text-danger'>".$errormsg."</small>";
                        ?>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Email address</label>
                        <input type="email"name="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label"> Password </label>
                        <input type="password"name="password" class="form-control" id="Password"placeholder="password">
                        <small class="text-danger"> Password should be minimum 6 char long </small>
                    </div>

                    <input type="submit" class="btn btn-sd btn-info" value=" Add new user" name="saveinfo">

                   
                </form>

                <!-- edit information  -->

            
                <h3> update users</h3>

                <?php 
                
                if (isset($_GET['edit_id'])) {

                    $editid = $_GET['edit_id'];

                    $sql = "SELECT * FROM users where id= '$editid'";

                    $res = mysqli_query($db,$sql);

                    $row = mysqli_fetch_assoc($res);

                    $name = $row['name'];
                    $email = $row['email'];
                    $pass = $row['pass'];
                    $role = $row['role'];
                    $status = $row['status'];
                    

                    ?>
                    <form class="my-5"method = "POST">
                       <div class="mb-3">
                        <label for="username" class="form-label">Enter your name</label>
                        <input type="text" name="username" class="form-control" id="username" placeholder="Fullname" value = "<?php echo $name;?>">
                        
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Email address</label>
                        <input type="email"name="email"value = "<?php echo $email;?>" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label"> Set a New Password </label>
                        <input type="password"name="password" class="form-control" id="Password"placeholder="password">
                        <label for="">set admin panel</label>
                        <select name="role" id="" class="form-control mt-3">
                            <option value="2" <?php if($role == 2) echo 'selected'; ?>>Admin</option>
                            <option value="1" <?php if($role == 1) echo 'selected'; ?>>Editor</option>
                            <option value="0" <?php if($role == 0) echo 'selected'; ?>>Subscriber</option>
                        </select>
                        <label for="">set status panel</label>
                        <select name="status" id="" class="form-control mt-3">
                            <option value="1" <?php if($status == 1) echo 'selected'; ?>>Active</option>
                            <option value="0" <?php if($status == 0) echo 'selected'; ?>>Inactive</option>
                        </select>

                        <input type="hidden" value = "<?php echo $editid;?>" name = "up_id">
                    </div>

                    <input type="submit" class="btn btn-sd btn-info" value=" Add new user" name="upinfo">

                    

                   
                </form>
                <?php

                   
                    

                    
                }
                ?>

                
                

                
            </div>
            <div class="col-md-8">
                <h3 class="ms-5"> All users information</h3>
           <table class="table m-5 table-striped">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Email</th>
                  <th scope="col">UserRole</th>
                  <th scope="col">Status</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                

                <?php
                
                $sql1 = "SELECT * FROM users";
                $res1 = mysqli_query($db,$sql1);
                $serial = 0;

            while ($row = mysqli_fetch_assoc($res1)) {
                
                
                $id =   $row['id'];
                $name =   $row['name'];
                $email =   $row['email'];
                $role =   $row['role'];
                $status =   $row['status'];
                $pass =   $row['pass'];
                $serial++

                ?>
                <tr>
                  <th scope="row"><?php echo $serial;?></th>
                  <td><?php echo $name;?></td>
                  <td><?php echo $email;?></td>
                  <td><?php 
                  
                  if ($role == 2) {
                    echo "<small class = 'badge bg-danger'>Admin</small>";
                  }
                  
                  if ($role == 1) {
                    echo "<small class = 'badge bg-info'>Editor</small>";
                  }
                  
                  if ($role == 0) {
                    echo "<small class = 'badge bg-success'>Subscriber</small>";
                  }
                  ?></td>
                  <td><?php 
                  if ($status == 1) {
                    echo "<small class = 'badge bg-info'>Active</small>";
                  }
                  
                  if ($status == 0) {
                    echo "<small class = 'badge bg-success'>Inactive</small>";
                  }
                  ?></td>
                  <td>
                      <a href="index.php?edit_id=<?php echo $id; ?>" class="badge bg-success">Edit</a>
                       <a href="index.php?del_id=<?php echo $id; ?>" class="badge bg-danger">Delete</a>
                  </td>
                </tr>

                <?php
                
            }

                
                ?>
             


              </tbody>
            </table>
                            
            </div>
        </div>
    </div>

     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  

</body>
</html>
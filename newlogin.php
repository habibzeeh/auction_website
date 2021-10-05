
<?php


$pagename = 'newlogin.php';
$loginout = '<a href ="logout.php">Logout</a>';

$heading = 'Login/Register';
include 'models/user.php';

session_start();



?>

<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


<div class="w3-row">

<div class="w3-col m7 l9">

<form   action='newlogin.php' method='post' class="w3-container w3-card-4 w3-light-grey w3-text-blue w3-margin">
<h2 class="w3-center">Signup</h2>
 
<div class="w3-row w3-section">
  <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-user"></i></div>
    <div class="w3-rest">
      <input class="w3-input w3-border" type='text' name='first_name' id='name' placeholder="First Name">
    </div>
</div>

<div class="w3-row w3-section">
  <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-user"></i></div>
    <div class="w3-rest">
      <input class="w3-input w3-border" type='text' name='last_name' id='name' placeholder="Last Name">
    </div>
</div>

<div class="w3-row w3-section">
  <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-envelope-o"></i></div>
    <div class="w3-rest">
      <input class="w3-input w3-border" type='text' name='email' id='email' placeholder="Email">
    </div>
</div>

<div class="w3-row w3-section">
  <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-key"></i></div>
    <div class="w3-rest">
      <input class="w3-input w3-border" type='password' name='password' id='password' placeholder="Password">
    </div>
</div>
<input name="signup" hidden>
<button class="w3-button w3-block w3-section w3-blue w3-ripple w3-padding">Signup</button>

</form>


</div>







<div class="w3-col m5 l3">
<form  action="newlogin.php" method="POST"  class="w3-container w3-card-4 w3-light-grey w3-text-blue w3-margin">
<h2 class="w3-center">Login</h2>

<div class="w3-row w3-section">
  <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-envelope-o"></i></div>
    <div class="w3-rest">
      <input class="w3-input w3-border" id="email" name="email" type="email" placeholder="Email">
    </div>
</div>

<div class="w3-row w3-section">
  <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-key"></i></div>
    <div class="w3-rest">
      <input class="w3-input w3-border" type='password' name='password' id='password' placeholder="Password">
    </div>
</div>
<input name="login" hidden>
<button class="w3-button w3-block w3-section w3-blue w3-ripple w3-padding">Login</button>

</form>
</div>




</div>


<?php



$db = new db();


if (isset($_POST['signup'])) {
    // $stmt = $db->pdo->prepare('INSERT INTO users (first_name, last_name, email, password, role)  VALUES (:first_name, :last_name, :email, :password, :role)');
    // $values = [
    //     'first_name' => $_POST['first_name'],
    //     'last_name'  => $_POST['last_name'],
    //     'email'     => $_POST['email'],
    //     'password'  => password_hash($_POST['password'], PASSWORD_DEFAULT),
    //     'role' => 'user'
    //   ];
      
    //   // var_dump($values);
    // $stmt->execute($values);

    $stmt = $db->pdo->prepare('INSERT INTO users (first_name, last_name, email, password, role)  VALUES (:first_name, :last_name, :email, :password, :role)');
    $values = [
        'first_name' => $_POST['first_name'],
        'last_name'  => $_POST['last_name'],
        'email'     => $_POST['email'],
        'password'  => password_hash($_POST['password'], PASSWORD_DEFAULT),
        'role' => 'user'
    ];
      
    $stmt->execute($values);

    $mesage = 'Successfuly registed';
    echo $mesage;

} 
 if (isset($_POST['login'])) {

    $user = new user($_POST['email']);
    

    $select = $db->pdo->prepare('SELECT * FROM users WHERE email=:email');
    $values = [
        'email' => $_POST['email']
    ];
    $select->execute($values);
    $data = $select->fetch();
    //var_dump($data);
    $userp = $data['password'];




    // echo 'from database: '.$userp;
    // echo 'post: '.$_POST['password'];

    if (password_verify($_POST['password'], $data['password'])) {
    $_SESSION['user'] = $user->userInfo();
        

       // echo '<a href ="logout.php">Logout</a>';
    header ('Location: controller.php?page=profile');

    }
    else {
    echo 'Sorry, your account could not be found';
    }
 
    } else {
        $message = 'You did not enter the correct details, please try again.';
 
    }
// }


?>




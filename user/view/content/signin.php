<?php
    session_start();
    include("../../../database/connect.php");
    include("../../controller/singinController.php");

    $signinController = new SigninController($conn);
    $warning ="";
    if(isset($_POST['username'],$_POST['password'])){
        $warning_empty = "  <div class='notify' style='color: red;'>
                                <i class='fa-solid fa-circle-exclamation'></i>
                                username or password cannot be empty
                            </div>";
        $warning_wrong = "  <div class='notify' style='color: red;'>
                                <i class='fa-solid fa-circle-exclamation'></i>
                                Username or password is wrong, please check again
                            </div>";
        if(empty($_POST['username']) || empty($_POST['password'])){
            $warning = $warning_empty;
        }else{
            $result = $signinController->check($_POST['username'], $_POST['password']);
            if(!strcmp($result,"admin")){
                $_SESSION['username'] = $_POST['username'];
                header("location: ../../../admin/view/main.php");
            }else if(!strcmp($result,"user")){
                $_SESSION['username'] = $_POST['username'];
                header("location: ../../../index.php");
            }else{
                $warning = $warning_wrong;
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/component.css">
    <link rel="stylesheet" href="../../assets/css/sign_in_up.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <header class="header">
        <a href="../../../index.php" class="logo">
        <img src="../../assets/img/logo.png" alt="LOGO">
        </a>

        <h1>Sign In</h1>
        <div class="clear-header"></div>
    </header>

    <main>
        <div class="wrapper wrapper-signin">
            <div class="wrapper-content">
                <h1>Sign in</h1> 
                <form action="" method="post">
                    <input type="text" name="username" id="username" placeholder="Username/Email">
                    <input type="password" name="password" id="password" placeholder="password">
                    <?php echo "$warning" ?>
                    <button type="submit">Đăng nhập</button>
                </form>
                <div class="link">
                    <a href="#">Forgot password</a>
                    <a href="#">Log In with Phone Number</a>
                </div>
                <div class="divide">
                    <hr> <span>OR</span> <hr>
                </div>

                <div class="divide-button">
                    <button class="btn-icon">
                        <img class="img-icon img-icon-gg" src="../../assets/img/icon_gg.png" alt="icon google">
                        google
                    </button>
                    <button class="btn-icon">
                        <img class="img-icon img-icon-fb" src="../../assets/img/icon_fb.png" alt="icon facebook">
                        facebook
                    </button>
                </div>

                <div class="btn-signup">No account? <a href="./signup.php">Sign Up</a></div>
            </div>
        </div>
    </main>

    <?php include("../components/footer.php"); ?>
    <script src="../../assets/script/main.js"></script>
</body>
</html>
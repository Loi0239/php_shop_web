<?php
    include("../../../database/connect.php");
    include("../../controller/singupController.php");

    $signupController = new SignupController($conn);
    $warning ="";
    if(isset($_POST['username'],$_POST['password'],$_POST['email'],$_POST['phonenumber'])){
        $warning_empty = "  <div class='notify' style='color: red;'>
                                <i class='fa-solid fa-circle-exclamation'></i>
                                information cannot be empty
                            </div>";
        $warning_susses = " <div class='notify' style='color:green'>
                                <i class='fa-solid fa-circle-exclamation'></i>
                                You have failed registered an account
                            </div>";
        $warning_susses = "  <div class='notify' style='color:green'>
                                <i class='fa-solid fa-circle-exclamation'></i>
                                You have successfully registered an account
                            </div>";
        if(empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email']) || empty($_POST['phonenumber'])){
            $warning = $warning_empty;
        }else{
            $result = $signupController->insert($_POST['username'], $_POST['password'],$_POST['email'], $_POST['phonenumber']);
            if($result){
                $warning = $warning_susses;
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
    <title>Đăng ký</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/component.css">
    <link rel="stylesheet" href="../../assets/css/sign_in_up.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <header class="header">
        <a href="../../../index.php" class="logo">
        <img src="https://cdn.logo.com/hotlink-ok/logo-social.png" alt="LOGO">
        </a>

        <h1>Sign Up</h1>
        <div class="clear-header"></div>
    </header>

    <main>
        <div class="wrapper wrapper-signup">
            <div class="wrapper-content">
                <h1>Sign up</h1>
                <form action="" method="post">
                    <input type="text" name="username" id="username" placeholder="Username">
                    <input type="password" name="password" id="password" placeholder="password">
                    <input type="email" name="email" id="email" placeholder="email">
                    <input type="text" name="phonenumber" id="phonenumber" placeholder="phonenumber">
                    <?php echo "$warning" ?>
                    <button type="submit">Đăng ký</button>
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

                <div class="btn-signup">Have an account? <a href="./signin.php">Sign In</a></div>
            </div>
        </div>
    </main>

    <?php include("../components/footer.php"); ?>
    <script src="../../assets/script/main.js"></script>
</body>
</html>
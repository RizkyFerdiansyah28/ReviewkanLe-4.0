<?php 
    session_start();
    if(!isset($_SESSION["login"])){
        include 'layout/header-guest.php';
    } else include 'layout/header.php';

    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $result = register_user($_POST);
        if ($result > 0) {
            echo "<script>alert('Registrasi berhasil!');
            document.location.href = 'login.php';
            </script>
            
            ";
            
        } else {
            echo "<script>alert('Registrasi gagal atau username sudah ada.');</script>";
        }
    }
?>


<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-12 col-sm-8 col-md-6 m-auto">
            <div class="card">
                <div class="card-body">
                    <h1 class="text-center">Sign Up</h1>
                    <form action="" method="POST">
                        <input type="text" name="username" id="username" class="form-control my-3 py-2"
                            placeholder="username" required />
                        <input type="Email" name="email" id="email" class="form-control my-3 py-2" required
                            placeholder="email" />
                        <input type="Password" name="password" id="password" class="form-control my-3 py-2" required
                            placeholder="Password" />
                        <div class="text-center mt-3">
                            <button name="register" type="submit" id="register" class="btn btn-primary">Sign Up</button>
                        </div>
                    </form>
                    <a href="login.php" class="nav-link text-primary text-center text-py-10">Login</a>
                </div>
            </div>
        </div>
    </div>
</div>
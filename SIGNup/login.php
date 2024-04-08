<?php
session_start(); //is this the messing piece
if(isset($_SESSION['id'])){ //This is not working why??
    echo<<<_END
    <script>
    document.location.href = '../new_dashboard/home.php' 
    </script>
    _END;
}
else{
    echo<<<_END
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>AMS</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
        <link rel="stylesheet" href="login.css">
    </head>
    <body>
        <div class="split-screen">
            <div class="left">
                <section class="copy">
                    <h1>Assignment Management System</h1>
                    <p>Your interactivity for any course.</p>
                </section>
            </div>
            <div class="right">
                <form action="authenticate.php" method="POST">
                    <section class="copy">
                        <h2>Login</h2>
                        <div class="login-container">
                            <p>Don't have an account? <a href="signup.html"><strong>Signup</strong></a></p>
                        </div>
                    </section>
                    <div class="input-container email">
                        <label for="email">Email</label>
                        <input id="email" name="email" type="email">
                    </div>
                    <div class="input-container password">
                        <label for="password">Password</label>
                        <input id="password" name="password" type="password" placeholder="Must be at least 6 characters">
                        <span class="material-symbols-outlined">
                            visibility_off
                            </span>
                    </div>
                    <button class="signup-btn" type="submit">Login</button>
                </form>
            </div>
        </div>
    </body>
    </html>
    _END;
}

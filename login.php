<?php
session_start();

$users = [
    "admin" => "12345"
];

$error = "";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (isset($users[$username]) && $users[$username] === $password) {
        $_SESSION['username'] = $username;
        header("Location: tugas2.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
         * {
      box-sizing: border-box;
      margin: 10px;
      padding: 5px;
    }

        body {
            font-family: Arial, sans-serif;
            background-color: rgb(0, 119, 255);
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            }

            .login-box {
            height: 60vh;
            width: 30vw;
            margin: auto;
            border: 5px solid orange;   
            border-radius: 10px;       
            padding: 20px 40px;        
            background: white;         
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.42); 
            text-align: center;
            }
            
            
         h2 { 
            text-align: center;
            color: orange; }
            
            input[type="text"],
            input[type="password"] {
                text-align: center;
                width: 100%;
                padding: 8px;
                border: 2px solid orange;
                border-radius: 7px;

            }
            
             button {
                width: 50%;
                padding: 8px;
                background: blue;
                border: 2px solid black;
                border-radius: 5px;
                cursor: pointer;
          
            }

             button:hover {
      background: rgb(0, 119, 255);
      color: white;
    }
    </style>
</head>
<body>
    <div class="login-box">
    <h2>Login Data Warga</h2>
    <?php if ($error): ?>
        <p class="error"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="post" action="">
        <div class="form-row">
            <label>Username:</label><br>
            <input type="text" name="username" required>
        </div>

        <div class="form-row">
            <label>Password:</label><br>
            <input type="password" name="password" required>
        </div>

        <button type="submit">Login</button>
    </form>
    </table>
    
</body>
</html>
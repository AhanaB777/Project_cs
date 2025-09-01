<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CS Department Portal</title>
    <link rel="stylesheet" href="styles.css">
    <script defer src="script.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: url('welcome_page_background.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
            overflow-y: auto;
        }
        
        .welcome-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 100%;
            padding: 20px;
            position: relative;
        }
        
        .logo {
            width: 120px;
            height: auto;
            margin-bottom: 20px;
            opacity: 0.9;
            animation: logoFadeIn 1.5s ease-in-out, logoBounce 2s infinite ease-in-out;
        }
        
        .glassmorphic-card {
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(15px);
            border-radius: 15px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2);
            max-width: 500px;
            animation: fadeIn 1s ease-in-out;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: transform 0.1s ease-out;
            position: relative;
        }
        
        h1 {
            font-size: 2.2rem;
            margin-bottom: 10px;
        }
        
        p {
            font-size: 1.2rem;
            opacity: 0.8;
        }
        
        .buttons {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 24px;
            text-decoration: none;
            color: white;
            background: rgba(0, 140, 255, 0.7);
            border-radius: 8px;
            transition: all 0.3s ease-in-out;
            position: relative;
            overflow: hidden;
            font-weight: 600;
        }
        
        .btn::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.3);
            transition: left 0.3s;
        }
        
        .btn:hover::before {
            left: 100%;
        }
        
        .btn:hover {
            background: rgba(0, 140, 255, 1);
            transform: scale(1.05);
            box-shadow: 0px 0px 10px rgba(0, 140, 255, 0.8);
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes logoFadeIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        @keyframes logoBounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const card = document.querySelector(".glassmorphic-card");
            
            document.addEventListener("mousemove", (e) => {
                const { clientX: x, clientY: y } = e;
                const { innerWidth: width, innerHeight: height } = window;
                
                const moveX = (x / width - 0.5) * 20;
                const moveY = (y / height - 0.5) * 20;
                
                card.style.transform = `translate(${moveX}px, ${moveY}px)`;
            });
        });
    </script>
</head>
<body>
    <div class="welcome-container">
        <img src="welcome_page_logo.png" alt="CS Department Logo" class="logo">
        <div class="glassmorphic-card">
            <h1>Welcome to the CS Department Portal</h1>
            <p>Your gateway to all things Computer Science</p>
            <div class="buttons">
                <a href="login/login_page.php" class="btn">Faculty Login</a>
                <a href="index.php" class="btn">Homepage</a>
            </div>
        </div>
    </div>
</body>
</html>

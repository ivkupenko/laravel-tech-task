<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <style>
        :root {
            --black: #000;
            --white: #fff;
            --gray: #777;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: var(--white);
            color: var(--black);
            font-family: "Inter", "Helvetica Neue", Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            overflow: hidden;
        }

        .container {
            text-align: center;
            position: relative;
            z-index: 2;
            animation: fadeIn 1.2s ease;
        }

        h1 {
            font-size: 4rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
            position: relative;
        }

        h1::after {
            content: "";
            display: block;
            width: 60px;
            height: 4px;
            background: var(--black);
            margin: 1rem auto 0;
        }

        p {
            font-size: 1.2rem;
            color: var(--gray);
            letter-spacing: 0.03em;
            margin-top: 1rem;
        }

        a.button {
            margin-top: 2rem;
            display: inline-block;
            padding: 0.9rem 2.5rem;
            border: 2px solid var(--black);
            color: var(--black);
            text-decoration: none;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.1em;
            transition: all 0.3s ease;
        }

        a.button:hover {
            background-color: var(--black);
            color: var(--white);
        }

        footer {
            position: absolute;
            bottom: 1.5rem;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 0.85rem;
            color: var(--gray);
        }

        /* Background geometry */
        .bg-shape {
            position: absolute;
            width: 300px;
            height: 300px;
            border: 2px solid var(--black);
            opacity: 0.05;
            border-radius: 50%;
            animation: rotate 20s linear infinite;
        }

        .bg-shape:nth-child(1) {
            top: -100px;
            left: -100px;
        }

        .bg-shape:nth-child(2) {
            bottom: -100px;
            right: -100px;
            animation-delay: -10s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        @media (max-width: 600px) {
            h1 {
                font-size: 2.5rem;
            }

            p {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
<div class="bg-shape"></div>
<div class="bg-shape"></div>

<div class="container">
    <h1>Welcome</h1>
    <p>A clean, modern start for my new app.</p>
    <a href="<?php echo e(route('login')); ?>" class="button">Login</a>
    <a href="<?php echo e(route('register')); ?>" class="button">Register</a>
</div>

<footer>&copy; <?php echo e(date('Y')); ?> Crafted by Me and some one else</footer>
</body>
</html>
<?php /**PATH /var/www/html/resources/views/welcome.blade.php ENDPATH**/ ?>
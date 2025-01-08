<head>
    <title>HealthTrak</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="../public/style.css">
    <style>
        .brand{
            background: #9face6;
        }
        .brand-text{
            color: blue !important;
            font-weight: bold;
            font-family: Poppins, sans-serif;
        }
        form{
            max-width: 460px;
            margin: 20px auto;
            padding: 20px;
        }

        
        :root {
            --primary-color: #072d44;
            --primary-color2: #064469;
            --secondary-color: #1976D2;
            --secondary-color2: #5790ab;
            --text-color: #00ff00;
            --text-color3: #00ffff;
            --background-color: #d0d7e1;
            --card-background: #ffffff;
            --card-background2: #9ccddb;
        }

        .container {
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            flex-direction: column; 

        }

        body {
            background-color: var(--background-color);
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .past-appointments .no-appointments {
            padding: 20px;
            background-color: #f8d7da;
            border-radius: 5px;
            border: 1px solid #f5c6cb;
            color: #721c24;
            text-align: center;
            font-size: 1.2em;
        }

        .past-appointments .no-appointments p {
            margin: 0;
            padding: 10px;
        }

        .documents-list .no-documents {
            padding: 20px;
            background-color: #d1ecf1;
            border-radius: 5px;
            border: 1px solid #bee5eb;
            color: #0c5460;
            text-align: center;
            font-size: 1.2em;
        }


        .documents-list .no-documents p {
            margin: 0;
            padding: 10px;
        }

        .medical-history .no-history {
            padding: 20px;
            background-color: #d4edda;
            border-radius: 5px;
            border: 1px solid #c3e6cb;
            color: #155724;
            text-align: center;
            font-size: 1.2em;
        }

        .medical-history .no-history p {
            margin: 0;
            padding: 10px;
        }


        /* -----------Dashboard ---------------*/

        .dashboard {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .settings{
            background-color: #333333;
            border: 1px solid #ddd;
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 24px;
            height: 24px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0
            margin: 0;
            text-decoration: none;
        }

        .settings i{
            font-size: 24px;
            color: #2196F3;
            line-height: 1;
        }

        .settings i:hover{
            color:rgb(13, 72, 121);
        }

        .profile {
            display: inline-block;
            border-radius: 50%; /* Ensures the profile is circular */
            overflow: hidden; /* Hides anything outside the circle */
            transition: box-shadow 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

        .profile:hover {
            transform: scale(1.1); /* Slight zoom-in effect */
            box-shadow: 0 0 10px #00e6e6, 0 0   20px #00e6e6, 0 0 30px #00e6e6; /* Neon glow */
        }

        .profile:hover::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 2px solid #00e6e6;
            box-shadow: 0 0 10px #00e6e6, 0 0 20px #00e6e6, 0 0 30px #00e6e6;
            animation: neon-glow 1.5s infinite alternate;
        }


        .profile-picture {
            text-align: center;
            margin-bottom: 10px;
        }

        .profile-picture img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #2196F3;
        }

        /* -----------prescriptions ---------------*/
        
        .prescriptions-list {
            text-align: center;
            margin: 20px auto;
            padding: 20px;
        }

        .no-prescriptions {
            background-color: #f9f9f9;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 20px auto;
        }


        .no-prescriptions p {
            margin: 10px 0;
            font-size: 18px;
            color: #555;
        }

        ul li a{
            display: flex;
            align-items: center;
            justify-content: center;
            height: auto; /* Adjusts height automatically */
            padding: 0.75rem 1.5rem;
            line-height: normal;
        }

        .material-icons {
            color: var(--primary-color);
        }

        .welcome {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 2rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .welcome h1 {
            margin: 0;
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #f5f5f5;
        }

        .welcome p {
            margin: 0;
            color: var(--text-color);
        }

        p{
            color: #333333;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .card {
            background: var(--card-background);
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h3 {
            color: var(--primary-color);
            margin-top: 0;
            margin-bottom: 1rem;
            font-size: 1.25rem;
        }

        .stats {
            font-size: 2rem;
            font-weight: bold;
            color: var(--secondary-color);
            margin: 1rem 0;
        }

        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background-color: var(--primary-color);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            text-align: center;
            margin-top: 1rem;
        }

        .btn:hover {
            background-color: var(--secondary-color);
        }

        .nav-wrapper {
            padding: 0 2rem;
        }

        #nav-mobile {
            display: flex;
            gap: 1rem;
        }

        /*menu bar for mobile*/
        /* Style for the menu icon */
.menu-icon {
    width: 32px;
    height: 32px;
    cursor: pointer;
}

/* Dropdown menu styles */
#dropdown-menu {
    display: none;
    position: absolute;
    top: 60px; /* Adjust based on the navbar height */
    right: 10px;
    background: white;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    list-style: none;
    padding: 0;
    margin: 0;
    z-index: 1000;
    overflow: hidden;
}

#dropdown-menu li {
    border-bottom: 1px solid #e0e0e0;
}

#dropdown-menu li:last-child {
    border-bottom: none;
}

#dropdown-menu li a {
    display: block;
    padding: 1rem 1.5rem;
    text-decoration: none;
    color: #333;
    font-size: 1rem;
}

#dropdown-menu li a:hover {
    background-color: #f5f5f5;
    color: #000;
}

/* Sidebar styling */
.sidebar {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #ffffff;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar a {
            padding: 12px 8px 12px 32px;
            text-decoration: none;
            font-size: 18px;
            color: #333333;
            display: flex;
            transition: 0.3s;
        }

        .sidebar a i {
            margin-right: 10px;
            font-size: 24px;
            color: #666666;
        }

        .sidebar a:hover {
            background-color: #f5f5f5;
            color: #2196f3;
        }

        .sidebar a:hover i {
            color: #2196F3;
        }

        .menu-icon {
            cursor: pointer;
            top: 10px;
            left: 10px;
            z-index: 2;
        }

        /* Push content when sidebar opens */
        #main {
            transition: margin-left .5s;
            padding: 16px;
        }

        /* --------------keyframes */
        @keyframes neon-glow {
            from {
                box-shadow: 0 0 10px #00e6e6, 0 0 20px #00e6e6, 0 0 30px #00e6e6;
            }
            to {
                box-shadow: 0 0 15px #00ffff, 0 0 25px #00ffff, 0 0 35px #00ffff;
            }
        }

        /* Responsive layout */
        @media screen and (min-width: 993px) {
            .menu-icon {
                display: none;
            }
        }


        footer {
            position: relative;
            bottom: 0;
            width: 100%;
        }



        @media (max-width: 768px) {
            .dashboard {
                padding: 1rem;
            }
            
            .grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body class="grey lighten-4">
    <nav class="white ">
        <div class="container">
            <a href="dashboard.php" class="brand-logo brand-text">HealthTrak</a>
           

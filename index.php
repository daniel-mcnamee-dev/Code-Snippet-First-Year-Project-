<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta Information & Stylesheets -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Code Snippet - Your file repository for coding snippets, programming tutorials, and learning resources for student programmers">
    <meta name="keywords" content="programming, coding, code snippets, programming languages, learning resources, repository, student programmers, coding tutorials, learning resources, web development, programming portfolio, code management, learning to code, coding practice">

    <!-- Page Title -->
    <title>Home Page</title>
    
    <!-- External Style Sheets -->
    <link rel="stylesheet" type="text/css" href="css/landing-page/style.css">
    
    <!-- Font and Icon Links -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;300;400;500;600;700;800&family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>

<body>

    <!-- Off-Screen Menu -->
    <div class="offScreenMenu">
        <button class="closeMenu">&times;</button> 
        <ul id="menuItems">
            <a href="login-reg.php" id="loginMenuItem">
                <li>Login</li>
            </a>
            <a href="library.php">
                <li>Library</li>
            </a>
            <a href="about.php">
            <li>About</li>
            </a>
        </ul>
    </div>

    <!-- Main Content Section -->
    <div class="stack-area">

        <!-- Navigation Bar -->
        <nav>
            <header>Code Snippet</header>
            <div class="hamMenu">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </nav>

        <!-- Left Section: Introduction and Features -->
        <div class="left">
            <div class="title">Our Features</div>
            <div class="sub-title">
                Code Snippet is an intuitive and efficient platform designed for aspiring and experienced programmers 
                to store, organize, and access code snippets and learning notes. 
                <br><br>
                Whether you're studying new programming concepts, experimenting with different coding techniques, or building 
                a personal knowledge base, our platform ensures that your essential code and insights are always within reach. 
                <br><br>
                With a user-friendly interface and robust organizational features, Code Snippet helps streamline your learning 
                process, making it easier to reference past work, improve coding skills, and enhance productivity.
                <br>
                <div id="accountSection">
                    <a href="login-reg.php" id="createAccountLink">
                        <button id="createAccountBtn">Create Account</button>
                    </a>
                    <div id="welcomeMessage" style="display: none; font-weight: bold; margin-top: 10px;"></div>
                </div>
            </div>
        </div>

        <!-- Right Section: Features Cards -->
        <div class="right">
            <div class="card">
                <div class="sub">Organization</div>
                <div class="content">Effortlessly organize code and learning resources.</div>
                <div class="prompt">Scroll for more</div>
            </div>
            <div class="card">
                <div class="sub">Productivity</div>
                <div class="content">Boost productivity through organized code access.</div>
            </div>
            <div class="card">
                <div class="sub">Facilitated learning</div>
                <div class="content">Empower learning through efficient code management.</div>
            </div>
            <div class="card">
                <div class="sub">Asset Management</div>
                <div class="content">Store reusable code for quick retrieval and seamless use.</div>
            </div>
        </div>
    </div>

<!-- JavaScript -->
<script src="java/landing-page/java.js"></script>
<script>
    // Wait for DOM to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM fully loaded');
        // Check login status immediately when DOM is ready
        checkLoginStatus();
    });

    function checkLoginStatus() {
        // First, try to get login info from PHP session
        fetch('php/login-reg/session_check.php', {
            method: 'GET',
            credentials: 'include' // Important for cookies/session
        })
        .then(response => response.json())
        .then(data => {
            console.log('Login status data:', data);
            if (data && data.logged_in) {
                // User is logged in via session
                updateUIForLoggedInUser(data.user_name);
                
                // Update localStorage for redundancy
                localStorage.setItem('userLoggedIn', 'true');
                localStorage.setItem('userName', data.user_name);
            } else {
                // Fallback to localStorage if session check fails
                checkLoginStatusFromLocalStorage();
            }
        })
        .catch(error => {
            console.error('Error checking session:', error);
            // Fallback to localStorage if fetch fails
            checkLoginStatusFromLocalStorage();
        });
    }

    function checkLoginStatusFromLocalStorage() {
        const isLoggedIn = localStorage.getItem('userLoggedIn') === 'true';
        const userName = localStorage.getItem('userName');
        
        if (isLoggedIn && userName) {
            updateUIForLoggedInUser(userName);
            return true;
        }
        return false;
    }

    function updateUIForLoggedInUser(userName) {
        console.log('Updating UI for logged-in user:', userName);
        
        // Update create account button/link
        const createAccountBtn = document.getElementById('createAccountBtn');
        const createAccountLink = document.getElementById('createAccountLink');
        if (createAccountBtn) createAccountBtn.style.display = 'none';
        if (createAccountLink) createAccountLink.style.display = 'none';
        
        // Show welcome message
        const welcomeMessage = document.getElementById('welcomeMessage');
        if (welcomeMessage) {
            welcomeMessage.textContent = `Welcome, ${userName}!`;
            welcomeMessage.style.display = 'block';
        }
        
        // Update login menu item to logout
        const loginMenuItem = document.getElementById('loginMenuItem');
        if (loginMenuItem) {
            loginMenuItem.setAttribute('href', 'javascript:void(0);');
            const menuItemText = loginMenuItem.querySelector('li');
            if (menuItemText) menuItemText.textContent = 'Logout';
            
            // Add click event for logout
            loginMenuItem.onclick = function(e) {
                e.preventDefault();
                handleLogout();
                return false;
            };
        }
    }

    function handleLogout() {
        // Clear localStorage
        localStorage.removeItem('userLoggedIn');
        localStorage.removeItem('userName');
        
        // Redirect to logout script
        window.location.href = 'php/login-reg/session_check.php?action=logout';
    }
</script>
</body>

</html>
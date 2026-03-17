<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta Information -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Code Snippet - Your file repository for coding snippets, programming tutorials, and learning resources for student programmers">
    <meta name="Keywords" content="user account, secure login, student programmer, registration, coding account, programming portfolio, code snippet access, user authentication, password recovery, developer account, coding resource access">

    <!-- External Style Sheets -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/login-reg/style.css">
    
    <!-- Page Title -->
    <title>Login and Registration</title>

    <!-- Font and Icon Links -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@10..48,200;10..48,300;10..48,400;10..48,500;10..48,600;10..48,700;10..48,800&family=IBM+Plex+Mono:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Round|Material+Icons+Sharp|Material+Icons+Two+Tone" rel="stylesheet">
</head>

<body>
    <!-- Close Screen / Back to Landing Page -->
     <a href="index.php">
    <button class="closeMenu">&times;</button> 
    </a>

    <!-- Wrapper Start -->
    <div class="wrapper">

        <!-- Form Header: Titles for Login/Register -->
        <div class="form-header">
            <div class="titles">
                <div class="title-login">Login</div>
                <div class="title-register">Register</div>
                <div class="title-forgot">Forgot Password</div>
            </div>
        </div>

        <!-- LOGIN FORM -->
<form class="login-form" autocomplete="off">
    <!-- Email Input -->
    <div class="input-box">
        <input type="text" class="input-field" id="log-email" name="email" required>
        <label for="log-email" class="label">Email</label>
        <i class='bx bx-envelope icon'></i>
    </div>

    <!-- Password Input (with Checkbox for Show/Hide) -->
    <div class="input-box">
        <input type="checkbox" name="checkbox" id="show-password-log">
        <div class="password">
            <div class="back"></div>
            <input type="password" id="password" name="password" placeholder="Password">
            <label for="show-password-log"></label>
        </div>
    </div>

    <!-- Forgot Password Link -->
    <div class="form-cols">
        <div class="col-1"></div>
        <div class="col-2">
            <a href="#">Forgot password?</a>
        </div>
    </div>

    <!-- Sign In Button -->
    <div class="input-box">
        <button type="submit" class="btn-submit" id="SignInBtn">Sign In <i class='bx bx-log-in'></i></button>
    </div>

    <!-- Switch to Register Form -->
    <div class="switch-form">
        <span>Don't have an account? <a href="#" onclick="registerFunction()">Register</a></span>
    </div>
</form>

<!-- FORGOT PASSWORD FORM -->
<form class="forgot-password-form" autocomplete="off">
    <!-- Step 1: Email Input -->
    <div class="forgot-step" id="forgot-step-1">
        <div class="input-box">
            <input type="text" class="input-field" id="forgot-email" name="email" required>
            <label for="forgot-email" class="label">Email</label>
            <i class='bx bx-envelope icon'></i>
        </div>
        
        <div class="input-box">
            <button type="button" class="btn-submit" id="verifyEmailBtn">Verify Email <i class='bx bx-envelope-open'></i></button>
        </div>
    </div>

    <!-- Step 2: Security Question -->
    <div class="forgot-step" id="forgot-step-2" style="display: none;">
        <div class="security-question-display">
            <h4>Security Question:</h4>
            <p id="security-question-text"></p>
        </div>
        
        <div class="input-box">
            <input type="text" class="input-field" id="forgot-answer" name="security_answer" required>
            <label for="forgot-answer" class="label">Your Answer</label>
            <i class='bx bx-shield icon'></i>
        </div>
        
        <div class="input-box">
            <button type="button" class="btn-submit" id="verifyAnswerBtn">Verify Answer <i class='bx bx-check-shield'></i></button>
        </div>
    </div>

    <!-- Step 3: New Password -->
    <div class="forgot-step" id="forgot-step-3" style="display: none;">
        <div class="input-box">
            <input type="checkbox" name="" id="show-password-forgot">
            <div class="password">
                <div class="back"></div>
                <input type="password" id="new-password" name="new_password" placeholder="New Password">
                <label for="show-password-forgot"></label>
            </div>
        </div>

        <div class="input-box">
            <button type="button" class="btn-submit" id="resetPasswordBtn">Reset Password <i class='bx bx-lock-open'></i></button>
        </div>
    </div>

    <!-- Return to Login Form -->
    <div class="switch-form">
        <span><a href="#" onclick="loginFunction()">Back to Login</a></span>
    </div>
</form>

        <!-- REGISTER FORM -->
<form class="register-form" autocomplete="off">
    <!-- Username Input -->
    <div class="input-box">
        <input type="text" class="input-field" id="reg-name" name="name" required>
        <label for="reg-name" class="label">Username</label>
        <i class='bx bx-user icon'></i>
    </div>

    <!-- Email Input -->
    <div class="input-box">
        <input type="text" class="input-field" id="reg-email" name="email" required>
        <label for="reg-email" class="label">Email</label>
        <i class='bx bx-envelope icon'></i>
    </div>

    <!-- Password Input (with Checkbox for Show/Hide) -->
    <div class="input-box">
        <input type="checkbox" name="" id="show-password-reg">
        <div class="password">
            <div class="back"></div>
            <input type="password" id="password-reg" name="password" placeholder="Password">
            <label for="show-password-reg"></label>
        </div>
    </div>

    <!-- Security Question Section -->
    <div class="input-box">
        <select class="input-field security-select" id="security-question" name="security_question" required>
            <option value="" disabled selected>Select a security question</option>
            <option value="pet">What was your first pet's name?</option>
            <option value="school">What was the name of your first school?</option>
            <option value="city">What city were you born in?</option>
            <option value="maiden">What was your mother's maiden name?</option>
        </select>
        <i class='bx bx-lock-alt icon'></i>
    </div>

    <div class="input-box">
        <input type="text" class="input-field" id="security-answer" name="security_answer" required>
        <label for="security-answer" class="label">Security Answer</label>
        <i class='bx bx-shield icon'></i>
    </div>

    <!-- Terms & Conditions Checkbox -->
    <div class="form-cols">
        <div class="col-1">
            <input type="checkbox" id="agree" required>
            <label for="agree"> I agree to </label>
            <a href="#" id="openTermsModal" class="terms-button">terms & conditions</a>
        </div>
        <div class="col-2"></div>
    </div>

    <!-- Sign Up Button -->
    <div class="input-box">
        <button type="submit" class="btn-submit" id="SignUpBtn">Sign Up <i class='bx bx-user-plus'></i></button>
    </div>

    <!-- Switch to Login Form -->
    <div class="switch-form">
        <span>Already have an account? <a href="#" onclick="loginFunction()">Login</a></span>
    </div>
</form>

    </div>

<!-- Terms & Conditions Modal -->
<div id="termsModal" class="terms-modal-hidden">
    <div class="terms-modal-overlay">
        <div class="terms-modal-container">
            <div class="terms-modal-header">
                <h2>Terms and Conditions</h2>
                <button id="closeTermsModal" class="terms-modal-close">&times;</button>
            </div>
            <div class="terms-modal-body">
                <p>This website is developed as part of an educational 
                    student project for college coursework and is provided on an 'as is' basis. Users acknowledge and accept that 
                    they access and use this site at their own risk. <br> <br> Welcome to our website. If you continue to browse and use this website, you are agreeing to comply with and be 
                    bound by the following terms and conditions of use.</p>
                
                <h3>1. Terms of Use</h3>
                <p>The content of the pages of this website is for your general information and use only. It is subject to change without notice.</p>
                
                <h3>2. Privacy Policy</h3>
                <p>Your use of this website is subject to our Privacy Policy. We respect your privacy and are committed to protecting your personal data.</p>
                
                <h3>3. User Account</h3>
                <p>When you create an account with us, you must provide information that is accurate, complete, and current at all times. Failure to do so constitutes a breach of the Terms, which may result in immediate termination of your account.</p>
                
                <h3>4. Prohibited Activities</h3>
                <p>You are prohibited from using the site or its content: (a) for any illegal purpose; (b) to solicit others to perform or participate in any unlawful acts; (c) to violate any regulations, rules, laws, or local ordinances.</p>
                
                <h3>5. Termination</h3>
                <p>We may terminate or suspend your account immediately, without prior notice or liability, for any reason whatsoever, including without limitation if you breach the Terms.</p>
                
                <h3>6. Limitations of Liability</h3>
                <p>In no event shall we be liable for any indirect, consequential, exemplary, incidental, special, or punitive damages, including lost profit, arising from your use of the service.</p>
            </div>
        </div>
    </div>
</div>
    <!-- Wrapper End -->

    <!-- External JavaScript -->
    <script src="java/login-reg/java.js"></script>

<!-- Internal JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check login status
        fetch('php/login-reg/session_check.php')
            .then(response => response.json())
            .then(data => {
                console.log('Login status:', data);
                const loginButton = document.getElementById('SignInBtn');
                const registerButton = document.getElementById('SignUpBtn');
                
                if (data.logged_in) {
                    // User is logged in
                    if (loginButton) {
                        loginButton.textContent = 'Logout';
                        loginButton.parentElement.parentElement.action = 'php/login-reg/session_check.php?action=logout';
                        
                        // Change form submission behavior for logout
                        document.querySelector('.login-form').onsubmit = function(e) {
                            e.preventDefault();
                            window.location.href = 'php/login-reg/session_check.php?action=logout';
                        };
                    }
                    if (registerButton) {
                        registerButton.style.opacity = '0';
                        registerButton.style.pointerEvents = 'none';
                    }
                }
            })
            .catch(error => console.error('Error checking login status:', error));
    });
</script>

</body>

</html>


<!-- 
Update landing page when user is logged in so Create Account Opacity = 0; and Login Button changes to Logout Button
Have Login Page take you back to landing page once logged in.
-->
const loginForm = document.querySelector(".login-form");
const registerForm = document.querySelector(".register-form");
const wrapper = document.querySelector(".wrapper");
const loginTitle = document.querySelector(".title-login");
const registerTitle = document.querySelector(".title-register");
const signUpBtn = document.querySelector("#SignUpBtn");
const signInBtn = document.querySelector("#SignInBtn");

function loginFunction(){
    loginForm.style.left = "50%";
    loginForm.style.opacity = 1;
    registerForm.style.left = "150%";
    registerForm.style.opacity = 0;
    forgotPasswordForm.style.left = "150%"; // Move it off-screen
    forgotPasswordForm.style.opacity = 0;   // Make it invisible
    wrapper.style.height = "500px";
    loginTitle.style.top = "50%";
    loginTitle.style.opacity = 1;
    registerTitle.style.top = "50px";
    registerTitle.style.opacity = 0;
    forgotTitle.style.top = "-60px";       // Move it up and out of view
    forgotTitle.style.opacity = 0;         // Make it invisible
    
    // Clear any status messages
    clearStatusMessages();
    
    // Reset forgot password form to first step
    document.getElementById('forgot-step-1').style.display = 'block';
    document.getElementById('forgot-step-2').style.display = 'none';
    document.getElementById('forgot-step-3').style.display = 'none';
}

function registerFunction(){
    loginForm.style.left = "-50%";
    loginForm.style.opacity = 0;
    registerForm.style.left = "50%";
    registerForm.style.opacity = 1;
    wrapper.style.height = "680px"; 
    loginTitle.style.top = "-60px";
    loginTitle.style.opacity = 0;
    registerTitle.style.top = "50%";
    registerTitle.style.opacity = 1;
    
    // Clear any status messages
    clearStatusMessages();
}

// Get elements for the login and registration password visibility
var showPasswordLogin = document.getElementById('show-password-log');
var passwordFieldLogin = document.getElementById('password');

var showPasswordRegister = document.getElementById('show-password-reg');
var passwordFieldRegister = document.getElementById('password-reg');

// Toggles password visibility for login
showPasswordLogin.addEventListener('change', function() {
    if (showPasswordLogin.checked) {
        passwordFieldLogin.type = 'text'; // Shows password as plain text
        passwordFieldLogin.style.webkitTextSecurity = 'none'; // Remove dots
    } else {
        passwordFieldLogin.type = 'password'; // Hides password as dots
        passwordFieldLogin.style.webkitTextSecurity = 'disc'; // Dots for password
    }
});

// Toggles password visibility for registration
showPasswordRegister.addEventListener('change', function() {
    if (showPasswordRegister.checked) {
        passwordFieldRegister.type = 'text'; // Shows password as plain text
        passwordFieldRegister.style.webkitTextSecurity = 'none'; // Remove dots
    } else {
        passwordFieldRegister.type = 'password'; // Hides password as dots
        passwordFieldRegister.style.webkitTextSecurity = 'disc'; // Dots for password
    }
});

// Function to show status message
function showStatusMessage(form, message, isSuccess) {
    // Removes any existing status message
    clearStatusMessages();
    
    // Creates new status message element
    const statusDiv = document.createElement('div');
    statusDiv.className = `status-message ${isSuccess ? 'success' : 'error'}`;
    statusDiv.textContent = message;
    
    // Insert before the switch-form div
    const switchForm = form.querySelector('.switch-form');
    form.insertBefore(statusDiv, switchForm);
    
    // Auto remove success messages after 3 seconds
    if (isSuccess) {
        setTimeout(() => {
            statusDiv.remove();
        }, 3000);
    }
}

// Function to clear all status messages
function clearStatusMessages() {
    const statusMessages = document.querySelectorAll('.status-message');
    statusMessages.forEach(msg => msg.remove());
}

// Function to save user data to localStorage
function saveUserToLocalStorage(userData) {
    localStorage.setItem('userLoggedIn', 'true');
    localStorage.setItem('userName', userData.name);
    localStorage.setItem('userId', userData.id);
}

// Handle login form submission
loginForm.addEventListener('submit', function(e) {
    e.preventDefault(); // Prevents default form submission
    
    // Get form data
    const formData = new FormData(loginForm);
    
    // Submit form using fetch API with absolute path
    fetch(`/php/login-reg/log.php`, {
        method: 'POST',
        body: formData,
        credentials: 'include' // Important for handling cookies/sessions
    })
    .then(response => {
        console.log('Raw response:', response);
        // Check if the response is JSON
        const contentType = response.headers.get('content-type');
        if (contentType && contentType.includes('application/json')) {
            return response.json();
        }
        throw new Error('Expected JSON response but got ' + contentType);
    })
    .then(data => {
        console.log('Login response:', data);
        if (data.success) {
            showStatusMessage(loginForm, data.message, true);
            
            // Save user data to localStorage
            if (data.user) {
                saveUserToLocalStorage(data.user);
            }
            
            // Redirects to index.php after successful login
            setTimeout(() => {
                window.location.href = 'index.php';
            }, 1000);
        } else {
            showStatusMessage(loginForm, data.message, false);
        }
    })
    .catch(error => {
        showStatusMessage(loginForm, 'An error occurred. Please try again.', false);
        console.error('Error:', error);
    });
});

// Adds Forgot password functionality
document.addEventListener('DOMContentLoaded', function() {
    // Get forgot password link
    const forgotPwdLink = document.querySelector('.login-form .col-2 a');
    if (forgotPwdLink) {
        forgotPwdLink.addEventListener('click', function(e) {
            e.preventDefault();
            forgotPasswordFunction();
        });
    }
});

// Handle registration form submission
registerForm.addEventListener('submit', function(e) {
    e.preventDefault(); // Prevents default form submission
    
    // Check if terms & conditions checkbox is checked
    const agreeCheckbox = document.getElementById('agree');
    if (!agreeCheckbox.checked) {
        showStatusMessage(registerForm, 'Please agree to the terms and conditions.', false);
        return;
    }

    // Reset error state when checkbox is clicked
    document.getElementById('agree').addEventListener('change', function() {
    if (this.checked) {
        this.parentElement.classList.remove('checkbox-error');
        // Remove any error message related to the checkbox
        const errorMessages = document.querySelectorAll('.status-message.error');
        errorMessages.forEach(msg => {
            if (msg.textContent.includes('terms and conditions')) {
                msg.remove();
            }
        });
    }
});
    
    // Get form data
    const formData = new FormData(registerForm);
    
    // Submit form using fetch API with absolute path
    fetch(`/php/login-reg/reg.php`, {
        method: 'POST',
        body: formData,
        credentials: 'include' // Important for handling cookies/sessions
    })
    .then(response => {
        console.log('Raw response:', response);
        // Check if the response is JSON
        const contentType = response.headers.get('content-type');
        if (contentType && contentType.includes('application/json')) {
            return response.json();
        }
        throw new Error('Expected JSON response but got ' + contentType);
    })
    .then(data => {
        console.log('Registration response:', data);
        if (data.success) {
            showStatusMessage(registerForm, data.message, true);
            
            // Clear form fields on successful registration
            registerForm.reset();
            
            // Switch to login form after 2 seconds
            setTimeout(() => {
                loginFunction();
                showStatusMessage(loginForm, 'Registration successful! You can now login.', true);
            }, 2000);
        } else {
            showStatusMessage(registerForm, data.message, false);
        }
    })
    .catch(error => {
        showStatusMessage(registerForm, 'An error occurred. Please try again.', false);
        console.error('Error:', error);
    });
});

// Get the forgot password form
const forgotPasswordForm = document.querySelector(".forgot-password-form");
const forgotTitle = document.querySelector(".title-forgot");

// Function to show forgot password form
function forgotPasswordFunction() {
    loginForm.style.left = "-50%";
    loginForm.style.opacity = 0;
    registerForm.style.left = "150%";
    registerForm.style.opacity = 0;
    forgotPasswordForm.style.left = "50%";
    forgotPasswordForm.style.opacity = 1;
    wrapper.style.height = "430px";
    loginTitle.style.top = "-60px";
    loginTitle.style.opacity = 0;
    registerTitle.style.top = "-60px";
    registerTitle.style.opacity = 0;
    forgotTitle.style.top = "50%";
    forgotTitle.style.opacity = 1;
    
    // Reset to first step
    document.getElementById('forgot-step-1').style.display = 'block';
    document.getElementById('forgot-step-2').style.display = 'none';
    document.getElementById('forgot-step-3').style.display = 'none';
    
    // Clear any status messages
    clearStatusMessages();
}

// Toggle password visibility for forgot password
document.addEventListener('DOMContentLoaded', function() {
    
    // Add the forgot password toggle functionality
    const showPasswordForgot = document.getElementById('show-password-forgot');
    if (showPasswordForgot) {
        showPasswordForgot.addEventListener('change', function() {
            const newPassword = document.getElementById('new-password');
            if (this.checked) {
                newPassword.setAttribute('type', 'text');
            } else {
                newPassword.setAttribute('type', 'password');
            }
        });
    }
});

// Handle verify email button click
document.getElementById('verifyEmailBtn').addEventListener('click', function() {
    const email = document.getElementById('forgot-email').value;
    
    if (!email) {
        showStatusMessage(forgotPasswordForm, 'Please enter your email address.', false);
        return;
    }
    
    // Create form data
    const formData = new FormData();
    formData.append('email', email);
    formData.append('action', 'verifyEmail');
    
    // Fetch security question for the email
    fetch(`/php/login-reg/forgot_password.php`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Store the user's email in sessionStorage for later use
            sessionStorage.setItem('resetEmail', email);
            
            // Display the security question
            document.getElementById('security-question-text').textContent = data.security_question;
            
            // Show step 2
            document.getElementById('forgot-step-1').style.display = 'none';
            document.getElementById('forgot-step-2').style.display = 'block';
            wrapper.style.height = "500px";
        } else {
            showStatusMessage(forgotPasswordForm, data.message, false);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showStatusMessage(forgotPasswordForm, 'An error occurred. Please try again.', false);
    });
});

// Handle verify answer button click
document.getElementById('verifyAnswerBtn').addEventListener('click', function() {
    const answer = document.getElementById('forgot-answer').value;
    const email = sessionStorage.getItem('resetEmail');
    
    if (!answer) {
        showStatusMessage(forgotPasswordForm, 'Please enter your answer.', false);
        return;
    }
    
    // Create form data
    const formData = new FormData();
    formData.append('email', email);
    formData.append('security_answer', answer);
    formData.append('action', 'verifyAnswer');
    
    // Verify security answer
    fetch(`/php/login-reg/forgot_password.php`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show step 3
            document.getElementById('forgot-step-2').style.display = 'none';
            document.getElementById('forgot-step-3').style.display = 'block';
        } else {
            showStatusMessage(forgotPasswordForm, data.message, false);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showStatusMessage(forgotPasswordForm, 'An error occurred. Please try again.', false);
    });
});

// Handle reset password button click
document.getElementById('resetPasswordBtn').addEventListener('click', function() {
    const newPassword = document.getElementById('new-password').value;
    const email = sessionStorage.getItem('resetEmail');
    
    if (!newPassword) {
        showStatusMessage(forgotPasswordForm, 'Please enter a new password.', false);
        return;
    }
    
    // Create form data
    const formData = new FormData();
    formData.append('email', email);
    formData.append('new_password', newPassword);
    formData.append('action', 'resetPassword');
    
    // Reset password
    fetch(`/php/login-reg/forgot_password.php`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showStatusMessage(forgotPasswordForm, data.message, true);
            
            // Clear session storage
            sessionStorage.removeItem('resetEmail');
            
            // Switch back to login after successful reset
            setTimeout(() => {
                loginFunction();
                showStatusMessage(loginForm, 'Password reset successful! You can now login.', true);
            }, 2000);
        } else {
            showStatusMessage(forgotPasswordForm, data.message, false);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showStatusMessage(forgotPasswordForm, 'An error occurred. Please try again.', false);
    });
});

//Terms Modal Functionality
document.addEventListener('DOMContentLoaded', function() {
    // Get elements
    const termsLink = document.getElementById('openTermsModal');
    const termsModal = document.getElementById('termsModal');
    const closeButton = document.getElementById('closeTermsModal');
    
    // Function to show modal
    function showTermsModal() {
        termsModal.className = 'terms-modal-visible';
        document.body.style.overflow = 'hidden'; // Prevent scrolling
    }
    
    // Function to hide modal
    function hideTermsModal() {
        termsModal.className = 'terms-modal-hidden';
        document.body.style.overflow = ''; // Re-enable scrolling
    }
    
    // Add click event to the terms link
    if (termsLink) {
        termsLink.addEventListener('click', function(e) {
            e.preventDefault();
            showTermsModal();
        });
    }
    
    // Add click event to close button
    if (closeButton) {
        closeButton.addEventListener('click', hideTermsModal);
    }
    
    // Close when clicking outside the modal content
    window.addEventListener('click', function(e) {
        if (e.target === termsModal.querySelector('.terms-modal-overlay')) {
            hideTermsModal();
        }
    });
    
    // Close with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            hideTermsModal();
        }
    });
    
    // Make sure modal is hidden on page load
    hideTermsModal();
});

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape' && termsModal.style.display === 'block') {
        termsModal.style.display = 'none';
        document.body.style.overflow = 'auto'; // Re-enable scrolling
    }
});
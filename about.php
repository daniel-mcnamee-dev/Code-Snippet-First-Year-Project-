<!DOCTYPE html>
<?php
// Start the session at the very top of your file
session_start();

// Check if user is logged in
$logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
$user_name = $_SESSION['user_name'] ?? null;
?>
<html lang="en">

<head>
    <!-- Meta data for SEO -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Code Snippet - Your file repository for coding snippets, programming tutorials, and learning resources for student programmers">
    <meta name="keywords" content="code repository, programming education, coding practice, developer resources, learning platform, software development, computer science">

    <!-- Page Title -->
    <title>Code Snippet - Programming Education Resource</title>
    
    <!-- External Style Sheets -->
    <link rel="stylesheet" href="css/about/style.css">

    <!-- Favicon -->
    <link rel="icon" href="/api/placeholder/32/32" type="image/x-icon">
</head>

<body>
    <!-- Header with logo and navigation -->
    <header>
        <div class="container">
            <div class="logo">
                <img src="images/Logo1_no_text.png" alt="Code Snippet Logo">
                <h1>Code Snippet</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="library.php">Library</a></li>
                    <li><a href="about.php">About</a></li>
                    <?php if ($logged_in): ?>
                        <li><a href="..WebDevProject_WIP/php/landing-page/logout.php" id="logoutLink">Logout (<?php echo htmlspecialchars($user_name); ?>)</a></li>
                    <?php else: ?>
                        <li><a href="login-reg.php" id="loginLink">Login</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    
    <!-- Hero section with background image -->
    <div class="hero">
        <div class="hero-content">
            <h2>Master Your Coding Journey</h2>
            <p>Store, organize, and learn from your code snippets</p>
        </div>
    </div>

    <!-- Internal Styling-->
    <style>
        .hero {
            height: 400px;
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            margin-bottom: 2rem;
        }

        .hero-content {
            background-color: rgba(0, 0, 0, 0.6);
            padding: 2rem;
            border-radius: 5px;
        }
    </style>
    
    <div class="container">
        <!-- Example of inline styling -->
        <div style="background-color:rgb(225, 239, 248); padding: 15px; border-left: 5px solid #2f4786; margin-bottom: 2rem;">
            <h3>Welcome to Code Snippet</h3>
            <p>Your trusted repository for programming snippets and learning resources since 2025.</p>
        </div>
        
        <!-- Multi-column content -->
        <h2>Our Approach</h2>
        <div class="text-container multi-column">
            <p>At Code Snippet, we believe in learning by doing. Our platform focuses on helping student programmers create, store, and organize code snippets alongside detailed notes to enhance their learning journey.</p>
            
            <p>We emphasize practical coding experience with best practices for clean, efficient, and maintainable code. Our team of experienced developers and programming educators are passionate about guiding the next generation of coders.</p>
            
            <p>Whether you're just starting your programming journey, looking to expand your knowledge into new languages, or need a reliable place to store your coding solutions, we're here to help. Our services are tailored to support students at all levels.</p>
            
            <p>By choosing Code Snippet, you're not just storing code – you're building a personalized learning resource. Join us in our mission to make programming education more accessible and effective.</p>
            
            <p>Explore our website to learn more about our services, see examples of code snippets, and get inspired to create your own programming portfolio. We look forward to helping you excel in your coding journey!</p>
        </div>
        
        <!-- Main content with article, section, and aside -->
        <div class="main-content">
            <article>
                <div class="text-container">
                    <h2>Effective Programming Learning Strategies</h2>
                
                    <section id="learning-approaches" class="section-container">
                        <h3>Problem-Based Learning</h3>
                        <!-- url https://stock.adobe.com/ie/images/e-learning-graduate-certificate-program-concept-man-use-computer-laptop-for-online-study-internet-education-course-degree-study-knowledge-to-creative-thinking-idea-and-problem-solving-solutio/1113734957?prev_url=detail -->
                        <img src="images/Student_working_on_coding_problem.jpg" alt="Student working on coding problem" style="float: right; margin-left: 15px; margin-bottom: 15px; max-width: 300px; width: 100%;">
                        <p>Learning to code effectively requires a hands-on approach. Here are some proven strategies for mastering programming concepts:</p>
                        <ul>
                            <li>Work on small projects that solve real problems</li>
                            <li>Use code challenges from platforms like LeetCode and HackerRank</li>
                            <li>Participate in pair programming sessions</li>
                            <li>Break complex problems into smaller, manageable parts</li>
                            <li>Practice explaining your code to others</li>
                        </ul>
                    </section>
                    
                    <section id="code-organization" class="section-container">
                        <h3>Code Organization</h3>
                        <!-- url https://stock.adobe.com/uk/images/the-latest-interface-for-neurogenetics-research-combining-brain-scans-and-dna-sequencing-highlighting-neural-synapses-as-well-as-genetic-analysis-3d-rendering/949784956?prev_url=detail -->
                        <img src="images/Well_structured_code.jpg" alt="Well-organized code structure" style="float: left; margin-right: 15px; margin-bottom: 15px; max-width: 300px; width: 100%;">
                        <p>Organizing your code snippets effectively is crucial for learning. Here's our approach:</p>
                        <ul>
                            <li>Create libraries of reusable code patterns and solutions</li>
                            <li>Document your code with clear comments explaining the logic</li>
                            <li>Use consistent naming conventions across your projects</li>
                            <li>Apply proper indentation and formatting for readability</li>
                            <li>Tag snippets by language, concept, and difficulty level</li>
                        </ul>
                    </section>
                    
                    <section id="collaboration" class="section-container">
                        <h4>Learning Through Collaboration</h4>
                        <p>Programming is rarely a solo activity in professional environments. Learning to collaborate with other developers is essential. By sharing code snippets, participating in code reviews, and contributing to open-source projects, you can accelerate your learning and prepare for real-world programming work.</p>
                    </section>
                </div>
                
                <!-- Table of statistical information -->
                <section id="stats">
                    <h3>Programming Language Popularity</h3>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Language</th>
                                    <th>Job Market Demand</th>
                                    <th>Learning Curve</th>
                                    <th>Community Support</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Python</td>
                                    <td>Very High</td>
                                    <td>Low</td>
                                    <td>Excellent</td>
                                </tr>
                                <tr>
                                    <td>JavaScript</td>
                                    <td>Very High</td>
                                    <td>Medium</td>
                                    <td>Excellent</td>
                                </tr>
                                <tr>
                                    <td>Java</td>
                                    <td>High</td>
                                    <td>Medium</td>
                                    <td>Very Good</td>
                                </tr>
                                <tr>
                                    <td>C#</td>
                                    <td>High</td>
                                    <td>Medium</td>
                                    <td>Very Good</td>
                                </tr>
                                <tr>
                                    <td>Rust</td>
                                    <td>Growing</td>
                                    <td>High</td>
                                    <td>Good</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>
                
                <!-- Video section -->
                <section id="video">
                    <h3>How To Efficiently Learn Coding</h3>
                    <div class="video-container">
                        <!-- Embedding a video iframe -->
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/NtfbWkxJTHw?si=zqR5iO3pS_68DeDZ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                    <p><a href="https://www.youtube.com/watch?v=NtfbWkxJTHw" target="_blank">Watch video on YouTube</a></p>
                </section>
            </article>
            
            <aside>
                <h3 style="margin-bottom: 20px; margin-top: 20px;">Quick Tips</h3>
                <ol class="quick-tips">
                    <li>Code a little bit every day to build consistency</li>
                    <li>Read other people's code to learn different approaches</li>
                    <li>Use version control like Git for all your projects</li>
                    <li>Test your code regularly with unit tests</li>
                    <li style="margin-bottom: 50px;">Learn keyboard shortcuts for your IDE</li>
                </ol>
                
                <h4 style="margin-bottom: 20px;">Upcoming Workshops</h4>
                <ul class="workshop">
                    <li>April 15: Introduction to Python</li>
                    <li>May 3: Web Development Fundamentals</li>
                    <li>May 20: Data Structures and Algorithms</li>
                    <li style="margin-bottom: 50px;">June 10: Mobile App Development</li>
                </ul>
                
                <h4 style="margin-bottom: 20px;">External Resources</h4>
                <ul>
                    <li><a href="https://github.com" target="_blank">GitHub</a></li>
                    <li><a href="https://stackoverflow.com" target="_blank">Stack Overflow</a></li>
                    <li><a href="https://www.freecodecamp.org" target="_blank">freeCodeCamp</a></li>
                </ul>
                
                <!-- Contact form section -->
                <h4 style="margin-top: 30px; margin-bottom: 20px;">Contact Us</h4>
                <div class="form-container">
                    <form action="http://foo.com" method="get">
                        <div class="form-group">
                            <label for="name" class="required">Name</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email" class="required">Email</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="tel" id="phone" name="phone">
                        </div>
                        
                        <div class="form-group">
                            <label for="service" class="required">Topic</label>
                            <select id="service" name="service" required>
                                <option value="">-- Select a Topic --</option>
                                <option value="consultation">Learning Path Consultation</option>
                                <option value="design">Custom Snippet Organization</option>
                                <option value="installation">Platform Integration Help</option>
                                <option value="maintenance">Account Support</option>
                                <option value="workshop">Workshop Registration</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="message" class="required">Message</label>
                            <textarea id="message" name="message" rows="4" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="newsletter">
                                <input type="checkbox" id="newsletter" name="newsletter" value="yes"> Subscribe to our coding tips newsletter
                            </label>
                        </div>

                        <button type="submit">Send Message</button>
                    </form>
                </div>

                <!-- Google Maps integration -->
                <h4 style="margin-top: 30px; margin-bottom: 20px;">Visit Our Campus</h4>
                <div class="map-container">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2329.401580492886!2d-8.463897922998228!3d54.27916317257446!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x485ee84ef3fb4b37%3A0xc76b5b21d985fb79!2sAtlantic%20Technological%20University%20Sligo!5e0!3m2!1sen!2sie!4v1741345125578!5m2!1sen!2sie" width="100%" height="100%" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                </div>
                <address style="margin-bottom: 30px;">
                    ATU Sligo & ATU St Angelas<br>
                    College Rd, Sligo, Ireland<br>
                    <a href="tel:+35371915000">(071) 915 0000</a><br>
                    <a href="mailto:info@codesnippet.example">info@codesnippet.example</a>
                </address>
            </aside>
        </div>

        <!-- Gallery section with images -->
        <section id="gallery">
            <h2>Featured Code Snippets</h2>
            <div class="gallery-container">
                <!-- Python data analysis snippet -->
                <div class="snippet-group">
                    <h3>Python data analysis snippet</h3>
                    <div class="image-row">
                        <img src="images/PythonDataAnalysis.png" alt="Python data analysis snippet" class="snippet-image" onclick="openLightbox(this)">
                    </div>
                </div>
        
                <!-- JavaScript front-end code with multiple parts -->
                <div class="snippet-group">
                    <h3>JavaScript front-end code</h3>
                    <div class="image-row">
                        <img src="images/JavaScript_front-end_code_Part_1.png" alt="JavaScript front-end code part 1" class="snippet-image" onclick="openLightbox(this)">
                        <img src="images/JavaScript_front-end_code_Part_2.png" alt="JavaScript front-end code part 2" class="snippet-image" onclick="openLightbox(this)">
                        <img src="images/JavaScript_front-end_code_Part_3.png" alt="JavaScript front-end code part 3" class="snippet-image" onclick="openLightbox(this)">
                    </div>
                </div>
        
                <!-- Java object-oriented design -->
                <div class="snippet-group">
                    <h3>Java object-oriented design</h3>
                    <div class="image-row">
                        <img src="images/Java_object-oriented_design_Part1.png" alt="Java object-oriented design" class="snippet-image" onclick="openLightbox(this)">
                        <img src="images/Java_object-oriented_design_Part2.png" alt="Java object-oriented design" class="snippet-image" onclick="openLightbox(this)">
                    </div>
                </div>
        
                <!-- C# application framework -->
                <div class="snippet-group">
                    <h3>C# application framework</h3>
                    <div class="image-row">
                        <img src="images/C_Application_Frameworks.png" alt="C# application framework" class="snippet-image" onclick="openLightbox(this)">
                    </div>
                </div>
        
                <!-- SQL database queries -->
                <div class="snippet-group">
                    <h3>SQL database queries</h3>
                    <div class="image-row">
                        <img src="images/SQL_Database_Queries_Part_1.png" alt="SQL database queries" class="snippet-image" onclick="openLightbox(this)">
                        <img src="images/SQL_Database_Queries_Part_2.png" alt="SQL database queries" class="snippet-image" onclick="openLightbox(this)">
                    </div>
                </div>

                <!-- HTML structure -->
                <div class="snippet-group">
                    <h3>HTML structure</h3>
                    <div class="image-row">
                        <img src="images/HTML_structure_Part_1.png" alt="HTML structure" class="snippet-image" onclick="openLightbox(this)">
                        <img src="images/HTML_structure_Part_2.png" alt="HTML structure" class="snippet-image" onclick="openLightbox(this)">
                        <img src="images/HTML_structure_Part_3.png" alt="HTML structure" class="snippet-image" onclick="openLightbox(this)">
                    </div>
                </div>

                <!-- CSS component structure -->
                <div class="snippet-group">
                    <h3>CSS component structure</h3>
                    <div class="image-row">
                        <img src="images/CSS_component_structure_Part_1.png" alt="HTML structure" class="snippet-image" onclick="openLightbox(this)">
                        <img src="images/CSS_component_structure_Part_2.png" alt="HTML structure" class="snippet-image" onclick="openLightbox(this)">
                        <img src="images/CSS_component_structure_Part_3.png" alt="HTML structure" class="snippet-image" onclick="openLightbox(this)">
                    </div>
                </div>
        
                <!-- PHP component structure -->
                <div class="snippet-group">
                    <h3>PHP component structure</h3>
                    <div class="image-row">
                        <img src="images/PHP_component_structure_Part_1.png" alt="PHP component structure" class="snippet-image" onclick="openLightbox(this)">
                        <img src="images/PHP_component_structure_Part_2.png" alt="PHP component structure" class="snippet-image" onclick="openLightbox(this)">
                        <img src="images/PHP_component_structure_Part_3.png" alt="PHP component structure" class="snippet-image" onclick="openLightbox(this)">
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Lightbox Modal -->
    <div id="imageModal" class="modal">
        <span class="close" onclick="closeLightbox()">&times;</span>
        <div class="modal-content">
            <img id="modalImage">
            <div id="modalCaption"></div>
        </div>
    </div>

    <!-- Footer with navigation and copyright -->
    <footer>
        <div class="container">
            <div style="display: flex; flex-wrap: wrap; justify-content: space-between; margin-bottom: 1rem;">
                <div>
                    <div class="logo">
                        <img src="images/Logo1_no_text.png" alt="Code Snippet Logo" style="float: left;">
                        <h3>Code Snippet</h3>
                    </div>
                    <p>Empowering student programmers with organized learning resources.</p>
                </div>
                
                <div>
                    <h4>Navigation</h4>
                    <nav>
                        <ul>
                            <li><a href="index.php">Home</a></li>
                            <li><a href="library.php">Library</a></li>
                            <li><a href="about.php">About</a></li>
                            <?php if ($logged_in): ?>
                                <li><a href="..WebDevProject_WIP/php/landing-page/logout.php" id="logoutLink">Logout (<?php echo htmlspecialchars($user_name); ?>)</a></li>
                            <?php else: ?>
                                <li><a href="login-reg.php" id="loginLink">Login</a></li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
                
                <div>
                    <h4>Connect With Us</h4>
                    <ul>
                        <li><a href="https://github.com" target="_blank">GitHub</a></li>
                        <li><a href="https://twitter.com" target="_blank">Twitter</a></li>
                        <li><a href="https://discord.com" target="_blank">Discord</a></li>
                        <li><a href="https://youtube.com" target="_blank">YouTube</a></li>
                    </ul>
                </div>
            </div>
            
            <hr style="border: none; border-top: 1px solid rgba(255, 255, 255, 0.2); margin: 1rem 0;">
            
            <p>&copy; Copyright 2025 Code Snippet. All rights reserved.</p>
        </div>
    </footer>

    <!-- Script for lightbox -->
    <script src="../WebDevProject_WIP/java/about/java.js"></script>

    <!-- Script for session check -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check login status via AJAX
            fetch('php/login-reg/session_check.php', {
                method: 'GET',
                credentials: 'include' // Important for session cookies
            })
            .then(response => response.json())
            .then(data => {
                const navList = document.querySelector('nav ul');
                const loginItem = document.querySelector('nav ul li:last-child');

                if (data.logged_in) {
                    // User is logged in, show logout link
                    loginItem.innerHTML = `<a href="WebDevProject_WIP/php/landing-page/logout.php" id="logoutLink">Logout (${data.user_name})</a>`;
                } else {
                    // User is not logged in, show login link
                    loginItem.innerHTML = '<a href="login-reg.php" id="loginLink">Login</a>';
                }
            })
            .catch(error => console.error('Error checking login status:', error));
        });
    </script>

    <!-- Script for form validation -->
    <script>
         document.addEventListener('DOMContentLoaded', function() {
        // Form validation code (existing)
        const form = document.querySelector('form');
        
        form.addEventListener('submit', function(event) {
            let valid = true;
            const requiredFields = form.querySelectorAll('[required]');
            
            requiredFields.forEach(function(field) {
                if (!field.value.trim()) {
                    valid = false;
                    field.style.borderColor = 'red';
                } else {
                    field.style.borderColor = '#ddd';
                }
            });
            
            const email = form.querySelector('#email');
            if (email.value && !validateEmail(email.value)) {
                valid = false;
                email.style.borderColor = 'red';
                alert('Please enter a valid email address');
            }
            
            if (!valid) {
                event.preventDefault();
                alert('Please fill in all required fields correctly');
            }
        });
        
        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }
        
        // Mobile menu toggle (new)
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const navMenu = document.querySelector('nav ul');
        
        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', function() {
                navMenu.classList.toggle('active');
            });
        }
        
        // Add smooth scrolling to anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    window.scrollTo({
                        top: target.offsetTop - 70,
                        behavior: 'smooth'
                    });
                    
                    // Close mobile menu if open
                    navMenu.classList.remove('active');
                }
            });
        });
    });
    </script>
</body>
</html>
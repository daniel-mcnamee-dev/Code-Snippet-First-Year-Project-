<?php
    // Start session if not already started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Check if user is logged in
    $logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    $user_id = $logged_in ? $_SESSION['user_id'] : null;
    $user_name = $logged_in ? $_SESSION['user_name'] : null;
?>
<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Code Snippet - Your file repository for coding snippets, programming tutorials, and learning resources for student programmers">
    <meta name="keywords" content="code library, code storage, snippet management, programming files, code organization, learning resources, file repository, coding portfolio, programming snippets, developer tools, code collection, programming practice, folder organization, code documentation">

    <!-- Page Title -->
    <title>Code Snippets Library</title>

    <!-- External Style Sheets -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/library/library.css">
</head>

<body>
    <div class="library-container">
        <div class="navigation-buttons">
            <button class="btn" id="home-btn"><a href="index.php">Home</a></button>
            <?php if ($logged_in): ?>
                <span class="user-welcome">Welcome, <?php echo htmlspecialchars($user_name); ?></span>
                <a href="php/landing-page/logout.php" class="btn auto-width" id="logout-btn">Logout</a>
            <?php else: ?>
                <button class="btn" id="login-btn"><a href="login-reg.php">Login</a></button>
            <?php endif; ?>
        </div>

        <header class="header">
            <h1>My Code Library</h1>
            <div class="logo">
                <img src="images/Logo1_no_text.png" alt="Logo">
            </div>
            <div class="controls">
                <?php if ($logged_in): ?>
                    <button class="btn" id="new-folder-btn">New Folder</button>
                    <button class="btn" id="new-file-btn">New File</button>
                <?php else: ?>
                    <div class="login-prompt">Please login to manage your library</div>
                <?php endif; ?>
            </div>
        </header>

        <div class="file-explorer" id="folders-container">
            <!-- Folders and files will be dynamically added here -->
            <?php if (!$logged_in): ?>
                <div class="login-required-message">
                    <p>Please <a href="login-reg.php">log in</a> to view and manage your code library.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Open File Modal -->
        <div id="openFileModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <div id="open-file-modal-content">
                    <h2>File Content</h2>
                    <div id="open-file-name"></div>
                    <div id="open-file-content" tabindex="0"></div>
                </div>
            </div>
        </div>

        <!-- New File Modal -->
        <div id="newFileModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Create New File</h2>
                <input type="text" id="filename" placeholder="File Name" required>
                <textarea id="file-content" placeholder="Write your code here..." required></textarea>
                <button id="create-file-folder" class="btn">Save File</button>
            </div>
        </div>        

        <!-- New Folder Modal -->
        <div id="newFolderModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Create New Folder</h2>
                <input type="text" id="foldername" placeholder="Folder Name" required>
                <button id="create-folder-btn" class="btn">Create Folder</button>
            </div>
        </div>        
    </div>

    <div class="notification-container"></div>

    <!-- Pass user data to JavaScript -->
    <script>
        const userAuth = {
            loggedIn: <?php echo isset($_SESSION['logged_in']) && $_SESSION['logged_in'] ? 'true' : 'false'; ?>,
            userId: <?php echo isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 'null'; ?>,
            userName: <?php echo isset($_SESSION['username']) ? "'" . addslashes($_SESSION['username']) . "'" : 'null'; ?>
        };
    </script>

    <script src="/java/library/java.js"></script>

    <!-- Debug scripts  -->
    <script>
        console.log('Direct test script executed');
        
        // Wait for DOM to be ready
        document.addEventListener('DOMContentLoaded', function() {
          console.log('Folders found:', document.querySelectorAll('.folder').length);
          
          // Add direct event listeners to all folders
          document.querySelectorAll('.folder-info').forEach(function(folderInfo) {
            console.log('Adding click handler to folder:', folderInfo);
            
            // Remove existing click handlers
            folderInfo.onclick = null;
            
            // Add new direct click handler
            folderInfo.addEventListener('click', function(e) {
              console.log('Folder clicked directly');
              e.stopPropagation(); // Stop any other handlers
              
              const folder = this.closest('.folder');
              const fileList = folder.querySelector('.file-list');
              const toggleIcon = this.querySelector('.folder-toggle span');
              
              console.log('Before toggle:', fileList.classList.contains('collapsed'));
              
              if (fileList.classList.contains('collapsed')) {
                fileList.classList.remove('collapsed');
                toggleIcon.innerHTML = "&#x25BC;"; // Down arrow
                console.log('Expanded folder');
              } else {
                fileList.classList.add('collapsed');
                toggleIcon.innerHTML = "&#x25B6;"; // Right arrow
                console.log('Collapsed folder');
              }
              
              console.log('After toggle:', fileList.classList.contains('collapsed'));
              
              // Verify CSS is applied
              console.log('Current max-height:', window.getComputedStyle(fileList).maxHeight);
            });
          });
        });

        function checkCSSApplication() {
          const fileList = document.querySelector('.file-list');
          console.log('Initial file list max-height:', window.getComputedStyle(fileList).maxHeight);
          
          // Toggle class
          fileList.classList.toggle('collapsed');
          console.log('After toggle file list max-height:', window.getComputedStyle(fileList).maxHeight);
          
          // Toggle back
          fileList.classList.toggle('collapsed');
          console.log('Toggled back file list max-height:', window.getComputedStyle(fileList).maxHeight);
        }

        // Call this function from the console to test
        console.log('You can test CSS by typing checkCSSApplication() in the console');

        function debugOtherFilesSection() {
            console.log("Debugging Other Files section:");
            
            // Check if there are any unfiled files in the data
            fetch("/php/library/fetch-files.php" + (userAuth.loggedIn ? "?user_id=" + userAuth.userId : ""))
                .then(response => response.json())
                .then(fileData => {
                    const files = fileData.files || [];
                    const unfiledFiles = files.filter(file => !file.folder_id);
                    console.log(`Number of unfiled files found: ${unfiledFiles.length}`);
                    console.log("Unfiled files:", unfiledFiles);
                    
                    // Check if the unfiled-files section exists in the DOM
                    const unfiledSection = document.querySelector('.unfiled-files');
                    console.log("Unfiled section exists:", !!unfiledSection);
                    
                    if (unfiledSection) {
                        console.log("Unfiled section HTML:", unfiledSection.outerHTML);
                        console.log("File list in unfiled section:", unfiledSection.querySelector('.file-list'));
                        
                        // Check CSS visibility
                        const computedStyle = window.getComputedStyle(unfiledSection);
                        console.log("Unfiled section computed style:", {
                            display: computedStyle.display,
                            visibility: computedStyle.visibility,
                            opacity: computedStyle.opacity,
                            height: computedStyle.height,
                            maxHeight: computedStyle.maxHeight
                        });
                    }
                })
                .catch(error => {
                    console.error("Error debugging unfiled files:", error);
                });
        }

        // DOMContentLoaded event listener
        document.addEventListener('DOMContentLoaded', () => {
            
            // Debugging
            setTimeout(() => {
                if (userAuth.loggedIn) {
                    debugOtherFilesSection();
                }
            }, 2000); // Run 2 seconds after page load
        });
    </script>
</body>
</html>

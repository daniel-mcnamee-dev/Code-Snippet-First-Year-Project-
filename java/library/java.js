// Utility Functions
function showModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        // Center the modal
        modal.style.display = 'flex';
        const modalContent = modal.querySelector('.modal-content');
        modalContent.style.margin = 'auto';
        
        // Prevent background scrolling
        document.body.classList.add('modal-open');
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none';
        
        // Restore background scrolling
        document.body.classList.remove('modal-open');
    }
}

function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.classList.add('notification', type);
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Check for user authentication
function checkUserAuth() {
    // userAuth is defined in library.php
    if (typeof userAuth === 'undefined' || !userAuth.loggedIn) {
        // If user is not logged in, display appropriate message
        const folderContainer = document.getElementById('folders-container');
        if (folderContainer) {
            folderContainer.innerHTML = '<div class="login-required-message"><p>Please <a href="login-reg.php">log in</a> to view and manage your code library.</p></div>';
        }
        return false;
    }
    return true;
}

// File and Folder Management
function toggleFolder(element) {
    // Ensure we have the right element
    const folder = element.closest('.folder, .unfiled-files');
    if (!folder) {
      console.error('No folder found', element);
      return;
    }
    
    const fileList = folder.querySelector('.file-list');
    if (!fileList) {
      console.error('No file list found in folder', folder);
      return;
    }
    
    const toggleIcon = folder.querySelector('.folder-toggle span');
    if (!toggleIcon) {
      console.error('No toggle icon found in folder', folder);
      return;
    }
    
    console.log('Before toggle - Collapsed:', fileList.classList.contains('collapsed'));
    
    // Toggle the class
    if (fileList.classList.contains('collapsed')) {
      fileList.classList.remove('collapsed');
      toggleIcon.innerHTML = "&#x25BC;"; // Down arrow
    } else {
      fileList.classList.add('collapsed');
      toggleIcon.innerHTML = "&#x25B6;"; // Right arrow
    }
}

function createFileFromModal() {
    // Check if user is logged in
    if (!checkUserAuth()) {
        showNotification('You must be logged in to create files', 'error');
        return;
    }

    const filename = document.getElementById('filename').value.trim();
    const content = document.getElementById('file-content').value.trim();
    const folderId = document.getElementById('create-file-folder').dataset.folderId || null;
    const fileId = document.getElementById('create-file-folder').dataset.fileId || null;

    if (!filename || !content) {
        showNotification('Please provide both filename and content', 'error');
        return;
    }

    let data = {
        filename: filename,
        content: content,
        folderId: folderId,
        userId: userAuth.userId // Add user ID to the request
    };

    // If fileId exists, we're updating an existing file
    if (fileId) {
        data.id = fileId;
    }

    fetch('/php/library/save-file.php', {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {
            'Content-Type': 'application/json',
        }
    })
    .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showNotification(fileId ? 'File updated successfully!' : 'File saved successfully!');
            closeModal('newFileModal');
            
            // Clear input fields
            document.getElementById('filename').value = '';
            document.getElementById('file-content').value = '';
            document.getElementById('create-file-folder').dataset.fileId = '';
            
            // After creating/updating a file, fetch both files and folders to update the UI
            fetchFilesAndFolders();
        } else {
            throw new Error(data.message || 'Unknown error occurred');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification(error.message || 'Error occurred while saving the file', 'error');
    });
}

function editFile(id) {
    // Check if user is logged in
    if (!checkUserAuth()) {
        showNotification('You must be logged in to edit files', 'error');
        return;
    }

    fetch(`/php/library/fetch-file.php?id=${id}&userId=${userAuth.userId}`)
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            // Check if the user has access to this file
            if (data.error) {
                throw new Error(data.error);
            }
            
            // Populate the new file modal with the file data
            document.getElementById('filename').value = data.filename;
            document.getElementById('file-content').value = data.content;
            
            // Set the file ID in the create button's dataset
            const createFileBtn = document.getElementById('create-file-folder');
            createFileBtn.dataset.fileId = id;
            createFileBtn.dataset.folderId = data.folder_id || '';
            
            // Update modal title
            const modalTitle = document.getElementById('newFileModal').querySelector('h2');
            modalTitle.textContent = 'Edit File';
            
            showModal('newFileModal');
        })
        .catch(error => {
            console.error("Error fetching file:", error);
            showNotification(error.message || 'Failed to load file for editing', 'error');
        });
}

function createNewFolder() {
    // Check if user is logged in
    if (!checkUserAuth()) {
        showNotification('You must be logged in to create folders', 'error');
        return;
    }

    const foldername = document.getElementById('foldername').value.trim();
    const folderId = document.getElementById('create-folder-btn').dataset.folderId || null;

    if (!foldername) {
        showNotification('Please enter a folder name', 'error');
        return;
    }

    const data = new FormData();
    data.append('foldername', foldername);
    data.append('userId', userAuth.userId); // Add user ID to the request
    
    // If folderId exists, we're updating an existing folder
    if (folderId) {
        data.append('id', folderId);
    }

    fetch('/php/library/save-folder.php', {
        method: 'POST',
        body: data
    })
    .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
    })
    .then(responseData => {
        if (responseData.success) {
            showNotification(folderId ? 'Folder updated successfully!' : 'Folder created successfully!');
            closeModal('newFolderModal');
            
            // Clear input field and folder ID
            document.getElementById('foldername').value = '';
            document.getElementById('create-folder-btn').dataset.folderId = '';
            
            // Refresh folders and files
            fetchFilesAndFolders();
        } else {
            throw new Error(responseData.message || 'Unknown error occurred');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification(error.message || 'Error occurred while managing folder', 'error');
    });
}

function editFolder(id, name) {
    // Check if user is logged in
    if (!checkUserAuth()) {
        showNotification('You must be logged in to edit folders', 'error');
        return;
    }

    // Populate the folder modal with the folder data
    document.getElementById('foldername').value = name;
    
    // Set the folder ID in the create button's dataset
    const createFolderBtn = document.getElementById('create-folder-btn');
    createFolderBtn.dataset.folderId = id;
    
    // Update modal title
    const modalTitle = document.getElementById('newFolderModal').querySelector('h2');
    modalTitle.textContent = 'Edit Folder';
    
    showModal('newFolderModal');
}

// New function to prepare new file creation within a specific folder
function prepareNewFileInFolder(folderId, folderName) {
    // Check if user is logged in
    if (!checkUserAuth()) {
        showNotification('You must be logged in to create files', 'error');
        return;
    }

    document.getElementById('filename').value = '';
    document.getElementById('file-content').value = '';
    
    const createFileBtn = document.getElementById('create-file-folder');
    createFileBtn.dataset.folderId = folderId;
    createFileBtn.dataset.fileId = '';
    
    // Update modal title to show which folder the file will be created in
    const modalTitle = document.getElementById('newFileModal').querySelector('h2');
    modalTitle.textContent = `Create New File in "${folderName}"`;
    
    showModal('newFileModal');
}

// Combined function to fetch both files and folders
function fetchFilesAndFolders() {
    // Check if user is logged in
    if (!checkUserAuth()) {
        return;
    }

    // First fetch folders to create the structure
    fetch(`/php/library/fetch-folders.php?userId=${userAuth.userId}`)
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(folderData => {
            // Now fetch files to populate the folders
            fetch(`/php/library/fetch-files.php?userId=${userAuth.userId}`)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(fileData => {
                    // Process both data sets
                    renderFoldersAndFiles(folderData.folders || [], fileData.files || []);
                })
                .catch(error => {
                    console.error('File fetch error:', error);
                    showNotification('Failed to load files', 'error');
                });
        })
        .catch(error => {
            console.error('Folder fetch error:', error);
            showNotification('Failed to load folders', 'error');
        });
}

// Updated function to render both folders and files with toggle functionality
function renderFoldersAndFiles(folders, files) {
    const folderContainer = document.getElementById('folders-container');
    
    // Clear existing content
    folderContainer.innerHTML = '';
    
    // Create unfiled files section
    const unfiledFiles = files.filter(file => !file.folder_id);
    
    // First render folders
    if (folders.length === 0 && unfiledFiles.length === 0) {
        folderContainer.innerHTML = '<p class="empty-state">No folders or files found. Create a new folder or file to get started!</p>';
        return;
    }
    
    // Render folders
    folders.forEach(folder => {
        const folderElement = document.createElement('div');
        folderElement.classList.add('folder');
        folderElement.id = `folder-${folder.id}`;
        
        // Initialize with folder expanded
        folderElement.innerHTML = `
            <div class="folder-header">
                <div class="folder-info" onclick="toggleFolder(this)">
                    <div class="folder-toggle">
                        <span>&#x25BC;</span>
                    </div>
                    <span class="folder-name">${folder.foldername}</span>
                </div>
                <div class="folder-controls">
                    <button class="btn small-btn add-file-btn" onclick="prepareNewFileInFolder(${folder.id}, '${folder.foldername}')">Add</button>
                    <button class="btn small-btn edit-btn" onclick="editFolder(${folder.id}, '${folder.foldername}')">Edit</button>
                    <button class="btn small-btn delete-btn" onclick="deleteFolder(${folder.id})">Delete</button>
                </div>
            </div>
            <div class="file-list">
                <!-- Files will be added here -->
            </div>
        `;
        folderContainer.appendChild(folderElement);
        
        // Find files for this folder
        const folderFiles = files.filter(file => file.folder_id === folder.id);
        const fileListElement = folderElement.querySelector('.file-list');
        
        if (folderFiles.length === 0) {
            fileListElement.innerHTML = '<p class="empty-folder">No files in this folder</p>';
        } else {
            folderFiles.forEach(file => {
                const fileElement = document.createElement('div');
                fileElement.classList.add('file');
                fileElement.innerHTML = `
                    <span class="file-name">${file.filename}</span>
                    <div class="file-controls">
                        <button class="btn small-btn open-btn" onclick="openFile(${file.id})">Open</button>
                        <button class="btn small-btn edit-btn" onclick="editFile(${file.id})">Edit</button>
                        <button class="btn small-btn delete-btn" onclick="deleteFile(${file.id})">Delete</button>
                    </div>
                `;
                fileListElement.appendChild(fileElement);
            });
        }
    });
    
    // Render unfiled files ("Other Files") if there are any with toggle functionality
    if (unfiledFiles.length > 0) {
        const unfiledSection = document.createElement('div');
        unfiledSection.classList.add('unfiled-files'); // Keeps the original class
        
        // Create header structure similar to folders, but keeps 'unfiled-files' class
        unfiledSection.innerHTML = `
            <div class="folder-header">
                <div class="folder-info" onclick="toggleFolder(this)">
                    <div class="folder-toggle">
                        <span>&#x25BC;</span>
                    </div>
                    <span class="folder-name">Other Files</span>
                </div>
            </div>
            <div class="file-list">
                <!-- Other files will be added here -->
            </div>
        `;
        
        // Get the file list container
        const otherFilesList = unfiledSection.querySelector('.file-list');
        
        // Add files to the list
        unfiledFiles.forEach(file => {
            const fileElement = document.createElement('div');
            fileElement.classList.add('file');
            fileElement.innerHTML = `
                <span class="file-name">${file.filename}</span>
                <div class="file-controls">
                    <button class="btn small-btn open-btn" onclick="openFile(${file.id})">Open</button>
                    <button class="btn small-btn edit-btn" onclick="editFile(${file.id})">Edit</button>
                    <button class="btn small-btn delete-btn" onclick="deleteFile(${file.id})">Delete</button>
                </div>
            `;
            otherFilesList.appendChild(fileElement);
        });
        
        folderContainer.appendChild(unfiledSection);
    }
}

function openFile(id) {
    // Check if user is logged in
    if (!checkUserAuth()) {
        showNotification('You must be logged in to view files', 'error');
        return;
    }

    fetch(`/php/library/fetch-file.php?id=${id}&userId=${userAuth.userId}`)
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            // Checks if the user has access to this file
            if (data.error) {
                throw new Error(data.error);
            }
            
            // Displays file name in modal
            const fileNameElement = document.getElementById("open-file-name");
            if (fileNameElement) {
                fileNameElement.textContent = data.filename;
            }
            
            document.getElementById("open-file-content").textContent = data.content;
            showModal('openFileModal');
            
            // Focus on the modal content to enable immediate scrolling
            setTimeout(() => {
                const contentElement = document.getElementById("open-file-content");
                if (contentElement) {
                    contentElement.focus();
                }
            }, 100);
        })
        .catch(error => {
            console.error("Error fetching file:", error);
            showNotification(error.message || 'Failed to open file', 'error');
        });
}

function deleteFile(id) {
    // Checks if user is logged in
    if (!checkUserAuth()) {
        showNotification('You must be logged in to delete files', 'error');
        return;
    }

    if (!confirm("Are you sure you want to delete this file?")) return;

    fetch("/php/library/delete-file.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id: id, userId: userAuth.userId })
    })
    .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showNotification('File deleted successfully');
            fetchFilesAndFolders();
        } else {
            throw new Error(data.message || 'Failed to delete file');
        }
    })
    .catch(error => {
        console.error("Error deleting file:", error);
        showNotification(error.message, 'error');
    });
}

function deleteFolder(id) {
    // Checks if user is logged in
    if (!checkUserAuth()) {
        showNotification('You must be logged in to delete folders', 'error');
        return;
    }

    if (!confirm("Are you sure you want to delete this folder and all its contents?")) return;

    fetch("/php/library/delete-folder.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id: id, userId: userAuth.userId })
    })
    .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showNotification('Folder deleted successfully');
            fetchFilesAndFolders();
        } else {
            throw new Error(data.message || 'Failed to delete folder');
        }
    })
    .catch(error => {
        console.error("Error deleting folder:", error);
        showNotification(error.message, 'error');
    });
}

// Makes files draggable
function makeDraggable() {
    // Get all file elements
    const fileElements = document.querySelectorAll('.file');
    
    fileElements.forEach(file => {
        // Add draggable attribute
        file.setAttribute('draggable', 'true');
        
        // Store the file ID as a data attribute for easier access during drag operations
        const fileId = file.querySelector('.file-controls .open-btn').getAttribute('onclick').match(/\d+/)[0];
        file.dataset.fileId = fileId;
        
        // Add drag event listeners
        file.addEventListener('dragstart', handleDragStart);
        file.addEventListener('dragend', handleDragEnd);
    });

    // Setup drop targets (folders and unfiled section)
    setupDropTargets();
}

// Handle the start of dragging
function handleDragStart(e) {
    // Add a CSS class to indicate element is being dragged
    this.classList.add('dragging');
    
    // Set the data to be transferred - the file ID
    e.dataTransfer.setData('text/plain', this.dataset.fileId);
    
    // Set the drag effect to move
    e.dataTransfer.effectAllowed = 'move';
    
    // Creates a custom drag image
    const dragIcon = document.createElement('div');
    dragIcon.innerHTML = `<span class="file-name">${this.querySelector('.file-name').textContent}</span>`;
    dragIcon.classList.add('drag-icon');
    document.body.appendChild(dragIcon);
    e.dataTransfer.setDragImage(dragIcon, 0, 0);
    
    // Removes the drag icon after drop
    setTimeout(() => {
        document.body.removeChild(dragIcon);
    }, 0);
}

// Handles the end of dragging
function handleDragEnd() {
    // Removes the dragging class
    this.classList.remove('dragging');
}

// Setup drop targets
function setupDropTargets() {
    // Add drop capability to all folders
    const folders = document.querySelectorAll('.folder');
    folders.forEach(folder => {
        setupDropTarget(folder, folder.id.replace('folder-', ''));
    });
    
    // Add drop capability to the unfiled/other files section
    const unfiledSection = document.querySelector('.unfiled-files');
    if (unfiledSection) {
        setupDropTarget(unfiledSection, null); // null for unfiled
    }
}

// Setup individual drop targets
function setupDropTarget(element, folderId) {
    element.addEventListener('dragover', (e) => {
        // Prevents default to allow drop
        e.preventDefault();
        
        // Adds visual indicator
        element.classList.add('drag-over');
    });
    
    element.addEventListener('dragleave', () => {
        // Removes visual indicator
        element.classList.remove('drag-over');
    });
    
    element.addEventListener('drop', (e) => {
        // Prevents default action
        e.preventDefault();
        
        // Removes visual indicator
        element.classList.remove('drag-over');
        
        // Get the dragged file's ID
        const fileId = e.dataTransfer.getData('text/plain');
        
        // Moves the file to this folder
        moveFile(fileId, folderId);
    });
}

// Function to move a file to a new folder
function moveFile(fileId, folderId) {
    // Checks if user is logged in
    if (!checkUserAuth()) {
        showNotification('You must be logged in to move files', 'error');
        return;
    }
    
    // Prepares data for the server
    const data = {
        fileId: fileId,
        folderId: folderId === null ? 0 : folderId, // This will be null for the "Other Files" section
        userId: userAuth.userId
    };
    
    // Sends the request to move the file
    fetch('/php/library/move-file.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
    })
    .then(responseData => {
        if (responseData.success) {
            // Show success notification
            const targetName = folderId ? document.querySelector(`#folder-${folderId} .folder-name`).textContent : 'Other Files';
            showNotification(`File moved to "${targetName}" successfully!`);
            
            // Refresh the view to show the updated structure
            fetchFilesAndFolders();
        } else {
            throw new Error(responseData.message || 'Unknown error occurred');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification(error.message || 'Error occurred while moving the file', 'error');
    });
}

// Adds CSS class for drag visualization to document head
function addDragStyles() {
    const styleElement = document.createElement('style');
    styleElement.textContent = `
        .file[draggable=true] {
            cursor: move;
        }
        
        .file.dragging {
            opacity: 0.5;
        }
        
        .folder.drag-over .folder-header,
        .unfiled-files.drag-over .folder-header {
            background-color: #e0f7fa;
            transition: background-color 0.3s ease;
        }
        
        .drag-icon {
            background: #fff;
            border: 1px solid #ccc;
            padding: 5px 10px;
            border-radius: 4px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            position: absolute;
            top: -1000px; /* Hide it from view initially */
        }
        
        /* Highlight folders and unfiled-files section on drag over */
        .folder.drag-over, 
        .unfiled-files.drag-over {
            box-shadow: 0 0 10px rgba(70, 96, 154, 0.7);
        }
    `;
    document.head.appendChild(styleElement);
}


// Event Listeners
document.addEventListener('DOMContentLoaded', () => {
    // Adds styles for drag and drop
    addDragStyles();
    
    // Calls existing checkUserAuth and initial fetch
    if (!checkUserAuth()) {
        console.log('User not authenticated');
        return; // Exit early if not authenticated
    }
    
    // Initial fetch of files and folders
    fetchFilesAndFolders();

    // Resets folder ID when opening the new file modal from the main button
    document.getElementById('new-file-btn')?.addEventListener('click', () => {
        const createFileBtn = document.getElementById('create-file-folder');
        createFileBtn.dataset.folderId = '';
        createFileBtn.dataset.fileId = '';
        
        // Resets modal title
        const modalTitle = document.getElementById('newFileModal').querySelector('h2');
        modalTitle.textContent = 'Create New File';
        
        // Clears form fields
        document.getElementById('filename').value = '';
        document.getElementById('file-content').value = '';
        
        showModal('newFileModal');
    });

    // Resets folder ID when opening the new folder modal
    document.getElementById('new-folder-btn')?.addEventListener('click', () => {
        document.getElementById('foldername').value = '';
        document.getElementById('create-folder-btn').dataset.folderId = '';
        
        // Resets modal title
        const modalTitle = document.getElementById('newFolderModal').querySelector('h2');
        modalTitle.textContent = 'Create New Folder';
        
        showModal('newFolderModal');
    });

    // Adds event listeners for modal close buttons
    document.querySelectorAll('.close').forEach(closeButton => {
        closeButton.addEventListener('click', () => {
            const modal = closeButton.closest('.modal');
            if (modal) {
                modal.style.display = 'none';
                // Restores scrolling
                document.body.classList.remove('modal-open');
            }
        });
    });

    // Event listeners for buttons
    document.getElementById('create-folder-btn')?.addEventListener('click', createNewFolder);
    document.getElementById('create-file-folder')?.addEventListener('click', createFileFromModal);
    
    // Closes modals when clicking outside of them
    window.addEventListener('click', (event) => {
        document.querySelectorAll('.modal').forEach(modal => {
            if (event.target === modal) {
                modal.style.display = 'none';
                // Restores scrolling
                document.body.classList.remove('modal-open');
            }
        });
    });

    // Handles escape key to close modals
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            document.querySelectorAll('.modal').forEach(modal => {
                if (modal.style.display === 'flex') {
                    modal.style.display = 'none';
                    // Restores scrolling
                    document.body.classList.remove('modal-open');
                }
            });
        }
    });
});

// Update to existing fetchFilesAndFolders function
const originalFetchFilesAndFolders = fetchFilesAndFolders;
fetchFilesAndFolders = function() {
    originalFetchFilesAndFolders();
    
    // Short delay to ensure DOM has been updated
    setTimeout(() => {
        makeDraggable();
    }, 200);
};
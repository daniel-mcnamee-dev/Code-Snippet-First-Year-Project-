function openLightbox(imgElement) {
    // Get the modal
    const modal = document.getElementById("imageModal");
    
    // Get the image and insert it inside the modal
    const modalImg = document.getElementById("modalImage");
    const captionText = document.getElementById("modalCaption");
    
    // Set modal display to block first (but invisible)
    modal.style.display = "block";
    
    // Set the source of the modal image
    modalImg.src = imgElement.src;
    
    // Make the modal image 50% wider
    const originalWidth = imgElement.width;
    modalImg.style.width = (originalWidth * 1.75) + "px";

    // Make the modal image 50% taller
    const originalHeight = imgElement.height;
    modalImg.style.height = (originalHeight * 1.2) + "px";
    
    // Get the alt text as the caption
    captionText.innerHTML = imgElement.alt;
    
    // Add a small delay before adding the 'show' class for animation
    setTimeout(() => {
        modal.classList.add('show');
    }, 30);
    
    // Prevent scrolling on the body when lightbox is open
    document.body.style.overflow = "hidden";
    
    // Add keyboard event listener for escape key
    document.addEventListener('keydown', handleEscapeKey);
    
    // Add click event for closing when clicking outside the image
    modal.addEventListener('click', handleOutsideClick);
}

function closeLightbox() {
    const modal = document.getElementById("imageModal");
    
    // Fade out animation
    modal.classList.remove('show');
    
    // After animation completes, hide the modal
    setTimeout(() => {
        modal.style.display = "none";
    }, 300);
    
    // Restore scrolling on the body
    document.body.style.overflow = "auto";
    
    // Remove event listeners
    document.removeEventListener('keydown', handleEscapeKey);
    modal.removeEventListener('click', handleOutsideClick);
}

// Handle escape key press
function handleEscapeKey(event) {
    if (event.key === "Escape") {
        closeLightbox();
    }
}

// Handle clicking outside the image to close
function handleOutsideClick(event) {
    const modalImg = document.getElementById("modalImage");
    // Close only if clicking outside the image
    if (event.target !== modalImg) {
        closeLightbox();
    }
}

// DOMContentLoaded event
document.addEventListener('DOMContentLoaded', function() {
    // Preload images for better lightbox experience
    const galleryImages = document.querySelectorAll('.snippet-image');
    galleryImages.forEach(img => {
        const preloadLink = document.createElement('link');
        preloadLink.href = img.src;
        preloadLink.rel = 'preload';
        preloadLink.as = 'image';
        document.head.appendChild(preloadLink);
        
        // Add hover hint to indicate clickability
        img.title = "Click to enlarge";
    });
});
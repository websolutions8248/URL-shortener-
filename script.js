// Load page content dynamically
async function loadPage(pageName) {
    try {
        // Update active nav link
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.classList.remove('active');
        });
        event.target.classList.add('active');
        
        // Load page content
        const response = await fetch(`pages/${pageName}.html`);
        const content = await response.text();
        document.getElementById('content').innerHTML = content;
        
        // Initialize page-specific scripts
        initializePage(pageName);
    } catch (error) {
        console.error('Error loading page:', error);
        document.getElementById('content').innerHTML = '<div class="error">Page not found</div>';
    }
}

// Initialize page-specific functionality
function initializePage(pageName) {
    switch(pageName) {
        case 'home':
            initializeHomePage();
            break;
        case 'dashboard':
            initializeDashboard();
            break;
        case 'analytics':
            initializeAnalytics();
            break;
    }
}

// Load home page by default
document.addEventListener('DOMContentLoaded', () => {
    loadPage('home');
});

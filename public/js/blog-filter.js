/**
 * Blog Filtering System
 * Handles category and destination filtering in blog pages
 */

document.addEventListener('DOMContentLoaded', function() {
    // Get all filter elements
    const categoryLinks = document.querySelectorAll('.category-link');
    const destinationTags = document.querySelectorAll('.destination-tag');
    const blogItems = document.querySelectorAll('.blog-item');
    const featuredPost = document.getElementById('featuredPost');
    const blogGrid = document.getElementById('blogGrid');
    const noResultsDiv = createNoResultsElement();

    // Get current URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const currentCategory = urlParams.get('category');
    const currentDestination = urlParams.get('destination');

    // Initialize filters on page load
    initializeFilters();

    /**
     * Initialize filters based on URL parameters
     */
    function initializeFilters() {
        if (currentCategory) {
            applyFilter('category', currentCategory);
        }
        if (currentDestination) {
            applyFilter('destination', currentDestination);
        }
    }

    /**
     * Add click event listeners to category links
     */
    categoryLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const href = this.getAttribute('href');
            const url = new URL(href, window.location.origin);
            const category = url.searchParams.get('category');
            
            // Update URL without page reload
            if (category) {
                updateURL('category', category);
                applyFilter('category', category);
            } else {
                // "All Posts" clicked
                clearFilter('category');
            }
        });
    });

    /**
     * Add click event listeners to destination tags
     */
    destinationTags.forEach(tag => {
        tag.addEventListener('click', function(e) {
            e.preventDefault();
            const href = this.getAttribute('href');
            const url = new URL(href, window.location.origin);
            const destination = url.searchParams.get('destination');
            
            // Update URL without page reload
            if (destination) {
                updateURL('destination', destination);
                applyFilter('destination', destination);
            }
        });
    });

    /**
     * Apply filter to blog items
     */
    function applyFilter(filterType, filterValue) {
        let visibleCount = 0;
        const currentParams = new URLSearchParams(window.location.search);
        
        blogItems.forEach(item => {
            const itemCategory = item.dataset.category;
            const itemDestination = item.dataset.destination;
            let show = true;

            // Check category filter
            const activeCategory = currentParams.get('category');
            if (activeCategory && itemCategory !== activeCategory) {
                show = false;
            }

            // Check destination filter
            const activeDestination = currentParams.get('destination');
            if (activeDestination && itemDestination !== activeDestination) {
                show = false;
            }

            if (show) {
                item.style.display = 'block';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        // Update active states
        updateActiveStates();

        // Handle featured post visibility
        if (featuredPost) {
            const hasFilters = currentParams.get('category') || currentParams.get('destination');
            featuredPost.style.display = hasFilters ? 'none' : 'block';
        }

        // Show/hide no results message
        if (visibleCount === 0) {
            showNoResults();
        } else {
            hideNoResults();
        }

        // Smooth scroll to results
        if (blogGrid) {
            blogGrid.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    /**
     * Clear specific filter
     */
    function clearFilter(filterType) {
        const currentParams = new URLSearchParams(window.location.search);
        currentParams.delete(filterType);
        
        const newURL = currentParams.toString() 
            ? `${window.location.pathname}?${currentParams.toString()}`
            : window.location.pathname;
        
        window.history.pushState({}, '', newURL);
        
        // Reapply remaining filters
        applyAllFilters();
    }

    /**
     * Apply all active filters
     */
    function applyAllFilters() {
        const currentParams = new URLSearchParams(window.location.search);
        const category = currentParams.get('category');
        const destination = currentParams.get('destination');
        
        let visibleCount = 0;
        
        blogItems.forEach(item => {
            const itemCategory = item.dataset.category;
            const itemDestination = item.dataset.destination;
            let show = true;

            if (category && itemCategory !== category) {
                show = false;
            }

            if (destination && itemDestination !== destination) {
                show = false;
            }

            if (show) {
                item.style.display = 'block';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        updateActiveStates();

        if (featuredPost) {
            const hasFilters = category || destination;
            featuredPost.style.display = hasFilters ? 'none' : 'block';
        }

        if (visibleCount === 0) {
            showNoResults();
        } else {
            hideNoResults();
        }
    }

    /**
     * Update URL with new filter parameter
     */
    function updateURL(paramName, paramValue) {
        const currentParams = new URLSearchParams(window.location.search);
        currentParams.set(paramName, paramValue);
        const newURL = `${window.location.pathname}?${currentParams.toString()}`;
        window.history.pushState({}, '', newURL);
    }

    /**
     * Update active states on filter elements
     */
    function updateActiveStates() {
        const currentParams = new URLSearchParams(window.location.search);
        const activeCategory = currentParams.get('category');
        const activeDestination = currentParams.get('destination');

        // Update category links
        categoryLinks.forEach(link => {
            const href = link.getAttribute('href');
            const url = new URL(href, window.location.origin);
            const linkCategory = url.searchParams.get('category');
            
            if (!activeCategory && !linkCategory) {
                // "All Posts" is active
                link.classList.add('active');
            } else if (linkCategory === activeCategory) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });

        // Update destination tags
        destinationTags.forEach(tag => {
            const href = tag.getAttribute('href');
            const url = new URL(href, window.location.origin);
            const tagDestination = url.searchParams.get('destination');
            
            if (tagDestination === activeDestination) {
                tag.classList.add('active');
            } else {
                tag.classList.remove('active');
            }
        });
    }

    /**
     * Create no results element
     */
    function createNoResultsElement() {
        const div = document.createElement('div');
        div.className = 'col-12 no-results-wrapper';
        div.style.display = 'none';
        div.innerHTML = `
            <div class="no-results">
                <div class="no-results-icon"><i class="bi bi-search"></i></div>
                <h3>No articles found</h3>
                <p>Try adjusting your filters to find more content</p>
                <button class="btn btn-primary" onclick="window.location.href='${window.location.pathname}'">
                    Clear All Filters
                </button>
            </div>
        `;
        return div;
    }

    /**
     * Show no results message
     */
    function showNoResults() {
        if (blogGrid && !blogGrid.querySelector('.no-results-wrapper')) {
            blogGrid.appendChild(noResultsDiv);
        }
        if (noResultsDiv) {
            noResultsDiv.style.display = 'block';
        }
    }

    /**
     * Hide no results message
     */
    function hideNoResults() {
        if (noResultsDiv) {
            noResultsDiv.style.display = 'none';
        }
    }

    /**
     * Handle browser back/forward buttons
     */
    window.addEventListener('popstate', function() {
        applyAllFilters();
    });
});

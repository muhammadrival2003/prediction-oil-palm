// Modern Afdeling Interactive Features

document.addEventListener('DOMContentLoaded', function() {
    initializeAfdelingPage();
});

function initializeAfdelingPage() {
    // Initialize staggered animations
    initStaggeredAnimations();
    
    // Initialize search functionality
    initSearchFeature();
    
    // Initialize card interactions
    initCardInteractions();
    
    // Initialize keyboard navigation
    initKeyboardNavigation();
    
    // Initialize lazy loading
    initLazyLoading();
    
    // Initialize theme detection
    initThemeDetection();
}

// Staggered Animation for Cards
function initStaggeredAnimations() {
    const cards = document.querySelectorAll('.afdeling-card');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, index * 100);
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });
    
    cards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
}

// Search Feature
function initSearchFeature() {
    // Create search input if it doesn't exist
    const headerSection = document.querySelector('.relative.overflow-hidden');
    if (headerSection && !document.querySelector('#afdeling-search')) {
        const searchContainer = document.createElement('div');
        searchContainer.className = 'mt-6';
        searchContainer.innerHTML = `
            <div class="relative max-w-md">
                <input 
                    type="text" 
                    id="afdeling-search"
                    placeholder="Cari afdeling..."
                    class="w-full px-4 py-3 pl-10 pr-4 text-gray-700 dark:text-gray-300 bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm border border-gray-200 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-300"
                >
                <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
        `;
        
        const statsContainer = headerSection.querySelector('.flex.flex-wrap.gap-4');
        if (statsContainer) {
            statsContainer.parentNode.insertBefore(searchContainer, statsContainer.nextSibling);
        }
    }
    
    // Search functionality
    const searchInput = document.querySelector('#afdeling-search');
    if (searchInput) {
        searchInput.addEventListener('input', debounce(handleSearch, 300));
    }
}

function handleSearch(event) {
    const searchTerm = event.target.value.toLowerCase();
    const cards = document.querySelectorAll('.afdeling-card');
    let visibleCount = 0;
    
    cards.forEach(card => {
        const cardContainer = card.closest('.group');
        const title = card.querySelector('h3').textContent.toLowerCase();
        const description = card.querySelector('p')?.textContent.toLowerCase() || '';
        
        const isVisible = title.includes(searchTerm) || description.includes(searchTerm);
        
        if (isVisible) {
            cardContainer.style.display = 'block';
            cardContainer.style.opacity = '1';
            cardContainer.style.transform = 'scale(1)';
            visibleCount++;
        } else {
            cardContainer.style.opacity = '0';
            cardContainer.style.transform = 'scale(0.8)';
            setTimeout(() => {
                if (cardContainer.style.opacity === '0') {
                    cardContainer.style.display = 'none';
                }
            }, 300);
        }
    });
    
    // Show/hide no results message
    showNoResultsMessage(visibleCount === 0 && searchTerm.length > 0);
}

function showNoResultsMessage(show) {
    let noResultsDiv = document.querySelector('#no-results-message');
    
    if (show && !noResultsDiv) {
        noResultsDiv = document.createElement('div');
        noResultsDiv.id = 'no-results-message';
        noResultsDiv.className = 'text-center py-12 col-span-full';
        noResultsDiv.innerHTML = `
            <div class="mx-auto w-24 h-24 text-gray-400 mb-4">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-full h-full">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.467-.881-6.08-2.33m0 0L3 15.5v-2.25m0 0a9.975 9.975 0 0112-4.5c2.491 0 4.773.901 6.556 2.4L21 8.25v2.25"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Tidak ada hasil</h3>
            <p class="text-gray-500 dark:text-gray-400">Coba gunakan kata kunci yang berbeda</p>
        `;
        
        const grid = document.querySelector('.grid');
        if (grid) {
            grid.appendChild(noResultsDiv);
        }
    } else if (!show && noResultsDiv) {
        noResultsDiv.remove();
    }
}

// Card Interactions
function initCardInteractions() {
    const cards = document.querySelectorAll('.afdeling-card');
    
    cards.forEach(card => {
        // Add ripple effect on click
        card.addEventListener('click', createRippleEffect);
        
        // Add hover sound effect (optional)
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'translateY(-8px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'translateY(0) scale(1)';
        });
        
        // Add focus management
        card.addEventListener('focus', () => {
            card.scrollIntoView({ behavior: 'smooth', block: 'center' });
        });
    });
}

function createRippleEffect(event) {
    const card = event.currentTarget;
    const rect = card.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height);
    const x = event.clientX - rect.left - size / 2;
    const y = event.clientY - rect.top - size / 2;
    
    const ripple = document.createElement('div');
    ripple.style.cssText = `
        position: absolute;
        width: ${size}px;
        height: ${size}px;
        left: ${x}px;
        top: ${y}px;
        background: rgba(16, 185, 129, 0.3);
        border-radius: 50%;
        transform: scale(0);
        animation: ripple 0.6s linear;
        pointer-events: none;
        z-index: 1;
    `;
    
    card.style.position = 'relative';
    card.appendChild(ripple);
    
    setTimeout(() => {
        ripple.remove();
    }, 600);
}

// Keyboard Navigation
function initKeyboardNavigation() {
    const cards = document.querySelectorAll('.afdeling-card');
    let currentIndex = -1;
    
    document.addEventListener('keydown', (event) => {
        if (event.target.tagName === 'INPUT') return;
        
        switch (event.key) {
            case 'ArrowRight':
            case 'ArrowDown':
                event.preventDefault();
                currentIndex = Math.min(currentIndex + 1, cards.length - 1);
                focusCard(currentIndex);
                break;
                
            case 'ArrowLeft':
            case 'ArrowUp':
                event.preventDefault();
                currentIndex = Math.max(currentIndex - 1, 0);
                focusCard(currentIndex);
                break;
                
            case 'Enter':
            case ' ':
                if (currentIndex >= 0) {
                    event.preventDefault();
                    cards[currentIndex].click();
                }
                break;
                
            case 'Home':
                event.preventDefault();
                currentIndex = 0;
                focusCard(currentIndex);
                break;
                
            case 'End':
                event.preventDefault();
                currentIndex = cards.length - 1;
                focusCard(currentIndex);
                break;
        }
    });
    
    function focusCard(index) {
        if (cards[index]) {
            cards[index].focus();
            cards[index].scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }
}

// Lazy Loading for Images
function initLazyLoading() {
    const images = document.querySelectorAll('img[loading="lazy"]');
    
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });
        
        images.forEach(img => {
            img.classList.add('lazy');
            imageObserver.observe(img);
        });
    }
}

// Theme Detection
function initThemeDetection() {
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)');
    
    function handleThemeChange(e) {
        // Update any theme-specific animations or styles
        const cards = document.querySelectorAll('.afdeling-card');
        cards.forEach(card => {
            if (e.matches) {
                card.classList.add('dark-theme');
            } else {
                card.classList.remove('dark-theme');
            }
        });
    }
    
    prefersDark.addEventListener('change', handleThemeChange);
    handleThemeChange(prefersDark);
}

// Utility Functions
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Performance Monitoring
function initPerformanceMonitoring() {
    if ('PerformanceObserver' in window) {
        const observer = new PerformanceObserver((list) => {
            list.getEntries().forEach((entry) => {
                if (entry.entryType === 'paint') {
                    console.log(`${entry.name}: ${entry.startTime}ms`);
                }
            });
        });
        
        observer.observe({ entryTypes: ['paint'] });
    }
}

// Add CSS for ripple animation
const style = document.createElement('style');
style.textContent = `
    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
    
    .lazy {
        opacity: 0;
        transition: opacity 0.3s;
    }
    
    .lazy.loaded {
        opacity: 1;
    }
`;
document.head.appendChild(style);
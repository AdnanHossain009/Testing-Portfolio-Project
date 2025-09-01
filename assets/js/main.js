// Mobile Navigation Toggling
const hamburger = document.querySelector('.hamburger');
const navMenu = document.querySelector('.nav-menu');
const navbar = document.querySelector('.navbar');


function updateNavbar() {
  // Always force dark background instead changing color while scrolling
  navbar.style.background = 'rgba(15, 23, 42, 0.95)';
  navbar.style.color = '#cbd5e1';

  // Optional: adding a class for shadow effect after scrolling
  if (window.scrollY > 50) {
    navbar.classList.add('navbar-scrolled');
  } else {
    navbar.classList.remove('navbar-scrolled');
  }
}

//Run on scroll
window.addEventListener('scroll', updateNavbar);

//Run on page load
document.addEventListener('DOMContentLoaded', updateNavbar);


hamburger.addEventListener('click', () => {

    hamburger.classList.toggle('active');
    navMenu.classList.toggle('active');
});


// will close mobile menu when clicking on a link

document.querySelectorAll('.nav-link').forEach(n => n.addEventListener('click', () => {
    hamburger.classList.remove('active');
    navMenu.classList.remove('active');
}));


// smooth scrolling for navigation links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});


// navbar background change on scroll (always dark theme)
window.addEventListener('scroll', () => {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 100) {
    navbar.classList.add('navbar-scrolled');
    } 
    else {
    navbar.classList.remove('navbar-scrolled');
    }
});


// Also run on page load (incase user refreshes mid-page)

document.addEventListener("DOMContentLoaded", () => {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 100) {
    navbar.classList.add('navbar-scrolled');
    }
});


// Intersection Observer for fade-in animations

const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
        }
    });
}, observerOptions);

// Observe all sections for animation


document.querySelectorAll('section').forEach(section => {
    section.classList.add('fade-in');
    observer.observe(section);
});


// Skill items hover effect 
document.querySelectorAll('.skill-item').forEach(item => {
    item.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-8px) scale(1.05)';
    });
    
    item.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0) scale(1)';
    });
});


// Project cards hover effect
document.querySelectorAll('.project-card').forEach(card => {
    card.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-15px)';
    });
    
    card.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0)';
    });
});


// Typing effect for hero title
function typeWriter(element, text, speed = 100) {
    let i = 0;
    element.innerHTML = '';
    
    function type() {
        if (i < text.length) {
            element.innerHTML += text.charAt(i);
            i++;
            setTimeout(type, speed);
        }
    }
    
    type();
}


// initialize typing effect when page loads
window.addEventListener('load', () => {
    const heroTitle = document.querySelector('.hero-title');
    if (heroTitle) {
        const originalText = heroTitle.innerHTML;
        typeWriter(heroTitle, originalText, 50);
    }
});


// Counter animation for stats
function animateCounter(element, target, duration = 2000) {
    let start = 0;
    const increment = target / (duration / 16);
    
    function updateCounter() {
        start += increment;
        if (start < target) {
            element.textContent = Math.floor(start) + '+';
            requestAnimationFrame(updateCounter);
        } else {
            element.textContent = target + '+';
        }
    }
    
    updateCounter();
}

// Animate counters when they come into view
const counterObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const counter = entry.target.querySelector('.stat-number');
            const target = parseInt(counter.textContent);
            animateCounter(counter, target);
            counterObserver.unobserve(entry.target);
        }
    });
}, { threshold: 0.5 });


document.querySelectorAll('.about-stats').forEach(stats => {
    counterObserver.observe(stats);
});


// added parallax effect for hero section ^-^

window.addEventListener('scroll', () => {
    const scrolled = window.pageYOffset;
    const hero = document.querySelector('.hero');
    if (hero) {
        const rate = scrolled * -0.5;
        hero.style.transform = `translateY(${rate}px)`;
    }
});

// Form validation and AJAX submission
const contactForm = document.querySelector('.contact-form form');
if (contactForm) {
    contactForm.addEventListener('submit', async function(e) {
        e.preventDefault();

        const form = this;
        const name = form.querySelector('input[name="name"]').value.trim();
        const email = form.querySelector('input[name="email"]').value.trim();
        const subject = form.querySelector('input[name="subject"]').value.trim();
        const message = form.querySelector('textarea[name="message"]').value.trim();

        if (!name || !email || !subject || !message) {
            showNotification('Please fill in all fields', 'error');
            return;
        }
        if (!isValidEmail(email)) {
            showNotification('Please enter a valid email address', 'error');
            return;
        }

        try {
            const res = await fetch('process_contact.php', {
                method: 'POST',
                headers: { 'Accept': 'application/json' },
                body: new FormData(form)
            });
            const data = await res.json();
            if (data.success) {
                showNotification(data.message || 'Message sent successfully!', 'success');
                form.reset();
            } else {
                showNotification(data.message || 'Failed to send message', 'error');
            }
        } catch (err) {
            showNotification('Network error. Please try again later.', 'error');
        }
    });
}

// Email validation helper(without using @ it won't let the user pass)

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Notification system 
function showNotification(message, type = 'info') {
    // Remove existing notifications
    const existingNotification = document.querySelector('.notification');
    if (existingNotification) {
        existingNotification.remove();
    }
    
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <span class="notification-message">${message}</span>
            <button class="notification-close">&times;</button>
        </div>
    `;
    

    // Add styles
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'success' ? '#28a745' : type === 'error' ? '#dc3545' : '#17a2b8'};
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        z-index: 10000;
        transform: translateX(400px);
        transition: transform 0.3s ease;
        max-width: 300px;
    `;
    
    // Add to page
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    

    // Auto remove after 5 seconds
    setTimeout(() => {
        notification.style.transform = 'translateX(400px)';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 300);
    }, 5000);
    

    // Close button functionality
    const closeBtn = notification.querySelector('.notification-close');
    closeBtn.addEventListener('click', () => {
        notification.style.transform = 'translateX(400px)';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 300);
    });
}


// Add notification styles to CSS
const notificationStyles = `
    .notification-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }
    
    .notification-close {
        background: none;
        border: none;
        color: white;
        font-size: 1.5rem;
        cursor: pointer;
        padding: 0;
        line-height: 1;
    }
    
    .notification-close:hover {
        opacity: 0.8;
    }
`;

// Inject notification styles
if (!document.querySelector('#notification-styles')) {
    const styleSheet = document.createElement('style');
    styleSheet.id = 'notification-styles';
    styleSheet.textContent = notificationStyles;
    document.head.appendChild(styleSheet);
}

// Lazy loading for images (if any are added later)
const imageObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const img = entry.target;
            img.src = img.dataset.src;
            img.classList.remove('lazy');
            imageObserver.unobserve(img);
        }
    });
});

document.querySelectorAll('img[data-src]').forEach(img => {
    imageObserver.observe(img);
});

// Performance optimization: Debounce scroll events
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

// Applied debouncing to scroll events
const debouncedScrollHandler = debounce(() => {
    // Handle scroll events here
}, 16);

window.addEventListener('scroll', debouncedScrollHandler);

// Added loading animation
window.addEventListener('load', () => {
    document.body.classList.add('loaded');
});

// Added CSS for loading state
const loadingStyles = `
    body:not(.loaded) {
        overflow: hidden;
    }
    
    body:not(.loaded)::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    body:not(.loaded)::after {
        content: 'Loading...';
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        font-size: 1.5rem;
        font-weight: 600;
        z-index: 10000;
    }
`;

// Inject loading styles
if (!document.querySelector('#loading-styles')) {
    const styleSheet = document.createElement('style');
    styleSheet.id = 'loading-styles';
    styleSheet.textContent = loadingStyles;
    document.head.appendChild(styleSheet);
}

console.log('Portfolio JavaScript loaded successfully! 🚀');





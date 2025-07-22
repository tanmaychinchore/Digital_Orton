// Digital Orton - Complete JavaScript Functionality

// Global variables
let selectedService = null;
let animationFrame = null;

// DOM Content Loaded Event
document.addEventListener('DOMContentLoaded', function() {
    initializeApp();
});

// Initialize all app functionality
function initializeApp() {
    setupNavigation();
    setupHeroAnimations();
    setupScrollEffects();
    setupServiceCards();
    setupFAQ();
    setupModal();
    setupContactForms();
    setupCounterAnimations();
    setupSmoothScrolling();
    setupMobileMenu();
    setupTypingEffect();
    setupParticleSystem();
}

// ==================== NAVIGATION ====================
function setupNavigation() {
    const navbar = document.querySelector('.navbar');
    const navLinks = document.querySelectorAll('.nav-link');
    
    // Navbar scroll effect
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            navbar.style.background = 'rgba(255, 255, 255, 0.98)';
            navbar.style.boxShadow = '0 2px 30px rgba(0, 0, 0, 0.15)';
        } else {
            navbar.style.background = 'rgba(255, 255, 255, 0.95)';
            navbar.style.boxShadow = '0 2px 20px rgba(0, 0, 0, 0.1)';
        }
    });

    // Active link highlighting
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Remove active class from all links
            navLinks.forEach(l => l.classList.remove('active'));
            // Add active class to clicked link
            this.classList.add('active');
        });
    });

    // Update active link on scroll
    window.addEventListener('scroll', updateActiveNavLink);
}

function updateActiveNavLink() {
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.nav-link');
    
    let current = '';
    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        if (window.scrollY >= (sectionTop - 200)) {
            current = section.getAttribute('id');
        }
    });

    navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === `#${current}`) {
            link.classList.add('active');
        }
    });
}

// ==================== MOBILE MENU ====================
function setupMobileMenu() {
    const hamburger = document.querySelector('.hamburger');
    const navMenu = document.querySelector('.nav-menu');
    
    if (hamburger && navMenu) {
        hamburger.addEventListener('click', () => {
            hamburger.classList.toggle('active');
            navMenu.classList.toggle('active');
        });

        // Close menu when clicking on a link
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', () => {
                hamburger.classList.remove('active');
                navMenu.classList.remove('active');
            });
        });
    }
}

// ==================== HERO ANIMATIONS ====================
function setupHeroAnimations() {
    const heroTitle = document.querySelector('.hero-title');
    const heroDescription = document.querySelector('.hero-description');
    const heroButtons = document.querySelector('.hero-buttons');
    const analyticsCards = document.querySelectorAll('.card');
    
    // Stagger hero content animations
    if (heroTitle) {
        setTimeout(() => heroTitle.style.animation = 'fadeInLeft 1s ease-out', 100);
    }
    if (heroDescription) {
        setTimeout(() => heroDescription.style.animation = 'fadeInLeft 1s ease-out', 300);
    }
    if (heroButtons) {
        setTimeout(() => heroButtons.style.animation = 'fadeInLeft 1s ease-out', 500);
    }

    // Animate analytics cards
    analyticsCards.forEach((card, index) => {
        setTimeout(() => {
            card.style.animation = `fadeInUp 0.8s ease-out ${index * 0.2}s both`;
        }, 700 + (index * 200));
    });

    // Hero button interactions
    const getStartedBtn = document.getElementById('getStartedBtn');
    const learnMoreBtn = document.getElementById('learnMoreBtn');
    
    if (getStartedBtn) {
    getStartedBtn.addEventListener('click', () => {
        window.location.href = 'form.php';  // ✅ Go to form page
    });
}

    
    if (learnMoreBtn) {
        learnMoreBtn.addEventListener('click', () => {
            document.getElementById('about').scrollIntoView({ 
                behavior: 'smooth',
                block: 'start'
            });
        });
    }
}

// ==================== SCROLL EFFECTS ====================
function setupScrollEffects() {
    // Intersection Observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animation = 'fadeInUp 0.8s ease-out forwards';
                entry.target.style.opacity = '1';
            }
        });
    }, observerOptions);

    // Observe elements
    const elementsToAnimate = document.querySelectorAll(
        '.service-card, .about-text, .about-stats, .faq-item, .stat-item'
    );
    
    elementsToAnimate.forEach(el => {
        el.style.opacity = '0';
        observer.observe(el);
    });

    // Parallax effect for hero background
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const parallax = document.querySelector('.hero');
        if (parallax) {
            const speed = scrolled * 0.5;
            parallax.style.transform = `translateY(${speed}px)`;
        }
    });
}

// ==================== SERVICE CARDS ====================
function setupServiceCards() {
    const serviceCards = document.querySelectorAll('.service-card');
    
    serviceCards.forEach(card => {
        // Hover effects
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-15px) scale(1.02)';
            this.style.boxShadow = '0 25px 50px rgba(0, 0, 0, 0.2)';
        });
        
        card.addEventListener('mouseleave', function() {
            if (!this.classList.contains('featured')) {
                this.style.transform = 'translateY(0) scale(1)';
                this.style.boxShadow = '0 10px 30px rgba(0, 0, 0, 0.1)';
            } else {
                this.style.transform = 'scale(1.05)';
            }
        });

        // Click to expand details
        card.addEventListener('click', function() {
            const cardRect = this.getBoundingClientRect();
            showServiceDetails(this, cardRect);
        });
    });
}

function selectService(serviceType) {
    selectedService = serviceType;
    const serviceNames = {
        'google-business': 'Google Business Profile Optimization',
        'social-media': 'Social Media Page Promotion',
        'complete-package': 'Complete Digital Package'
    };
    
    const servicePrices = {
        'google-business': '₹3,300/-',
        'social-media': '₹3,000/Month',
        'complete-package': 'Contact Us'
    };
    
    const modalMessage = document.getElementById('modalMessage');
    if (modalMessage) {
        modalMessage.innerHTML = `
            <div class="service-selection">
                <h3>${serviceNames[serviceType]}</h3>
                <p class="price">${servicePrices[serviceType]}</p>
                <p>Ready to get started with this service? Click below to proceed with booking or continue browsing our other services.</p>
            </div>
        `;
    }
    
    showModal();
    
    // Track selection (for analytics)
    trackServiceSelection(serviceType);
}

function showServiceDetails(card, rect) {
    // Create detailed view overlay
    const overlay = document.createElement('div');
    overlay.className = 'service-detail-overlay';
    overlay.innerHTML = `
        <div class="service-detail-modal">
            <button class="close-detail">&times;</button>
            ${card.innerHTML}
            <div class="extra-details">
                <h4>What's Included:</h4>
                <ul>
                    <li>Detailed analysis and strategy</li>
                    <li>Implementation and setup</li>
                    <li>Monthly progress reports</li>
                    <li>Ongoing support and optimization</li>
                </ul>
            </div>
        </div>
    `;
    
    document.body.appendChild(overlay);
    
    // Close functionality
    overlay.querySelector('.close-detail').addEventListener('click', () => {
        overlay.remove();
    });
    
    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) {
            overlay.remove();
        }
    });
}

// ==================== FAQ FUNCTIONALITY ====================
function setupFAQ() {
    const faqItems = document.querySelectorAll('.faq-item');
    
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        const answer = item.querySelector('.faq-answer');
        const icon = question.querySelector('i');
        
        question.addEventListener('click', () => {
            const isOpen = item.classList.contains('open');
            
            // Close all FAQ items
            faqItems.forEach(faq => {
                faq.classList.remove('open');
                faq.querySelector('.faq-answer').style.maxHeight = '0';
                faq.querySelector('.faq-question i').style.transform = 'rotate(0deg)';
            });
            
            // Open clicked item if it wasn't open
            if (!isOpen) {
                item.classList.add('open');
                answer.style.maxHeight = answer.scrollHeight + 'px';
                icon.style.transform = 'rotate(180deg)';
            }
        });
    });
}

function toggleFAQ(element) {
    const faqItem = element.parentElement;
    const answer = faqItem.querySelector('.faq-answer');
    const icon = element.querySelector('i');
    
    if (faqItem.classList.contains('open')) {
        faqItem.classList.remove('open');
        answer.style.maxHeight = '0';
        icon.style.transform = 'rotate(0deg)';
    } else {
        // Close other open FAQs
        document.querySelectorAll('.faq-item.open').forEach(openItem => {
            openItem.classList.remove('open');
            openItem.querySelector('.faq-answer').style.maxHeight = '0';
            openItem.querySelector('.faq-question i').style.transform = 'rotate(0deg)';
        });
        
        faqItem.classList.add('open');
        answer.style.maxHeight = answer.scrollHeight + 'px';
        icon.style.transform = 'rotate(180deg)';
    }
}

// ==================== MODAL FUNCTIONALITY ====================
function setupModal() {
    const modal = document.getElementById('serviceModal');
    const closeBtn = modal?.querySelector('.close');
    
    if (closeBtn) {
        closeBtn.addEventListener('click', closeModal);
    }
    
    if (modal) {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal();
            }
        });
    }
    
    // Escape key to close modal
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal && modal.style.display === 'flex') {
            closeModal();
        }
    });
}

function showModal() {
    const modal = document.getElementById('serviceModal');
    if (modal) {
        modal.style.display = 'flex';
        modal.style.animation = 'fadeIn 0.3s ease-out';
        document.body.style.overflow = 'hidden';
    }
}

function closeModal() {
    const modal = document.getElementById('serviceModal');
    if (modal) {
        modal.style.animation = 'fadeOut 0.3s ease-out';
        setTimeout(() => {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }, 300);
    }
}

function proceedToBooking() {
    // In a real application, this would redirect to a booking form
    alert(`Proceeding to booking for ${selectedService}. This would redirect to a booking form.`);
    closeModal();
    
    // Simulate form redirect
    window.location.href = `#contact?service=${selectedService}`;
}

// ==================== CONTACT FORMS ====================
function setupContactForms() {
    const contactForms = document.querySelectorAll('form');
    
    contactForms.forEach(form => {
        form.addEventListener('submit', handleFormSubmit);
    });
}

function handleFormSubmit(e) {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData);
    
    // Show loading state
    const submitBtn = e.target.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    submitBtn.textContent = 'Sending...';
    submitBtn.disabled = true;
    
    // Simulate API call
    setTimeout(() => {
        alert('Thank you for your message! We\'ll get back to you soon.');
        e.target.reset();
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
    }, 2000);
}

// ==================== COUNTER ANIMATIONS ====================
function setupCounterAnimations() {
    const counters = document.querySelectorAll('.stat-number');
    
    const animateCounter = (counter) => {
        const target = parseInt(counter.textContent.replace(/[^\d]/g, ''));
        const duration = 2000;
        const step = target / (duration / 16);
        let current = 0;
        
        const timer = setInterval(() => {
            current += step;
            if (current >= target) {
                counter.textContent = counter.textContent.replace(/[\d]/g, '') + target;
                clearInterval(timer);
            } else {
                counter.textContent = counter.textContent.replace(/[\d]/g, '') + Math.floor(current);
            }
        }, 16);
    };
    
    // Trigger when in view
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                observer.unobserve(entry.target);
            }
        });
    });
    
    counters.forEach(counter => observer.observe(counter));
}

// ==================== SMOOTH SCROLLING ====================
function setupSmoothScrolling() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                const headerOffset = 80;
                const elementPosition = target.offsetTop;
                const offsetPosition = elementPosition - headerOffset;
                
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
}

// ==================== TYPING EFFECT ====================
function setupTypingEffect() {
    const heroTitle = document.querySelector('.hero-title');
    if (!heroTitle) return;
    
    const originalText = heroTitle.textContent;
    const words = originalText.split(' ');
    let currentWord = 0;
    let currentChar = 0;
    let isDeleting = false;
    
    function typeEffect() {
        const currentText = words.slice(0, currentWord).join(' ') + 
                          (currentWord < words.length ? ' ' + words[currentWord].slice(0, currentChar) : '');
        
        heroTitle.textContent = currentText + '|';
        
        if (!isDeleting && currentChar < words[currentWord]?.length) {
            currentChar++;
            setTimeout(typeEffect, 100);
        } else if (!isDeleting && currentWord < words.length - 1) {
            currentWord++;
            currentChar = 0;
            setTimeout(typeEffect, 200);
        } else {
            heroTitle.textContent = originalText;
            setTimeout(() => {
                heroTitle.style.animation = 'fadeIn 0.5s ease-in';
            }, 500);
        }
    }
    
    // Start typing effect after initial load
    setTimeout(typeEffect, 2000);
}

// ==================== PARTICLE SYSTEM ====================
function setupParticleSystem() {
    const hero = document.querySelector('.hero');
    if (!hero) return;
    
    const canvas = document.createElement('canvas');
    canvas.style.position = 'absolute';
    canvas.style.top = '0';
    canvas.style.left = '0';
    canvas.style.width = '100%';
    canvas.style.height = '100%';
    canvas.style.pointerEvents = 'none';
    canvas.style.opacity = '0.1';
    
    hero.appendChild(canvas);
    
    const ctx = canvas.getContext('2d');
    const particles = [];
    
    function resizeCanvas() {
        canvas.width = hero.offsetWidth;
        canvas.height = hero.offsetHeight;
    }
    
    function createParticle() {
        return {
            x: Math.random() * canvas.width,
            y: Math.random() * canvas.height,
            vx: (Math.random() - 0.5) * 0.5,
            vy: (Math.random() - 0.5) * 0.5,
            size: Math.random() * 3 + 1
        };
    }
    
    function animateParticles() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        particles.forEach((particle, index) => {
            particle.x += particle.vx;
            particle.y += particle.vy;
            
            if (particle.x < 0 || particle.x > canvas.width) particle.vx *= -1;
            if (particle.y < 0 || particle.y > canvas.height) particle.vy *= -1;
            
            ctx.beginPath();
            ctx.arc(particle.x, particle.y, particle.size, 0, Math.PI * 2);
            ctx.fillStyle = '#667eea';
            ctx.fill();
        });
        
        requestAnimationFrame(animateParticles);
    }
    
    resizeCanvas();
    window.addEventListener('resize', resizeCanvas);
    
    // Create initial particles
    for (let i = 0; i < 50; i++) {
        particles.push(createParticle());
    }
    
    animateParticles();
}

// ==================== UTILITY FUNCTIONS ====================
function trackServiceSelection(serviceType) {
    // Analytics tracking (implement with your preferred analytics service)
    console.log(`Service selected: ${serviceType}`);
    
    // Example: Google Analytics event
    if (typeof gtag !== 'undefined') {
        gtag('event', 'service_selection', {
            'event_category': 'engagement',
            'event_label': serviceType,
            'value': 1
        });
    }
}

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

// Performance optimization
const debouncedScroll = debounce(() => {
    updateActiveNavLink();
}, 10);

window.addEventListener('scroll', debouncedScroll);

// ==================== ERROR HANDLING ====================
window.addEventListener('error', (e) => {
    console.error('JavaScript error:', e.error);
    // In production, you might want to send this to an error tracking service
});

// ==================== ACCESSIBILITY ====================
function setupAccessibility() {
    // Keyboard navigation for service cards
    const serviceCards = document.querySelectorAll('.service-card');
    serviceCards.forEach(card => {
        card.setAttribute('tabindex', '0');
        card.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                card.click();
            }
        });
    });
    
    // Focus trap for modal
    const modal = document.getElementById('serviceModal');
    if (modal) {
        modal.addEventListener('keydown', (e) => {
            if (e.key === 'Tab') {
                const focusableElements = modal.querySelectorAll(
                    'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
                );
                const firstElement = focusableElements[0];
                const lastElement = focusableElements[focusableElements.length - 1];
                
                if (e.shiftKey && document.activeElement === firstElement) {
                    e.preventDefault();
                    lastElement.focus();
                } else if (!e.shiftKey && document.activeElement === lastElement) {
                    e.preventDefault();
                    firstElement.focus();
                }
            }
        });
    }
}

// Initialize accessibility features
setupAccessibility();

// ==================== EXPORT FOR TESTING ====================
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        selectService,
        toggleFAQ,
        showModal,
        closeModal,
        proceedToBooking
    };
}
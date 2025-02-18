jQuery(document).ready(function($) {
    // Mobile Menu Toggle
    const mobileMenuBtn = $('.mobile-menu-btn');
    const navLinks = $('.nav-links');
    const navButtons = $('.nav-buttons');
    const navItems = $('.nav-item');
    let isMenuOpen = false;
    let currentOpenMenu = null;
    let hoverTimeout;
    const HOVER_DELAY = 200;

    function toggleScrollLock() {
        $('body').toggleClass('menu-open');
    }

    function toggleMenu() {
        mobileMenuBtn.toggleClass('active');
        navLinks.toggleClass('active');
        navButtons.toggleClass('active');
        toggleScrollLock();
    }

    mobileMenuBtn.on('click', toggleMenu);

    // Handle Mobile Mega Menu Toggles
    navItems.each(function() {
        const item = $(this);
        const link = item.find('.has-mega-menu');
        if (link.length) {
            link.on('click', function(e) {
                if (window.innerWidth <= 768) {
                    e.preventDefault();
                    const wasActive = item.hasClass('active');
                    closeAllMegaMenus();
                    if (!wasActive) {
                        item.addClass('active');
                        currentOpenMenu = item;
                    } else {
                        currentOpenMenu = null;
                    }
                }
            });
        }
    });

    // Close mobile menu when clicking outside
    $(document).on('click', function(e) {
        if (navLinks.hasClass('active') && 
            !$(e.target).closest('.nav-links').length && 
            !$(e.target).closest('.mobile-menu-btn').length) {
            toggleMenu();
        }
    });

    // Close mobile menu when pressing escape key
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape' && navLinks.hasClass('active')) {
            toggleMenu();
        }
    });

    // Handle window resize
    $(window).on('resize', function() {
        if (window.innerWidth > 768 && isMenuOpen) {
            toggleMenu();
        }
    });

    // Testimonials Slider
    const testimonialsSlider = $('.testimonials-slider');
    const prevBtn = $('.prev-btn');
    const nextBtn = $('.next-btn');
    const dots = $('.dot');
    const cards = $('.testimonial-card');
    let currentIndex = 0;

    function updateSlider() {
        const cardWidth = cards.first().outerWidth() + 32; // Width + gap
        testimonialsSlider.animate({
            scrollLeft: currentIndex * cardWidth
        }, 300);
        
        // Update dots
        dots.removeClass('active')
            .eq(currentIndex).addClass('active');

        // Update button states
        prevBtn.css('opacity', currentIndex === 0 ? '0.5' : '1');
        nextBtn.css('opacity', currentIndex === cards.length - 1 ? '0.5' : '1');
    }

    function slideNext() {
        if (currentIndex < cards.length - 1) {
            currentIndex++;
            updateSlider();
        }
    }

    function slidePrev() {
        if (currentIndex > 0) {
            currentIndex--;
            updateSlider();
        }
    }

    // Event Listeners
    nextBtn.on('click', slideNext);
    prevBtn.on('click', slidePrev);

    dots.each(function(index) {
        $(this).on('click', function() {
            currentIndex = index;
            updateSlider();
        });
    });

    // Touch events for mobile
    let touchStartX = 0;
    let touchEndX = 0;

    testimonialsSlider.on('touchstart', function(e) {
        touchStartX = e.originalEvent.touches[0].screenX;
    });

    testimonialsSlider.on('touchend', function(e) {
        touchEndX = e.originalEvent.changedTouches[0].screenX;
        handleSwipe();
    });

    function handleSwipe() {
        const swipeThreshold = 50;
        const swipeLength = touchEndX - touchStartX;

        if (Math.abs(swipeLength) > swipeThreshold) {
            if (swipeLength > 0) {
                slidePrev();
            } else {
                slideNext();
            }
        }
    }

    // Contact Form Handling
    const contactForm = $('#contactForm');
    const formInputs = contactForm.find('input, select, textarea');

    // Add floating label effect and validation
    formInputs.each(function() {
        const input = $(this);
        
        // Handle input focus
        input.on('focus', function() {
            input.parent().addClass('focused');
        });

        // Handle input blur
        input.on('blur', function() {
            input.parent().removeClass('focused');
            validateInput(input);
        });

        // Handle input change
        input.on('input', function() {
            validateInput(input);
        });
    });

    function validateInput(input) {
        const wrapper = input.parent();
        
        if (input.val().trim() === '') {
            if (input.prop('required')) {
                wrapper.addClass('invalid').removeClass('valid');
            }
        } else {
            if (input.attr('type') === 'email') {
                const isValidEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(input.val());
                wrapper.toggleClass('invalid', !isValidEmail)
                       .toggleClass('valid', isValidEmail);
            } else if (input.attr('type') === 'tel') {
                const isValidPhone = /^[\d\s-+()]*$/.test(input.val());
                wrapper.toggleClass('invalid', !isValidPhone)
                       .toggleClass('valid', isValidPhone);
            } else {
                wrapper.removeClass('invalid').addClass('valid');
            }
        }
    }

    // Handle form submission
    contactForm.on('submit', function(e) {
        e.preventDefault();
        
        // Validate all inputs before submission
        let isValid = true;
        formInputs.each(function() {
            validateInput($(this));
            if ($(this).parent().hasClass('invalid')) {
                isValid = false;
            }
        });

        if (!isValid) {
            return;
        }

        const submitBtn = contactForm.find('.submit-btn');
        const originalText = submitBtn.html();
        
        // Show loading state
        submitBtn.prop('disabled', true)
                .html('<i class="fas fa-spinner fa-spin"></i> Sending...');

        // Prepare form data
        const formData = new FormData(contactForm[0]);
        formData.append('action', 'asapsystems_contact_form');
        formData.append('nonce', asapsystemsAjax.nonce);

        // Send AJAX request
        $.ajax({
            url: asapsystemsAjax.ajaxurl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                showFormMessage(response.success ? 'success' : 'error', response.message);
                if (response.success) {
                    contactForm[0].reset();
                    formInputs.each(function() {
                        $(this).parent().removeClass('valid invalid focused');
                    });
                }
            },
            error: function() {
                showFormMessage('error', 'Oops! Something went wrong. Please try again later.');
            },
            complete: function() {
                submitBtn.prop('disabled', false).html(originalText);
            }
        });
    });

    function showFormMessage(type, message) {
        const messageDiv = $('<div>', {
            class: `form-message ${type}`,
            html: `
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                <span>${message}</span>
            `
        });
        
        contactForm.prepend(messageDiv);
        
        // Remove message after 5 seconds
        setTimeout(function() {
            messageDiv.remove();
        }, 5000);
    }

    // Newsletter Form Handling
    const newsletterForm = $('#newsletterForm');
    
    newsletterForm.on('submit', function(e) {
        e.preventDefault();
        
        const emailInput = newsletterForm.find('input[type="email"]');
        const submitBtn = newsletterForm.find('button[type="submit"]');
        const originalText = submitBtn.html();

        if (!emailInput.val().trim()) {
            return;
        }

        submitBtn.prop('disabled', true)
                .html('<i class="fas fa-spinner fa-spin"></i>');

        $.ajax({
            url: asapsystemsAjax.ajaxurl,
            type: 'POST',
            data: {
                action: 'asapsystems_newsletter_subscription',
                email: emailInput.val(),
                nonce: newsletterForm.find('#newsletter_nonce').val()
            },
            success: function(response) {
                if (response.success) {
                    emailInput.val('');
                    showNewsletterMessage('success', response.message);
                } else {
                    showNewsletterMessage('error', response.message);
                }
            },
            error: function() {
                showNewsletterMessage('error', 'Something went wrong. Please try again.');
            },
            complete: function() {
                submitBtn.prop('disabled', false).html(originalText);
            }
        });
    });

    function showNewsletterMessage(type, message) {
        const messageDiv = $('<div>', {
            class: `newsletter-message ${type}`,
            html: `<span>${message}</span>`
        });

        newsletterForm.after(messageDiv);

        setTimeout(function() {
            messageDiv.remove();
        }, 5000);
    }

    // Initialize the slider
    updateSlider();
}); 
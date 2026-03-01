document.addEventListener('DOMContentLoaded', () => {
    // Typing Effect
    const textToType = "Capture & Share Your Ideas Instantly";
    const typingElement = document.getElementById('typing-text');
    let typeIndex = 0;

    function typeWriter() {
        if (typeIndex < textToType.length) {
            typingElement.textContent += textToType.charAt(typeIndex);
            typeIndex++;
            setTimeout(typeWriter, 50); // Typing speed
        }
    }

    // Start typing after a short delay
    if (typingElement) {
        setTimeout(typeWriter, 500);
    }

    // Scroll Animations
    const observerOptions = {
        threshold: 0.1
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('slide-up-active');
                observer.unobserve(entry.target); // Only animate once
            }
        });
    }, observerOptions);

    const hiddenElements = document.querySelectorAll('.scroll-hidden');
    hiddenElements.forEach((el) => observer.observe(el));
});

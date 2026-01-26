document.addEventListener('DOMContentLoaded', function () {
    const preloader = document.getElementById('preloader');

    // Hide preloader when DOM is ready (not waiting for load event)
    setTimeout(function () {
        preloader.classList.add('hidden');

        // Remove from DOM after animation
        setTimeout(function () {
            preloader.style.display = 'none';
            // Optional: Remove from DOM entirely
            preloader.remove();
        }, 500);
    }, 500); // Short delay for visual effect

    // Safety timeout - remove if everything loads normally
    setTimeout(function () {
        if (preloader && preloader.style.display !== 'none') {
            preloader.remove();
        }
    }, 3000);
});

// Remove or simplify the livewire event listener
document.addEventListener('livewire:load', function () {
    const preloader = document.getElementById('preloader');
    if (preloader) {
        preloader.remove();
    }
});
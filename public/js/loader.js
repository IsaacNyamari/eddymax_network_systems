document.addEventListener('DOMContentLoaded', function () {
    const preloader = document.getElementById('preloader');
    window.addEventListener('load', function () {
        setTimeout(function () {
            preloader.classList.add('preloader-hidden');
            setTimeout(function () {
                preloader.style.display = 'none';
            }, 500);
        }, 500);
    });

    setTimeout(function () {
        if (preloader.style.display !== 'none') {
            preloader.classList.add('preloader-hidden');
            setTimeout(function () {
                preloader.style.display = 'none';
            }, 500);
        }
    }, 3000);
});
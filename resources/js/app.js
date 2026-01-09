// resources/js/app.js
import './bootstrap';
import 'flowbite';
import './editor';
// Import Alpine
import Alpine from 'alpinejs';

// Import Chart.js
import Chart from 'chart.js/auto';

window.Chart = Chart;

window.Alpine = Alpine;

// Initialize Alpine after Livewire is ready
document.addEventListener('livewire:load', () => {
    Alpine.start();
});
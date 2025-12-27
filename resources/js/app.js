import './bootstrap';
import 'flowbite';

// Import Livewire
import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';

// Import Alpine
import Alpine from 'alpinejs';

// Import Chart.js
import Chart from 'chart.js/auto';

// Make them globally available
window.Alpine = Alpine;
window.Chart = Chart;

// Start Alpine
Alpine.start();

// Start Livewire AFTER Alpine
Livewire.start();
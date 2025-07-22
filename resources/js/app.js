// resources/js/app.js

import './bootstrap'; // Keep this if you have it for Axios/CSRF setup

import Alpine from 'alpinejs';
import focus from '@alpinejs/focus'; // Import the focus plugin

// Register the focus plugin with Alpine.js
Alpine.plugin(focus);

// Make Alpine available globally (optional, but common practice)
window.Alpine = Alpine;

// Start Alpine.js
Alpine.start();

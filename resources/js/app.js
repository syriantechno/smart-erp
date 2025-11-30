// Load static files
import.meta.glob(["../images/**"]);

// Load theme settings for settings page
import './theme-settings';
import './erp/crud';

// Import page modules
import './pages/attendance';
import './pages/departments';
import './pages/positions';
import './pages/payroll';
import './pages/leave';

// Configure axios for CSRF protection
import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Set CSRF token for all axios requests
let token = document.head?.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

// Initialize all pages on DOMContentLoaded
document.addEventListener('DOMContentLoaded', () => {
    if (typeof window.initializeProjectsPage === 'function') {
        window.initializeProjectsPage();
    }
    if (typeof window.initializeDepartmentsPage === 'function') {
        window.initializeDepartmentsPage();
    }
    if (typeof window.initializePositionsPage === 'function') {
        window.initializePositionsPage();
    }
    if (typeof window.initializeAttendancePage === 'function') {
        window.initializeAttendancePage();
    }
    if (typeof window.initializeLeavePage === 'function') {
        window.initializeLeavePage();
    }
    if (typeof window.initializePayrollModal === 'function') {
        window.initializePayrollModal();
    }
});

import Alpine from 'alpinejs';
import AOS from 'aos';
import Swal from 'sweetalert2';
import axios from 'axios';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.Swal = Swal;

// Custom SweetAlert2 Toast Mixin with Gumer Brand Styling
window.Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3500,
    timerProgressBar: true,
    background: '#FAF6EE',
    color: '#2C1810',
    customClass: {
        popup: 'border border-[#E8DFD1] shadow-lg rounded-xl font-sans',
    },
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
    }
});

// Initialize AOS (Animate on Scroll)
AOS.init({
    duration: 650,
    once: true,
    offset: 40,
    easing: 'ease-out-cubic'
});

window.Alpine = Alpine;
Alpine.start();

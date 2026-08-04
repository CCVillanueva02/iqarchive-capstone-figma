import Swal from 'sweetalert2';
window.Swal = Swal;

import './iqa-documents.js';

document.addEventListener('alpine:init', () => {
    if (window.documentWorkspace && typeof Alpine !== 'undefined') {
        Alpine.data('documentWorkspace', window.documentWorkspace);
    }
});

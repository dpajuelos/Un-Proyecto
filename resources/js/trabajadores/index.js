document.addEventListener('DOMContentLoaded', function () {
    // Búsqueda en tiempo real
    const searchInput = document.getElementById('searchInput');

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const searchTerm = this.value.toLowerCase();

            // Search in mobile cards
            const mobileCards = document.querySelectorAll('.worker-card');
            mobileCards.forEach(card => {
                const text = card.textContent.toLowerCase();
                const parent = card.closest('.mobile-card');
                if (text.includes(searchTerm)) {
                    parent.style.display = 'block';
                } else {
                    parent.style.display = 'none';
                }
            });

            // Search in table rows
            const tableRows = document.querySelectorAll('.modern-table tbody tr');
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }

    // Add smooth scrolling to action buttons
    const actionButtons = document.querySelectorAll('.action-btn, .table-btn');
    actionButtons.forEach(btn => {
        btn.addEventListener('mouseenter', function () {
            this.style.transform = 'translateY(-2px)';
        });

        btn.addEventListener('mouseleave', function () {
            this.style.transform = 'translateY(0)';
        });
    });
});

// Funciones para el modal de eliminación
window.showDeleteModal = function (workerId, workerName, workerDNI) {
    const modal = document.getElementById('deleteModalOverlay');
    const form = document.getElementById('deleteForm');
    const nameEl = document.getElementById('workerName');
    const dniEl = document.getElementById('workerDNI');
    const avatarEl = document.getElementById('workerAvatar');

    // Configurar información del trabajador
    nameEl.textContent = workerName;
    dniEl.textContent = workerDNI;
    avatarEl.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(workerName)}&background=ef4444&color=fff&size=60`;

    // Configurar formulario
    form.action = `/trabajadores/${workerId}`;

    // Mostrar modal con animación
    modal.style.display = 'flex';
    setTimeout(() => {
        modal.classList.add('show');
    }, 10);

    // Bloquear scroll del body
    document.body.style.overflow = 'hidden';
};

window.hideDeleteModal = function () {
    const modal = document.getElementById('deleteModalOverlay');

    // Ocultar modal con animación
    modal.classList.remove('show');
    setTimeout(() => {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }, 300);
};

// Cerrar modal al hacer clic fuera de él
document.addEventListener('click', function (e) {
    const modal = document.getElementById('deleteModalOverlay');
    if (e.target === modal) {
        hideDeleteModal();
    }
});

// Cerrar modal con tecla Escape
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        hideDeleteModal();
    }
});

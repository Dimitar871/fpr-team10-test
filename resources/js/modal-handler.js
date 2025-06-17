const actionModal = document.getElementById('actionModal');
const cancelActionBtn = document.getElementById('cancelActionBtn');
const actionForm = document.getElementById('actionForm');
const modalMessage = document.getElementById('modalMessage');
const modalTitle = document.getElementById('modalTitle');

window.showBuyConfirmModal = function (actionUrl, itemName = 'this item', points) {
    actionForm.setAttribute('action', actionUrl);
    modalTitle.textContent = 'Confirm Purchase';
    modalMessage.textContent = `Are you sure you want to buy "${itemName}" for ${points} points?`;
    actionModal.classList.remove('hidden');
    actionModal.style.display = 'flex';
};

cancelActionBtn.addEventListener('click', () => {
    actionModal.classList.add('hidden');
    actionModal.style.display = 'none';
    actionForm.setAttribute('action', '');
    modalTitle.textContent = '';
    modalMessage.textContent = '';
});

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.open-action-modal').forEach(btn => {
        btn.addEventListener('click', function () {
            const action = this.dataset.action;
            const title = this.dataset.title || 'Confirm Action';
            const message = this.dataset.message || 'Are you sure you want to proceed?';
            const method = this.dataset.method || 'POST';

            actionForm.setAttribute('action', action);
            modalTitle.textContent = title;
            modalMessage.textContent = message;

            const existingMethod = actionForm.querySelector('input[name="_method"]');
            if (existingMethod) existingMethod.remove();

            if (method !== 'POST') {
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = method;
                actionForm.appendChild(methodInput);
            }

            actionModal.classList.remove('hidden');
            actionModal.style.display = 'flex';
        });
    });
});

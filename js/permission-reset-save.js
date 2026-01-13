document.addEventListener('DOMContentLoaded', () => {
    const permissionSection = document.getElementById('permissionSection');
    if (!permissionSection) return;

    const resetButton = permissionSection.querySelector('.reset-button');
    const saveButton = permissionSection.querySelector('.save-button');
    const allCheckboxes = permissionSection.querySelectorAll('.permission-table input[type="checkbox"]');
    
    const storageKey = 'userPermissionsState';

    let defaultState = [];
    allCheckboxes.forEach(cb => {
        defaultState.push(cb.checked);
    });

    function loadPermissions() {
        const savedState = localStorage.getItem(storageKey);
        if (savedState) {
            const stateArray = JSON.parse(savedState);
            allCheckboxes.forEach((cb, index) => {
                cb.checked = stateArray[index];
            });
            console.log("Pengaturan izin berhasil dimuat.");
        } else {
            console.log("Tidak ada pengaturan tersimpan, menggunakan default.");
        }
    }

    if (saveButton) {
        saveButton.addEventListener('click', () => {
            let currentState = [];
            allCheckboxes.forEach(cb => {
                currentState.push(cb.checked);
            });
            localStorage.setItem(storageKey, JSON.stringify(currentState));
            alert("Pengaturan izin berhasil disimpan!");
        });
    }

    if (resetButton) {
        resetButton.addEventListener('click', () => {
            const confirmReset = confirm("Apakah Anda yakin ingin mengatur ulang semua izin ke default?");
            if (confirmReset) {
                allCheckboxes.forEach((cb, index) => {
                    cb.checked = defaultState[index];
                });
            }
        });
    }

    loadPermissions();
});
document.addEventListener('DOMContentLoaded', (event) => {
    const inputRekening = document.getElementById('noRekening');

    if (inputRekening) {
        inputRekening.addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^0-9]/g, ''); 

            let formattedValue = '';

            if (value.length > 0) {
                // Kelompok 1: 4 digit
                formattedValue += value.substring(0, 4);
            }
            if (value.length > 4) {
                // Kelompok 2: 2 digit
                formattedValue += '-' + value.substring(4, 6);
            }
            if (value.length > 6) {
                // Kelompok 3: 6 digit
                formattedValue += '-' + value.substring(6, 12);
            }
            if (value.length > 12) {
                // Kelompok 4: 2 digit
                formattedValue += '-' + value.substring(12, 14);
            }
            if (value.length > 14) {
                // Kelompok 5: 1 digit
                formattedValue += '-' + value.substring(14, 15);
            }

            e.target.value = formattedValue;
        });

        inputRekening.setAttribute('maxlength', '19');
    }
});
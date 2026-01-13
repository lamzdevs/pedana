const inputNamaLengkap = document.getElementById('namaLengkap');

if (inputNamaLengkap) {
    inputNamaLengkap.addEventListener('input', function(e) {
        let value = e.target.value;
        let filteredValue = value.replace(/[^a-zA-Z\s]/g, '');

        e.target.value = filteredValue;
    });
}
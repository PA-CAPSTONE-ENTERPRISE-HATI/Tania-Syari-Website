// Ambil semua elemen radio input untuk rating
// const ratings = document.querySelectorAll('input[name="rate"]');
// const namaProdukInput = document.querySelector('.textarea1 textarea');
// const deskripsiInput = document.querySelector('.textarea textarea');
// const form = document.querySelector('form');

// Tambahkan event listener untuk saat formulir disubmit
// form.addEventListener('submit', function(event) {
//     event.preventDefault(); // Mencegah pengiriman formulir secara langsung

//     let selectedRating;
//     ratings.forEach(rating => {
//         if (rating.checked) {
//             selectedRating = rating.id.split('-')[1]; // Ambil nilai rating yang dipilih
//         }
//     });

//     const namaProduk = namaProdukInput.value;
//     const deskripsi = deskripsiInput.value;

//     // Kirim data ke server menggunakan Fetch API
//     fetch('http://localhost/capstone/baju/index.php', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json'
//         },
//         body: JSON.stringify({
//             rating: selectedRating,
//             nama_produk: namaProduk,
//             deskripsi: deskripsi
//         })
//     })
//     .then(response => {
//         if (!response.ok) {
//             throw new Error('Network response was not ok');
//         }
//         return response.json();
//     })
//     .then(data => {
//         console.log('Data saved:', data);
//         // Lakukan sesuatu setelah data berhasil disimpan
//     })
//     .catch(error => {
//         console.error('There was a problem with your fetch operation:', error);
//     });
// });

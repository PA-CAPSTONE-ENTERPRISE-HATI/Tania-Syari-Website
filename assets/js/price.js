document.addEventListener("DOMContentLoaded", function() {
    var prices = document.getElementsByClassName('price');
    for (var i = 0; i < prices.length; i++) {
        // Using parseFloat to handle decimal values correctly
        var price = parseFloat(prices[i].innerText);
        prices[i].innerText = formatPrice(price);
    }
});

function formatPrice(price) {
    // Formatting the price according to Indonesian currency format
    return 'Rp' + price.toLocaleString('id-ID', {
        minimumFractionDigits: 2, // ensure two decimal places
        maximumFractionDigits: 2  // ensure two decimal places
    });
}

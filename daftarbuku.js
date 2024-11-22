const API_URL = 'http://localhost/api/product/';

async function fetchProducts() {
    const response = await fetch(API_URL);
    const products = await response.json();

    const productContainer = document.getElementById('product-list');
    productContainer.innerHTML = '';

    products.forEach(product => {
        const productCard = document.createElement('div');
        productCard.className = 'product-card';

        productCard.innerHTML = `
            <h2>${product.NAME}</h2>
            <p>${product.DESCRIPTION}</p>
            <p><strong>Price:</strong> $${product.PRICE}</p>
        `;
        productContainer.appendChild(productCard);
    });
}

document.addEventListener('DOMContentLoaded', fetchProducts);

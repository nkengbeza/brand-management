const apiUrl = '/api/toplist';
const brandList = document.getElementById('brand-list');
const prevBtn = document.getElementById('prev-page');
const nextBtn = document.getElementById('next-page');
const pageInfo = document.getElementById('page-info');
const countrySelect = document.getElementById('country-select');

let currentPage = 1;
let currentCountry = countrySelect.value;
const perPage = 15;
let totalPages = 1;

function loadBrands(page = 1, country = 'DEFAULT') {
    brandList.innerHTML = 'Please wait...';

    fetch(`${apiUrl}?per_page=${perPage}&page=${page}`, {
        headers: {
            'Accept': 'application/json',
            'CF-IPCountry': country
        }
    })
        .then(res => res.json())
        .then(data => {
            if (!data || !data.data) {
                brandList.innerHTML = '<p>No brands available.</p>';
                return;
            }

            brandList.innerHTML = data.data.map(brand => `
                <div class="brand-card">
                  <img src="${brand.image}" alt="${brand.name}">
                  <h2>${brand.name}</h2>
                  <div class="rating">${'★'.repeat(brand.rating)}${'☆'.repeat(5 - brand.rating)}</div>
                </div>
              `).join('');

            currentPage = data.pagination.page;
            totalPages = data.pagination.total_pages;

            pageInfo.textContent = `Page ${currentPage} of ${totalPages}`;
            prevBtn.disabled = currentPage === 1;
            nextBtn.disabled = currentPage === totalPages;
        })
        .catch(err => {
            console.error(err);
            brandList.innerHTML = '<p>Failed to load brands.</p>';
        });
}

loadBrands(currentPage, currentCountry);

prevBtn.addEventListener('click', () => {
    if (currentPage > 1) loadBrands(currentPage - 1, currentCountry);
});

nextBtn.addEventListener('click', () => {
    if (currentPage < totalPages) loadBrands(currentPage + 1, currentCountry);
});

countrySelect.addEventListener('change', () => {
    currentCountry = countrySelect.value;
    currentPage = 1;
    loadBrands(currentPage, currentCountry);
});

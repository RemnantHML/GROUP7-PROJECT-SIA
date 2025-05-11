async function fetchBreeds(query = '') {
  const endpoint = query
    ? `http://localhost:8000/breeds/search/${encodeURIComponent(query)}`
    : 'http://localhost:8000/breeds';

  try {
    const response = await fetch(endpoint);
    let breeds = await response.json();

    const resultsContainer = document.getElementById('dog-results');
    resultsContainer.innerHTML = '';

    // Limit to first 4 breeds if no query is entered
    if (!query) {
      breeds = breeds.slice(0, 4);
    }

    if (!breeds.length) {
      resultsContainer.innerHTML = '<p>No breeds found.</p>';
      return;
    }

    // Fetch image for each breed and display the breed details
    for (let breed of breeds) {
      // Fetch breed image
      const imageResponse = await fetch(`https://dog.ceo/api/breeds/image/random?breed=${breed.name.toLowerCase()}`);
      const imageData = await imageResponse.json();
      const imageUrl = imageData.message;

      // Create the dog card with breed details and image
      const card = document.createElement('div');
      card.className = 'dog-card';

      card.innerHTML = `
        <img src="${imageUrl}" alt="${breed.name}" style="width: 100%; height: 150px; object-fit: cover; border-radius: 8px; margin-bottom: 10px;">
        <h3>${breed.name}</h3>
        <p><strong>Life Span:</strong> ${breed.life_span || 'N/A'}</p>
        <p><strong>Origin:</strong> ${breed.origin || 'N/A'}</p>
        <p><strong>Temperament:</strong> ${breed.temperament || 'N/A'}</p>
      `;
      resultsContainer.appendChild(card);
    }
  } catch (err) {
    console.error('Failed to fetch breeds:', err);
    document.getElementById('dog-results').innerHTML = '<p>Error loading data.</p>';
  }
}

document.getElementById('search-dog-btn').addEventListener('click', () => {
  const query = document.getElementById('dog-search-input').value.trim();
  fetchBreeds(query);
});

// Load first 4 breeds on page load
window.addEventListener('DOMContentLoaded', () => fetchBreeds());

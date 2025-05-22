document.getElementById('fetchFactBtn').addEventListener('click', async () => {
  const number = document.getElementById('numberInput').value.trim();
  const type = document.getElementById('typeSelect').value;
  const factDisplay = document.getElementById('factDisplay');

  // Validate number
  if (!number) {
    factDisplay.textContent = 'Please enter a valid number.';
    return;
  }

  // Validate date format for date type
  if (type === 'date' && !/^\d{1,2}\/\d{1,2}$/.test(number)) {
    factDisplay.textContent = 'Please enter a date in MM/DD format (e.g., 4/15).';
    return;
  }

  factDisplay.textContent = 'Loading...';

  try {
    const authToken = localStorage.getItem('authToken');
    if (!authToken) {
      factDisplay.textContent = 'Authentication token not found. Please log in again.';
      return;
    }

    // Use your backend URL here
    const url = new URL('http://localhost:8000/site3');
    url.searchParams.set('number', number);
    url.searchParams.set('type', type);

    const response = await fetch(url.toString(), {
      method: 'GET',
      headers: {
        'Authorization': `Bearer ${authToken}`,
        'Accept': 'application/json',
      },
    });

    if (!response.ok) {
      throw new Error(`Server returned status ${response.status}`);
    }

    const data = await response.json();

    // Show the 'text' field from the API response
    factDisplay.textContent = data.text || 'No fact found.';

  } catch (error) {
    console.error('Fetch error:', error);
    factDisplay.textContent = `Failed to fetch fact: ${error.message}`;
  }
});

// Display logged in user email if available
const userEmail = localStorage.getItem('userEmail');
const userDisplay = document.getElementById('userEmailDisplay');
if (userDisplay && userEmail) {
  userDisplay.textContent = `Logged in as: ${userEmail}`;
}

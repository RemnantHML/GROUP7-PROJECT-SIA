const API_URL = "http://localhost:8000/wikipedia/search";

// Function to search Wikipedia articles using your API endpoint
function searchWiki() {
  const query = document.getElementById("searchInput").value.trim();
  if (!query) return; // Do nothing if input is empty

  fetch(`${API_URL}?srsearch=${encodeURIComponent(query)}&srlimit=10`)
    .then(res => res.json())
    .then(data => {
      const results = data.query?.search || [];
      const container = document.getElementById("resultsContainer");
      container.innerHTML = ""; // Clear previous results

      // Create and append result items
      results.forEach(item => {
        const div = document.createElement("div");
        div.className = "result-item";
        div.innerHTML = `<strong>${item.title}</strong><p>${item.snippet}...</p>`;
        div.addEventListener("click", () => showPageContent(item.pageid, item.title));
        container.appendChild(div);
      });
    })
    .catch(err => {
      console.error("Error fetching search results:", err);
      document.getElementById("resultsContainer").innerHTML = "<p>Failed to load results. Please try again later.</p>";
    });
}

// Function to fetch and display full Wikipedia page content inside the modal
function showPageContent(pageid, title) {
  fetch(`https://en.wikipedia.org/w/api.php?origin=*&action=parse&pageid=${pageid}&format=json`)
    .then(res => res.json())
    .then(data => {
      const content = data.parse?.text["*"] || "<p>No content found</p>";
      document.getElementById("fullContent").innerHTML = `<h2>${title}</h2>${content}`;
      document.getElementById("contentModal").style.display = "flex";
    })
    .catch(err => {
      console.error("Error fetching full content:", err);
      document.getElementById("fullContent").innerHTML = "<p>Failed to load content. Please try again later.</p>";
      document.getElementById("contentModal").style.display = "flex";
    });
}

// Function to close the modal
function closeModal() {
  document.getElementById("contentModal").style.display = "none";
}

// Optional: Close modal when clicking outside modal content
window.onclick = function(event) {
  const modal = document.getElementById("contentModal");
  if (event.target === modal) {
    closeModal();
  }
};

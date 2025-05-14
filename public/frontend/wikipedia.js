const API_URL = "http://localhost:8000/wikipedia/search";

function searchWiki() {
  const query = document.getElementById("searchInput").value.trim();
  if (!query) return;

  fetch(`${API_URL}?srsearch=${encodeURIComponent(query)}&srlimit=10`)
    .then(res => res.json())
    .then(data => {
      const results = data.query?.search || [];
      const container = document.getElementById("resultsContainer");
      container.innerHTML = "";

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
    });
}

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
    });
}

function closeModal() {
  document.getElementById("contentModal").style.display = "none";
}

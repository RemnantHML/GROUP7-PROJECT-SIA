const API_URL = "http://localhost:8000/api/site1";

// Function to search Wikipedia articles using your secure API
function searchWiki() {
  const query = document.getElementById("searchInput").value.trim();
  if (!query) return;

  const token = localStorage.getItem('authToken'); // Assumes token is stored after login
  if (!token) {
    alert("You are not logged in. Please login first.");
    return;
  }

  fetch(`${API_URL}?query=${encodeURIComponent(query)}`, {
    method: 'GET',
    headers: {
      'Authorization': `Bearer ${token}`
    }
  })
    .then(res => {
      if (!res.ok) {
        throw new Error("Unauthorized or request failed");
      }
      return res.json();
    })
    .then(data => {
      const container = document.getElementById("resultsContainer");
      container.innerHTML = "";

      data.forEach(item => {
        const div = document.createElement("div");
        div.className = "result-item";
        div.innerHTML = `<strong>${item.title}</strong><p>${item.snippet}...</p>`;
        div.addEventListener("click", () => showPageContent(item.pageid, item.title));
        container.appendChild(div);
      });
    })
    .catch(err => {
      console.error("Search failed:", err);
      document.getElementById("resultsContainer").innerHTML = "<p>Login or try again later.</p>";
    });
}

// Full Wikipedia page content
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

function closeModal() {
  document.getElementById("contentModal").style.display = "none";
}

window.onclick = function(event) {
  const modal = document.getElementById("contentModal");
  if (event.target === modal) {
    closeModal();
  }
// Optionally, display user email somewhere
const userEmail = localStorage.getItem('userEmail');
const userDisplay = document.getElementById('userEmailDisplay');
if (userDisplay && userEmail) {
      userDisplay.textContent = `Logged in as: ${userEmail}`;
    }
};

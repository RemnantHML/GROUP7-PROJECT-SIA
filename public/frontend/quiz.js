document.addEventListener("DOMContentLoaded", () => {
  const categoryInput = document.getElementById("category"); // Changed to input field
  const form = document.getElementById("generate-form");
  const output = document.getElementById("quiz-output");
  const sidebar = document.getElementById("sidebar"); // Sidebar container

  // Fetch categories
  fetch("https://opentdb.com/api_category.php")
    .then(res => res.json())
    .then(data => {
      // Clear sidebar before adding new categories
      sidebar.innerHTML = "<h3>Categories</h3>";

      data.trivia_categories.forEach(cat => {
        // Add to sidebar with category ID and name
        const sidebarItem = document.createElement("div");
        sidebarItem.classList.add("sidebar-item");
        sidebarItem.textContent = `id: ${cat.id} - ${cat.name}`;  // Display ID and name
        sidebar.appendChild(sidebarItem);
      });
    })
    .catch(() => {
      sidebar.innerHTML = "<p>Failed to load categories</p>";
    });

  // Handle quiz generation
  form.addEventListener("submit", e => {
    e.preventDefault();
    output.innerHTML = "<p>Loading quiz...</p>";

    const amount = document.getElementById("amount").value;
    const category = categoryInput.value;  // Get category ID from input field
    const difficulty = document.getElementById("difficulty").value;
    const type = document.getElementById("type").value;

    const params = new URLSearchParams({ amount, type });
    if (category) params.append("category", category); // Send category ID as input
    if (difficulty) params.append("difficulty", difficulty);

    fetch(`http://localhost:8000/api/quiz?${params.toString()}`)
      .then(res => res.json())
      .then(data => {
        if (data.results && data.results.length > 0) {
          output.innerHTML = data.results.map((q, index) => {
            const answers = [...q.incorrect_answers, q.correct_answer]
              .sort(() => Math.random() - 0.5)
              .map(ans => `<li>${ans}</li>`).join("");
            return ` 
              <div class="question-block">
                <h4>Q${index + 1}: ${q.question}</h4>
                <ul>${answers}</ul>
              </div>
            `;
          }).join("");
        } else {
          output.innerHTML = "<p>No questions found.</p>";
        }
      })
      .catch(() => {
        output.innerHTML = "<p>Failed to fetch questions. Try again.</p>";
      });
  });
});
// Optionally, display user email somewhere
const userEmail = localStorage.getItem('userEmail');
const userDisplay = document.getElementById('userEmailDisplay');
if (userDisplay && userEmail) {
      userDisplay.textContent = `Logged in as: ${userEmail}`;
    };
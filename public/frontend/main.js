// public/frontend/js/main.js
console.log("Dashboard loaded");

// Optionally add fetches to your Lumen API endpoints here
document.addEventListener("DOMContentLoaded", () => {
  const categorySelect = document.getElementById("category");
  const form = document.getElementById("generate-form");
  const output = document.getElementById("quiz-output");

  // Fetch categories
  fetch("http://localhost:8000/api/categories")
    .then(res => res.json())
    .then(data => {
      categorySelect.innerHTML = '<option value="">Any</option>';
      data.trivia_categories.forEach(cat => {
        const option = document.createElement("option");
        option.value = cat.id;
        option.textContent = cat.name;
        categorySelect.appendChild(option);
      });
    })
    .catch(() => {
      categorySelect.innerHTML = '<option value="">Failed to load categories</option>';
    });

  // Handle quiz generation
  form.addEventListener("submit", e => {
    e.preventDefault();
    output.innerHTML = "<p>Loading quiz...</p>";

    const amount = document.getElementById("amount").value;
    const category = document.getElementById("category").value;
    const difficulty = document.getElementById("difficulty").value;
    const type = document.getElementById("type").value;

    const params = new URLSearchParams({ amount, type });
    if (category) params.append("category", category);
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

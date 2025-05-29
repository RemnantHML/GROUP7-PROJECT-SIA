document.getElementById("lookupBtn").addEventListener("click", async () => {
  const word = document.getElementById("wordInput").value.trim();
  const resultsContainer = document.getElementById("dictionaryResults");
  resultsContainer.innerHTML = "";

  if (!word) {
    resultsContainer.innerHTML = "<p>Please enter a word to search.</p>";
    return;
  }

  try {
    const response = await fetch(`https://api.dictionaryapi.dev/api/v2/entries/en/${word}`);
    if (!response.ok) throw new Error("Word not found");

    const data = await response.json();
    const meanings = data[0].meanings;

    meanings.forEach((meaning, i) => {
      const defBlock = document.createElement("div");
      defBlock.className = "dictionary-definition";

      const partOfSpeech = document.createElement("h3");
      partOfSpeech.textContent = `${i + 1}. ${meaning.partOfSpeech}`;

      const definitions = meaning.definitions.map((def, j) =>
        `<p><strong>Definition ${j + 1}:</strong> ${def.definition}</p>`
      ).join("");

      defBlock.appendChild(partOfSpeech);
      defBlock.innerHTML += definitions;

      resultsContainer.appendChild(defBlock);
    });

  } catch (err) {
    resultsContainer.innerHTML = `<p style="color: red;">Error: ${err.message}</p>`;
  }
});
// Optionally, display user email somewhere
const userEmail = localStorage.getItem('userEmail');
const userDisplay = document.getElementById('userEmailDisplay');
if (userDisplay && userEmail) {
      userDisplay.textContent = `Logged in as: ${userEmail}`;
    };
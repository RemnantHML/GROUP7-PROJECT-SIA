function displayUser(data) {
      const output = document.getElementById("codewars-output");
      output.innerHTML = `
        <h3>${data.username}</h3>
        <p><strong>Clan:</strong> ${data.clan || 'N/A'}</p>
        <p><strong>Honor:</strong> ${data.honor}</p>
        <p><strong>Rank:</strong> ${data.ranks.overall.name} (${data.ranks.overall.score})</p>
        <p><strong>Completed Kata:</strong> ${data.codeChallenges.totalCompleted}</p>
      `;
    }

    function fetchCodewars() {
      const username = document.getElementById("username").value || "g964";
      const output = document.getElementById("codewars-output");
      output.innerHTML = "<p>Loading...</p>";

      fetch(`http://localhost:8000/api/codewars/${username}`)
        .then(res => res.json())
        .then(data => {
          if (data.error) {
            output.innerHTML = `<p>Error: ${data.error}</p>`;
          } else {
            displayUser(data);
          }
        })
        .catch(() => {
          output.innerHTML = "<p>Failed to fetch Codewars data.</p>";
        });
    }

    // Fetch default user on load
    document.addEventListener("DOMContentLoaded", fetchCodewars);
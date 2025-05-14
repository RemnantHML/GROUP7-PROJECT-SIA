const API_URL = 'http://localhost:8000/api/schedules/';
const form = document.getElementById('scheduler-form');
const taskList = document.getElementById('task-list');
const filterInput = document.getElementById('date-filter');
const filterBtn = document.getElementById('filter-btn');

// Load all schedules
async function loadSchedules(filterDate = '') {
  try {
    const response = await fetch(API_URL);
    const schedules = await response.json();

    taskList.innerHTML = ''; // Clear the list before re-rendering

    schedules.forEach(schedule => {
      // If there's a filter, only show tasks matching that date
      if (filterDate && !new Date(schedule.scheduled_at).toISOString().startsWith(filterDate)) {
        return;
      }

      const li = document.createElement('li');
      li.className = 'scheduler-task-item';
      li.innerHTML = `
        <div>
          <strong>${schedule.title}</strong>
          <em>${schedule.description}</em><br>
          <small>${new Date(schedule.scheduled_at).toLocaleString()}</small>
        </div>
        <div class="scheduler-actions">
          <button class="delete-btn" onclick="deleteSchedule(${schedule.id})">Delete</button>
        </div>
      `;
      taskList.appendChild(li); // Append the new task at the bottom
    });
  } catch (error) {
    console.error('Error loading schedules:', error);
  }
}

// Handle form submission to add new schedule
form.addEventListener('submit', async (e) => {
  e.preventDefault();

  const title = document.getElementById('title').value.trim();
  const description = document.getElementById('description').value.trim();
  const scheduled_at = document.getElementById('scheduled_at').value;

  try {
    // Send new task to the API
    await fetch(API_URL, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ title, description, scheduled_at })
    });

    form.reset();
    loadSchedules(); // Reload schedules with the new one added
  } catch (error) {
    console.error('Error adding schedule:', error);
  }
});

// Delete a schedule
async function deleteSchedule(id) {
  try {
    await fetch(`${API_URL}?id=${id}`, {
      method: 'DELETE'
    });
    loadSchedules(); // Reload schedules after deletion
  } catch (error) {
    console.error('Error deleting schedule:', error);
  }
}

// Filter schedules by date
filterBtn.addEventListener('click', () => {
  const filterDate = filterInput.value;
  loadSchedules(filterDate); // Only display schedules that match the selected date
});

// Load schedules on page load
window.addEventListener('DOMContentLoaded', () => loadSchedules());

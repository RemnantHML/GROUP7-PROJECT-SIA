const API_URL = 'http://localhost:8000/api/schedules/';
const form = document.getElementById('scheduler-form');
const taskList = document.getElementById('task-list');
const filterInput = document.getElementById('date-filter');
const filterBtn = document.getElementById('filter-btn');

// 🔐 Get token from localStorage
const token = localStorage.getItem('authToken');

// 🔒 If no token, redirect to login
if (!token) {
  window.location.href = 'login.html';
}

// 🔐 Helper to inject auth header
function authFetch(url, options = {}) {
  return fetch(url, {
    ...options,
    headers: {
      ...(options.headers || {}),
      'Authorization': `Bearer ${token}`,
      'Content-Type': 'application/json',
    },
  });
}

// 🚀 Load all schedules (optionally filtered by date)
async function loadSchedules(filterDate = '') {
  try {
    const response = await authFetch(API_URL);
    if (response.status === 401) return handleUnauthorized();

    const schedules = await response.json();
    taskList.innerHTML = '';

    schedules.forEach(schedule => {
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
      taskList.appendChild(li);
    });
  } catch (error) {
    console.error('Error loading schedules:', error);
  }
}

// ➕ Add schedule
form.addEventListener('submit', async (e) => {
  e.preventDefault();
  const title = document.getElementById('title').value.trim();
  const description = document.getElementById('description').value.trim();
  const scheduled_at = document.getElementById('scheduled_at').value;

  try {
    const response = await authFetch(API_URL, {
      method: 'POST',
      body: JSON.stringify({ title, description, scheduled_at }),
    });
    if (response.status === 401) return handleUnauthorized();

    form.reset();
    loadSchedules();
  } catch (error) {
    console.error('Error adding schedule:', error);
  }
});

// ❌ Delete schedule
async function deleteSchedule(id) {
  try {
    const response = await authFetch(`${API_URL}${id}`, {
      method: 'DELETE',
    });
    if (response.status === 401) return handleUnauthorized();

    alert('Schedule deleted!');
    loadSchedules();
  } catch (err) {
    console.error(err);
    alert('Error deleting schedule');
  }
}

// 📆 Filter
filterBtn.addEventListener('click', () => {
  const filterDate = filterInput.value;
  loadSchedules(filterDate);
});

// 🚨 Redirect on unauthorized
function handleUnauthorized() {
  alert('Session expired. Please log in again.');
  localStorage.removeItem('authToken');
  localStorage.removeItem('userEmail');
  window.location.href = 'login.html';
}

// 🧠 Load on page
window.addEventListener('DOMContentLoaded', () => loadSchedules());

// 🚪 Add Logout Button if needed
const nav = document.querySelector('.navbar nav ul');
if (nav) {
  const logoutItem = document.createElement('li');
  logoutItem.innerHTML = `<a href="#" id="logoutBtn">Logout</a>`;
  nav.appendChild(logoutItem);

  document.getElementById('logoutBtn').addEventListener('click', (e) => {
    e.preventDefault();
    localStorage.removeItem('authToken');
    localStorage.removeItem('userEmail');
    window.location.href = 'login.html';
  });
  // Optionally, display user email somewhere
const userEmail = localStorage.getItem('userEmail');
const userDisplay = document.getElementById('userEmailDisplay');
if (userDisplay && userEmail) {
      userDisplay.textContent = `Logged in as: ${userEmail}`;
    }
}

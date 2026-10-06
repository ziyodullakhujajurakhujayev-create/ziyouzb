document.addEventListener('DOMContentLoaded', function () {
  const alertsEl = document.getElementById('live-alerts');

  if (!alertsEl) return;

  function loadAlerts() {
    fetch('/api/alerts')
      .then((response) => response.json())
      .then((alerts) => {
        if (!Array.isArray(alerts) || !alerts.length) {
          alertsEl.innerHTML = '<div class="card"><h4>Bildirishnomalar</h4><p>Hech qanday ogohlantirish yo‘q.</p></div>';
          return;
        }

        alertsEl.innerHTML = alerts.slice(0, 3).map((alert) => `
          <div class="card">
            <h4>${alert.title || 'Bildirishnoma'}</h4>
            <p>${alert.message || ''}</p>
            <small>${alert.created_at || ''}</small>
          </div>
        `).join('');
      })
      .catch(() => {
        alertsEl.innerHTML = '<div class="card"><h4>Bildirishnomalar</h4><p>Yangilanishda xatolik yuz berdi.</p></div>';
      });
  }

  loadAlerts();
  setInterval(loadAlerts, 15000);
});

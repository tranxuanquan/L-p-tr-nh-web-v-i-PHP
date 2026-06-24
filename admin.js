window.addEventListener('load', function() {
  const chartEl = document.getElementById('chart');
  if (chartEl) {
    const ctx = chartEl.getContext('2d');
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: window.adminChartLabels || [],
        datasets: [{
          label: 'Doanh thu (₫)',
          data: window.adminChartValues || [],
          borderColor: '#b48d61',
          backgroundColor: 'rgba(180,141,97,0.15)',
          fill: true,
          tension: 0.3
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { display: false }
        },
        scales: {
          y: { beginAtZero: true }
        }
      }
    });
  }

  const stockChartEl = document.getElementById('stockChart');
  if (stockChartEl) {
    const ctxStock = stockChartEl.getContext('2d');
    new Chart(ctxStock, {
      type: 'bar',
      data: {
        labels: window.adminStockLabels || [],
        datasets: [{
          label: 'Tồn kho',
          data: window.adminStockValues || [],
          backgroundColor: '#b48d61'
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { display: false }
        },
        scales: {
          y: { beginAtZero: true }
        }
      }
    });
  }
});

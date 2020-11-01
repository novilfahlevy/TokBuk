function initChart(data) {
  const { bulan, label, pendapatan, pengeluaran } = data;

  $('#loading').hide();
  $('#bulan').text(bulan);

  new Chart(document.getElementById('transaksi').getContext('2d'), {
    type: 'line',
    data: {
      labels: label,
      datasets: [
        {
          label: 'Pengeluaran',
          data: pengeluaran.map(pengeluaran => pengeluaran.total_harga),
          backgroundColor: 'rgba(0, 0, 0, 0)',
          borderColor: '#d95c0f',
          lineTension: 0
        },
        {
          label: 'Pendapatan',
          data: pendapatan.map(pendapatan => pendapatan.total_harga),
          backgroundColor: 'rgba(0, 0, 0, 0)',
          borderColor: '#1285de',
          lineTension: 0
        }
      ]
    },
    options: {
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true,
            callback(value) {
              return `Rp ${new Intl.NumberFormat('id-ID', { maximumSignificantDigits: 3 }).format(value)}`;
            }
          }
        }]
      }
    }
  });
}

$.ajax({
  url: `${BASEURL}/api/dasbor`,
  method: 'GET',
  error: error => console.log(error),
  success: ({ data }) => initChart(data)
});

channelBind('dasbor', 'dasbor.update', function(data) {
  initChart(data.chart);
  $('#jumlahTransaksi').text(
    new Intl.NumberFormat('id-ID', { maximumSignificantDigits: 3 }).format(data.jumlahTransaksi)
  );
});
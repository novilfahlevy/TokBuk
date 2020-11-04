function initChart(data) {
  const { bulan, label, pendapatan } = data;

  $('#loading').hide();
  $('#bulan').text(bulan);

  new Chart(document.getElementById('transaksi').getContext('2d'), {
    type: 'line',
    data: {
      labels: label,
      datasets: [
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
              return `Rp ${new Intl.NumberFormat('id-ID').format(value)}`;
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
  $('#jumlahBuku').text(
    new Intl.NumberFormat('id-ID').format(data.jumlahBuku)
  );
  $('#jumlahTransaksi').text(
    new Intl.NumberFormat('id-ID').format(data.jumlahTransaksi)
  );
});
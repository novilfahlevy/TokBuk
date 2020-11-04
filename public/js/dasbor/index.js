function initChart(data) {
  const { tahun, bulan, label, pendapatan } = data;

  $('#loading').hide();
  $('#bulan').text(`${bulan.toLowerCase()} ${tahun}`);

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

function ambilDataChart(tahun = null, bulan = null) {
  $.ajax({
    url: `${BASEURL}/api/dasbor`,
    method: 'POST',
    data: { tahun, bulan },
    error: error => console.log(error),
    success: ({ data }) => initChart(data)
  });
}

channelBind('dasbor', 'dasbor.update', function(data) {
  initChart(data.chart);
  $('#jumlahBuku').text(
    new Intl.NumberFormat('id-ID').format(data.jumlahBuku)
  );
  $('#jumlahTransaksi').text(
    new Intl.NumberFormat('id-ID').format(data.jumlahTransaksi)
  );
});

ambilDataChart();

$('#gantiBulanChart').on('change', function() {
  const [tahun, bulan] = $(this).val().split('-');
  ambilDataChart(tahun, bulan);
});
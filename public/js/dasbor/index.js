channelBind('dasbor', 'dasbor.update', function(data) {
  $('#jumlahBuku').text(
    new Intl.NumberFormat('id-ID').format(data.jumlahBuku)
  );
  $('#jumlahTransaksi').text(
    new Intl.NumberFormat('id-ID').format(data.jumlahTransaksi)
  );
});

$('#gantiBulanChart').on('change', function() {
  const [tahun, bulan] = $(this).val().split('-');
  ambilDataChart(tahun, bulan);
});
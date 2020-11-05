const format = number => new Intl.NumberFormat('id-ID').format(number);

$('#submitPendapatan').on('click', function() {
  const [tahun, bulan] = $('#pendapatan').val().split('-');
  $.ajax({
    url: `${BASEURL}/api/laporan/penjualan`,
    method: 'POST',
    data: { tahun, bulan },
    error: error => console.log(error),
    success: (data) => {
      $('#laporanTransaksi').attr('href', `${BASEURL}/laporan/penjualan/${tahun}/${bulan}`);
      $('#totalTransaksi').text(data.totalTransaksi);
      $('#bukuTerjual').text(data.bukuTerjual);
      $('#totalPendapatan').text(`Rp ${format(data.pendapatan)}`);
      $('#waktuLaporanPenjualan').text(`${data.bulan} ${data.tahun}`)
    }
  });
});

$('#submitPengeluaran').on('click', function() {
  const [tahun, bulan] = $('#pengeluaran').val().split('-');
  $.ajax({
    url: `${BASEURL}/api/laporan/pembelian`,
    method: 'POST',
    data: { tahun, bulan },
    error: error => console.log(error),
    success: (data) => {
      $('#laporanPembelian').attr('href', `${BASEURL}/laporan/pembelian/${tahun}/${bulan}`);
      $('#totalPembelian').text(data.totalPembelian);
      $('#bukuTerbeli').text(data.bukuTerbeli);
      $('#totalPengeluaran').text(`Rp ${format(data.pengeluaran)}`);
      $('#waktuLaporanPendapatan').text(`${data.bulan} ${data.tahun}`)
    }
  });
});


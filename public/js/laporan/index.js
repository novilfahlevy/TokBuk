const format = number => new Intl.NumberFormat('id-ID').format(number);

function ambilDataTransaksi(tahun, bulan) {
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
}

function ambilDataPembelian(tahun, bulan) {
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
}

$('#submitPendapatan').on('click', function() {
  const [tahun, bulan] = $('#pendapatan').val().split('-');
  ambilDataTransaksi(tahun, bulan);
});

$('#submitPengeluaran').on('click', function() {
  const [tahun, bulan] = $('#pengeluaran').val().split('-');
  ambilDataPembelian(tahun, bulan);
});

const date = new Date();
const bulan = date.getMonth() + 1;
const tahun = date.getFullYear();

ambilDataTransaksi(tahun, bulan);
ambilDataPembelian(tahun, bulan);
const format = number => new Intl.NumberFormat('id-ID').format(number);

function ambilDataTransaksi(dari, sampai) {
  $.ajax({
    url: `${BASEURL}/api/laporan/penjualan`,
    method: 'POST',
    data: { dari, sampai },
    error: error => console.log(error),
    success: (data) => {
      $('#laporanTransaksi').attr('href', `${BASEURL}/laporan/penjualan/${dari}/${sampai}`);
      $('#totalTransaksi').text(data.totalTransaksi);
      $('#bukuTerjual').text(data.bukuTerjual);
      $('#totalPendapatan').text(`Rp ${format(data.pendapatan)}`);
      $('#waktuLaporanPenjualan').text(`${data.dari} s.d. ${data.sampai}`)
    }
  });
}

function ambilDataPembelian(dari, sampai) {
  $.ajax({
    url: `${BASEURL}/api/laporan/pembelian`,
    method: 'POST',
    data: { dari, sampai },
    error: error => console.log(error),
    success: (data) => {
      $('#laporanPembelian').attr('href', `${BASEURL}/laporan/pembelian/${dari}/${sampai}`);
      $('#totalPembelian').text(data.totalPembelian);
      $('#bukuTerbeli').text(data.bukuTerbeli);
      $('#totalPengeluaran').text(`Rp ${format(data.pengeluaran)}`);
      $('#waktuLaporanPendapatan').text(`${data.dari} s.d. ${data.sampai}`)
    }
  });
}

$('#submitPendapatan').on('click', function() {
  const dari = $('#awalTanggalPendapatan').val();
  const sampai = $('#akhirTanggalPendapatan').val();
  ambilDataTransaksi(dari, sampai);
});

$('#submitPengeluaran').on('click', function() {
  const dari = $('#awalTanggalPengeluaran').val();
  const sampai = $('#akhirTanggalPengeluaran').val();
  ambilDataPembelian(dari, sampai);
});

const date = new Date(), y = date.getFullYear(), m = date.getMonth() + 1;
date.setFullYear(14, 0, 1);

let dari = new Date(y, m, 1);
dari = `${y}-${m}-01`;

let sampai = new Date(y, m, 0);
sampai = `${y}-${m}-${sampai.getDate() > 9 ? sampai.getDate() : `0${sampai.getDate()}`}`;

ambilDataTransaksi(dari, sampai);
ambilDataPembelian(dari, sampai);
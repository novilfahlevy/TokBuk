function ambilDataTransaksi(dari, sampai) {
  $.ajax({
    url: `${BASEURL}/api/laporan/transaksi`,
    method: 'POST',
    data: { dari, sampai },
    error: error => console.log(error),
    success: (data) => {
      $('#laporanTransaksi').attr('href', `${BASEURL}/laporan/transaksi/${dari}/${sampai}`);
      $('#totalTransaksi').text(data.totalTransaksi);
      $('#bukuTerjual').text(data.bukuTerjual);
      $('#totalPendapatan').text(`${format(data.pendapatan)}`);
      $('#waktuLaporanTransaksi').text(`${data.dari} s.d. ${data.sampai}`)
    }
  });
}

function ambilDataPengadaan(dari, sampai) {
  $.ajax({
    url: `${BASEURL}/api/laporan/pengadaan`,
    method: 'POST',
    data: { dari, sampai },
    error: error => console.log(error),
    success: (data) => {
      $('#laporanPengadaan').attr('href', `${BASEURL}/laporan/pengadaan/${dari}/${sampai}`);
      $('#totalPengadaan').text(data.totalPengadaan);
      $('#bukuTerbeli').text(data.bukuTerbeli);
      $('#totalPengeluaran').text(`${format(data.pengeluaran)}`);
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
  ambilDataPengadaan(dari, sampai);
});

const date = new Date(), y = date.getFullYear(), m = date.getMonth() + 1;
date.setFullYear(14, 0, 1);

let dari = new Date(y, m, 1);
dari = `${y}-${m}-01`;

let sampai = new Date(y, m, 0);
sampai = `${y}-${m}-${sampai.getDate() > 9 ? sampai.getDate() : `0${sampai.getDate()}`}`;

ambilDataTransaksi(dari, sampai);
ambilDataPengadaan(dari, sampai);
channelBind('dasbor', 'dasbor.update', function(data) {
  $('#totalTransaksi').text(data.transaksi.totalTransaksi);
  $('#bukuTerjual').text(data.transaksi.bukuTerjual);
  $('#totalPendapatan').text(`${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(data.transaksi.pendapatan)}`);

  $('#totalPembelian').text(data.pembelian.totalPembelian);
  $('#bukuTerbeli').text(data.pembelian.bukuTerbeli);
  $('#totalPengeluaran').text(`${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(data.pembelian.pengeluaran)}`);

  $('#jumlahBuku').text(
    new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(data.jumlahBuku)
  );
  $('#jumlahTransaksi').text(
    new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(data.jumlahTransaksi)
  );
});
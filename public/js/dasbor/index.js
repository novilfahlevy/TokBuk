channelBind('dasbor', 'dasbor.update', function(data) {
  $('#totalTransaksi').text(data.transaksi.totalTransaksi);
  $('#bukuTerjual').text(data.transaksi.bukuTerjual);
  $('#totalPendapatan').text(`Rp ${new Intl.NumberFormat('id-ID').format(data.transaksi.pendapatan)}`);

  $('#totalPembelian').text(data.pembelian.totalPembelian);
  $('#bukuTerbeli').text(data.pembelian.bukuTerbeli);
  $('#totalPengeluaran').text(`Rp ${new Intl.NumberFormat('id-ID').format(data.pembelian.pengeluaran)}`);

  $('#jumlahBuku').text(
    new Intl.NumberFormat('id-ID').format(data.jumlahBuku)
  );
  $('#jumlahTransaksi').text(
    new Intl.NumberFormat('id-ID').format(data.jumlahTransaksi)
  );
});
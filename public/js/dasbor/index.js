// channelBind('dasbor', 'dasbor.update', function(data) {
//   $('#totalTransaksi').text(data.transaksi.totalTransaksi);
//   $('#bukuTerjual').text(data.transaksi.bukuTerjual);
//   $('#totalPendapatan').text(`${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(data.transaksi.pendapatan)}`);

//   $('#totalPengadaan').text(data.pengadaan.totalPengadaan);
//   $('#bukuTerbeli').text(data.pengadaan.bukuTerbeli);
//   $('#totalPengeluaran').text(`${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(data.pengadaan.pengeluaran)}`);

//   $('#jumlahBuku').text(
//     new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(data.jumlahBuku)
//   );
//   $('#jumlahTransaksi').text(
//     new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(data.jumlahTransaksi)
//   );
// });
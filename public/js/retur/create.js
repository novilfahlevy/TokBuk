let bukuRetur = [];

$('form#formTambahBukuBaru').submit(function(event) {
  event.preventDefault();

  const $self = $(this);
  const $isbn = $self.find('#isbn');
  const $judul = $self.find('#judul');
  const $keterangan = $self.find('#keterangan');
  const $jumlah = $self.find('#jumlah');
  const $harga = $self.find('#harga');
  const $subTotal = $self.find('#subTotal');

  const data = {
    isbn: $isbn.val(),
    judul: $judul.val(),
    keterangan: $keterangan.val(),
    jumlah: $jumlah.val(),
    harga: $harga.val(),
    subTotal: $subTotal.val(),
  };

  if ( data.isbn && data.judul && data.keterangan && data.jumlah && data.harga && data.subTotal ) {
    bukuRetur.push(data);
  }
});
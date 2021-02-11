$(window).keydown(function(event) {
  // Shortcuts
  const key = event.which || event.keyCode;

  if ( disableCtryKeys(event, 83) ) {
    return;
  }

  if ( event.ctrlKey ) {
    switch ( key ) {
      // Ctrl + B untuk focus ke input isbn (barcode)
      case 66 :
        $('input#isbn').focus();
      break;

      // Ctrl + Enter untuk submit transaksi
      case 13 :
        $('form#formTransaksi').submit();
      break;
    }
  }
});

const $bukuContainer = $('tbody#bukuContainer');
let bukuPesanan = [];

function updatePesananBuku() {
  $bukuContainer.empty();
  let total = 0;

  bukuPesanan.forEach((buku, i) => {
    total += buku.subTotal;

    // Install extensi 'ES6 String HTML' untuk vscode
    $bukuContainer.append( /*html*/ `
      <tr>
        <td>${i + 1}</td>
        <td>${buku.judul}</td>
        <td>${buku.jumlah}</td>
        <td>${format(buku.harga)}</td>
        <td>${buku.diskon ? '% ' + buku.diskon : '-'}</td>
        <td>${format(buku.subTotal)}</td>
        <td>
          <button class="btn btn-danger hapus" type="button" data-id="${buku.idBuku}">Hapus</button>
        </td>
      </tr>
    `);

  });
  
  $('#totalSemuaHarga').text(format(total));
}

$('input#isbn').keyup(function(event) {
  const $self = $(this);
  const isbn = $self.val();

  if ( isbn.length > 8 && event.keyCode != 17 ) {
    $.ajax({
      method: 'GET',
      url: `${BASEURL}/api/transaksi/${isbn}/buku`,
      success: function({ status, buku }) {
        if ( status == 200 ) {
          const { id: idBuku, judul, harga, diskon = null } = buku;
          const bukuSudahDipesan = bukuPesanan.find(buku => buku.idBuku == idBuku);
          const jumlah = bukuSudahDipesan ? bukuSudahDipesan.jumlah + 1 : 1;

          const totalHarga = harga * jumlah;
          const subTotal = diskon ? (totalHarga - ((totalHarga / 100) * diskon)) : totalHarga;

          if ( bukuSudahDipesan ) {
            const cloneBukuPesanan = [ ...bukuPesanan ];
            const indexBukuPesanan = cloneBukuPesanan.indexOf(bukuSudahDipesan);

            cloneBukuPesanan[indexBukuPesanan].jumlah = jumlah;
            cloneBukuPesanan[indexBukuPesanan].subTotal = subTotal;
            bukuPesanan = cloneBukuPesanan;
          } else {
            bukuPesanan.push({ idBuku, judul, jumlah, harga, diskon, subTotal });
          }

          updatePesananBuku();

          $self.val('');
          $self.focus();
        }
      }
    });
  }
});

$bukuContainer.click(function(event) {
  const $target = $(event.target);
  if ( $target.hasClass('hapus') ) {
    bukuPesanan = bukuPesanan.filter(buku => buku.idBuku != $target.data('id'));
    updatePesananBuku();
    console.log(bukuPesanan);
  }
});

$('form#formTransaksi').submit(function() {
  $('#hasilRespon').val(JSON.stringify({
    totalHarga: bukuPesanan.reduce((total, { subTotal }) => total += subTotal, 0),
    buku: bukuPesanan
  }));

  $(this).submit();
});
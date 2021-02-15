const $daftarBukuContainer = $('tbody#bukuContainer');
const $tambahBukuModal = $('#tambahBukuBaruModal');
const $tambahBukuForm = $tambahBukuModal.find('form#formTambahBukuBaru');
let daftarBuku = [];

// Update daftar buku
function updateDaftarBuku() {
  let total = 0;

  $daftarBukuContainer.empty();

  daftarBuku.forEach((buku, i) => {
    const subTotal = buku.harga * buku.jumlah;
    total += subTotal;
    $daftarBukuContainer.append(/*html*/ `
      <tr>
        <td>${i + 1}</td>
        <td>${buku.isbn}</td>
        <td>${buku.judul}</td>
        <td>${format(buku.harga)}</td>
        <td>${buku.jumlah}</td>
        <td>${format(subTotal)}</td>
        <td>
          <button type="button" class="btn btn-danger hapus" data-isbn="${buku.isbn}">Hapus</button>
        </td>
      </tr>
    `);
  });

  $('#totalSemuaHarga').text(format(total));
}

function error($error, $message = '') {
  $err = $tambahBukuForm.find('#error');
  $err[$error]();
  $err.text($message);
}

function updateFinalRespon() {
  $('#hasilRespon').val(JSON.stringify({
    totalHarga: daftarBuku.reduce((total, { harga, jumlah }) => total + (harga * jumlah), 0),
    buku: daftarBuku
  }));
}

// Fokus ke input ISBN saat modal 'tambah buku' terbuka
$tambahBukuModal.on('shown.bs.modal', function() {
  $(this).find('#isbn').focus();
});

// Tambah buku baru
$tambahBukuForm.submit(function(event) {
  event.preventDefault();

  const $self = $(this);

  const $isbn = $self.find('#isbn');
  const $judul = $self.find('#judul');
  const $jumlah = $self.find('#jumlah');
  const $harga = $self.find('#harga');
  const $subTotal = $self.find('#subTotal');
  const $barcode = $self.find('#barcode');

  const buku = {
    isbn: $isbn.val().trim(),
    judul: $judul.val(),
    jumlah: $jumlah.val(),
    harga: $harga.val(),
    barcode: $barcode.val()
  };

  if ( buku.isbn && buku.judul && buku.jumlah && buku.harga ) {
    if ( !daftarBuku.find(({ isbn }) => buku.isbn == isbn) ) {
      daftarBuku.push(buku);

      $isbn.focus();
      $isbn.val('');
      $judul.val('');
      $judul.attr('disabled', false);
      $jumlah.val(1);
      $harga.val(0);
      $subTotal.val(0);
      $barcode.val('');
      $barcode.attr('disabled', false);

      $tambahBukuForm.find('#isbnInfo').hide();

      error('hide');
    } else {
      error('show', 'Buku dengan ISBN ini sudah ada di dalam daftar');
    }
  } else {
    error('show', 'Mohon lengkapi semua data');
  }

  updateDaftarBuku();
});

// Cek buku apakah sudah tersedia atau belum dengan ISBN
$tambahBukuForm.find('#isbn').change(delayEvent(function() {
  const $self = $(this);
  const $isbnInfo = $tambahBukuForm.find('#isbnInfo');
  const isbn = $self.val();

  $isbnInfo.hide();
  
  if ( isbn ) {
    $.ajax({
      method: 'GET',
      url: `${BASEURL}/api/pengadaan/isbn/${isbn}`,
      success: function({ status, judul, barcode }) {
        if ( status == 200 ) {
          $isbnInfo.show();
          $tambahBukuForm.find('input#judul').attr('disabled', true);
          $tambahBukuForm.find('input#judul').val(judul);

          if ( barcode ) {
            $tambahBukuForm.find('input#barcode').attr('disabled', true);
          }
        } else {
          $isbnInfo.hide();
          $tambahBukuForm.find('input#barcode').attr('disabled', false);
          $tambahBukuForm.find('input#judul').attr('disabled', false);
          $tambahBukuForm.find('input#judul').val('');
        }
      },
      error: function() {
        $isbnInfo.hide();
      }
    });
  }
}, 100));

// Kalkulasi sub total
$tambahBukuForm.find('#harga').keyup(function() {
  const harga = $(this).val();
  const jumlah = $tambahBukuForm.find('#jumlah').val();
  if ( harga && jumlah ) {
    $tambahBukuForm.find('#subTotal').val(format(harga * jumlah, ''));
  }
});

// Kalkulasi sub total
$tambahBukuForm.find('#jumlah').keyup(function() {
  const jumlah = $(this).val();
  const harga = $tambahBukuForm.find('#harga').val();
  if ( harga && jumlah ) {
    $tambahBukuForm.find('#subTotal').val(format(harga * jumlah, ''));
  }
});

// Event delegasi daftar buku
$daftarBukuContainer.click(function(event) {
  const $target = $(event.target);
  
  // Hapus buku dari daftar
  if ( $target.hasClass('hapus') ) {
    const isbn = $target.data('isbn');
    daftarBuku = daftarBuku.filter(buku => buku.isbn != isbn);
    updateDaftarBuku();
  }
});

// Hasil respon
$('form#pengadaan').submit(function() {
  updateFinalRespon();
  $(this)[0].submit();
});
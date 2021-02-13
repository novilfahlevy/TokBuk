const $bukuContainer = $('tbody#bukuContainer');
const $tambahManualContainer = $('#bukuTambahManual');
const $tambahManualModal = $('#tambahManualModal');
const $tambahManualInput = $('input#buku');
let bukuPesanan = [];

// Daftar shortcuts
$(window).keydown(function(event) {
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
        updateFinalRespon();
        $('form#formTransaksi')[0].submit();
      break;
        
      // Ctrl + M untuk trigger modal secara manual
      case 77 :
        $tambahManualModal.modal({ show: true });
        $tambahManualModal.on('shown.bs.modal', function() {
          const $self = $(this);
          $self.find('input#buku').focus();
        });
      break;
    }
  }
});

// Set value hasilRespon dengan respon untuk backend
function updateFinalRespon() {
  $('#hasilRespon').val(JSON.stringify({
    totalHarga: bukuPesanan.reduce((total, { subTotal }) => total += subTotal, 0),
    buku: bukuPesanan
  }));
}

// Fungsi untuk menambah buku ke daftar pesanan
function tambahPesananBuku(barcode, callback = null) {
  $.ajax({
    method: 'GET',
    url: `${BASEURL}/api/transaksi/barcode/${barcode}`,
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

        if ( callback ) callback(status);
      } else {
        if ( callback ) callback(404);
      }
    },
    error: function() {
      if ( callback ) callback(400);
    }
  });
}

// Fungsi untuk menampilkan pesanan buku dan mengupdate segala yang terkait dengan pesanan buku
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

// Cari dan tambah pesanan buku berdasarkan ISBN (menggunakan barcode scan)
$('input#isbn').keyup(delayEvent(function(event) {
  const $self = $(this);
  const isbn = $self.val();

  if ( isbn ) {
    $self.attr('disabled', true);
  
    tambahPesananBuku(isbn, function() {
      $self.val('');
      $self.attr('disabled', false);
      $self.focus();
    });
  }
}, 500));

// Event delegasi pada buku container
$bukuContainer.click(function(event) {
  const $target = $(event.target);

  // Hapus buku dari pesanan
  if ( $target.hasClass('hapus') ) {
    bukuPesanan = bukuPesanan.filter(buku => buku.idBuku != $target.data('id'));
    updatePesananBuku();
  }
});

// Event keyup untuk mencari daftar buku berdasarkan keyword (isbn, judul, penulis, penerbit)
// menggunakan delay event (bisa dilihat di helpers.js)
$tambahManualInput.keyup(delayEvent(function() {
  const $self = $(this);
  const keyword = $self.val();

  if ( keyword ) {
    $self.attr('disabled', true);

    // Salin ISBN (belum selesai)
    // <i class="fas fa-copy ml-2 salin-isbn" style="user-select: none; cursor: pointer;" data-isbn="${isbn}" data-tooltip="tooltip"></i>

    $.ajax({
      method: 'GET',
      url: `${BASEURL}/api/transaksi/keyword/${keyword}`,
      success: function({ status, buku }) {
        if ( status == 200 ) {
          $tambahManualContainer.empty();
          buku.forEach(({ id, isbn, judul, penulis, penerbit, jumlah, sampul }) => {
            let jumlahDipesan = bukuPesanan.find(buku => buku.idBuku == id);
                jumlahDipesan = jumlahDipesan ? jumlahDipesan.jumlah : 0;
            $tambahManualContainer.append(/*html*/ `
              <div class="list-group-item d-flex justify-content-between align-items-center">
                <img src="${BASEURL}/images/buku/${sampul}" alt="" style="width:20%; height:150px; background-size: cover">
                <div class="w-100">
                  <h4>${judul.length <= 30 ? judul : judul.slice(0, 30) + '...'}</h4>
                  <p class="mb-0">ISBN: ${isbn}</p>
                  <p class="mb-0">Penulis: ${penulis}</p>
                  <p class="mb-0">Penerbit: ${penerbit}</p>
                  <p class="mb-0">Jumlah: ${jumlah}</p>
                </div>
                <div>
                  <button type="button" class="btn btn-success btn-sm tambah" data-isbn="${isbn}" data-jumlah-dipesan="${jumlahDipesan}">Tambah${jumlahDipesan ? ' (' + jumlahDipesan + ')' : ''}</button>
                </div>
              </div>
            `);
          });
        }
        $self.attr('disabled', false);
      },
      error: function() {
        $tambahManualContainer.empty();
        $self.attr('disabled', false);
      }
    });
  }
}, 1000));

// Event delegasi untuk list buku 'tambah manual'
$tambahManualContainer.click(function(event) {
  const $target = $(event.target);
  const isbn = $target.data('isbn');

  // Tambah buku dalam pesanan
  if ( $target.hasClass('tambah') ) {
    $target.attr('disabled', true);
    tambahPesananBuku(isbn, function() {
      const jumlahDipesan = $target.data('jumlah-dipesan') + 1;
      $target.attr('disabled', false);
      $target.data('jumlah-dipesan', jumlahDipesan);
      $target.text(`Tambah (${jumlahDipesan})`);
    });
  }

  // if ( $target.hasClass('salin-isbn') ) {
  //   const $copy = $('input#copy');
  //   $copy.val(isbn);
  //   $copy.select();
  //   document.execCommand('copy');
  // }
});

// Reset form modal 'tambah manual' ketika modal diclose
$tambahManualModal.on('hide.bs.modal', function() {
  $tambahManualInput.val('');
  $tambahManualContainer.empty();
});

// Submit hasil akhir dari respon transaksi
$('form#formTransaksi').submit(function() {
  updateFinalRespon();
  $(this)[0].submit();
});
const initJsSelect2 = (selectClass, options = {}) => $(`.${selectClass}`).select2(options);
const format = number => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(number);
const idPengadaan = $('#idPengadaan').text();

let jumlahBuku = 0;
let bukuCache = [];
let bukuPilihan = [];

const appendBukuPilihan = idBuku => bukuPilihan.push(idBuku);
const removeBukuPilihan = idBuku => {
 if ( idBuku !== 'empty' ) {
  bukuPilihan = bukuPilihan.filter(id => id !== idBuku);
 }
};

function setDisableTambahBuku() {
  $('button#tambahBuku').attr('disabled', $('#bukuContainer tr:not(.deleted)').toArray().length >= jumlahBuku);
}

function setDisableHapusBuku() {
  $('button.hapus-buku').attr('disabled', $('#bukuContainer tr:not(.deleted)').toArray().length <= 1);
}

function uniqueClass(length) {
  var result = '';
  var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
  var charactersLength = characters.length;
  for ( var i = 0; i < length; i++ ) {
     result += characters.charAt(Math.floor(Math.random() * charactersLength));
  }
  return result;
}

function fillJsSelect2Options(selectClass, initCallback) {
  initJsSelect2(selectClass, {
    templateSelection: function(data) {
      const buku = JSON.parse(atob(data.id));
      const tr = $(`tr[data-select-class=${selectClass}]`);

      tr.data('buku-id', buku.id);

      tr.find('.harga').text(`${format(buku.harga)}`);
      tr.find('.harga').data('harga', buku.harga);

      tr.find('.jumlah-buku-input').attr('max', buku.jumlah);
      tr.find('.jumlah-buku-input').val(1);

      tr.find('.jumlah-buku-label').text(buku.jumlah);
      tr.find('.jumlah-buku-label').data('jumlah', buku.jumlah);

      tr.find('.total-harga').text(`${format(buku.harga)}`);
      tr.find('.total-harga').data('total-harga', buku.harga);

      tr.find('.id_pengadaan').text(buku.id_pengadaan);

      $('#totalSemuaHarga').text(format(getTotalHarga()));

      appendBukuPilihan(buku.id);

      return data.text;
    },
    templateResult: function(data) {
      if ( data.id ) {
        const buku = JSON.parse(atob(data.id));
        return $(`
          <span class="d-flex align-items-center">
            <img src="${BASEURL}/images/buku/${buku.sampul}" width="50" height="50" class="mr-3" />
            <div class="d-flex flex-column">
              ${buku.judul.slice(0, 28)}${buku.judul.length > 28 ? '...' : ''}
              <span>${format(buku.harga)}</span>
            </div>
          </span>
        `);
      }
    }
  });
  initCallback();
}

function getAllBooks(selectClass) {
  if ( bukuCache.length ) {
    fillJsSelect2Options(selectClass, () => {
      bukuCache.forEach(option => {
        const idBuku = JSON.parse(atob($(option).attr('value'))).id;
        $(`.${selectClass}`).append(option);
        // if ( !bukuPilihan.includes(idBuku) ) {
        //   $(`.${selectClass}`).append(option);
        // }
      });
    });
    return;
  }

  $.ajax({
    method: 'GET',
    url: `${BASEURL}/api/retur/${idPengadaan}/buku`,
    success: function(data) {
      fillJsSelect2Options(selectClass, () => {
        data.buku.map(buku => {
          const data = btoa(JSON.stringify(buku));
          const option = `<option value="${data}">${buku.judul}</option>`;
          $(`.${selectClass}`).append(option);
          bukuCache.push(option);;
        });
        jumlahBuku = data.buku.length;
      });
    },
    error: function(error) {
      console.log(error);
    }
  });
}

function initNumbers() {
  const trs = $('#bukuContainer tr:not(.deleted)');
  trs.toArray().forEach((tr, i) => $(tr).find('#number').text(i + 1));
}

function tambahBuku() {
  const selectClass = uniqueClass(32);

  const bukuTr = $(`
    <tr class="buku" data-select-class="${selectClass}" data-buku-id="empty">
      <th id="number">1</th>
      <th>
        <select class="${selectClass} form-control buku-dipilih" name="states" style="width: 300px"></select>
      </th>
      <th class="d-flex align-items-center">
        <input type="number" class="form-control jumlah-buku-input" min="1" value="1" style="width: 80px">
        <span class="mx-2">/</span>
        <span class="jumlah-buku-label"></span>
      </th>
      <th>
        <input type="text" class="form-control keterangan" style="width: 150px">
      </th>
      <th class="harga"></th>
      <th class="total-harga">Rp 0</th>
      <th>
        <button type="button" class="btn btn-danger hapus-buku">Hapus</button>
        <span class="id_pengadaan d-none"></span>
      </th>
    </tr>
  `);
  
  $('#bukuContainer').append(bukuTr);

  initNumbers();
  getAllBooks(selectClass);
}

$('button#tambahBuku').on('click', tambahBuku);

$('form#formRetur').on('submit', function(event) {
  $('#hasilRespon').val(JSON.stringify(getAllBooksData()));
  $(this).submit();
});

function getAllBooksData() {
  const buku = $('#bukuContainer tr:not(.deleted)');
  let danaPengembalian = 0;
  const semuaBuku = buku.toArray().map(buku => {
    danaPengembalian += $(buku).find('.total-harga').data('total-harga');
    return {
      idBuku: $(buku).data('buku-id'),
      jumlah: parseInt($(buku).find('.jumlah-buku-input').val(), 10),
      harga: $(buku).find('.harga').data('harga'),
      keterangan: $(buku).find('.keterangan').val(),
      idDetailPengadaan: $(buku).find('.id_pengadaan').text()
    }
  });

  return {
    danaPengembalian,
    idPengadaan,
    tanggal: $('#tanggal').val(),
    buku: semuaBuku
  }
}

function getTotalHarga() {
  return $('#bukuContainer tr:not(.deleted)').toArray().reduce((total, buku) => {
    return total += $(buku).find('.total-harga').data('total-harga');
  }, 0);
}

// Propogate Event

$(document).on('click', function(event) {
  const target = $(event.target);
  if ( target.prop('tagName') === 'BUTTON' && target.hasClass('hapus-buku') ) {
    const tr = target.parent().parent();
    tr.addClass('deleted');
    $('#totalSemuaHarga').text(format(getTotalHarga()));
    initNumbers();
    removeBukuPilihan(tr.data('buku-id'));
  }
});

$(document).on('change', function(event) {
  const target = $(event.target);
  if ( target.prop('tagName') === 'INPUT' && target.hasClass('jumlah-buku-input') ) {
    const tr = target.parent().parent();
    const harga = tr.find('.harga').data('harga');
    const totalHarga = harga * target.val();
    tr.find('.total-harga').text(`${format(totalHarga)}`);
    tr.find('.total-harga').data('total-harga', totalHarga);
    $('#totalSemuaHarga').text(format(getTotalHarga()));
  }
});

tambahBuku();
setInterval(setDisableTambahBuku, 100);
setInterval(setDisableHapusBuku, 100);
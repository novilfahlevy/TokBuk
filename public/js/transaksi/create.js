const initJsSelect2 = (selectClass, options = {}) => $(`.${selectClass}`).select2(options);
const format = number => new Intl.NumberFormat('id-ID', { maximumSignificantDigits: 3 }).format(number);

function uniqueClass(length) {
  var result = '';
  var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
  var charactersLength = characters.length;
  for ( var i = 0; i < length; i++ ) {
     result += characters.charAt(Math.floor(Math.random() * charactersLength));
  }
  return result;
}

function getAllBooks(selectClass) {
  $.ajax({
    method: 'GET',
    url: `${BASEURL}/api/transaksi/buku`,
    success: function(data) {
      initJsSelect2(selectClass, {
        templateSelection: function(data) {
          const buku = JSON.parse(atob(data.id));
          const tr = $(`tr[data-select-class=${selectClass}]`);

          tr.data('buku-id', buku.id);

          tr.find('.harga').text(`Rp ${format(buku.harga)}`);
          tr.find('.harga').data('harga', buku.harga);

          tr.find('.jumlah-buku-input').attr('max', buku.jumlah);
          tr.find('.jumlah-buku-input').val(1);

          tr.find('.jumlah-buku-label').text(buku.jumlah);
          tr.find('.jumlah-buku-label').data('jumlah', buku.jumlah);

          tr.find('.total-harga').text(`Rp ${format(buku.harga)}`);
          tr.find('.total-harga').data('total-harga', buku.harga);

          $('#totalSemuaHarga').text(format(getTotalHarga()));

          return data.text;
        }
      });
      data.buku.map(buku => {
        const data = btoa(JSON.stringify(buku));
        $(`.${selectClass}`).append(`<option value="${data}">${buku.judul}</option>`);
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

$('button#tambahBuku').on('click', function() {
  const selectClass = uniqueClass(32);

  const bukuTr = $(`
    <tr class="buku" data-select-class="${selectClass}" data-buku-id="empty">
      <th id="number">1</th>
      <th>
        <select class="${selectClass} form-control buku-dipilih" name="states" style="width: 300px"></select>
      </th>
      <th class="d-flex align-items-center">
        <input type="number" class="form-control jumlah-buku-input" min="1" value="1">
        <span class="mx-2">/</span>
        <span class="jumlah-buku-label"></span>
      </th>
      <th class="harga"></th>
      <th class="total-harga">Rp 0</th>
      <th>
        <button type="button" class="btn btn-danger hapus-buku">Hapus</button>
      </th>
    </tr>
  `);
  
  $('#bukuContainer').append(bukuTr);

  initNumbers();
  getAllBooks(selectClass);
});

$('form#formTransaksi').on('submit', function(event) {
  $('#hasilRespon').val(JSON.stringify(getAllBooksData()));
  $(this).submit();
});

function getAllBooksData() {
  const buku = $('#bukuContainer tr:not(.deleted)');
  let totalHarga = 0;
  const semuaBuku = buku.toArray().map(buku => {
    totalHarga += $(buku).find('.total-harga').data('total-harga');
    return {
      idBuku: $(buku).data('buku-id'),
      jumlah: parseInt($(buku).find('.jumlah-buku-input').val(), 10),
      harga: $(buku).find('.total-harga').data('total-harga')
    }
  });

  return {
    totalHarga,
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
    target.parent().parent().addClass('deleted');
    $('#totalSemuaHarga').text(getTotalHarga());
    initNumbers();
  }
});

$(document).on('change', function(event) {
  const target = $(event.target);
  if ( target.prop('tagName') === 'INPUT' && target.hasClass('jumlah-buku-input') ) {
    const tr = target.parent().parent();
    const totalHarga = parseInt(tr.find('.harga').data('harga'), 10) * target.val();
    tr.find('.total-harga').text(`Rp ${format(totalHarga)}`);
    tr.find('.total-harga').data('total-harga', totalHarga);
    $('#totalSemuaHarga').text(format(getTotalHarga()));
  }
});
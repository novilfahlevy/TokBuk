const initJsSelect2 = (selectClass, options = {}) => $(`.${selectClass}`).select2(options);
const format = number => new Intl.NumberFormat('id-ID').format(number);

let bukuCache = [];

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

      return data.text;
    },
    templateResult: function(data) {
      if ( data.id ) {
        const buku = JSON.parse(atob(data.id));
        return $(`
          <span class="d-flex align-items-center">
            <img src="${BASEURL}/images/buku/${buku.sampul}" width="50" height="50" class="mr-3" />
            ${buku.judul.slice(0, 30)}${buku.judul.length > 30 ? '...' : ''}
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
      bukuCache.map(option => $(`.${selectClass}`).append(option));
    });
    return;
  }

  $.ajax({
    method: 'GET',
    url: `${BASEURL}/api/transaksi/buku`,
    success: function(data) {
      fillJsSelect2Options(selectClass, () => {
        data.buku.map(buku => {
          const data = btoa(JSON.stringify(buku));
          const option = `<option value="${data}">${buku.judul}</option>`;
          $(`.${selectClass}`).append(option);
          bukuCache.push(option);
        });
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
    <tr class="buku" data-select-class="${selectClass}" data-buku-id="empty" data-status="Baru">
      <th id="number">1</th>
      <th>
        <select required class="form-control status" value="Baru">
          <option value="Baru" selected>Baru</option>
          <option value="Penambahan">Penambahan</option>
        </select>
      </th>
      <th>
        <div class="d-none penambahan">
          <select class="${selectClass} form-control buku-dipilih" name="states" style="width: 300px"></select>
        </div>
        <div class="form-group my-2 baru">
          <input type="text" class="form-control form-control-sm mb-2 isbn" placeholder="ISBN">
          <input type="text" class="form-control form-control-sm judul" placeholder="Judul">
        </div>
      </th>
      <th>
        <input type="number" class="form-control jumlah-buku-input" min="1" value="1">
      </th>
      <th class="harga">
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">Rp</span>
          </div>
          <input type="number" class="form-control harga-per-buku" value="0">
        </div>
      </th>
      <th class="total-harga">Rp 0</th>
      <th>
        <button type="button" class="btn btn-danger hapus-buku">Hapus</button>
      </th>
    </tr>
  `);
  
  $('#bukuContainer').append(bukuTr);

  initNumbers();
  getAllBooks(selectClass);
}

$('button#tambahBuku').on('click', tambahBuku);

$('form#pembelianBuku').on('submit', function() {
  $('#hasilRespon').val(JSON.stringify(getAllBooksData()));
  $(this).submit();
});

function getAllBooksData() {
  const buku = $('#bukuContainer tr:not(.deleted)');
  let totalHarga = 0;
  const semuaBuku = buku.toArray().map(buku => {
    totalHarga += $(buku).find('.total-harga').data('total-harga');
    if ( $(buku).data('status') === 'Baru' ) {
      return {
        status: 'Baru',
        isbn: $(buku).find('.isbn').val(),
        judul: $(buku).find('.judul').val(),
        jumlah: parseInt($(buku).find('.jumlah-buku-input').val(), 10),
        harga: $(buku).find('.harga-per-buku').val()
      }
    }
    return {
      status: 'Penambahan',
      idBuku: $(buku).data('buku-id'),
      jumlah: parseInt($(buku).find('.jumlah-buku-input').val(), 10),
      harga: $(buku).find('.harga-per-buku').val()
    }
  });

  return {
    totalHarga,
    buku: semuaBuku
  }
}

function getTotalHarga() {
  return $('#bukuContainer tr:not(.deleted)').toArray()
  .filter(buku => !!$(buku).find('.total-harga').data('total-harga'))
  .reduce((total, buku) => {
    const totalHarga = $(buku).find('.total-harga').data('total-harga');
    return total += totalHarga;
  }, 0);
}

function setTotalHarga() {
  $('#totalSemuaHarga').html(format(getTotalHarga()));
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
  const tr = target.parent().parent();

  if ( target.prop('tagName') === 'INPUT' && target.hasClass('jumlah-buku-input') ) {
    const hargaPerBuku = tr.find('.harga-per-buku').val();
    const totalHarga = hargaPerBuku * target.val();

    tr.find('.total-harga').html(`Rp ${format(totalHarga)}`);
    tr.find('.total-harga').data('total-harga', totalHarga);

    setTotalHarga();
  }

  if ( target.prop('tagName') === 'SELECT' && target.hasClass('status') ) {
    tr.data('status', target.val());
    if ( target.val() == 'Penambahan' ) {
      tr.find('.penambahan').removeClass('d-none');
      tr.find('.baru').addClass('d-none');
    } else {
      tr.find('.penambahan').addClass('d-none');
      tr.find('.baru').removeClass('d-none');
    }
  }

  if ( target.prop('tagName') === 'INPUT' && target.hasClass('harga-per-buku') ) {
    const jumlahBuku = tr.parent().find('.jumlah-buku-input').val();
    const totalHarga = target.val() * jumlahBuku;

    tr.parent().find('.total-harga').html(`Rp ${format(totalHarga)}`);
    tr.parent().find('.total-harga').data('total-harga', totalHarga);

    setTotalHarga();
  }
});

tambahBuku();
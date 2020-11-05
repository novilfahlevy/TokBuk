{{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<div class="card">
  <div class="card-header">
    <h4>Laporan Transaksi</h4>
  </div>
  <div class="card-body">
    <h5 class="mb-3" id="waktuLaporanPenjualan">{{ $waktuMasukan->monthName }} {{ $waktuMasukan->year }}</h5>
    <div class="table-responsive">
      <table class="table table-striped">
        <tr>
          <td width="30%">
            Total Transaksi
          </td>
          <td id="totalTransaksi">
            {{ $totalTransaksi }}
          </td>
        </tr>
        <tr>
          <td>
            Buku Terjual
          </td>
          <td id="bukuTerjual">
            {{ $bukuTerjual }}
          </td>
        </tr>
        <tr>
          <td>
            Total Pendapatan
          </td>
          <td id="totalPendapatan">
            Rp {{ number_format($pendapatan) }}
          </td>
        </tr>
      </table>
    </div>
  </div>
</div> --}}

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<h3 style="text-align: center; ">
    {{ $pengaturan->nama_toko }}
</h3>

<table>
    <tr>
        <td>
            <small><b>Alamat</b></small>
        </td>
        <td>
            <small>{{$pengaturan->alamat}}</small>
        </td>
    </tr>
    <tr>
        <td>
            <small><b>Telepon</b></small>
        </td>
        <td>
            <small>{{$pengaturan->telepon}}</small>
        </td>
    </tr>
    <tr>
        <td>
            <small><b>E-Mail</b></small>
        </td>
        <td>
            <small>{{$pengaturan->email}}</small>
        </td>
    </tr>
</table>
<hr>
<h5 style="text-align: center;">Laporan Penjualan Bulan {{ $waktuMasukan->monthName }} {{ $waktuMasukan->year }}</h5><br/>
<div class="table-responsive">
    <table class="table table-striped">
      <tr>
        <td width="30%">
          Total Transaksi
        </td>
        <td id="totalTransaksi">
          {{ $totalTransaksi }}
        </td>
      </tr>
      <tr>
        <td>
          Buku Terjual
        </td>
        <td id="bukuTerjual">
          {{ $bukuTerjual->buku_terjual }}
        </td>
      </tr>
      <tr>
        <td>
          Total Pendapatan
        </td>
        <td id="totalPendapatan">
          Rp {{ number_format($pendapatan) }}
        </td>
      </tr>
    </table>
  </div>


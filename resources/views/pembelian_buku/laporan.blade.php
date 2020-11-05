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
<h5 style="text-align: center;">Laporan Pembelian Bulan {{ $waktuMasukan->monthName }} {{ $waktuMasukan->year }}</h5><br/>
<div class="table-responsive">
    <table class="table table-striped">
      <tr>
        <td width="30%">
          Total Pembelian
        </td>
        <td id="totalTransaksi">
          {{ $totalPembelian }}
        </td>
      </tr>
      <tr>
        <td>
          Buku Terbeli
        </td>
        <td id="bukuTerjual">
          {{ $bukuTerbeli}}
        </td>
      </tr>
      <tr>
        <td>
          Total Pengeluaran
        </td>
        <td id="totalPendapatan">
          Rp {{ number_format($pengeluaran) }}
        </td>
      </tr>
    </table>
  </div>


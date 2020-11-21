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
<h5 style="text-align: center;">Laporan Pembelian Tanggal {{ $dari }} s.d. {{ $sampai }}</h5><br/>
<div class="table-responsive">
    <table class="table table-striped">
      <tr>
        <td width="30%">
          Total Pengadaan
        </td>
        <td id="totalPembelian">
          {{ $totalPembelian }}
        </td>
      </tr>
      <tr>
        <td>
          Jumlah Buku Yang Dibeli
        </td>
        <td id="bukuTerbeli">
          {{$bukuTerbeli->buku_terbeli ? $bukuTerbeli->buku_terbeli : '0'  }}
        </td>
      </tr>
      <tr>
        <td>
          Total Pengeluaran
        </td>
        <td id="pengeluaran">
          Rp {{ number_format($pengeluaran, 2, ',', '.') }}
        </td>
      </tr>
    </table>
  </div>


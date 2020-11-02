<table style="text-align: center">
  <thead>
    <tr>
      <th>No</th>
      <th>Tanggal</th>
      <th>Jumlah Buku</th>
      <th>Total Harga</th>
      <th>Uang Pembeli</th>
      <th>Kembalian</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($transaksi as $t)
      <tr>
        <td>{{ $loop->index + 1 }}</td>
        <td>{{ $t->created_at }}</td>
        <td>{{ $t->jumlah_buku }}</td>
        <td>Rp {{ number_format($t->total_harga) }}</td>
        <td>Rp {{ number_format($t->uang_pembeli) }}</td>
        <td>Rp {{ number_format($t->uang_pembeli - $t->total_harga) }}</td>
        <td></td>
      </tr>
    @endforeach
  </tbody>
</table>
<table style="text-align: center">
  <thead>
    <tr>
      <th>No</th>
      <th>Tanggal</th>
      <th>Judul Buku</th>
      <th>Jumlah</th>
      <th>Harga Per Buku</th>
      <th>Total Harga</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($transaksi as $t)
      <tr>
        <td>{{$loop->index+1}}</td>
        <td>{{ $t->created_at }}</td>
        <td>{{ $t->buku()->withTrashed()->first()->judul }}</td>
        <td>{{ $t->jumlah }}</td>
        <td>Rp {{ number_format($t->buku()->withTrashed()->first()->harga) }}</td>
        <td>Rp {{ number_format($t->transaksi()->withTrashed()->first()->total_harga) }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
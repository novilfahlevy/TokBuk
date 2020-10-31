<table style="text-align: center">
  <thead>
    <tr>
      <th>No</th>
      <th>Tanggal</th>
      <th>Judul Buku</th>
      <th>Ditangani Oleh</th>
      <th>Harga Jual / Buku</th>
      <th>Harga Beli</th>
      <th>Jumlah</th>
      <th>Total Harga</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($buku as $b)
      <tr>
        <td>{{ $loop->index+1 }}</td>
        <td>{{ $b->created_at }}</td>
        <td>{{ $b->buku()->withTrashed()->first()->judul }}</td>
        <td>{{ $b->user()->withTrashed()->first()->name }}</td>
        <td>Rp {{ number_format($b->harga_jual) }}</td>
        <td>Rp {{ number_format($b->harga_beli) }}</td>
        <td>{{ $b->jumlah }}</td>
        <td>Rp {{ number_format($b->harga_jual * $b->jumlah) }}</td>
        <td>{{ $b->status }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
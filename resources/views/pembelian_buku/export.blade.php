<table style="text-align: center">
  <thead>
    <tr>
      <th>#</th>
      <th>Kode</th>
      <th>Tanggal</th>
      <th>ISBN</th>
      <th>Judul Buku</th>
      <th>Harga</th>
      <th>Jumlah</th>
      <th>Total Harga</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($pembelian as $p)
      @php
        $pembelianParent = $p->pembelian()->withTrashed()->first();
        $buku = $p->buku()->withTrashed()->first();
      @endphp
      <tr>
        <td>{{ $loop->index + 1 }}</td>
        <td>{{ $pembelianParent->kode }}</td>
        <td>{{ $pembelianParent->created_at }}</td>
        <td>{{ $buku->isbn }}</td>
        <td>{{ $buku->judul }}</td>
        <td>Rp {{ number_format($p->harga_jual) }}</td>
        <td>{{ number_format($p->jumlah) }}</td>
        <td>Rp {{ number_format($p->harga_jual * $p->jumlah) }}</td>
        <td>{{ $p->status }}</td>
        <td></td>
      </tr>
    @endforeach
  </tbody>
</table>
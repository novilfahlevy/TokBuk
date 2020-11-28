<table style="text-align: center">
  <thead>
    <tr>
      <th>No</th>
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
    @foreach ($pengadaan as $p)
      @php
        $pengadaanParent = $p->pengadaan;
        $buku = $p->buku;
      @endphp
      <tr>
        <td>{{ $loop->index + 1 }}</td>
        <td>{{ $pengadaanParent->kode }}</td>
        <td>{{ $pengadaanParent->tanggal }}</td>
        <td>{{ $buku ? $buku->isbn : '-' }}</td>
        <td>{{ $buku ? $buku->judul : '-' }}</td>
        <td>Rp {{ number_format($p->harga, 2, ',', '.') }}</td>
        <td>{{ number_format($p->jumlah) }}</td>
        <td>Rp {{ number_format($p->harga * $p->jumlah, 2, ',', '.') }}</td>
        <td>{{ $p->status }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
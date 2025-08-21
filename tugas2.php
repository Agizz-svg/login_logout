<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Pencarian Warga</title>
  <link rel="stylesheet" type="text/css" href="tugas.css">
  <script src="jquery-3.7.1.min.js"></script>
</head>
<body>

  <h1>Pencarian Data Warga</h1>

  <div class="search-box">
  <input type="text" class="cari" placeholder="Ketik nama/alamat...">
  </div>

  <h3> Tambah Data Warga</h3>
  <p>Nama: <input type="text" id="nama" name="nama"></p>
  <p>Alamat: <input type="text" id="alamat" name="alamat"></p>
  <button type="button" id="tambahBtn">Tambah</button>
  <hr>

  <table border="1" cellpadding="10" cellspacing="0">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Alamat</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody id="hasil"></tbody>
  </table>

  <!-- Modal Edit -->
  <div id="editModal" style="display:none; border:1px solid #333; padding:20px; background:#eee;">
      <h3>Edit data Warga</h3>
      <input type="hidden" id="edit_id">
      <p>Nama: <input type="text" id="edit_nama"></p>
      <p>Alamat: <input type="text" id="edit_alamat"></p>
      <button id="updateBtn">Update</button>
      <button onclick="$('#editModal').hide()">Tutup</button>
  </div>

  <script src="tugas.js"></script>
</body>
</html>
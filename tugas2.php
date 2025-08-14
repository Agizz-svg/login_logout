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
    <input type="text" id="keyword" placeholder="Ketik nama/alamat...">
    <button id="btnCari">Cari</button>

    
  </div>

  <table>
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

  <script src="tugas.js"></script>
</body>
</html>
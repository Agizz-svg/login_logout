<?php
include "jaringan.php";

// Ambil semua data alamat
$result = $koneksi->query("SELECT * FROM alamat ORDER BY id_blok ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Data Alamat</title>
    <link rel="stylesheet" href="tugas.css">
    <script src="jquery-3.7.1.min.js"></script>
</head>
<body>
    <h1>Master Data Alamat</h1>

    <div><a href="tugas2.php"> Kembali ke pencarian Warga</a></div>
<hr>
<!-- Form Tambah Alamat -->
 <h3>Tambah Alamat Baru</h3>
 <p>Nama Blok: <input type="text" id="nama_blok"></p>
 <button id="tambahAlamatBtn">Tambah</button>

 <hr>
  
 <!-- Tabel daftar alamat -->
  <table border="1" cellpadding="10" cellspacing="0">
    <thead>
      <tr>
        <th>ID Blok</th>
        <th>Nama Blok</th>
        <th>Aksi</th>
      </tr>
    </thead>
<tbody id="alamatTable">
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr id="alamat-<?php echo $row['id_blok']; ?>">
            <td><?php echo $row['id_blok']; ?></td>
            <td><?php echo $row['nama_blok']; ?></td>
            <td>
                <button class="hapusAlamatBtn" data-id="<?php echo $row['id_blok']; ?>">Hapus</button>
                <button class="editAlamatBtn" data-id="<?php echo $row['id_blok']; ?>" data-nama="<?php echo $row['nama_blok']; ?>">Edit</button>
            </td>
        </tr>
    <?php } ?>
</tbody>
</table>

<!-- Form Edit (Hidden) -->
<div id="formEdit" style="display:none; margin-top:20px; border:1px solid #aaa; padding:10px;">
    <h3>Edit Alamat</h3>
    <input type="hidden" id="edit_id">
    <p>Nama Blok: <input type="text" id="edit_nama"></p>
    <button id="updateAlamatBtn">Update</button>
    <button onclick="$('#formEdit').hide()">Batal</button>
</div>

<script>
    // Tambah alamat
    $("#tambahAlamatBtn").click(function() {
        var nama = $("#nama_blok").val().trim();

        if (!nama) {
            alert("Nama Blok harus diisi!");
            return;
        }

        $.post("tugas.php", { action: "tambah_alamat", nama_blok: nama }, function(res) {
           if (res.status === "success") {
                    alert("Alamat berhasil ditambahkan!");
                    location.reload();
                } else {
                    alert("Gagal: " + (res.pesan || ""));
            }
        }, "json");
    });

    //Tampilkan form edit
    $("body").on("click", ".editAlamatBtn", function() {
        var id = $(this).data("id");
        var nama = $(this).data("nama");

        $("#edit_id").val(id);
        $("#edit_nama").val(nama);
        $("#formEdit").show();
    });

    // Update alamat
    $("#updateAlamatBtn").click(function() {
        var id = $("#edit_id").val();
        var nama = $("#edit_nama").val().trim();

        if (!nama) {
            alert("Nama blok tidak boleh kosong!");
            return;
        }
    

        $.post("tugas.php", { action: "edit_alamat", id: id, nama_blok: nama }, function(res){
           
                if(res.status === "success"){
                    alert("Alamat berhasil di update!");
                    $("#alamat-" + id + " td:nth-child(2)").text(nama);
                    $("#formEdit").hide();
                } else {
                    alert("Gagal update.");
            
        
                }
            }, "json");
        
        });

                   

    
    // Hapus alamat
    $("body").on("click", ".hapusAlamatBtn", function() {
        var id = $(this).data("id");
        if (confirm("Yakin hapus alamat ini?")) {
            $.post("tugas.php", { action: "hapus_alamat", id: id}, function (res) {
                try {
                    var data = typeof res === "string" ? JSON.parse(res) : res;
                    if (res.status === "success") {
                        $("#alamat-" + id).remove();
                    } else {
                        alert("Gagal menghapus.");
                    }
                } catch (e) {
                    console.error("Respon error:", res);
                    alert("Terjadi kesalahan.");
                }
            }, "json");
                
        }
    });
</script>
</body>
</html>
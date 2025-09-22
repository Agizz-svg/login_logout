<?php
    include "jaringan.php";
    
    
    $action = $_POST['action'] ?? '';
    
if($action === 'tambah_alamat') {
   $nama_blok = $koneksi->real_escape_string($_POST['nama_blok'] ?? '');

    if ($nama_blok) {
            $insert = $koneksi->query("INSERT INTO alamat (nama_blok) VALUES ('$nama_blok')");
            echo json_encode(['status' => $insert ? 'success' : 'error']);
    } else {
        echo json_encode(['status' => 'error', 'pesan' => 'Nama blok tidak boleh kosong.']);
    }
    exit;
}

    // Tambah Data Warga
if ($action === 'tambah') {
    $nama = $koneksi->real_escape_string($_POST['nama'] ?? '');
    $id_blok = $koneksi->real_escape_string($_POST['nama_blok'] ?? ''); // dari JS, ini sebenarnya id_blok

    if ($nama && $id_blok) {
        $insert = $koneksi->query("INSERT INTO warga (nama, id_blok) VALUES ('$nama', '$id_blok')");
        if ($insert) {
            echo "success";
        } else {
            echo "error: " . $koneksi->error;
        }
    } else {
        echo "error: data tidak lengkap";
    }
    exit;
}



    $action = $_POST['action'] ?? '';
    $keyword = $_POST['keyword'] ?? '';

    // Hapus Data
    if ($action == 'hapus') {
        $id = intval($_POST['id']);
        $hapus = $koneksi->query("DELETE FROM warga WHERE id = $id");
            echo "success";
        exit;
    }
    
    // Ambil data untuk edit
    if ($action == "getData"){
        $id = intval($_POST['id']);
        $result = $koneksi->query("SELECT * FROM warga WHERE id=$id");
        echo json_encode($result->fetch_assoc());
        exit;
    }

    // Update Data
    if ($action == "update"){
        $id     = intval($_POST['id']);
        $nama   = $koneksi->real_escape_string($_POST['nama']);
        $id_blok = $koneksi->real_escape_string($_POST['nama_blok']);

        $update = $koneksi->query("UPDATE warga SET nama='$nama', id_blok='$id_blok' WHERE id='$id'");

        $res = $koneksi->query("SELECT nama_blok FROM alamat WHERE id_blok='$id_blok'");
        $row = $res->fetch_assoc();

        echo json_encode([
            'status' => $update ? 'success' : 'error',
            'id'     => $id,
            'nama'   => $nama,
            'alamat' => $id_blok
        ]);
        exit;
    }

    
if ($action === 'hapus_alamat') {
    $id = intval($_POST['id']);
    $hapus = $koneksi->query("DELETE FROM alamat WHERE id_blok = $id");
    echo json_encode(['status' => $hapus ? 'success' : 'error']);
    exit;
}

if ($action === 'get_alamat_list') {
    $data = [];
    $result = $koneksi->query("SELECT id_blok, nama_blok FROM alamat ORDER BY nama_blok Asc");  
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    if (empty($data)) {
        echo json_encode(['status' => 'error', 'pesan' => 'Data alamat kosong']);
    } else {
        echo json_encode($data);
    }
    exit;
}

    if ($action === 'edit_alamat') {
    $id = intval($_POST['id']);
    $nama_blok = $koneksi->real_escape_string($_POST['nama_blok'] ?? '');

    if ($id && $nama_blok) {
        $update = $koneksi->query("UPDATE alamat SET nama_blok='$nama_blok' WHERE id_blok=$id");
        echo json_encode(['status' => $update ? 'success' : 'error']);
    } else {
        echo json_encode(['status' => 'error', 'pesan' => 'Data tidak lengkap']);
    }
    exit;
}

    // Pencarian Data

    $keyword = $_POST['keyword'] ?? '';

    $sql = "SELECT warga.id, warga.nama, alamat.nama_blok, warga.detail_alamat
            FROM warga 
            LEFT JOIN alamat ON warga.id_blok = alamat.id_blok
            WHERE warga.nama LIKE ? OR alamat.nama_blok LIKE ?";
    $stmt = $koneksi->prepare($sql);
    $param = "%$keyword%";
    $stmt->bind_param("ss", $param, $param);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $no = 1;
        while ($row = $result->fetch_assoc()) {
            echo "
                <tr id='row-$row[id]'>
                     <td>$no</td> 
                      <td class='nama_$row[id]'>$row[nama]</td>
                      <td class='alamat_$row[id]'>$row[nama_blok]</td>
                     <td>
                         <button class='hapusBtn' data-id='$row[id]'>Hapus</button>
                         <button class='editBtn' data-id='$row[id]'>Edit</button>
                     </td>
                </tr>
                ";
                $no++;
        }           
    } else {
        echo "<tr><td colspan='4'>Data tidak ditemukan.</td></tr>";
    }

    $stmt->close();
    $koneksi->close();
?>
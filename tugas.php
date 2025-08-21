<?php
    include "jaringan.php";
    
    
    $action = $_POST['action'] ?? '';
    
if($action === 'tambah'){
    header('Content-Type: application/json');
    $nama = $koneksi->real_escape_string($_POST['nama'] ?? '');
    $alamat = $koneksi->real_escape_string($_POST['alamat'] ?? '');

if ($nama && $alamat) {
    $insert = $koneksi->query("INSERT INTO warga (nama, alamat) VALUES ('$nama', '$alamat')");
    if ($insert) {
        $id = $koneksi->insert_id;
        echo json_encode([
            'status' => 'success',
            'id' => $id,
            'nama' => $nama,
            'alamat' => $alamat,
        ]);
    } else {
        echo json_encode(['status' => 'error', 'pesan' => $koneksi->error]);
    }
} else {
    echo json_encode(['status' =>'error', 'pesan' => 'Nama/alamat kosong']);
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
        $alamat = $koneksi->real_escape_string($_POST['alamat']);
        $update = $koneksi->query("UPDATE warga SET nama='$nama', alamat='$alamat' WHERE id=$id");
        echo "success";
        exit;
    }

    // Pencarian Data

    $keyword = $_POST['keyword'] ?? '';

    $sql = "SELECT * FROM warga WHERE nama LIKE ? OR alamat LIKE ?";
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
                        <td class='alamat_$row[id]'>$row[alamat]</td>
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
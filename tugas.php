<?php
    include "jaringan.php";

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
                <tr>
                        <td>$no</td> 
                        <td>{$row['nama']}</td>
                        <td>{$row['alamat']}<td>
                        <button onclick=\"return confirmHapus({$row['id']})\">Hapus</button>
                        <button onclick=\"alert('Apakah anda ingin megeditnya?')\">Edit</button>
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
$(document).ready(function () {



      $.ajax({
        url: 'tugas.php',
        method: 'POST',
        data: { keyword: '' },
        success: function (data) {
          $("#hasil").html(data);
        },
        error: function () {
          alert("Gagal memuat data.");
      }
    });
    
  
   
    $("body").on(" keyup",".cari",function(){
        var cari = $(this).val();
              
      // alert(cari);
        $.ajax({
          url: 'tugas.php',
          method: 'POST',
          data: { keyword: cari },
          success: function (data) {
            $("#hasil").html(data);
          },
          error: function () {
            alert("Terjadi kesalahan saat mengambil data.");
        }
      });
    });
});


 
  // Hapus data
  $("body").on("click", ".hapusBtn", function(){
    var id = $(this).data("id");
    if(confirm("Yakin hapus data ini?")){
      $.post("tugas.php", {action:"hapus", id: id}, function(res){
        if(res.trim() == "success"){
          $("#row-"+id).remove();
         
        } else {
          alert("Gagal menghapus data.");
        }
      });
    }
  });

  // Edit data
  $("body").on("click", ".editBtn", function(){
    var id = $(this).data("id");
    $.post("tugas.php", {action:"getData", id:id}, function(res){
      var data = JSON.parse(res);
      $("#edit_id").val(data.id);
      $("#edit_nama").val(data.nama);
      $("#edit_alamat").val(data.alamat);
      $("#editModal").show();
    });
  });

  // update data
  $("#updateBtn").click(function(){
    var id     = $("#edit_id").val();
    var nama   = $("#edit_nama").val();
    var alamat = $("#edit_alamat").val();

    console.log("Data dikirim:", id, nama, alamat)

    $.post("tugas.php", {action:"update", id:id, nama:nama, alamat:alamat}, function(res){
      if(res == "success"){
        $(".nama_"+id).text(nama);
        $(".alamat_"+id).text(alamat);
        $("#editModal").hide();
      }
    });
  });

  // *Tambah data*
    $("#tambahBtn").click(function () {
        var nama = $("#nama").val();
        var alamat = $("#alamat").val();

        if (nama === '' || alamat === '') {
            alert("Nama dan Alamat tidak boleh kosong!");
            return;
        }

          $.post("tugas.php", {
            action: "tambah",
            nama: nama,
            alamat: alamat
          }, function (res) {
            // Asumsikan res adalah JSON berisi id, nama, alamat dari data baru
            console.log("Respon dari server", res);
            try {
                var data = typeof res === "string" ? JSON.parse(res) : res;
                if (data.status === "success") {
                    alert("Data berhasil ditambahkan!");

                    // Buat baris baru untuk tabel
                    var no = $("#hasil tr").length + 1; // nomor urut baru
                    var newRow = `
                        <tr id="row-${data.id}">
                            <td>${no}</td>
                            <td class="nama_${data.id}">${data.nama}</td>
                            <td class="alamat_${data.id}">${data.alamat}</td>
                            <td>
                                <button class="hapusBtn" data-id="${data.id}">Hapus</button>
                                <button class="editBtn" data-id="${data.id}">Edit</button>
                            </td>
                        </tr>
                    `;
// Tambahkan baris ke tbody
                    $("#hasil").append(newRow);

                    // Reset form input
                    $("#nama").val('');
                    $("#alamat").val('');
                } else {
                    alert("Gagal menambahkan data: " + (data.pesan || ""));
                }
            } catch (e) {
                console.error("Parsing JSON gagal:", res);
                alert("Response error!");
            }
        }, "json");
});



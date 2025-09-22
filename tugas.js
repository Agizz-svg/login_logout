$(document).ready(function () {
  function loadBlokDropdown() {
    $.post("tugas.php", {action: "get_alamat_list"}, function(list){
       console.log("Data blok diterima:", list); 

      let options = '<option value="">Pilih Blok</option>';
      list.forEach(function (item) {
        options += `<option value="${item.id_blok}">${item.nama_blok}</option>`;
      });

      $("#alamat").html(options);
      $("#edit_alamat").html(options);
    }, "json") .fail(function(jqXHR, textStatus, errorThrown) {
        console.error("Gagal ambil alamat:", textStatus, errorThrown); 
        console.error("Response:", jqXHR.responseText);
  });
}

  loadBlokDropdown(); // Panggil saat halaman load

   // Tampilkan modal master data
  $("#masterBtn").click(function () {
    window.location.href = "master_data.php";

  });

   // Tambah data warga
  $("#tambahBtn").click(function () {
    var nama = $("#nama").val().trim();
    var nama_blok = $("#alamat").val();

    if (!nama || !nama_blok) {
      alert("Nama dan blok harus diisi!");
      return;
    }

    $.post("tugas.php", {action: "tambah", nama: nama, nama_blok: nama_blok}, function(res){
      if(res === "success"){
        alert("Data warga berhasil ditambahkan!");
        $(".cari").keyup(); // reload tabel
      } else {
        alert("Gagal menambahkan data!");
      }
    });
  });




  // ⬇ Load data warga pertama kali
  $.post('tugas.php', { action: 'cari_warga', keyword: '' }, function (res) {
    $("#hasil").html(res.html);
  }, "json");



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
    
  
   
    $("body").on("keyup",".cari",function(){
        var cari = $(this).val();
              
      // alert(cari);
        $.ajax({
          url: 'tugas.php',
          method: 'POST',
          data: {
             action: 'cari_warga',
             keyword: cari },
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
      $("#edit_alamat").val(data.id_blok).trigger("change");
      $("#editModal").show();
    });
  });

  // update data
  $("#updateBtn").click(function(){
    var id     = $("#edit_id").val();
    var nama   = $("#edit_nama").val();
    var id_blok = $("#edit_alamat").val();
    var alamatText = $("#edit_alamat option:selected").text();

    console.log("Data dikirim:", id, nama, id_blok)

    $.post("tugas.php", {action:"update", id:id, nama:nama, nama_blok: id_blok}, function(res){
      console.log("Respon server:", res);

      var data = typeof res === "string" ? JSON.parse(res) : res;

      if(res.status == "success"){
        $(".nama_"+id).text(nama);
        $(".alamat_"+id).text(alamatText);

        $("#editModal").hide();
        alert("Data berhasil diupdate!");
      } else {
        alert("Gagal update: " + (data.pesan || "Error server"));
      }
        }, "json");
      
});




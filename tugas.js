$(document).ready(function () {
  $("#btnCari").click(function () {
    var keyword = $("#keyword").val();

    $.ajax({
      url: "tugas.php",
      method: "POST",
      data: { keyword: keyword },
      success: function (data) {
        $("#hasil").html(data);
      },
      error: function () {
        alert("Terjadi kesalahan saat mengambil data.");
      }
    });
  });
});
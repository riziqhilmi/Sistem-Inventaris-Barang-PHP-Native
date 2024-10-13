<?php
include('../koneksi.php');
$id = $_GET['id'];
?>

<script type="text/javascript">
    var result = confirm("Apakah Anda yakin ingin menghapus data ini?");
    if(result) {
        // Jika pengguna menekan "OK", maka data akan dihapus
        window.location.href = "delete_action_guru.php?id=<?php echo $id; ?>";
    } else {
        window.location.href = "../data_guru.php";

    }
</script>


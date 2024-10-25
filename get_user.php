<?php
require_once "koneksi.php";

if (isset($_GET['function']) && function_exists($_GET['function'])) {
    $_GET['function']();
}

function get_guru()
{
    global $koneksi;
    $query = $koneksi->query("SELECT * FROM guru");
    $data = array();
    while ($row = mysqli_fetch_object($query)) {
        $data[] = $row;
    }
    $response = array(
        'status' => 1,
        'message' => 'Sukses',
        'data' => $data
    );
    header('Content-Type: application/json');
    echo json_encode($response);
}

function get_guru_id()
{
    global $koneksi;

    if (!empty($_GET["id"])) {
        $id = $_GET["id"];
        $query = $koneksi->query("SELECT * FROM guru WHERE id_guru = '$id'");
        
        if ($row = mysqli_fetch_object(result: $query)) {
            $response = array(
                'status' => 1,
                'message' => 'Sukses',
                'data' => $row
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Data not found'
            );
        }
    } else {
        $response = array(
            'status' => 0,
            'message' => 'Wrong Parameter'
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

function update_guru()
{
    global $koneksi;

    if (!empty($_GET["id"])) {
        $id = $_GET["id"];
        $nama = $_GET["nama"];

        $query = "UPDATE guru SET nama = '$nama' WHERE id_guru = '$id'";

        if ($result = mysqli_query($koneksi, $query)) {
            $response = array(
                'status' => 1,
                'message' => 'Update Success'
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Update Failed'
            );
        }
    } else {
        $response = array(
            'status' => 0,
            'message' => 'Wrong Parameter'
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

function delete_guru()
{
    global $koneksi;

    if (!empty($_GET['id'])) {
        $id = $_GET['id'];
        $query = "DELETE FROM guru WHERE id_guru = '$id'";

        if (mysqli_query($koneksi, $query)) {
            $response = array(
                'status' => 1,
                'message' => 'Delete Success'
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Delete Failed'
            );
        }
    } else {
        $response = array(
            'status' => 0,
            'message' => 'Wrong Parameter'
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

function insert_guru()
{
    global $koneksi;

    if (!empty($_GET["nama"]) && !empty($_GET["NIP"]) && !empty($_GET["kontak"]) && 
        !empty($_GET["tempat_lahir"]) && !empty($_GET["tgl_lahir"]) && 
        !empty($_GET["alamat"]) && !empty($_GET["status"])) {

        $nama = $_GET["nama"];
        $NIP = $_GET["NIP"];
        $kontak = $_GET["kontak"];
        $tempat_lahir = $_GET["tempat_lahir"];
        $tgl_lahir = $_GET["tgl_lahir"];
        $alamat = $_GET["alamat"];
        $status = $_GET["status"];

        $query = "INSERT INTO guru (nama, NIP, kontak, tempat_lahir, tgl_lahir, alamat, status) 
                  VALUES ('$nama', '$NIP', '$kontak', '$tempat_lahir', '$tgl_lahir', '$alamat', '$status')";

        if (mysqli_query($koneksi, $query)) {
            $response = array(
                'status' => 1,
                'message' => 'Insert Success'
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Insert Failed'
            );
        }
    } else {
        $response = array(
            'status' => 0,
            'message' => 'Wrong Parameters'
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}


?>

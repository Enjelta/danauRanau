<?php
// Koneksi ke database
require '../conn.php';

// Mengecek halaman yang sedang aktif
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Mengatur jumlah data yang ditampilkan per halaman
$limit = 10;

// Menghitung offset data
$offset = ($page - 1) * $limit;

// Menghapus data jika ada request penghapusan
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Query untuk menghapus data wahana berdasarkan ID
    $sql_delete = "DELETE FROM wahana WHERE id = $id";

    if (mysqli_query($conn, $sql_delete)) {
        echo "<script>alert('Data wahana dengan ID $id berhasil dihapus.');</script>";
        echo "<script>window.location.href = 'tampil.php';</script>";
    } else {
        echo "Error: " . $sql_delete . "<br>" . mysqli_error($conn);
    }
}

// Mengecek apakah ada pencarian yang dilakukan
if (isset($_GET['search'])) {
    $search = $_GET['search'];

    // Query untuk mengambil data wahana berdasarkan pencarian
    $sql = "SELECT * FROM wahana WHERE nama_wahana LIKE '%$search%'";
    $searchValue = $search; // Menyimpan nilai pencarian untuk ditampilkan kembali di input
} else {
    // Query untuk mengambil semua data wahana dengan pagination
    $sql = "SELECT * FROM wahana LIMIT $limit OFFSET $offset";
    $searchValue = ""; // Set nilai pencarian ke kosong
}

$result = mysqli_query($conn, $sql);

// Menghitung jumlah total data
$totalData = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM wahana WHERE nama_wahana LIKE '%$searchValue%'"));
// Menghitung jumlah halaman
$totalPages = ceil($totalData / $limit);

// Mengecek apakah ada data yang dihasilkan
if (mysqli_num_rows($result) > 0) {
    if (!isset($_GET['search'])) { // Tampilkan pencarian hanya jika tidak ada pencarian yang dilakukan
        echo "<form action='tampil.php' method='GET'>";
        echo "<input type='text' name='search' value='$searchValue' placeholder='Cari Nama Wahana...'>";
        echo "<input type='submit' value='Cari'>";
        echo "</form>";
    }

    echo "<table id='wahanaTable'>";
    echo "<tr><th>No</th><th>Nama Wahana</th><th>Deskripsi</th><th>Latitude</th><th>Longitude</th><th>Gambar Wahana</th><th>Aksi</th></tr>";

    // Menampilkan data ke dalam tabel
    $no = ($page - 1) * $limit + 1;
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $no . "</td>";
        echo "<td>" . $row["nama_wahana"] . "</td>";
        echo "<td>" . $row["deskripsi"] . "</td>";
        echo "<td>" . $row["latitude"] . "</td>";
        echo "<td>" . $row["longitude"] . "</td>";
        echo "<td><img src='" . $row["gambar"] . "' alt='Gambar Wahana' width='100'></td>";
        echo "<td><a href='edit.php?id=" . $row["id"] . "'>Edit</a> | <a href='tampil.php?delete=" . $row["id"] . "' onclick='return confirmDelete();'>Delete</a></td>";
        echo "</tr>";
        $no++;
    }

    echo "</table>";

    // Membuat navigasi pagination
    if (!isset($_GET['search']) && $totalData > $limit) { // Tampilkan pagination hanya jika tidak ada pencarian yang dilakukan dan jumlah data lebih dari batas per halaman
        echo "<ul class='pagination'>";
        if ($page > 1) {
            echo "<li><a href='tampil.php?page=" . ($page - 1) . "'>&laquo;</a></li>";
        }

        for ($i = 1; $i <= $totalPages; $i++) {
            echo "<li";
            if ($i == $page) {
                echo " class='active'";
            }
            echo "><a href='tampil.php?page=$i'>$i</a></li>";
        }

        if ($page < $totalPages) {
            echo "<li><a href='tampil.php?page=" . ($page + 1) . "'>&raquo;</a></li>";
        }
        echo "</ul>";
    }
} else {
    if (!isset($_GET['search'])) { // Tampilkan pencarian hanya jika tidak ada pencarian yang dilakukan
        echo "<form action='tampil.php' method='GET'>";
        echo "<input type='text' name='search' value='$searchValue' placeholder='Cari Nama Wahana...'>";
        echo "<input type='submit' value='Cari'>";
        echo "</form>";
    }
    echo "<p>Data belum ada.</p>";
}

mysqli_close($conn);
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var timer;

        $('input[name="search"]').keyup(function() {
            clearTimeout(timer);

            var searchValue = $(this).val();

            // Delay untuk menunggu pengguna selesai mengetik
            timer = setTimeout(function() {
                // Mengirim permintaan AJAX ke server
                $.ajax({
                    type: 'GET',
                    url: 'tampil.php',
                    data: {
                        search: searchValue
                    },
                    success: function(response) {
                        $('#wahanaTable').html(response);
                    }
                });
            }, 300);
        });
    });
</script>

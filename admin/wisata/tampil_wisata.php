<?php
// Koneksi ke database (ganti dengan informasi koneksi sesuai dengan database Anda)
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'indah';

$conn = mysqli_connect($host, $username, $password, $database);

// Fungsi untuk mendapatkan total data wisata dari database
function getTotalData()
{
    global $conn;

    $query = "SELECT COUNT(*) as total FROM wisata";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    return $row['total'];
}

// Mendapatkan semua data wisata dari database
$query = "SELECT * FROM wisata";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Wisata</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Data Wisata</h2>
    <p>Total data: <?php echo getTotalData(); ?></p>
    <table>
        <tr>
            <th>Nama</th>
            <th>Deskripsi</th>
            <th>Kategori</th>
            <th>Gambar</th>
        </tr>
        <?php
        // Menampilkan data wisata
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['nama_wisata'] . "</td>";
                echo "<td>" . $row['deskripsi'] . "</td>";
                echo "<td>" . $row['kategori'] . "</td>";
                echo "<td><img src='uploads/" . $row['gambar'] . "' width='100' height='100'></td>";
                echo "<td><img src='uploads/" . $row['gambar2'] . "' width='100' height='100'></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Tidak ada data wisata.</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
// Menutup koneksi ke database
mysqli_close($conn);
?>

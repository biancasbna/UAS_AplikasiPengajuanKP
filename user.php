<?php
include "./koneksi.php";
$result = $dbCrud->query("SELECT * FROM header_footer LIMIT 1");
$data = $result->fetch_assoc();
?>

<?php 
    if(isset($_POST['frmId'])) {
        // Kalau tambah data
        if($_POST['frmId'] == "frmTambah") {
            $nama_mhs = $_POST['nama_mhs'];
            $nim = $_POST['nim'];  
            $thnakademik = $_POST['thnakademik'];
            $prodi = $_POST['prodi'];
            $nmperusahaan = $_POST['nmperusahaan'];
            $alamat = $_POST['alamat'];
            $tgl_pengajuan = $_POST['tgl_pengajuan'];
            $dosenpa = $_POST['dosenpa'];

            //query insert statement dan periksa apakah insert berhasil*/
            if($dbCrud->query("insert into form values ('$nama_mhs', '$nim', '$thnakademik', '$prodi', '$nmperusahaan', '$alamat',  '$tgl_pengajuan', '$dosenpa');")) {
                echo " ";
            }
            else {
                echo "Error: insert into form " . "<br>" . $dbCrud->error;
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['nmweb']; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <section class="header-content">
        <img src="data:image/jpeg;base64,<?= base64_encode($data['logo']); ?>" alt="Logo" class="header-logo">
        <section class="header-text">
            <h1><?= $data['nmweb']; ?></h1>
            <p><?= $data['slogan']; ?></p>
            <p><?= $data['alamat']; ?></p>
        </section>
    </section>
</header>

    <main>
      <nav>
    <?php $query = $dbCrud->query("select * from nav"); ?>
    <ul>
        <?php 
        while($nav = $query->fetch_object()) {
            if ($nav->listnav == 'Lowongan') {
                echo '<li><a href="lowongan.php">' . $nav->listnav . '</a></li>';
            } else {
                echo '<li>' . $nav->listnav . '</li>';
            }
        }
        ?>
    </ul>
    </nav>

    <article>
    <h2>Form Pengajuan Kerja Profesi</h2>
    <form action="./user.php" method="POST" id="frmTambah">
        <table>
            <tr>
                <td><label for="nama_mhs">Nama Mahasiswa:</label></td><td>
                <input type="text" name="nama_mhs" id="nama_mhs"></td>
            </tr>
            <tr>
                <td><label for="nim">NIM Mahasiswa:</label></td><td>
                <input type="text" name="nim" id="nim"></td>
            </tr>
            <tr>
                <td><label for="thnakademik">Tahun Akademik:</label></td><td>
                <input type="text" name="thnakademik" id="thnakademik"></td>
            </tr>
            <tr>
                <td ><label for="prodi">Program Studi:</label></td><td>
                <input type="text" name="prodi" id="prodi"></td>
            </tr>
            <tr>
                <td ><label for="nmperusahaan">Nama Perusahaan:</label></td><td>
                <input type="text" name="nmperusahaan" id="nmperusahaan"></td>
            </tr>
            <tr>
                <td ><label for="alamat">Alamat Perusahaan:</label></td><td>
                <input type="text" name="alamat" id="alamat"></td>
            </tr>
            <tr>
                <td ><label for="tgl_pengajuan">Tanggal Pengajuan:</label></td><td>
                <input type="date" name="tgl_pengajuan" id="tgl_pengajuan"></td>
            </tr>
            <tr>
                <td ><label for="dosenpa">Dosen Pembimbing:</label></td><td>
                <input type="text" name="dosenpa" id="dosenpa"></td>
            </tr>
            <tr>
                <td  align="right"></td><td align="right">
                <input type="submit" value="SUBMIT"></td>
            </tr>
        </table>
        <input type="hidden" value="frmTambah" name="frmId" id="frmId1" >
    </form>
</article>


    <aside>
        <h2><b>Informasi</b></h2>
        <?php $query = $dbCrud->query("select * from aside"); ?>
        <?php while ($aside = $query->fetch_object()) { ?>
        <ul>
            <li><?php echo $aside->pengumuman; ?></li>
        </ul>
        <?php } ?>
    </aside>
    </main>


<footer>
    <section class="socials">
        <p>Twitter: <?= $data['twitter']; ?></p>
        <p>FB: <?= $data['fb']; ?></p>
        <p>Instagram: <?= $data['instagram']; ?></p>
    </section>
    <section class="copyright">
        <p>&copy; 2024. All Rights Reserved.</p>
    </section>
    <section class="footer-name">
        <p><b><?= $data['nmweb']; ?></b></p>
        <p><?= $data['slogan']; ?></p>
    </section>
</footer>

<script>
    const formTambah = document.getElementById("frmTambah");
</script>
</body>
</html>

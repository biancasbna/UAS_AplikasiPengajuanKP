<?php
include "./koneksi.php";
$result = $dbCrud->query("SELECT * FROM header_footer LIMIT 1");
$data = $result->fetch_assoc();
?>

<?php
    if(isset($_GET['hapus'])) {
        $parNim = $_GET['nim'];
        $dbCrud->query("DELETE FROM form WHERE nim='$parNim'");
    }

    if(isset($_POST['frmId'])) {
        if ($_POST['frmId'] == "frmUbah") {
            $nama_mhs = $_POST['nama_mhs'];
            $nim = $_POST['nim'];  
            $thnakademik = $_POST['thnakademik'];
            $prodi = $_POST['prodi'];
            $nmperusahaan = $_POST['nmperusahaan'];
            $alamat = $_POST['alamat'];
            $tgl_pengajuan = $_POST['tgl_pengajuan'];
            $dosenpa = $_POST['dosenpa'];

            if ($dbCrud->query("UPDATE form SET nama_mhs='$nama_mhs', 
            thnakademik='$thnakademik',
            prodi='$prodi',
            nmperusahaan='$nmperusahaan',
            alamat='$alamat',
            tgl_pengajuan='$tgl_pengajuan',
            dosenpa='$dosenpa'
            WHERE nim='$nim'")) {
                echo " ";
            } else {
                echo "Error: update form " . "<br>" . $dbCrud->error;
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
    <?php $query = $dbCrud->query("SELECT * FROM nav_admin"); ?>
    <ul>
        <?php 
        while($nav = $query->fetch_object()) {
            if ($nav->listnav == 'Kelola Lowongan') {
                echo '<li><a href="crud_lowongan.php">' . $nav->listnav . '</a></li>';
            } else if ($nav->listnav == 'Kelola Header dan Footer') {
                echo '<li><a href="crudheader_footer.php">' . $nav->listnav . '</a></li>';
            } else if ($nav->listnav == 'Kelola Aside') {
                echo '<li><a href="crud_aside.php">' . $nav->listnav . '</a></li>';
            } else {
                echo '<li>' . $nav->listnav . '</li>';
            }
        }
        ?>
    </ul>
</nav>
    
<article>

    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" id="frmUbah" style="display: none;">
        <b>Form Ubah Form</b>
        <table>
            <tr>
                <td><label for="nama_mhs">Nama Mahasiswa:</label></td><td>
                <input type="text" name="nama_mhs" id="unama_mhs"></td>
            </tr>
            <tr>
                <td><label for="nim">NIM Mahasiswa:</label></td><td>
                <input type="text" name="fnim" id="fnim" disabled></td>
            </tr>
            <tr>
                <td><label for="thnakademik">Tahun Akademik:</label></td><td>
                <input type="text" name="thnakademik" id="uthnakademik"></td>
            </tr>
            <tr>
                <td><label for="prodi">Program Studi:</label></td><td>
                <input type="text" name="prodi" id="uprodi"></td>
            </tr>
            <tr>
                <td><label for="nmperusahaan">Nama Perusahaan:</label></td><td>
                <input type="text" name="nmperusahaan" id="unmperusahaan"></td>
            </tr>
            <tr>
                <td><label for="alamat">Alamat Perusahaan:</label></td><td>
                <input type="text" name="alamat" id="ualamat"></td>
            </tr>
            <tr>
                <td><label for="tgl_pengajuan">Tanggal Pengajuan:</label></td><td>
                <input type="date" name="tgl_pengajuan" id="utgl_pengajuan"></td>
            </tr>
            <tr>
                <td><label for="dosenpa">Dosen Pembimbing:</label></td><td>
                <input type="text" name="dosenpa" id="dosenpa"></td>
            </tr>
            <tr>
                <td  align="right"></td><td align="right"><button type="reset" id="batalUbah">BATAL</button><input type="submit" value="UBAH"></td>
            </tr>
        </table>
        <input type="hidden" value="<?php echo($varNim); ?>" name="nim" id="unim" >
        <input type="hidden" value="frmUbah" name="frmId" id="frmId2">
    </form>

    <h2><b>Data Pengajuan KP Mahasiswa</b></h2>
    <table class="tblForm">
        <thead>
            <tr>
                <th>NO</th>
                <th>Nama Mahasiswa</th>
                <th>NIM</th>
                <th>Tahun Akademik</th>
                <th>Prodi</th>
                <th>Nama Perusahaan</th>
                <th>Alamat</th>
                <th>Tanggal Pengajuan</th>
                <th>Dosen Pembimbing</th>
                <th>Kelola</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $no = 1;
                $query = $dbCrud->query("SELECT * FROM form");
                while ($form = $query->fetch_object()) {
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($form->nama_mhs); ?></td>
                <td><?= htmlspecialchars($form->nim); ?></td>
                <td><?= htmlspecialchars($form->thnakademik); ?></td>
                <td><?= htmlspecialchars($form->prodi); ?></td>
                <td><?= htmlspecialchars($form->nmperusahaan); ?></td>
                <td><?= htmlspecialchars($form->alamat); ?></td>
                <td><?= htmlspecialchars($form->tgl_pengajuan); ?></td>
                <td><?= htmlspecialchars($form->dosenpa); ?></td>
                <td>
                    <button onclick="ubah('<?php echo($form->nama_mhs); ?>', '<?php echo($form->nim); ?>', '<?php echo($form->thnakademik); ?>', '<?php echo($form->prodi); ?>',
                    '<?php echo($form->nmperusahaan); ?>', '<?php echo($form->alamat); ?>', '<?php echo($form->tgl_pengajuan); ?>', '<?php echo($form->dosenpa); ?>');" class="btn-ubah">Ubah</button>
                    <button onclick="document.location='admin.php?hapus=true&nim=<?= $form->nim; ?>'" class="btn-hapus">Hapus</button>
                </td>
            </tr>
            <?php
                }
            ?>
        </tbody>
    </table>

</article>

<aside>
    <h2><b>Informasi</b></h2>
    <?php
        $query = $dbCrud->query("SELECT * FROM aside");
        while ($aside = $query->fetch_object()) {
    ?>
    <ul>
        <li><?= $aside->pengumuman; ?></li>
    </ul>
    <?php
        }
    ?>
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
    const formUbah = document.getElementById("frmUbah");
    const btnBatalUbah = document.getElementById("batalUbah");

    btnBatalUbah.addEventListener("click", () => {
        formUbah.style.display = "none";
        formTambah.style.display = "";
        document.querySelector("#unama_mhs").value = "";
        document.querySelector("#fnim").value = "";
        document.querySelector("#unim").value = "";
        document.querySelector("#uthnakademik").value = "";
        document.querySelector("#uprodi").value = "";
        document.querySelector("#unmperusahaan").value = "";
        document.querySelector("#ualamat").value = "";
        document.querySelector("#utgl_pengajuan").value = "";
        document.querySelector("#dosenpa").value = "";
    });

    let ubah = (parNama, parNim, parThn, parProdi, parNmPerusahaan, parAlamat, parTgl, parDosen) => {
        formUbah.style.display = "block";
        document.querySelector("#unama_mhs").value = parNama;
        document.querySelector("#fnim").value = parNim;
        document.querySelector("#unim").value = parNim;
        document.querySelector("#uthnakademik").value = parThn;
        document.querySelector("#uprodi").value = parProdi;
        document.querySelector("#unmperusahaan").value = parNmPerusahaan;
        document.querySelector("#ualamat").value = parAlamat;
        document.querySelector("#utgl_pengajuan").value = parTgl;
        document.querySelector("#dosenpa").value = parDosen;
    }
</script>

</body>
</html>

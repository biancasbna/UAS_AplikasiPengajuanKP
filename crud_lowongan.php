
<?php
include "./koneksi.php";
$result = $dbCrud->query("SELECT * FROM header_footer LIMIT 1");
$data = $result->fetch_assoc();
?>

<?php
    // ini code untk hapus lowongan yang sebelumnya udah di tambahkan 
    if(isset($_GET['hapus'])) {
        $parIDLowongan = $_GET['idlowongan'];
        $dbCrud->query("delete from lowongan where idlowongan='$parIDLowongan'");
    }

    if(isset($_POST['frmId'])) {
        // Kalau tambah data
        if($_POST['frmId'] == "frmTambah") {
            /*data yang akan disimpan ke tabel*/
            $idlowongan = $_POST['idlowongan'];
            $nmperusahaan = $_POST['nmperusahaan'];
            $alamatperusahaan = $_POST['alamatperusahaan'];  
            $lowongantersedia = $_POST['lowongantersedia'];

            //query insert statement dan periksa apakah insert berhasil*/
            if($dbCrud->query("insert into lowongan values ( '$idlowongan','$nmperusahaan', '$alamatperusahaan', '$lowongantersedia');")) {
                echo " ";
            }
            else {
                echo "Error: insert into lowongan " . "<br>" . $dbCrud->error;
            }
        }

        // Kalau ubah data
        if ($_POST['frmId'] == "frmUbah") {
            $idlowongan = $_POST['idlowongan'];
            $nmperusahaan = $_POST['nmperusahaan']; 
            $alamatperusahaan = $_POST['alamatperusahaan'];  
            $lowongantersedia = $_POST['lowongantersedia'];
        
            
            if ($dbCrud->query("UPDATE lowongan SET nmperusahaan='$nmperusahaan', alamatperusahaan='$alamatperusahaan' , lowongantersedia='$lowongantersedia' WHERE idlowongan='$idlowongan'")) {
                echo " ";
            } else {
                echo "Error: update lowongan " . "<br>" . $dbCrud->error;
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
    <?php $query = $dbCrud->query("select * from nav_admin"); ?>
    <ul>
        <?php 
        while($nav = $query->fetch_object()) {
            if ($nav->listnav == 'Kelola Data Mahasiswa') {
                echo '<li><a href="admin.php">' . $nav->listnav . '</a></li>';
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

    <form action="./crud_lowongan.php" method="POST" id="frmTambah">
        <h2><b>Tambah Data Lowongan</b></h2>
        <table>
            <tr>
                <td align="right"><label for="idlowongan">ID Lowongan:</label></td><td>
                <input type="text" name="idlowongan" id="idlowongan"></td>
            </tr>
            <tr>
                <td align="right"><label for="nmperusahaan">Nama Perusahaan:</label></td><td>
                <input type="text" name="nmperusahaan" id="nmperusahaan"></td>
            </tr>
            <tr>
                <td  align="right"><label for="alamatperusahaan">Alamat Perusahaan:</label></td><td>
                <input type="text" name="alamatperusahaan" id="alamatperusahaan"></td>
            </tr>
            <tr>
                <td  align="right"><label for="lowongantersedia">Lowongan:</label></td><td>
                <input type="text" name="lowongantersedia" id="lowongantersedia"></td>
            </tr>
            <tr>
                <td  align="right"></td><td align="right">
                <input type="submit" value="TAMBAH"></td>
            </tr>
        </table>
        <input type="hidden" value="frmTambah" name="frmId" id="frmId1" >
    </form>

    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" id="frmUbah" style="display: none;">
        <h2><b>Form Ubah Lowongan</b></h2>
        <table>
            <tr>
                <td align="right"><label for="idlowongan">ID Lowongan:</label></td><td><input type="text" name="fidlowongan" id="fidlowongan" disabled></td>
            </tr>
            <tr>
                <td align="right"><label for="nmperusahaan">Nama Perusahaan:</label></td><td><input type="text" name="nmperusahaan" id="unmperusahaan"></td>
            </tr>
            <tr>
                <td  align="right"><label for="alamatperusahaan">Alamat Perusahaan:</label></td><td><input type="text" name="alamatperusahaan" id="ualamatperusahaan"></td>
            </tr>
            <tr>
                <td  align="right"><label for="lowongantersedia">Lowongan:</label></td><td><input type="text" name="lowongantersedia" id="ulowongantersedia"></td>
            </tr>
            <tr>
            <tr>
                <td  align="right"></td><td align="right"><button type="reset" id="batalUbah">BATAL</button><input type="submit" value="UBAH"></td>
            </tr>
        </table>
        <input type="hidden" value="<?php echo($varLowongan); ?>" name="idlowongan" id="uidlowongan" >
        <input type="hidden" value="frmUbah" name="frmId" id="frmId2">
    </form>

        <?php $query = $dbCrud->query("select * from lowongan"); ?>

        <h2><b>Daftar Lowongan</b></h2>
<table class="tblLowongan">
    <thead>
        <tr>
            <th>NO</th>
            <th>ID Lowongan</th>
            <th>Nama Perusahaan</th>
            <th>Alamat Perusahaan</th>
            <th>Lowongan</th>
            <th>Kelola</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        while ($lowongan = $query->fetch_object()) {
        ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $lowongan->idlowongan; ?></td>
            <td><?php echo $lowongan->nmperusahaan; ?></td>
            <td><?php echo $lowongan->alamatperusahaan; ?></td>
            <td><?php echo $lowongan->lowongantersedia; ?></td>
            <td>
                <button onclick="ubah('<?php echo($lowongan->idlowongan); ?>','<?php echo($lowongan->nmperusahaan); ?>', '<?php echo($lowongan->alamatperusahaan); ?>', '<?php echo($lowongan->lowongantersedia); ?>');" class="btn-ubah">Ubah</button>
                <button onclick="document.location='crud_lowongan.php?hapus=true&&idlowongan=<?php echo($lowongan->idlowongan); ?>'" class="btn-hapus">Hapus</button>
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
    const btnBatalUbah = document.getElementById("batalUbah");
    const formTambah = document.getElementById("frmTambah");
    const formUbah = document.getElementById("frmUbah");
    
    btnBatalUbah.addEventListener("click", () => {
        formUbah.style.display = "none";
        formTambah.style.display = "";
        document.querySelector("#fidlowongan").value = "";
        document.querySelector("#uidlowongan").value = "";
        document.querySelector("#unmperusahaan").value = "";
        document.querySelector("#ualamatperusahaan").value = "";
        document.querySelector("#ulowongantersedia").value = "";
    });

    let ubah = (parIDLowongan,parPerusahaan, parAlamat, parLowongan) => {
        formUbah.style.display = "";
        formTambah.style.display = "none";
        document.querySelector("#fidlowongan").value = parIDLowongan;
        document.querySelector("#uidlowongan").value = parIDLowongan;
        document.querySelector("#unmperusahaan").value = parPerusahaan;
        document.querySelector("#ualamatperusahaan").value = parAlamat;
        document.querySelector("#ulowongantersedia").value = parLowongan;
        }
</script>

</body>
</html>

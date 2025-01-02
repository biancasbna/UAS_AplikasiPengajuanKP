<?php
include "./koneksi.php";
$result = $dbCrud->query("SELECT * FROM header_footer LIMIT 1");
$data = $result->fetch_assoc();
?>

<?php
    if(isset($_GET['hapus'])) {
        $parIDpengumuman = $_GET['idpengumuman'];
        $dbCrud->query("delete from aside where idpengumuman='$parIDpengumuman'");
    }

    if(isset($_POST['frmId'])) {
        
        if($_POST['frmId'] == "frmTambah") {
            $idpengumuman = $_POST['idpengumuman'];
            $pengumuman = $_POST['pengumuman'];  

            if($dbCrud->query("insert into aside values ('$idpengumuman', '$pengumuman');")) {
                echo " ";
            }
            else {
                echo "Error: insert into aside " . "<br>" . $dbCrud->error;
            }
        }

        if ($_POST['frmId'] == "frmUbah") {
            $idpengumuman = $_POST['idpengumuman']; 
            $pengumuman = $_POST['pengumuman'];  

            if ($dbCrud->query("UPDATE aside SET pengumuman='$pengumuman' WHERE idpengumuman='$idpengumuman'")) {
                echo " ";
            } else {
                echo "Error: update aside " . "<br>" . $dbCrud->error;
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
            } else if ($nav->listnav == 'Kelola Lowongan') {
                echo '<li><a href="crud_lowongan.php">' . $nav->listnav . '</a></li>';
            } else {
                echo '<li>' . $nav->listnav . '</li>';
            }
        }
        ?>
    </ul>
</nav>
    
<article>
    <form action="./crud_aside.php" method="POST" id="frmTambah">
        <h2><b>Tambah Informasi </b></h2>
        <table>
            <tr>
                <td align="right"><label for="idpengumuman">ID Pengumuman:</label></td>
                <td><input type="text" name="idpengumuman" id="idpengumuman"></td>
            </tr>
            <tr>
                <td align="right"><label for="pengumuman">Pengumuman Baru :</label></td>
                <td><input type="text" name="pengumuman" id="pengumuman"></td>
            </tr>
            <tr>
                <td align="right"></td>
                <td align="right"><input type="submit" value="TAMBAH"></td>
            </tr>
        </table>
        <input type="hidden" value="frmTambah" name="frmId" id="frmId1">
    </form>

    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" id="frmUbah" style="display: none;">
        <h2><b>Form Ubah Informasi</b></h2>
        <table>
            <tr>
                <td align="right"><label for="fidpengumuman">No :</label></td>
                <td><input type="text" name="fidpengumuman" id="fidpengumuman" disabled></td>
            </tr>
            <tr>
                <td align="right"><label for="upengumuman">Pengumuman :</label></td>
                <td><input type="text" name="pengumuman" id="upengumuman"></td>
            </tr>
            <tr>
                <td align="right"></td>
                <td align="right"><button type="reset" id="batalUbah">BATAL</button>
                <input type="submit" value="UBAH"></td>
            </tr>
        </table>
        <input type="hidden" value="<?php echo($varIDPengumuman); ?>" name="idpengumuman" id="uidpengumuman" >
        <input type="hidden" value="frmUbah" name="frmId" id="frmId2">
    </form>

    <?php $query = $dbCrud->query("select * from aside"); ?>

    <h2><b>Data Pengumuman</b></h2>
<table class="tblPengumuman">
    <thead>
        <tr>
            <th>No</th>
            <th>ID Pengumuman</th>
            <th>Pengumuman</th>
            <th>Kelola</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $query = $dbCrud->query("SELECT * FROM aside");
        $no = 1;
        while ($aside = $query->fetch_object()) {
        ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $aside->idpengumuman; ?></td>
            <td><?php echo $aside->pengumuman; ?></td>
            <td>
                <button class="btn-ubah" onclick="ubah('<?= htmlspecialchars($aside->idpengumuman); ?>', '<?= addslashes(htmlspecialchars($aside->pengumuman)); ?>');">Ubah</button>
                <button class="btn-hapus" onclick="document.location='crud_aside.php?hapus=true&idpengumuman=<?= htmlspecialchars($aside->idpengumuman); ?>';">Hapus</button>
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
    document.querySelector("#fidpengumuman").value = "";
    document.querySelector("#uidpengumuman").value = "";
    document.querySelector("#upengumuman").value = "";
});

let ubah = (parIDpengumuman, parPengumuman) => {
    formUbah.style.display = "";
    formTambah.style.display = "none";
    document.querySelector("#fidpengumuman").value = parIDpengumuman;
    document.querySelector("#uidpengumuman").value = parIDpengumuman;
    document.querySelector("#upengumuman").value = parPengumuman;
}
</script>

</body>
</html>

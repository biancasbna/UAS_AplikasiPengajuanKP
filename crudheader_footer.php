<?php
include "./koneksi.php";


$result = $dbCrud->query("SELECT * FROM header_footer LIMIT 1");
$data = $result->fetch_assoc();

if (isset($_POST['frmId']) && $_POST['frmId'] === "frmUbah") {
    $nmweb = $_POST['nmweb'];
    $slogan = $_POST['slogan'];
    $alamat = $_POST['alamat'];
    $twitter = $_POST['twitter'];
    $fb = $_POST['fb'];
    $instagram = $_POST['instagram'];


    if (isset($_FILES['logo']['tmp_name']) && !empty($_FILES['logo']['tmp_name'])) {
        $logo = addslashes(file_get_contents($_FILES['logo']['tmp_name']));
        $dbCrud->query("UPDATE header_footer SET slogan='$slogan', alamat='$alamat', twitter='$twitter', fb='$fb', instagram='$instagram', logo='$logo' WHERE nmweb='$nmweb'");
    } else {
        $dbCrud->query("UPDATE header_footer SET slogan='$slogan', alamat='$alamat', twitter='$twitter', fb='$fb', instagram='$instagram' WHERE nmweb='$nmweb'");
    }
    header("Location: crudheader_footer.php");
}


if (isset($_POST['frmId']) && $_POST['frmId'] === "frmUbah") {
    $nmweb = $_POST['nmweb']; 
    $slogan = $_POST['slogan'];
    $alamat = $_POST['alamat'];
    $twitter = $_POST['twitter'];
    $fb = $_POST['fb'];
    $instagram = $_POST['instagram'];

   
    if (isset($_FILES['logo']['tmp_name']) && !empty($_FILES['logo']['tmp_name'])) {
        $logo = addslashes(file_get_contents($_FILES['logo']['tmp_name']));
        $dbCrud->query("UPDATE header_footer SET nmweb='$nmweb', slogan='$slogan', alamat='$alamat', twitter='$twitter', fb='$fb', instagram='$instagram', logo='$logo' WHERE nmweb='{$data['nmweb']}'");
    } else {
        $dbCrud->query("UPDATE header_footer SET nmweb='$nmweb', slogan='$slogan', alamat='$alamat', twitter='$twitter', fb='$fb', instagram='$instagram' WHERE nmweb='{$data['nmweb']}'");
    }
    header("Location: crudheader_footer.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Header dan Footer</title>
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
            } else if ($nav->listnav == 'Kelola Data Mahasiswa') {
                echo '<li><a href="admin.php">' . $nav->listnav . '</a></li>';
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
    <h2>Ubah Header dan Footer</h2>
    <form action="crudheader_footer.php" method="POST" enctype="multipart/form-data">
        <table>
            <tr>
                <td><label for="nmweb">Nama Web:</label></td>
                <td><input type="text" name="nmweb" id="nmweb" value="<?= $data['nmweb']; ?>" required></td>
            </tr>
            <tr>
                <td><label for="slogan">Slogan:</label></td>
                <td><input type="text" name="slogan" id="slogan" value="<?= $data['slogan']; ?>" required></td>
            </tr>
            <tr>
                <td><label for="alamat">Alamat:</label></td>
                <td><input type="text" name="alamat" id="alamat" value="<?= $data['alamat']; ?>" required></td>
            </tr>
            <tr>
                <td><label for="twitter">Twitter:</label></td>
                <td><input type="text" name="twitter" id="twitter" value="<?= $data['twitter']; ?>"></td>
            </tr>
            <tr>
                <td><label for="fb">FB:</label></td>
                <td><input type="text" name="fb" id="fb" value="<?= $data['fb']; ?>"></td>
            </tr>
            <tr>
                <td><label for="instagram">Instagram:</label></td>
                <td><input type="text" name="instagram" id="instagram" value="<?= $data['instagram']; ?>"></td>
            </tr>
            <tr>
                <td><label for="logo">Logo:</label></td>
                <td><input type="file" name="logo" id="logo"></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                <input type="hidden" name="frmId" value="frmUbah">
                <button type="submit" class="btn-submit">Ubah</button>
                 </td>
            </tr>
        </table>
    </form>

    
</article>

<aside>
    <h2><b>Informasi</b></h2>
    <?php
        $query = $dbCrud->query("SELECT * FROM aside");
        while ($aside = $query->fetch_object()) {
    ?>
    <ul>
        <li><?= htmlspecialchars($aside->pengumuman); ?></li>
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

</body>
</html>

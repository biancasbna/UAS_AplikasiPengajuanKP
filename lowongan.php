<?php
include "./koneksi.php";
$result = $dbCrud->query("SELECT * FROM header_footer LIMIT 1");
$data = $result->fetch_assoc();
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
            if ($nav->listnav == 'Form') {
                echo '<li><a href="user.php">' . $nav->listnav . '</a></li>';
            } else {
                echo '<li>' . $nav->listnav . '</li>';
            }
        }
        ?>
    </ul>
    </nav>
    
    <article>
        <?php $query = $dbCrud->query("select * from lowongan"); ?>

        <h2><b>Daftar Lowongan</b></h2>
        <table class="tblLowongan">
        <thead>
            <tr>
                <th>NO</th>
                <th>Nama Perusahaan</th>
                <th>Alamat Perusahaan</th>
                <th>Lowongan</th>
            </tr>
        </thead>
        <tbody>
                <?php
                    $no = 1;
                    while($lowongan=$query->fetch_object()){
                ?>
                <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $lowongan->nmperusahaan; ?></td>
                <td><?php echo $lowongan->alamatperusahaan; ?></td>
                <td><?php echo $lowongan->lowongantersedia; ?></td>
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

</body>
</html>

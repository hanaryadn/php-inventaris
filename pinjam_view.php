<!DOCTYPE html>
<?php
    include 'config.php';
?>

<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Data Peminjaman Inventaris</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css" />
    <script src="main.js"></script>
</head>
<body class="bg">
    <?php
        include 'template/head.php';
    ?>
    <?php
    
    if($_SESSION['status']!="login"){
    header("location:index.php?pesan=belum_login"); 
    }
    ?>

<div class="container">
	<div class="container-fluid main-container">
		<div class="col-md-12 content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <b><a href="admin" class="btn btn-md btn-info">
                    <span class="glyphicon glyphicon-home"></span> Kembali ke Beranda</a> </b>
                </div>
<div class="panel-body">    
<div class="row">

    <div class="col-sm-10 col-sm-offset-1 page-header">
        <h1>Data Peminjaman Barang
        <form class="navbar-form pull-right" action="pinjam_view.php" method="get">
            <div class="form-group">
            <input type="text" class="form-control" name="cari" placeholder="Cari Nama Barang">
            <button type="submit" value="cari" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Cari</button>
            </div>
        </form>
        </h1>
        
    </div>
    
    

    <div class="col-sm-12">
        <?php
            if(isset($_GET['cari'])){
                $cari = $_GET['cari'];
            echo "<b>Hasil Pencarian untuk <u>".$cari."</u></b> <a href='pinjam_view.php' class='btn btn-xs btn-danger'>Hapus</a>
            <hr>
            ";
            }
        ?>

        <?php
            if(isset($_GET['pesan'])){
                if($_GET['pesan'] == "dipinjam"){
                    echo "  <div class='alert alert-success'>
                                Aset berhasil di Pinjam !!!
                            </div>";
                    }
                }
        ?>

        <a href="pinjam.php" class="btn btn-sm btn-success">
        <span class="glyphicon glyphicon-plus"></span> Pinjam Barang</a> 
        <p>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>No. Inventaris</th>
                    <th>Nama</th>
                    <th>Jenis</th>
                    <th>Jumlah</th>
                    <th>Peminjam</th>
                    <th>NIK</th>
                    <th>Alamat</th>
                    <th>Tgl. Pinjam</th>
                    <th>Tujuan Pinjam</th>
                    <th width='150px'>Aksi</th>
                </tr>
            </thead>
        <?php
            $halaman = 10;
            $page = isset($_GET["halaman"]) ? (int)$_GET["halaman"] : 1;
            $mulai = ($page>1) ? ($page * $halaman) - $halaman : 0;
            $result = mysqli_query($koneksi, "SELECT * FROM tbl_inventaris where status='DIPINJAM'");
            $total = mysqli_num_rows($result);
            $pages = ceil($total/$halaman);
            $no = $mulai+1;
        
            if(isset($_GET['cari'])){
                $cari = $_GET['cari'];
                $data = mysqli_query($koneksi, "select * from tbl_inventaris where nama like '%".$cari."%' AND status='DIPINJAM'");
            }else{
                $data = mysqli_query($koneksi, "select * from tbl_inventaris where status='DIPINJAM' ORDER BY id DESC LIMIT $mulai, $halaman");
            }
                $no = 1;
            while($d = mysqli_fetch_assoc($data)){
        ?>
            <tbody>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $d['nomer']; ?></td>
                    <td><?php echo $d['nama']; ?> (<?php echo $d['merk']; ?>)</td>
                    <td><?php echo $d['jenis']; ?></td>
                    <td><?php echo $d['jumlah']; ?></td>
                    <td><?php echo $d['peminjam']; ?></td>
                    <td><?php echo $d['nik']; ?></td>
                    <td><?php echo $d['alamat']; ?></td>
                    <td><?php echo $d['tgl_pinjam']; ?></td>
                    <td><?php echo $d['tujuan']; ?></td>
                    <td><a href="kembali.php?id=<?php echo $d['id']; ?>" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-export"></span> Kembalikan</a> 
                    </td>
                </tr>
        <?php } ?>
            </tbody>
        </table>
    
    <div align="right">
        <ul class="pagination">
            <li><span class="btn btn-primary">Halaman</span></li>
            <li><?php    
                for ($i=1; $i<=$pages; $i++){ ?>
                    <a href="?halaman=<?php echo $i; ?>"><?php echo $i; ?></a>
                <?php } ?>
            </li>
        </ul>
    </div>
    </div>
</div>
    </div>
            </div>
        </div>
    </div>
</div>
<?php
        include 'template/foot.php';
    ?>
</body>
</html>
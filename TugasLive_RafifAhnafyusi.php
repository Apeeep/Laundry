<?php error_reporting (E_ALL ^ E_NOTICE);?>
<?php
    $cabang = array("Jakarta","Bogor","Depok","Tangerang","Bekasi");
    array_multisort($cabang, SORT_ASC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <style>
        img {
            width: 200px;
            align-self: center;
        }
    </style>
</head>
<body>
    <div class="container-fluid d-flex flex-column gap-3">
        <div class="d-flex flex-column justify-content-center align-center w-100 gap-3">
            <h1 class="text-center">FORM PEMESANAN LAUNDRY</h1>
            <img src="./Images/laundry-machine.png" alt="Laundry" class="img-thumbnail">
            <form action="#" method="POST" class="w-50 d-flex flex-column gap-2 align-self-center">
                <table>
                    <tr>
                        <td><label>Cabang</label></td>
                        <td>
                            <select name="cabang" class="form-select">
                                <option>-- Pilihan Cabang --</option>
                                <?php  
                                    foreach ( $cabang as $c ) {
                                        echo "<option value='". $c ."'>" . $c . "</option>";
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Nama Pelanggan</label></td>
                        <td><input type="text" name="namaPelanggan" class="form-control" required></td>
                    </tr>
                    <tr>
                        <td><label>Nomor HP</label></td>
                        <td><input type="text" name="nomorHp" class="form-control" required></td>
                    </tr>
                    <tr>
                        <td><label>Jumlah ( KG )</label></td>
                        <td><input type="number" name="jumlah" class="form-control" required></td>
                    </tr>
                </table>
                <button type="submit" name="btn-submit" class="w-100 btn btn-primary">Lakukan Pemesanan</button>
            </form>
        </div>
        <div class="container-fluid">
            <div class="row gap-2 d-flex justify-content-center">
                <?php if ( isset($_POST['btn-submit'])) {
                    $cb = $_POST["cabang"];
                    $np = $_POST["namaPelanggan"];
                    $nh = $_POST["nomorHp"];
                    $jml = $_POST["jumlah"];
                    $total = 5000 * $jml;

                    if ( $total >= 100000) {
                        $diskon = 5 / 100 * $total;
                    }

                    $file = "laundry.json";
                    $Laundry = file_get_contents($file);
                    $data = json_decode($Laundry, true);

                    $data[] = array (
                        'cabang' => $cb,
                        'namaPelanggan' => $np,
                        'nomorHp' => $nh,
                        'jumlah' => $jml,
                        'total' => $total,
                        'diskon' => $diskon
                    );
                    krsort($data);

                    $content = json_encode($data, JSON_PRETTY_PRINT);
                    file_put_contents($file, $content);
                ?>
                <?php foreach( $data as $key => $d ) { ?>
                    <div class="col-2 card p-2">
                        <table>
                            <tr>
                                <td>Cabang</td>
                                <td><?php echo $d['cabang'] ?></td>
                            </tr>
                            <tr>
                                <td>Nama Pelanggan</td>
                                <td><?php echo $d['namaPelanggan'] ?></td>
                            </tr>
                            <tr>
                                <td>Nomor HP</td>
                                <td><?php echo $d['nomorHp'] ?></td>
                            </tr>
                            <tr>
                                <td>Jumlah Pesanan Baju</td>
                                <td><?php echo $d['jumlah'] . " Kg" ?></td>
                            </tr>
                            <tr>
                                <td>Tagihan Awal</td>
                                <td><?php echo $d['total'] ?></td>
                            </tr>
                            <tr>
                                <td>Diskon</td>
                                <td><?php echo $d['diskon'] ?></td>
                            </tr>
                            <tr>
                                <td>Tagihan Akhir</td>
                                <td><?php echo $d['total'] - $d['diskon'] ?></td>
                            </tr>
                        </table>
                    </div>
                <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
</body>
</html>
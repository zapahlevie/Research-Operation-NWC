<html>
<head><title>Model Transportasi</title></head>
<body>
    <?php
    if (!empty($_POST)) {

        $qs = $_POST['qs']; //quantity supply
        $qd = $_POST['qd']; //quantity demand
        if ($qs > 10 || $qd > 10) {
            echo"Input Supply dan Demand Maksimal 10!<br/>";
            echo"<a href='index.php'>Kembali</a>";
        } else {
            ?>
            <form action="proses.php" method="post">
                <table border='1' align="center">
                    <tr>
                        <td>Supply/Demand</td>
                        <?php
                        for ($w = 1; $w <= $qd; $w++) {
                            echo"<td>Demand $w</td>";
                        }
                        ?>
                        <td>Q Supply</td>
                    </tr>
                    <?php
                    for ($i = 1; $i <= $qs; $i++) {
                        echo "<tr><td> Supply $i</td>";

                        for ($j = 1; $j <= $qd; $j++) {
                            ?>
                            <td><input type="text" name="c[<?php echo $i ?>][<?php echo $j ?>]" value=""></td>
                            <?php if ($j == $qd) {
                                echo"<td><input type'text' name='s[$i]'></td>";
                            } ?>
                            <?php
                        } echo "</tr>";
                    } ?>	
                    <tr>
                        <td>Q Demand</td>
                        <?php
                        for ($d = 1; $d <= $qd; $d++) {
                            echo"<td><input type'text' name='d[$d]'></td>";
                        }
                        ?>
                    </tr>
                </table>
                <input type="hidden" name="qs" value="<?php echo $qs ?>">		
                <input type="hidden" name="qd" value="<?php echo $qd ?>">	
                <div align="center">	
                    <input type="submit" value="Submit" >
                </div>
            </form>
            <?php
        }
    } else {
        header("location:index.php");
    }
    ?>
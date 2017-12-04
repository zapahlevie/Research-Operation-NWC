<?php

if (!empty($_POST)) {
    $total = 0;
    $count = 0;
    $totals = 0;
    $totald = 0;
    $totalsemua = 0;
    $selisih = 0;
    $dummys = 0;
    $dummyr = 0;
    $sisas = $_POST['s']; //supply
    $sisad = $_POST['d']; //demand
    $s = $_POST['s']; //supply
    $d = $_POST['d']; //demand
    $qs = $_POST['qs']; //qsupply
    $qd = $_POST['qd']; //qdemand
    $c = $_POST['c']; //cost
    $x = array();
    $i = 1;
    $j = 1;


//menghitung total destination
    for ($l = 1; $l <= $qd; $l++) {
        $totald = $totald + $d[$l];
    }

//menghitung total origin
    for ($l = 1; $l <= $qs; $l++) {
        $totals = $totals + $s[$l];
    }
//pengecekan jika terjadi dummy
    if ($totals > $totald) {
        $totalsemua = $totals;
        $selisih = $totals - $totald;
        $qd = $qd + 1;
        $d[$qd] = $selisih;
        $sisad[$qd] = $selisih;
        //status dummy
        $dummyr = 1;
        for ($f = 1; $f <= $qs; $f++) {
            //set value dummy
            $c[$f][$qd] = 0;
        }
    } else if ($totals < $totald) {
        $totalsemua = $totald;
        $selisih = $totald - $totals;
        $qs = $qs + 1;
        $s[$qs] = $selisih;
        $sisas[$qs] = $selisih;
        //status dummy
        $dummys = 1;
        for ($f = 1; $f <= $qd; $f++) {
            //set value dummy
            $c[$qs][$f] = 0;
        }
    } else {
        $totalsemua = $totald;
    }
//melakukan iterasi untuk menentukan cost
    do {
        if(!(isset($sisas[$i])))
            $sisas[$i] = 0;
        if(!(isset($sisad[$i])))
            $sisad[$i] = 0;
        if ($sisas[$i] < $sisad[$j]) {
            $x[$i][$j] = $sisas[$i];
            $sisad[$j] = $sisad[$j] - $sisas[$i];
            $sisas[$i] = 0;
            $i++;
            $count++;
        } else if ($sisas[$i] > $sisad[$j]) {
            $x[$i][$j] = $sisad[$j];
            $sisas[$i] = $sisas[$i] - $sisad[$j];
            $sisad[$j] = 0;
            $j++;
            $count++;
        } else {
            $x[$i][$j] = $sisas[$i];
            $sisas[$i] = 0;
            $sisad[$j] = 0;
            $i++;
            $j++;
            $count++;
        }
    } while ($count <= $qs + $qd - 1);
    echo "<table border='1' align='center'>";
    echo"<tr>
<td>Supply/Demand</td>";
    for ($w = 1; $w <= $qd; $w++) {
        if ($w == $qd && $dummyr == 1) {
            echo"<td>dummy</td>";
        } else {
            echo"<td>Demand $w</td>";
        }
    }
    echo"<td>Q Supply</td>";
    echo"</tr>";
    for ($i = 1; $i <= $qs; $i++) {
        echo"<tr>";
        if ($i == $qs && $dummys == 1) {
            echo"<td>dummy</td>";
        } else {
            echo"<td>Supply $i</td>";
        }
        for ($j = 1; $j <= $qd; $j++) {

            if (isset($x[$i][$j])) {
                echo"<td><table ><tr ><td  rowspan='2' width='50'>" . $x[$i][$j] . '</td><td style="border-left:1px solid;border-bottom:1px solid;" >' . $c[$i][$j] . "</td></tr><tr><td>&nbsp;</td></tr></table></td>";
            } else {
                echo"<td><table ><tr ><td  rowspan='2' width='50'>0</td><td style='border-left:1px solid;border-bottom:1px solid;width:auto;'>" . $c[$i][$j] . "</td></tr><tr><td>&nbsp;</td></tr></table></td>";
            }
            if ($j == $qd) {
                echo"<td>" . $s[$i] . "</td>";
            }
        }

        echo"</tr>";
    }
    echo"<tr>
<td>Q Demand</td>";
    for ($l = 1; $l <= $qd; $l++) {
        echo"<td>" . $d[$l] . "</td>";
    }
    echo"<td>$totalsemua</td>";
    echo"</tr>";
    echo "</table>";
    echo"<div align='center'>";
    for ($i = 1; $i <= $qs; $i++) {
        for ($j = 1; $j <= $qd; $j++) {
            if (isset($x[$i][$j]) && isset($c[$i][$j])) {
                echo"Supply $i x Demand $j =&nbsp;" . $c[$i][$j] . "&nbsp;x&nbsp;" . $x[$i][$j] . "&nbsp;=&nbsp;" . $c[$i][$j] * $x[$i][$j] . "&nbsp;";
                echo "<br />";
            }
        }
    }
//menghitung optimal cost

    for ($i = 1; $i <= $qs; $i++) {
        for ($j = 1; $j <= $qd; $j++)
            if(isset($x[$i][$j]))
                $total = $total + ($c[$i][$j] * $x[$i][$j]);
    }
    echo "Total Cost :&nbsp;Rp" . number_format($total);

    echo"<br /><a href='index.php'>Ulangi</a>";
    echo"</div>";
} else {
    header("location:index.php");
}
?>
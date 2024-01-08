<?php
$search="";
$testua="";
if (isset($_GET['keyword']) && $_GET['keyword'] != '') {
    $testua = htmlspecialchars($_GET['keyword'], ENT_QUOTES, 'UTF-8');
}
// $search = "%" . $testua . "%";
$search = "%$testua%";



$stmt = $conx->prepare("SELECT * FROM produktuak WHERE izena LIKE ? OR deskripzioa LIKE ?");
$stmt->bind_param("ss", $search, $search);
$stmt->execute();
$result = $stmt->get_result();
$produktuak = array();
while ($row = $result->fetch_assoc()) {
    $produktuak[] = $row;
}
$stmt->close();

if(sizeof($produktuak) == 0){
    echo "<fieldset style=width:500;>";
    echo "<legend><b>Ez dago produkturik katalogoan ".$testua." deitzen denik</b></legend>";
    if(isset($_SESSION['admin'])){
      echo "<div align=center><h3><b><a href=".$_SERVER['PHP_SELF']."?action=updel>Eguneratu</a> katalogoa.</b></h3></div>";
    }
    else{
      echo "<div align=center>
                <h3>Enpresaren hasierako orria</h3></div>";
    }
    echo "</fieldset>";
}
else{
?>
    <table width=1000 cellpadding=10 cellspacing=10 align=center>
    <?php
    foreach($produktuak as $data){
        ?>

        <tr>
            <td align=center valign=top width=40%>
                <fieldset>
                <br>
                <a href=<?php echo "images/".$data["pic"]; ?>><img src=images/<?php echo $data["pic"]; ?> border=1></a><br>
                <br>
                </fieldset>
            </td>
            <td valign=top width=60%>
                <fieldset>
                    <legend><b>Izena</b></legend>
                    <br>
                    <?php echo htmlspecialchars($data['izena'], ENT_QUOTES, 'UTF-8');
; echo " - ".htmlspecialchars($data['salneurria'], ENT_QUOTES, 'UTF-8'). "€";?>
                    <br>
                </fieldset>
                <fieldset>
                    <legend><b>Deskripzioa</b></legend>
                    <br>
                    <?php echo htmlspecialchars($data['deskripzioa'], ENT_QUOTES, 'UTF-8'); ?>
                    <br>
                </fieldset>
                <br>
                <?php
                if(isset($_SESSION['admin']) && ($_SESSION['admin']==1))
                    {
                        if($_SESSION['username'] == 'admin@bdweb'){
                            ?>
                            <table width=100% cellpadding=2 cellspacing=2 align=center>
                            <tr><td width=50% align=left>
                            <a href=<?php echo $_SERVER['PHP_SELF']."?action=description&pic_id=".$data['id']; ?>><b>Deskripzioa/Salneurria aldatu</b></a>
                            </td>
                            </tr>
                            </table>
                            <?php
                        }
                        else {
                            echo "<a href='><img src='images/pngegg.png'></a>";
                        }
                    }
                ?>
            </td>
        </tr>
    <?php

    }

}

?>

</table>
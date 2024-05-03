<?php
if(!isset($_SESSION['id_tip_user']) && !isset($_SESSION['username'])){
echo '
<script>
    alert("Inicie Sesion para una mejor experiencia");
    window.location = "../index.php";
</script>
';
}
?>

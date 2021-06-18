<?php
session_start();
if(empty($_SESSION['active'])) {
  header("Location: ../");
}
require_once 'includes/session.php';
require_once 'includes/header.php';
?>

<main class="app-content">
    <div class="row">
        <div class="col-md-12">
            <img src="../images/bg.png" alt="imagem escola">
        </div>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>


<style>
.app-content img{
    
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, 15%);

}
</style>
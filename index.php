<?php
require "inc/header.php";
require "inc/nav.php";

$tags = $db->query("SELECT * FROM tags")->fetchAll();

?>
<section id="homePage">
    <div class="container">
        <div class="col-lg-12">
            <h1 style="margin-top: 100px;">Page d'accueil</h1>
        </div>
    </div>
</section>


<?php
require "inc/footer.php";
?>

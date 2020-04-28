<?php
require "inc/header.php";
require "inc/nav.php";
?>

<section id="homePage">
    <div class="container">
        <div class="col-lg-12">
            <h1 class="title-page center-text">Historique</h1>
        </div>
    </div>
</section>


<div class="form-group container">

    <div class="accordion md-accordion accordion-blocks" role="tablist" aria-multiselectable="true"
        id="accordionExample">
        <div class="card">
            <div class="card-header" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne"
                        aria-expanded="true" aria-controls="collapseOne">
                        Publications likées
                    </button>
                </h5>
            </div>

            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                    <div>
                        <table class="table">
                            <tr>
                                <td>a</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingTwo">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                        data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Publications commentées
                    </button>
                </h5>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                <div class="card-body">
                    <div>
                        <table class="table">
                            <tr>
                                <td>a</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
include "modals.php";
require "inc/footer.php";
?>
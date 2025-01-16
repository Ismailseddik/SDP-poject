<?php
class PaypalAdaptee {

    public function specifications() {
        header('Location: index.php?view=donor&action=listDonors');
    }
}

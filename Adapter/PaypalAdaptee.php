<?php
class PaypalAdaptee {

    // Method declaration without 'void' keyword
    public function specifications() {
        header('Location: index.php?view=donor&action=listDonors');
    }
}

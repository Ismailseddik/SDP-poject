<?php
ob_start();
include_once($_SERVER["DOCUMENT_ROOT"] . "\db-conn-setup.php");

include_once($_SERVER["DOCUMENT_ROOT"] . "\Iterator\Iterators.php");

ob_end_clean();

class DonationTypeModel extends Iterators
{
    private ?int $id;
    private ?String $donation_type;

    public function __construct(array $data)
    {
        // value(data) = array[key(column)]
        $this->id = $data['id'];
        $this->donation_type = $data['donation_type'];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public static function get_donation_type($donation_type_id): bool|DonationTypeModel
    {
        $rows = run_select_query("SELECT * FROM `donation_type` WHERE id = '$donation_type_id'");
        if ($rows->num_rows > 0) {
            return new self($rows->fetch_assoc());
        } else {
            return false;
        }
    }

    public static function get_all_donation_types(): array
    {
        $donationtypes = [];
        $rows = run_select_query("SELECT * FROM `donation_type`");

        if ($rows && $rows->num_rows > 0) {
            $itr = self::getDBIterator();
            $itr->SetIterable($rows);
            while($itr->HasNext())
            {
                $donationtypes[] = new DonationTypeModel($itr->Next());
            }
        }
        return $donationtypes;
    }
    public static function add_donation_type($donation_type): bool
    {
        $query = "INSERT INTO `donation_type` (donation_type)
              VALUES ('$donation_type')";

        return run_query($query, true);
    }

    public static function update($array): bool
    {   $donation_type_id = $array['donation_type_id'];
        $donation_type = $array['donation_type'];
        $query = "UPDATE `donation_type` SET donation_type = '$donation_type' WHERE id = '$donation_type_id' ";

        return run_query($query, true);
    }
    public static function delete($donation_type_id): bool
    {
        $query = "DELETE FROM `donation_type` WHERE id = '$donation_type_id'";
        return run_query($query, true);
    }
}
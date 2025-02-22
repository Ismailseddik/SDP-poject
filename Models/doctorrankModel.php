<?php
ob_start();
include_once($_SERVER["DOCUMENT_ROOT"] . "\db-conn-setup.php");

include_once($_SERVER["DOCUMENT_ROOT"] . "\Iterator\Iterators.php");

ob_end_clean();

class DoctorRank extends Iterators
{

    private ?int $id;
    private ?String $rank;

    public function __construct(array $data)
    {

        // value(data) = array[key(column)]
        $this->id = $data['id'];
        $this->rank = $data['rank'];
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getRank()
    {
        return $this->rank;
    }

    public static function getAllRanks(): array {
        $rows = run_select_query("SELECT id, rank FROM doctor_rank");
        $ranks = [];
    
        if ($rows && $rows->num_rows > 0) {

            $itr = self::getDBIterator();
            $itr->SetIterable($rows);

            while($itr->HasNext())
            {
                $rank = $itr->Next();
                $ranks[$rank['id']] = $rank['rank'];

            }
            // while ($row = $rows->fetch_assoc()) {
            //     $ranks[$row['id']] = $row['rank'];
            // }
        }
    
        return $ranks;
    }
    public static function get_doctor_rank($rankid): bool|DoctorRank
    {
        $rows = run_select_query("SELECT * FROM `doctor_rank` WHERE id = '$rankid'");
        if ($rows->num_rows > 0) {
            return new self($rows->fetch_assoc());
        } else {
            return false;
        }
    }
    public static function add_doctor_rank($rank): bool
    {
        $query = "INSERT INTO `doctor_rank` (rank)
              VALUES ('$rank')";

        return run_query($query, true);
    }

    public static function update($array): bool
    {   $rankid = $array['rank_id'];
        $rank = $array['rank'];
        $query = "UPDATE `doctor_rank` SET rank = '$rank' WHERE id = '$rankid' ";

        return run_query($query, true);
    }
    public static function delete($rankid): bool
    {

        $query = "DELETE FROM `doctor_rank` WHERE id = '$rankid'";
        return run_query($query, true);
    }

}

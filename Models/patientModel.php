<?php
// Patient.php
include_once($_SERVER["DOCUMENT_ROOT"] . "/db-conn-setup.php");

class Patient
{
    private ?int $id;
    private ?int $person_id;
    private ?string $name;
    private ?int $age;

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->person_id = $data['person_id'] ?? null;
        $this->name = $data['first_name'] . ' ' . $data['last_name'];
        $this->age = $data['age'] ?? 0;
    }

    // Getters
    public function getName() { return $this->name; }
    public function getAge() { return $this->age; }

    // Fetch all patients with associated personal details
    public static function getAllPatients(): array
    {
        $query = "
            SELECT 
                patient.id, 
                patient.person_id, 
                person.first_name, 
                person.last_name, 
                TIMESTAMPDIFF(YEAR, person.birth_date, CURDATE()) AS age
            FROM patient
            JOIN person ON patient.person_id = person.id
        ";
        
        $patients = [];
        $rows = run_select_query($query);

        if ($rows && $rows->num_rows > 0) {
            foreach ($rows->fetch_all(MYSQLI_ASSOC) as $row) {
                $patients[] = new Patient($row);
            }
        }

        return $patients;
    }

    // Add a new patient with personal details
    public static function addPatient(string $first_name, string $last_name, int $age): bool
    {
        global $conn;

        // Calculate birth_date based on the age provided
        $birth_date = date('Y-m-d', strtotime("-$age years"));

        // Insert into person table first
        $query_person = "INSERT INTO person (first_name, last_name, birth_date, address_id) VALUES ('$first_name', '$last_name', '$birth_date', 1)";
        if (!run_query($query_person, true)) {
            echo "Error: Failed to add person record.";
            return false;
        }
        
        // Get the new person_id
        $person_id = $conn->insert_id;

        // Insert into patient table with the new person_id
        $query_patient = "INSERT INTO patient (person_id) VALUES ($person_id)";
        if (!run_query($query_patient, true)) {
            echo "Error: Failed to add patient record.";
            return false;
        }

        return true;
    }
}
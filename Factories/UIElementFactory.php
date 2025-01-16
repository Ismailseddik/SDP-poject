<?php

class UIElementFactory
 {
    // Method to create a card element (e.g., doctor or donation card)
    public static function createCard(string $type, array $data): string {
        $class = $type . '-card';
        $title = htmlspecialchars($data['title'] ?? 'Title');
        $content = $data['content'] ?? 'No content provided'; // Ensure content is raw HTML
        $link = htmlspecialchars($data['link'] ?? '#');

        return "
            <div class='{$class}'>
                <h3>{$title}</h3>
                {$content}
                <a href='{$link}' class='button'>View Details</a>
            </div>
        ";
    }
    // Method to create an application card
    public static function createApplicationCard(array $data): string {
        $patientName = htmlspecialchars($data['patient_name'] ?? 'Unknown');
        $doctorName = htmlspecialchars($data['doctor_name'] ?? 'Unknown');
        $status = htmlspecialchars($data['status'] ?? 'Pending');
        $buttonLink = htmlspecialchars($data['button_link'] ?? '#');
        $buttonText = htmlspecialchars($data['button_text'] ?? 'Action');

        return "
            <div class='application-card'>
                <p><strong>Patient:</strong> {$patientName}</p>
                <p><strong>Doctor:</strong> {$doctorName}</p>
                <p><strong>Status:</strong> {$status}</p>
                <a href='{$buttonLink}' class='button'>{$buttonText}</a>
            </div>
        ";
    }

   // Create a card for patient information (aligned with internal styling)
   public static function createPatientCard(array $data): string {
    $name = htmlspecialchars($data['name'] ?? 'Unknown');
    $age = htmlspecialchars($data['age'] ?? 'N/A');

        return "
            <div class='patient-card'>
                <p><strong>Name:</strong> {$name}</p>
                <p><strong>Age:</strong> {$age}</p>
            </div>
        ";
    }
    // Method to create a styled button
    public static function createButton(array $data): string {
        $label = htmlspecialchars($data['label'] ?? 'Click Me');
        $link = htmlspecialchars($data['link'] ?? '#');
        $class = htmlspecialchars($data['class'] ?? 'add-donor-button'); // Default class for the button

        return "<a href='{$link}' class='{$class}'>{$label}</a>";
    }

    public static function createFormField(array $data): string {
        $label = htmlspecialchars($data['label'] ?? 'Label');
        $name = htmlspecialchars($data['name'] ?? 'input');
        $type = htmlspecialchars($data['type'] ?? 'text');
        $placeholder = htmlspecialchars($data['placeholder'] ?? '');
        $value = htmlspecialchars($data['value'] ?? '');
    
        return "
            <div class='form-group'>
                <label for='{$name}'>{$label}</label>
                <input type='{$type}' name='{$name}' id='{$name}' placeholder='{$placeholder}' value='{$value}' class='form-control'>
            </div>
        ";
    }
    
    public static function createList(array $data): string {
        $items = $data['items'] ?? [];
        $listItems = array_map(fn($item) => "<li>" . htmlspecialchars($item) . "</li>", $items);
        return "<ul>" . implode('', $listItems) . "</ul>";
    }
    // Create a submit button for forms
    public static function createSubmitButton(string $label): string {
        $escapedLabel = htmlspecialchars($label);
        return "<button type='submit' class='button'>{$escapedLabel}</button>";
      }    

            // Method to create a donor card
    public static function createDonorCard(array $data): string {
        $name = htmlspecialchars($data['name'] ?? 'Unknown');
        $amount = htmlspecialchars(number_format($data['amount'] ?? 0, 2));

        return "
            <div class='donor-card'>
                <p><strong>Name:</strong> {$name}</p>
                <p><strong>Donation Amount:</strong> \${$amount}</p>
            </div>
        ";
    }
    public static function createLogList(array $logs): string {
        if (empty($logs)) {
            return '';
        }

        $logItems = array_map(fn($log) => "<li>" . htmlspecialchars($log) . "</li>", $logs);
        return "
            <div class='logs'>
                <ul>" . implode('', $logItems) . "</ul>
            </div>
        ";
    }
    // Method to create a donation card
    public static function createDonationCard(array $data): string {
        $donationId = htmlspecialchars($data['donationId'] ?? 'N/A');
        $donorName = htmlspecialchars($data['donorName'] ?? 'Unknown Donor');
        $amount = $data['amount'] !== null ? "$" . htmlspecialchars(number_format($data['amount'], 2)) : null;
        $organ = htmlspecialchars($data['organ'] ?? '');
        $details = $amount ?? ($organ ? "Organ: $organ" : 'Unknown');
        $date = htmlspecialchars($data['date'] ?? 'N/A');

        return "
            <div class='donation-card'>
                <p><strong>Donation ID:</strong> {$donationId}</p>
                <p><strong>Donor Name:</strong> {$donorName}</p>
                <p><strong>Donation Details:</strong> {$details}</p>
                <p><strong>Donation Date:</strong> {$date}</p>
            </div>
        ";
    }
        // Method to create an "Add New Application" button
        public static function createAddButton(string $link, string $label): string {
            $escapedLink = htmlspecialchars($link);
            $escapedLabel = htmlspecialchars($label);
            return "
                <div class='add-button'>
                    <a href='{$escapedLink}' class='button'>{$escapedLabel}</a>
                </div>
            ";
        }
    
}

<?php

class UIElementFactory {
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

    // Method to create a styled button
    public static function createButton(array $data): string {
        $label = htmlspecialchars($data['label'] ?? 'Click Me');
        $link = htmlspecialchars($data['link'] ?? '#');
        $class = htmlspecialchars($data['class'] ?? 'button'); // Default button class

        return "<a href='{$link}' class='{$class}'>{$label}</a>";
    }

    // Method to create a styled form field
    public static function createFormField(array $data): string {
        $label = htmlspecialchars($data['label'] ?? 'Label');
        $name = htmlspecialchars($data['name'] ?? 'input');
        $type = htmlspecialchars($data['type'] ?? 'text');
        $placeholder = htmlspecialchars($data['placeholder'] ?? '');
        $value = htmlspecialchars($data['value'] ?? '');

        return "
            <label for='{$name}'>{$label}</label>
            <input type='{$type}' name='{$name}' id='{$name}' placeholder='{$placeholder}' value='{$value}'>
        ";
    }
    public static function createList(array $data): string {
        $items = $data['items'] ?? [];
        $listItems = array_map(fn($item) => "<li>" . htmlspecialchars($item) . "</li>", $items);
        return "<ul>" . implode('', $listItems) . "</ul>";
    }
    
}

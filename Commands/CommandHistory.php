<?php
class CommandHistory {
    private array $commands = [];

    public function push(Command $command) {
        $this->commands[] = $command;
    }

    public function pop(): ?Command {
        return array_pop($this->commands);
    }

    public function isEmpty(): bool {
        return empty($this->commands);
    }
}


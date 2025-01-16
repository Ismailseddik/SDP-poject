<?php
require_once '../interfaces/ICommand.php';
class AddAidTypeCommand implements Command {
    private AidTypeDecorator $decorator;
    private int $aidTypeId;
    private int $applicationId;
    //private $controller;
    public function __construct(AidTypeDecorator $decorator, int $aidTypeId,int $applicationId) {
        $this->decorator = $decorator;
        $this->aidTypeId = $aidTypeId;
        $this->applicationId = $applicationId;
        //$this->controller = $controller;
    }

    public function execute() {
        //$this->controller->logMessage("Executing AddAidTypeCommand for AidTypeId: " . $this->aidTypeId);
        $this->decorator->WrapAidType();
        //$this->controller->logMessage("Successfully added aid type: " . $this->aidTypeId);
    }

    public function undo() {
        try {
            pmaAidTypeModel::remove_entry($this->applicationId, $this->aidTypeId);
        } catch (Exception $e) {
            echo "Error: Unable to undo aid type addition. " . $e->getMessage();
        }
    }
}


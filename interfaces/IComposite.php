<?php
interface IComposite {
    public function AddChild(object $child);
    public function getChildren();
    public function IterateChildren();
}

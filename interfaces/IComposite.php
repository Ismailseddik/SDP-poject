<?php
interface IComposite {
    public function AddChild(object $child);
    public function getChildren();
}

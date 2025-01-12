<?php

interface Update{
    public static function Update($array);
    public static function ConditionedUpdate($id, $column_name, $new_attribute_value);
}
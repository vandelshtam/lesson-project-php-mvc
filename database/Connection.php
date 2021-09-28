<?php
class Connection 
{
    public static function make($config)
{
    return new PDO("{$config['connection']}; dbname={$config['database']}; charset={$config['charset']}", $config['username'], $config['password']);
}
}

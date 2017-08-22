<?php
/**
 * Created by PhpStorm.
 * User: olgakolos
 * Date: 02.07.17
 * Time: 0:48
 */

namespace Core;


class Roles
{
    const ADMIN = "admin";
    const MANAGER = 'RD-manager';
    const TRAINER = 'trainer';
    const LISTENER = 'listener';
    const GUEST= 'guest';

    public function roles() {
        $admin = self::ADMIN;
        $manager = self::MANAGER;
        $trainer = self::TRAINER;
        $listener = self::LISTENER;
        $guest = self::GUEST;

        $sql = "SELECT r_id FROM roles";
        $count = Database::select($sql);
        if(count($count) == 0) {
            Database::insert("roles", ['r_id' => 1, 'r_name' => $admin]);
            Database::insert("roles", ['r_id' => 2, 'r_name' => $manager]);
            Database::insert("roles", ['r_id' => 3, 'r_name' => $trainer]);
            Database::insert("roles", ['r_id' => 4, 'r_name' => $listener]);
            Database::insert("roles", ['r_id' => 5, 'r_name' => $guest]);
        }
    }

    public static function showRole($id) {
        $sql = "SELECT r_name FROM roles WHERE r_id= \"$id\"";
        $r_name = Database::select($sql);
        $r_name = $r_name[0]['r_name'];
        return $r_name;
    }

    public static function existingRoles($role) {
        $rolesArray = [self::ADMIN, self::MANAGER, self::TRAINER, self::LISTENER];
        $key = array_search($role, $rolesArray);
        unset($rolesArray[$key]);
        return $rolesArray;
    }
}
<?php 
namespace App\Enum;

enum UserRoleEnum {
    case ROLE_ADMIN;
    case ROLE_USER;

    public static function toArray(): array 
    {
        $column = array_column(self::cases(), 'name');
        $combineArray = array_combine($column, $column);

        return $combineArray;
    }
}
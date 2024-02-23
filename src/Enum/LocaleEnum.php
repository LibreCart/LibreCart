<?php
namespace App\Enum;

enum LocaleEnum {
    case ar_AR;
    case bn_BN;
    case cs_CZ;
    case de_DE;
    case en_ES;
    case en_GB;
    case en_US;
    case fr_FR;
    case hi_IN;
    case it_IT;
    case ja_JA;
    case ko_KR;
    case nl_NL;
    case pl_PL;
    case pt_PT;
    case ru_RU;
    case sv_SE;
    case tr_TR;
    case ur_UR;
    case vi_VN;
    case zh_CH;


    public static function toArray(): array 
    {
        $column = array_column(self::cases(), 'name');
        $combineArray = array_combine($column, $column);

        return $combineArray;
    }

    public static function getLocaleByString(string $locale): LocaleEnum 
    {
        $cases = self::cases();
        $index = array_search($locale, array_column($cases, 'name'));

        return  $cases[$index];
    }
}
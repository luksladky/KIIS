<?php
namespace App\Model;

use Nette\Utils\DateTime;

/**Contains custom Latte filters
 * Class Filters
 * @package App\Model
 */
class Filters
{

    /**Universal function to call any filter from this class, first parameter is filter name, second is value passed.
     * @param $filter
     * @param $value
     * @return mixed
     */
    public static function common($filter, $value)
    {
        if (method_exists(__CLASS__, $filter)) {
            $args = func_get_args();
            array_shift($args);
            return call_user_func_array([__CLASS__, $filter], $args);
        }
    }

    /**
     * Filter time ago in words.
     * @param  int
     * @return string
     */
    public static function timeAgoInWords($time)
    {
        if (!$time) {
            return FALSE;
        } elseif (is_numeric($time)) {
            $time = (int) $time;
        } elseif ($time instanceof DateTime) {
            $time = $time->format('U');
        } else {
            $time = strtotime($time);
        }

        $delta = time() - $time;

        if ($delta < 0) {
            $delta = round(abs($delta) / 60);
            if ($delta == 0) return 'za okamžik';
            if ($delta == 1) return 'za minutu';
            if ($delta < 45) return 'za ' . $delta . ' ' . self::plural($delta, 'minuta', 'minuty', 'minut');
            if ($delta < 90) return 'za hodinu';
            if ($delta < 1440) return 'za ' . round($delta / 60) . ' ' . self::plural(round($delta / 60), 'hodina', 'hodiny', 'hodin');
            if ($delta < 2880) return 'zítra';
            if ($delta < 43200) return 'za ' . round($delta / 1440) . ' ' . self::plural(round($delta / 1440), 'den', 'dny', 'dní');
            if ($delta < 86400) return 'za měsíc';
            if ($delta < 525960) return 'za ' . round($delta / 43200) . ' ' . self::plural(round($delta / 43200), 'měsíc', 'měsíce', 'měsíců');
            if ($delta < 1051920) return 'za rok';
            return 'za ' . round($delta / 525960) . ' ' . self::plural(round($delta / 525960), 'rok', 'roky', 'let');
        }

        $delta = round($delta / 60);
        if ($delta == 0) return 'před okamžikem';
        if ($delta == 1) return 'před minutou';
        if ($delta < 45) return "před $delta minutami";
        if ($delta < 90) return 'před hodinou';
        if ($delta < 1440) return 'před ' . round($delta / 60) . ' hodinami';
        if ($delta < 2880) return 'včera';
        if ($delta < 43200) return 'před ' . round($delta / 1440) . ' dny';
        if ($delta < 86400) return 'před měsícem';
        if ($delta < 525960) return 'před ' . round($delta / 43200) . ' měsíci';
        if ($delta < 1051920) return 'před rokem';
        return 'před ' . round($delta / 525960) . ' lety';
    }



    /**
     * Plural: three forms, special cases for 1 and 2, 3, 4.
     * (Slavic family: Slovak, Czech)
     * @param  int
     * @return mixed
     */
    private static function plural($n)
    {
        $args = func_get_args();
        return $args[($n == 1) ? 1 : (($n >= 2 && $n <= 4) ? 2 : 3)];
    }


}
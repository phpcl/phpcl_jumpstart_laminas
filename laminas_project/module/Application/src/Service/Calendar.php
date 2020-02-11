<?php
namespace Application\Service;

class Calendar
{
    const DEFAULT_CMD = 'ncal -yb ';
    const DEFAULT_LANG = 'en';

    protected $lang = 'en';
    protected $months;
    protected $days;
    protected $cmd;
    protected $cal = NULL;

    protected $config =  [
        'fr' => [
            'flags' => '-M',
            'months' => [
                'January' => 'janvier',
                'February' => 'février',
                'March' => 'mars',
                'April' => 'avril',
                'May' => 'mai',
                'June' => 'juin',
                'July' => 'juillet',
                'August' => 'aout',
                'September' => 'septembre',
                'October' => 'octobre',
                'November' => 'novembre',
                'December' => 'décembre'
            ],
            'days' => [
                'Su' => 'di',
                'Mo' => 'lu',
                'Tu' => 'ma',
                'We' => 'me',
                'Th' => 'je',
                'Fr' => 've',
                'Sa' => 'sa',
            ],
        ],
        'en' => [
            'flags' => '-S',
            'months' => [
                'January' => 'January',
                'February' => 'February',
                'March' => 'March',
                'April' => 'April',
                'May' => 'May',
                'June' => 'June',
                'July' => 'July',
                'August' => 'August',
                'September' => 'September',
                'October' => 'October',
                'November' => 'November',
                'December' => 'December'
            ],
            'days' => [
                'Su' => 'Su',
                'Mo' => 'Mo',
                'Tu' => 'Tu',
                'We' => 'We',
                'Th' => 'Th',
                'Fr' => 'Fr',
                'Sa' => 'Sa',
            ],
        ],
    ];

    /**
     * Produces a calendar from OS command
     *
     * @param string $lang == en|fr
     * @param int $year == year for which to generate calendar
     * @param string $cmd == OS command to use
     */
    public function getCalendar(string $lang = NULL, int $year = NULL, string $cmd = NULL)
    {
        $year = $year ?? date('Y');
        $lang = $lang ?? self::DEFAULT_LANG;
        $cmd  = $cmd  ?? self::DEFAULT_CMD;
        $conf = $this->config[$lang];
        if (!$this->cal) {
            $switch = $conf['flags'] ?? '';
            $cmd .= ' ' . $switch . ' ' . $year;
            $cal = shell_exec($cmd);
            if ($lang != self::DEFAULT_LANG) {
                $months = $conf['months'];
                $days   = $conf['days'];
                // replace month names with translation
                $cal = str_replace(array_keys($months), array_values($months), $cal);
                // replace day names with translation
                $cal = str_replace(array_keys($days), array_values($days), $cal);
            }
            $this->cal = $cal;
        }
        return $this->cal;
    }
}

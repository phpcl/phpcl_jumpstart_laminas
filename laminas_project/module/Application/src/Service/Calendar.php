<?php
namespace Application\Service;

class Calendar
{
	
    const DEFAULT_CMD = 'cal -y ';

    protected $cmd;
    protected $cal = NULL;

    /**
     * Produces a calendar from OS command
     *
     * @param int $year == year for which to generate calendar
     * @param string $cmd == OS command to use
     */
    public function getCalendar(int $year = NULL, string $cmd = NULL)
    {
        $year = $year ?? date('Y');
        $cmd  = $cmd  ?? self::DEFAULT_CMD;
        if (!$this->cal) {
            $cmd .= ' ' . $year;
            $cal = shell_exec($cmd);
            $this->cal = $cal;
        }
        return $this->cal;
    }
}

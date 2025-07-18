<?php
protected function schedule(Schedule $schedule)
{
    $schedule->command('car:import')->daily();
}

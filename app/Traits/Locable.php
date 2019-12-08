<?php
namespace App\Traits;

use Carbon\Carbon;

trait Locable {

    /**
     * Localize a date to users timezone
     *
     * @param null $dateField
     * @return Carbon
     */
    public function localize($dateField = null)
    {
        $dateValue = $dateField ?? Carbon::now();

        return $this->inUsersTimezone($dateValue);
    }

    /**
     * Change timezone of a carbon date
     *
     * @param $dateValue
     * @return Carbon
     */
    private function inUsersTimezone($dateValue): Carbon
    {
        $timezone = auth()->user() !== null ? auth()->user()->preferenceUser()->first()->time_zone : config('app.timezone');

        return $this->asDateTime($dateValue)->timezone($timezone);
    }
}

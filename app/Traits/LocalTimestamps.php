<?php

namespace App\Traits;

use Carbon\Carbon;

trait LocalTimestamps
{
    /**
     * Get a fresh timestamp for the model.
     * Override to use local timezone instead of UTC
     *
     * @return \Carbon\Carbon
     */
    public function freshTimestamp()
    {
        return Carbon::now(config('app.timezone'));
    }

    /**
     * Convert a DateTime to a storable string.
     * Override to ensure timezone is preserved
     *
     * @param  \DateTime|int  $value
     * @return string
     */
    public function fromDateTime($value)
    {
        if (is_null($value)) {
            return $value;
        }

        // If the value is already a Carbon instance, convert it to the app timezone
        if ($value instanceof Carbon) {
            return $value->setTimezone(config('app.timezone'))->format($this->getDateFormat());
        }

        // If the value is already a DateTime instance, convert it
        if ($value instanceof \DateTime) {
            return Carbon::instance($value)->setTimezone(config('app.timezone'))->format($this->getDateFormat());
        }

        // Otherwise, parse it as a string and convert to app timezone
        return Carbon::parse($value)->setTimezone(config('app.timezone'))->format($this->getDateFormat());
    }
}

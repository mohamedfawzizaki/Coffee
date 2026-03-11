<?php

namespace App\Traits;

use Carbon\Carbon;

trait ForceTimeZone
{
    /**
     * Saudi Arabia timezone constant
     */
    private const SAUDI_ARABIA_TIMEZONE = 'Asia/Riyadh';

    /**
     * Boot the trait
     */
    protected static function bootForceTimeZone()
    {
        // Set timezone when creating
        static::creating(function ($model) {
            $model->setTimezoneForDates();

        });

        // Set timezone when updating
        static::updating(function ($model) {
            $model->setTimezoneForDates();
        });
    }

    /**
     * Get a fresh timestamp for the model with Saudi Arabia timezone
     *
     * @return \Carbon\Carbon
     */
    public function freshTimestamp()
    {
        return Carbon::now(self::SAUDI_ARABIA_TIMEZONE);
    }

    /**
     * Convert a DateTime to a storable string with Saudi Arabia timezone
     *
     * @param  \DateTime|int  $value
     * @return string|null
     */
    public function fromDateTime($value)
    {
        if (is_null($value)) {
            return $value;
        }

        $carbon = $this->convertToCarbon($value);
        return $carbon->setTimezone(self::SAUDI_ARABIA_TIMEZONE)->format($this->getDateFormat());
    }

    /**
     * Convert value to Carbon instance
     *
     * @param  mixed  $value
     * @return \Carbon\Carbon
     */
    private function convertToCarbon($value)
    {
        if ($value instanceof Carbon) {
            return $value;
        }

        if ($value instanceof \DateTime) {
            return Carbon::instance($value);
        }

        return Carbon::parse($value);
    }

    /**
     * Set timezone for date fields
     */
    protected function setTimezoneForDates()
    {
        if (!$this->usesTimestamps()) {
            return;
        }

        // Set timezone for created_at if it exists
        if (isset($this->attributes['created_at'])) {
            $this->attributes['created_at'] = Carbon::parse($this->attributes['created_at'])
                ->setTimezone(self::SAUDI_ARABIA_TIMEZONE)
                ->format($this->getDateFormat());
        }

        // Set timezone for updated_at if it exists
        if (isset($this->attributes['updated_at'])) {
            $this->attributes['updated_at'] = Carbon::parse($this->attributes['updated_at'])
                ->setTimezone(self::SAUDI_ARABIA_TIMEZONE)
                ->format($this->getDateFormat());
        }
    }
}

<?php

namespace App\Http\Resources\Mobile\General;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    private function localizeAndTranslate(mixed $value): mixed
    {
        if (is_array($value)) {
            $locale = app()->getLocale();
            $fallbackLocale = config('app.fallback_locale');

            foreach ([$locale, $fallbackLocale] as $loc) {
                if ($loc && array_key_exists($loc, $value) && is_string($value[$loc])) {
                    return __($value[$loc]);
                }
            }

            // If it's an array but not keyed by locale, return the first string value (if any)
            foreach ($value as $v) {
                if (is_string($v)) {
                    return __($v);
                }
            }

            return $value;
        }

        if (is_string($value)) {
            return __($value);
        }

        return $value;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = $this->data;

        // Translate/localize common fields (support string or locale-array values)
        foreach (['title', 'body', 'message', 'content'] as $key) {
            if (isset($data[$key])) {
                $data[$key] = $this->localizeAndTranslate($data[$key]);
            }
        }

        return [
            'id' => $this->id,
            'type' => $this->type,
            'notifiable_id' => $this->notifiable_id,
            'data' => $data,
            'read_at' => $this->read_at,
            'created_at' => $this->created_at,
        ];
    }
}
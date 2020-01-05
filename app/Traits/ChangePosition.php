<?php

namespace App\Traits;

trait ChangePosition {
    public function changePosition($model, &$object, $position) {
        if ($object->position > $position) {
            foreach ($model::where('position', '>=', $position)
                         ->where('position', '<', $object->position)->get() as $item) {
                $item->increment('position', 1);
            }
        } else {
            foreach ($model::where('position', '<=', $position)
                         ->where('position', '>', $object->position)->get() as $item) {
                $item->decrement('position', 1);
            }
        }

        $object->position = $position;
    }
}

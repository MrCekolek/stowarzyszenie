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

    public function reindexPositions($model, $groupBy = 'shared_id') {
        $position = 1;

        foreach ($model::all()->sortBy('position')->groupBy($groupBy) as $items) {
            foreach ($items as $item) {
                $item->position = $position;
                $item->save();
            }

            ++$position;
        }
    }
}

<?php

namespace App\Traits;

trait ManagePortfolio {
    public static function changeSelected($input, $model) {
        $model->selected = $input['selected'];

        return $model->save();
    }

    public static function changeVisibility($input, $model) {
        if ($input['field'] === 'admin') {
            $success = $model->where('shared_id', $input['shared_id'])->update([
                'admin_visibility' => $input['visibility']
            ]);
        } else {
            $success = $model->where('id', $input['id'])->update([
                'user_visibility' => $input['visibility']
            ]);
        }

        return $success > 0;
    }

    public static function changeFilled($input, $model) {
        $model->filled_pl = $input['filled_pl'];
        $model->filled_en = $input['filled_en'];
        $model->filled_ru = $input['filled_ru'];

        return $model->save();
    }
}

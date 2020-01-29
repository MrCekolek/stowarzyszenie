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

    public static function changeValue($input, $model) {
        $model->value_pl = $input['value_pl'];
        $model->value_en = $input['value_en'];
        $model->value_ru = $input['value_ru'];

        return $model->save();
    }
}

<?php

namespace App\Jobs;

use App\Http\Controllers\PreferenceUserController;
use App\Models\PreferenceUser;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ChangeUserTimezoneJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email) {
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $geolocation = $this->getGeolocation();

        if (!empty($geolocation)) {
            $time_zone = $geolocation['time_zone']['name'];
        } else {
            $time_zone = 'UTC';
        }

        $user = User::email($this->email)->with('preferenceUser')->first();

        $preference_user = PreferenceUser::userId($user['id'])->first();

        if ($preference_user['time_zone'] !== $time_zone) {
            $preference_user['time_zone'] = $time_zone;
        }

        $preference_user->save();
    }

    public function getGeolocation() {
        return PreferenceUserController::getGeolocation();
    }
}

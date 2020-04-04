<?php

namespace App\Observers;

use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\Role;

class RoleObserver {
    /**
     * Handle the role "created" event.
     *
     * @param Role $role
     * @return void
     */
    public function created(Role $role) {
        foreach (Permission::all() as $permission) {
            factory(PermissionRole::class)->create([
                'permission_id' => $permission->id,
                'role_id' => $role->id,
                'selected' => $this->getSelected($role, $permission)
            ]);
        }
    }

    private function getSelected($role, $permission) {
        switch ($role->id) {
            case 1:
                return 1;

                break;

            case 2:
                return 0;

                break;

            case 3:
                switch ($permission->translation_key) {
                    case 'USERS.CHANGE_ROLE':
                    case 'ROLES.ADD':
                    case 'ROLES.CHANGE_PERMISSIONS':
                        return 1;

                        break;

                    default:
                        return 0;
                }

                break;

            case 4:
                switch ($permission->translation_key) {
                    case 'CONFERENCE_CFP.MANAGE_CFP':
                    case 'CONFERENCE_REVIEWS.ASSIGN_REVIEWERS':
                    case 'CONFERENCE_PROGRAMME.SET_DATES':
                        return 1;

                        break;

                    default:
                        return 0;
                }

                break;

            case 5:
                switch ($permission->translation_key) {
                    case 'CONFERENCE_ARTICLES.ACCEPT_ARTICLES':
                    case 'CONFERENCE_ARTICLES.REJECT_ARTICLES':
                    case 'CONFERENCE_ARTICLES.ADD_COMMENT':
                        return 1;

                        break;

                    default:
                        return 0;
                }

                break;

            case 6:
                switch ($permission->translation_key) {
                    case 'CONFERENCE_ARTICLES.ASSIGN_REVIEWERS':
                        return 1;

                        break;

                    default:
                        return 0;
                }

                break;

            case 7:
                switch ($permission->translation_key) {
                    case 'CONFERENCE_PAGE.ADD_NEW':
                    case 'CONFERENCE_PAGE.EDIT_PAGE':
                    case 'CONFERENCE_PAGE.DELETE_PAGE':
                        return 1;

                        break;

                    default:
                        return 0;
                }

                break;

            case 8:
                switch ($permission->translation_key) {
                    case 'CONFERENCE_REVIEWS.REVIEWING':
                    case 'CONFERENCE_ARTICLES.ADD_COMMENT':
                        return 1;

                        break;

                    default:
                        return 0;
                }

                break;

            case 9:
                switch ($permission->translation_key) {
                    case 'CONFERENCE_ARTICLES.PUBLISH_ARTICLES':
                        return 1;

                        break;

                    default:
                        return 0;
                }
        }
    }
}

import { Injectable } from '@angular/core';
import { ApiService } from './api.service';

@Injectable({
    providedIn: 'root'
})
export class UserRoleApiService {

    constructor(
        private apiService: ApiService
    ) { }

    getUsers(roleId) {
        const obj = {
            role_id: roleId
        };

        return this.apiService.post(`role/${roleId}/users`, obj);
    }

    assignUserToRole(userId, roleId) {
        const obj = {
            user_id: userId,
            role_id: roleId
        };

        return this.apiService.post(`role/${roleId}/user/${userId}/create`, obj);
    }

    getRoles(userId) {
        const obj = {
            user_id: userId
        };

        return this.apiService.post(`user/${userId}/roles`, obj);
    }

    getRole(roleId) {
        const obj = {
            id: roleId
        };

        return this.apiService.post(`role/${roleId}/show`, obj);
    }

    getUsersNotAssignedToRole(roleId) {
        const obj = {
            role_id: roleId
        };

        return this.apiService.post(`role/${roleId}/users/not`, obj);
    }
}

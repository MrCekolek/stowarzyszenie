import { Injectable } from '@angular/core';
import { ApiService } from "./api.service";

@Injectable({
  providedIn: 'root'
})
export class PermissionRoleApiService {
  constructor(
    private api: ApiService
  ) { }

  getRoles() {
    return this.api.post('role/get');
  }

  getRoleWithPermissions(roleId: number) {
    return this.api.post('role/' + roleId + '/permission/get');
  }

  addNewRole(role: object) {
    return this.api.post('role/create', role);
  }

  updateRolePermissions(roleID: number, permissions: any) {
    const obj = {
      id: roleID,
      permissions: permissions
    };
    return this.api.post(`role/${roleID}/permission/update`, obj);
  }

  updateRoleName(role: any) {
    return this.api.post(`role/${role.id}/update`, role);
  }

  deleteRole(roleId: number) {
    return this.api.post('role/delete/' + roleId);
  }

  getUsersWithRole(role) {
    return this.api.post(`role/${role.role_id}/users`, role);
  }
}

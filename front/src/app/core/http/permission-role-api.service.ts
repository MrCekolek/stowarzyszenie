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

  updateRolePermissions(roleID: number, roleConfig: any) {
    return this.api.post('role/' + roleID + '/permission/update', roleConfig);
  }

  updateRoleName(role: any) {
    return this.api.post(`role/${role.id}/update`);
  }

  deleteRole(roleId: number) {
    return this.api.post('role/delete/' + roleId);
  }
}

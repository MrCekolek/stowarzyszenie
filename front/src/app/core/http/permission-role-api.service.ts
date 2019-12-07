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
    return this.api.post('role/create', role).subscribe(
      data => console.log(data)
    );
  }

  updateRole(roleID: number, roleConfig: any) {
    return this.api.post('role/' + roleID + '/permission/update', roleConfig);
  }

  deleteRole(roleId: number) {
    return this.api.post('role/delete/' + roleId);
  }
}

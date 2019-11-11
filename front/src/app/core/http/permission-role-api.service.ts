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
    return this.api.get('role/get');
  }

  getRoleWithPermissions(role: number) {
    return this.api.get('role/' + role + '/permission/get');
  }

  addNewRole(roleName: string) {
    // TODO: tutaj poprosze link do api gdzie wysylac nazwe nowej roli
    // TODO: no i zrobic tutaj this.api.post (post na dodwanie? czy put?)
  }

  updateRole(roleID: number, roleConfig: any) {
    // TODO: tutaj poprosze link do api gdzie wysylac nowa nazwe roli pod jakie id 
    // TODO: no i zrobic tutaj this.api.put z nowa nazwa roli na dane ID roli
  }
}

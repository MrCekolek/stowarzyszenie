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

    // TODO: tutaj poprosze link do api gdzie wysylac nazwe nowej roli
    // TODO: no i zrobic tutaj this.api.post (post na dodwanie? czy put?)
    // TODO wszystko na POST co zmienia dane, wszystko co pobiera dane to GET
  }

  updateRole(roleID: number, roleConfig: any) {
    return this.api.post('role/' + roleID + '/permission/update', roleConfig);

    // TODO: tutaj poprosze link do api gdzie wysylac nowa nazwe roli pod jakie id
    // TODO: no i zrobic tutaj this.api.put z nowa nazwa roli na dane ID roli
  }

  deleteRole(roleId: number) {
    return this.api.post('role/delete/' + roleId);
  }
}

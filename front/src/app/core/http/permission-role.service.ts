import { Injectable } from '@angular/core';
import { ApiService } from "./api.service";
import {HttpClient} from "@angular/common/http";

@Injectable({
  providedIn: 'root'
})
export class PermissionRoleService {
  constructor(
    private api: ApiService,
    private http: HttpClient
  ) { }

  getRoles() {
    return this.api.post('role/get');
  }

  getRoleWithPermissions(role: number) {
    return this.api.post('role/' + role + '/permission/get');
  }
}

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
    return this.api.get('role/get');
  }

  getRoleWithPermissions(role: number) {
    return this.api.get('role/' + role + '/permission/get');
  }
}

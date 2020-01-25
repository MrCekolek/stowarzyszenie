import { Injectable } from '@angular/core';
import { UserModel } from '../../models/user.model';
import { ApiService } from '../../../core/http/api.service';

@Injectable({
  providedIn: 'root'
})
export class UserProviderService {

  private User: UserModel

  constructor(
    private apiService: ApiService
  ) { }

  public getUser(): UserModel {
    return this.User;
  }

  load() {
    return new Promise((resolve, reject) => {
      return this.apiService.post('account/me').subscribe(response => {
        this.User = response['user'];
        console.log(this.User);
        resolve(true);
      });
    });
  }

  checkPermission(permissionKey): boolean {
    console.log(this.getUser().roles);

    this.getUser().roles.forEach(role => {
      const key: any = role.permissions.find((x: any) => x.translation_key === permissionKey);
      console.log(key.pivot.selected);
      
      if (key.pivot.selected === 'true' || key.pivot.selected === true || key.pivot.selected) {
        return true;
      }
    });

    return false;
  }
}

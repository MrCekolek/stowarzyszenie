import { Injectable } from '@angular/core';
import { UserModel } from '../../models/user.model';
import { ApiService } from '../../../core/http/api.service';

@Injectable({
  providedIn: 'root'
})
export class UserProviderService {

  private User: UserModel;

  constructor(
    private apiService: ApiService
  ) { }

  public getUser(): UserModel {
    return this.User;
  }

  public setUser(user) {
    this.User = user;
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
}

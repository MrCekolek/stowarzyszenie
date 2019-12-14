import { Injectable } from '@angular/core';
import { BehaviorSubject } from "rxjs";
import { TokenService } from "../../../modules/auth/login/service/token.service";
import { HttpClient } from "@angular/common/http";
import { UserModel } from "../../models/user.model";
import { ApiService } from "../../../core/http/api.service";

@Injectable({
  providedIn: 'root'
})
export class UserService {
  public user: UserModel;
  private loggedIn: BehaviorSubject <boolean> = new BehaviorSubject <boolean> (this.tokenService.loggedIn());
  loginStatus = this.loggedIn.asObservable();

  constructor(
    private http: HttpClient,
    private tokenService: TokenService,
    private api: ApiService
  ) { }

  changeLoginStatus(value: boolean) {
    this.loggedIn.next(value);
  }

  changeUser(userModel: UserModel) {
    this.user = userModel;
  }

  getUser() {
    return this.user;
  }

  me() {
    return this.api.post('account/me');
  }
}

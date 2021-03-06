import { Injectable } from '@angular/core';
import { UserModel } from "../../shared/models/user.model";
import { BehaviorSubject } from "rxjs";
import { TokenService } from "../../modules/auth/login/service/token.service";
import { ApiService } from "../http/api.service";

@Injectable()
export class UserProviderService {

    private user: UserModel = null;

    private loggedIn: BehaviorSubject <boolean> = new BehaviorSubject <boolean> (this.tokenService.loggedIn());
    loginStatus = this.loggedIn.asObservable();

    private isOnMainPage: BehaviorSubject <boolean> = new BehaviorSubject <boolean> (this.tokenService.isOnMainPage());
    isOnMainPageStatus = this.isOnMainPage.asObservable();

    constructor(
        private tokenService: TokenService,
        private api: ApiService
    ) {
    }

    changeLoginStatus(value: boolean) {
        this.loggedIn.next(value);
    }

    changeIsOnHomePageStatus(value: boolean) {
        if (value) {
            localStorage.setItem('destiny', 'home page');
        } else {
            localStorage.setItem('destiny', 'panel');
        }

        this.isOnMainPage.next(value);
    }

    public setUser(user) {
      this.user = user;
    }

    public getUser(): UserModel {
        return this.user;
    }

    load() {
      let logged = false;

      this.loggedIn.subscribe(lg => {
        logged = lg;
      });

      if (logged) {
        return new Promise((resolve, reject) => {
          this.me().subscribe(
              (data) => {
                  this.user = data['user'];
              },
              (err) => {
                  reject(err);
              },
              () => {
                  resolve(true);
              }
          );
        });
      }
    }

    me() {
      return this.api.post('account/me');
    }

    checkPermission(permissionKey): boolean {
        let success = false;

        for (let role of this.getUser().roles) {
            const key: any = role.permissions.find((x: any) => x.translation_key === permissionKey);

            if (key) {
                if (key.pivot.selected) {
                    success = true;

                    break;
                }
            }
        }

        return success;
    }
}

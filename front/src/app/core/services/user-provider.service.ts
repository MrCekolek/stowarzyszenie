import { Injectable } from '@angular/core';
import { UserModel } from "../../shared/models/user.model";
import { UserService } from "../../shared/services/user/user.service";

@Injectable()
export class UserProviderService {

  private user: UserModel = null;

  constructor(
      private userService: UserService
  ) {

  }

  public getUser(): UserModel {
    return this.user;
  }

  load() {
    return new Promise((resolve, reject) => {
              this.userService.me().subscribe(data => {
                this.user = data['user'];
                this.userService.changeUser(this.user);
                console.log(this.userService.getUser());
              });

              setTimeout(() => {
              }, 2000);

            resolve(true);
        }
    )
  }
}

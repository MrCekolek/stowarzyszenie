import { Injectable } from '@angular/core';
import { ActivatedRouteSnapshot, CanActivateChild, RouterStateSnapshot, UrlTree } from '@angular/router';
import { Observable } from 'rxjs';
import {TokenService} from "../../modules/auth/login/service/token.service";

@Injectable({
  providedIn: 'root'
})
export class LoggedGuard implements CanActivateChild {
  constructor(
    private tokenService: TokenService
  ) { }

  canActivateChild(childRoute: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<boolean | UrlTree> | Promise<boolean | UrlTree> | boolean | UrlTree {
    return this.tokenService.loggedIn();
  }
}

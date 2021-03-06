import { Injectable } from '@angular/core';
import { ActivatedRouteSnapshot, CanActivateChild, RouterStateSnapshot, UrlTree, Router } from '@angular/router';
import { Observable } from 'rxjs';
import { TokenService } from "../../modules/auth/login/service/token.service";
import { Route } from '@angular/compiler/src/core';

@Injectable({
  providedIn: 'root'
})
export class LoggedGuard implements CanActivateChild {
  constructor(
    private tokenService: TokenService,
    private router: Router
  ) { }

  canActivateChild(childRoute: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<boolean | UrlTree> | Promise<boolean | UrlTree> | boolean | UrlTree {
      return this.tokenService.loggedIn();
  }
}

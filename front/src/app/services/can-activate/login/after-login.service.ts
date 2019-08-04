import { Injectable } from '@angular/core';
import { ActivatedRouteSnapshot, CanActivate, RouterStateSnapshot, UrlTree } from "@angular/router";
import { TokenService } from "../../token/token.service";
import { Observable } from "rxjs";

@Injectable({
  providedIn: 'root'
})
export class AfterLoginService implements CanActivate {

  constructor(
    private tokenService: TokenService
  ) { }

  canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<boolean | UrlTree> | Promise<boolean | UrlTree> | boolean | UrlTree {
    return this.tokenService.loggedIn();
  }
}

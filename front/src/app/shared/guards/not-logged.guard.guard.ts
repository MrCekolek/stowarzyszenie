import { Injectable } from '@angular/core';
import { ActivatedRouteSnapshot, CanActivateChild, RouterStateSnapshot, UrlTree, Router } from '@angular/router';
import { Observable } from 'rxjs';
import { TokenService } from "../../modules/auth/login/service/token.service";

@Injectable({
  providedIn: 'root'
})
export class NotLoggedGuard implements CanActivateChild {
  constructor(
    private tokenService: TokenService,
    private router: Router
  ) { }

  canActivateChild(childRoute: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<boolean | UrlTree> | Promise<boolean | UrlTree> | boolean | UrlTree {
    // if (childRoute.parent.data) {
    //   if (this.tokenService.loggedIn()) {
    //     this.router.navigate(['dashboard']);
    //   }
    // }

    return !this.tokenService.loggedIn();
  }
}

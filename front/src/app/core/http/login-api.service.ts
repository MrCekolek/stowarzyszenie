
import { Injectable } from '@angular/core';
import { LoginModel } from '../../shared/models/login.model';
import { ApiService } from './api.service';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class LoginApiService {

  constructor(
    private api: ApiService
  ) { }

  login(loginModel: LoginModel): Observable<any> {
    return this.api.post('account/login', loginModel);
  }

  getUserByID(userID: number) {
    return this.api.post(`user/${userID}/get`);
  }
}

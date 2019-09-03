import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";

@Injectable({
  providedIn: 'root'
})
export class AfterResetService {
  private baseURL: string = 'http://localhost:8000/api';

  constructor(
    private http: HttpClient
  ) { }

  changePassword(afterResetForm: Object) {
    return this.http.post(`${this.baseURL}/account/password/change`, afterResetForm);
  }
}

import { Injectable } from '@angular/core';
import { FormGroup } from "@angular/forms";
import { HttpClient } from "@angular/common/http";

@Injectable({
  providedIn: 'root'
})
export class BeforeResetService {
  private baseURL: string = 'http://localhost:8000/api';

  constructor(
    private http: HttpClient
  ) { }

  sendReset(beforeResendForm: Object) {
    return this.http.post(`${this.baseURL}/account/password/reset`, beforeResendForm);
  }
}

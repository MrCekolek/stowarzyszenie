import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class TokenService {

  private iss = {
    login: 'http://localhost:8000/api/auth/login'
  }

  constructor() { }

  handle(token) {
    this.set(token);
  }

  set(token) {
    localStorage.setItem('token', token);
  }

  get() {
    return localStorage.getItem('token');
  }

  remove() {
    localStorage.removeItem('token');
  }

  valid() {
    const token = this.get();

    if (token) {
      const payload = this.payload(token);

      if (payload) {
        return Object.values(this.iss).indexOf(payload.iss) > -1;
      }
    }

    return false;
  }

  payload(token) {
    const payload = token.split('.')[1];

    return this.decode(payload);
  }

  decode(payload) {
    return JSON.parse(atob(payload));
  }

  loggedIn() {
    return this.valid();
  }
}

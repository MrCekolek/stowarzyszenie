import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

  error = false;
  passwordIsHidden = true;

  constructor( ) { }

  ngOnInit() {
  }

  togglePassword() {
    this.passwordIsHidden = !this.passwordIsHidden;
  }
}

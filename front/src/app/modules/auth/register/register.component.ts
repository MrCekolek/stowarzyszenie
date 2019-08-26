import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.scss']
})
export class RegisterComponent implements OnInit {

  private passwordIsHidden: boolean;
  registrationCompleted = false;

  constructor() { 
    this.passwordIsHidden = true;
  }

  ngOnInit() {
  }

  togglePassword() {
    this.passwordIsHidden = !this.passwordIsHidden;
  }
}

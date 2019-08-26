import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-after-reset',
  templateUrl: './after-reset.component.html',
  styleUrls: ['./after-reset.component.scss']
})
export class AfterResetComponent implements OnInit {

  passwordIsHidden;
  private reseted;

  constructor() {
    this.reseted = false;
    this.passwordIsHidden = true;
   }

  ngOnInit() {
  }

  resetPassword() {
    this.reseted = true;
  }

  togglePassword() {
    this.passwordIsHidden = !this.passwordIsHidden;
  }
}

import { Component, OnInit } from '@angular/core';
import { AuthService } from "../../../../services/auth/auth.service";

@Component({
  selector: 'app-request-reset',
  templateUrl: './request-reset.component.html',
  styleUrls: ['./request-reset.component.css']
})
export class RequestResetComponent implements OnInit {

  public form = {
    email: null
  }

  public error = [];

  constructor(
    private authService: AuthService
  ) { }

  ngOnInit() {
  }

  onSubmit() {
    this.authService.sendPasswordResetLink(this.form).subscribe(
      data => this.handleResponse(data),
      error => this.handleError(error)
    );
  }

  handleResponse(res) {
    this.form.email = null;
    this.error = [];
  }

  handleError(error) {
    this.error = error.error.errors;
  }
}

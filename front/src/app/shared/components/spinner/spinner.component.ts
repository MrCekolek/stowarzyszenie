import { Component, OnInit, Input } from '@angular/core';
import { SpinnerService } from '../../services/spinner.service';

@Component({
  selector: 'app-spinner',
  templateUrl: './spinner.component.html',
  styleUrls: ['./spinner.component.scss']
})
export class SpinnerComponent implements OnInit {

  @Input() name: string;
  @Input() show = false;

  constructor(
    private spinnerService: SpinnerService
  ) { }

  ngOnInit() {
    if (!this.name) 
      throw new Error("Spinner must have a 'name' attribute.");

    this.spinnerService._register(this);
  }

  ngOnDestroy(): void {
    this.spinnerService._unregister(this);
  }
}

import { Injectable } from '@angular/core';
import { SpinnerComponent } from '../components/spinner/spinner.component';

@Injectable({
  providedIn: 'root'
})
export class SpinnerService {

  private spinnerCache = new Set<SpinnerComponent>();

  constructor() { }

  _register(spinner: SpinnerComponent) {
    this.spinnerCache.add(spinner);
  }

  _unregister(spinnerToRemove: SpinnerComponent): void {
    this.spinnerCache.forEach(spinner => {
      if (spinner === spinnerToRemove) {
        this.spinnerCache.delete(spinner);
      }
    });
  }

  show(spinnerName: string) {
    this.spinnerCache.forEach(spinner => {
      if (spinner.name == spinnerName) {
        spinner.show = true;
      }
    });
  }

  hide(spinnerName: string) {
    this.spinnerCache.forEach(spinner => {
      if (spinner.name == spinnerName) {
        spinner.show = false;
      }
    });
  }
}

import { Directive, ElementRef } from '@angular/core';

@Directive({
  selector: '[appShowHidePassword]'
})
export class ShowHidePasswordDirective {

  constructor(private el: ElementRef) {
    this.setup();
   }

   setup() {
    const parent = this.el.nativeElement.parentNode;
    const span = document.createElement('span');
    span.innerHTML = `Show password`;
    span.addEventListener('click', (event) => {
      alert('you just clicked me, you need to toggle view')
    });
    parent.appendChild(span);
  }
}

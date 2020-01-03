import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'lang'
})
export class LangPipe implements PipeTransform {

  transform(value: any, ...args: any[]): any {
    if (!value) {
      return null;
    }
    
    const splitted = value.split('_');
    return splitted[1];
  }

}

import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'genericPipe'
})
export class GenericPipe implements PipeTransform {
  transform(value: string): string {
    switch (value) {
      case 'OPEN':
        return 'ABERTO';
      case 'IN_PROGRESS':
        return 'EM ANDAMENTO';
      case 'COMPLETED':
        return 'FINALIZADO';
      case 'GENERAL':
        return 'GERAL';
      case 'RESTRICTED':
        return 'RESTRITO';
      default:
        return value;
    }
  }
}








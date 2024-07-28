import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'genericPipe',
  standalone: true
})
export class GenericPipe implements PipeTransform {
  transform(value: string | number, table?: string | null): string | number {
    if (table === 'tasks') {
      if (value === '1' || value === 1) {
        return 'Finalizado';
      }
      return 'Em aberto';
    }

    switch (value) {
      case 1:
        return 'Administrador';
      case 2:
        return 'Gerente';
      case 3:
        return 'Operacional';
      default:
        return value;
    }
  }
}

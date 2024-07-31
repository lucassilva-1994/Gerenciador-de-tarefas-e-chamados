import { Injectable, signal } from "@angular/core";

Injectable({ providedIn: 'root'})
export class MessageService{
  private message = signal<string | null>('');
  getMessage() {
    return this.message;
  }

  setMessage(value: string | null) {
    this.message.set(value);
  }
}
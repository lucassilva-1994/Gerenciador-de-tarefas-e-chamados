import { NgClass } from '@angular/common';
import { Component, inject, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-button-submit',
  standalone: true,
  imports: [NgClass],
  templateUrl: './button-submit.component.html',
  styleUrl: './button-submit.component.css'
})
export class ButtonSubmitComponent implements OnInit{
  mode?: string;
  private route = inject(ActivatedRoute);
  ngOnInit(): void {
    this.mode = this.route.snapshot.data['mode'];
  }
}

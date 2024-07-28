import { Component, inject, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-card-form',
  standalone: true,
  imports: [],
  templateUrl: './card-form.component.html',
  styleUrl: './card-form.component.css'
})
export class CardFormComponent implements OnInit{
  mode?: string;
  private route = inject(ActivatedRoute);
  ngOnInit(): void {
    this.mode = this.route.snapshot.data['mode'];
  }
}

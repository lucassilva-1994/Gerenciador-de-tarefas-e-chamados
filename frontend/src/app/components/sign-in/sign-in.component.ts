import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { Router } from '@angular/router';
import { User } from 'src/app/models/User';
import { AuthService } from 'src/app/services/auth.service';

@Component({
  selector: 'app-sign-in',
  templateUrl: './sign-in.component.html',
  styleUrls: ['./sign-in.component.css']
})
export class SignInComponent implements OnInit {
  form: FormGroup;
  message: string;
  constructor(private formBuilder: FormBuilder, private authService: AuthService, private router: Router) { }
  ngOnInit(): void {
    this.form = this.formBuilder.group({
      email: [''],
      password: ['']
    });
  }

  auth() {
    this.authService.auth(this.form.getRawValue() as User).subscribe({
      
      next: () => {
        this.router.navigate(['/departments'])
      },
      error: response => {
        this.message = response
      }
    });
  }
}

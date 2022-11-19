import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';


import { AuthenticationGuard } from './authentication.guard';
import { AddBookingComponent } from './components/add-booking/add-booking.component';
import { HomeComponent } from './components/home/home.component';


// COMPONENTS
import { LoginComponent } from './components/login/login.component';
import { ProfileComponent } from './components/profile/profile/profile.component';
import { RegisterComponent } from './components/register/register.component';



const routes: Routes = [
  {path: '', component: LoginComponent},
  {path: 'register', component: RegisterComponent},
  // {path: 'profile', component: ProfileComponent, canActivate:[AuthenticationGuard]}
  {path: 'home', component: HomeComponent},
  {path: 'add-booking', component: AddBookingComponent}

];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }

import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';


import { AuthenticationGuard } from './authentication.guard';
import { HomeComponent } from './components/home/home.component';


// COMPONENTS
import { LoginComponent } from './components/login/login.component';
import { ProfileComponent } from './components/profile/profile/profile.component';
import { RegisterComponent } from './components/register/register.component';



const routes: Routes = [
  {path: '', component: LoginComponent},
  {path: 'register', component: RegisterComponent},
  // {path: 'profile', component: ProfileComponent, canActivate:[AuthenticationGuard]}
  {path: 'home', component: HomeComponent}

];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }

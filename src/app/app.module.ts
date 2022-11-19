import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { LoginComponent } from './components/login/login.component';
import { RegisterComponent } from './components/register/register.component';

import { HttpClientModule } from '@angular/common/http';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { AuthguardServiceService } from './services/authguard-service.service';
import { ProfileComponent } from './components/profile/profile/profile.component';
import { HomeComponent } from './components/home/home.component';
import { AddBookingComponent } from './components/add-booking/add-booking.component';

@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    RegisterComponent,
    ProfileComponent,
    HomeComponent,
    AddBookingComponent

  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule,
    FormsModule,
    ReactiveFormsModule
  ],
  providers: [
                AuthguardServiceService
             ],
  bootstrap: [AppComponent]
})
export class AppModule { }

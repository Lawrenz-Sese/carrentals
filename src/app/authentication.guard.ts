import { Injectable } from '@angular/core';
import { ActivatedRouteSnapshot, CanActivate, Router, RouterStateSnapshot, UrlTree } from '@angular/router';
import { Observable } from 'rxjs';
import { AuthguardServiceService } from './services/authguard-service.service';
// SWEETALERT2
import Swal from 'sweetalert2';

@Injectable({
  providedIn: 'root'
})
export class AuthenticationGuard implements CanActivate 
{

    constructor(

                  private AuthService : AuthguardServiceService,
                  private router      : Router
                  
               ){}


    canActivate(
                  route: ActivatedRouteSnapshot,
                  state: RouterStateSnapshot
              ): 
                  Observable<boolean | UrlTree> | Promise<boolean | UrlTree> | boolean | UrlTree 
                {

                  if(!this.AuthService.getToken())
                  {

                    const Toast = Swal.mixin({
                      toast: true,
                      position: 'top',
                      showConfirmButton: false,
                      timer: 3000,
                      timerProgressBar: true,
                      didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                      }
                    })
                    
                    Toast.fire({
                      icon: 'error',
                      title: 'Not Authenticated'
                    })

                    this.router.navigateByUrl('');

                  }
                  
                  return this.AuthService.getToken();

                }
  
}

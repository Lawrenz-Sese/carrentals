import { Component, OnInit, AfterViewInit  } from '@angular/core';

// Dataserve Initialization (HTTP Client)
import { DataService } from 'src/app/services/data.service';

// SWEETALERT2
import Swal from 'sweetalert2';

// ROUTER
import { Router } from '@angular/router';



// JQuery Initialization
declare let $: any;

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

  

  constructor
  (
    private dataService: DataService,
    public route: Router
  ) { }

  _userInfo : any = {};
  _userRole : any;

  ngOnInit(): void 
  {
    
    localStorage.clear();
  
  }


  
  ngAfterViewInit() 
  {

    

  }

  register(role)
  {

    localStorage.setItem('role', role);
    this.route.navigate(['register']);

  }


  login_user()
  {
  
    if(!$("._email").val() || !$("._password").val())
    {
      this.dynamic_alert("error", "All fields required!", "");
      return;

    }

    this._userInfo.user_email    = $("._email").val();
    this._userInfo.user_password = $("._password").val();
    
    this.dataService.sendRequest('login_user',this._userInfo)
    .subscribe((response) =>
    {
      console.log(response);

      if(response.text != "not verified")
      {
        this.dynamic_alert(response.icon, `Welcome ${response.payload.user_fname} ${response.payload.user_lname}`, response.text );
        // INSERT ROUTE HERE (ADMIN PAGE || RIDER/USER PAGE)
        return;
      }

      else if(response.text == "not verified")
      {
        $('#otpModal').modal('show');
        return;
      }

      else
      {
        this.dynamic_alert(response.icon, response.title, response.text);
       
      }

   
   
    });


  }

  verify_user()
  {

    this._userInfo.user_otp = $('#_otp').val();

    this.dataService.sendRequest('verify_user', this._userInfo)
    .subscribe(async (response) =>
    {
    
          await $("#otpModal").modal('hide');
          this.dynamic_alert(response.icon, response.title, response.text);
     
    });


  }



  dynamic_alert(icon, title, text)
  {
    Swal.fire({
      icon: icon,
      title: title,
      text: text
    })
  }



}

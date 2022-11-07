import { Component, OnInit, AfterViewInit} from '@angular/core';

// Dataserve Initialization (HTTP Client)
import { DataService } from 'src/app/services/data.service';

// SWEETALERT2
import Swal from 'sweetalert2';

// ROUTER
import { Router } from '@angular/router';

// Form Control (For Validation Purposes)
import { FormControl,FormGroup,ValidationErrors,Validators,FormBuilder } from '@angular/forms';

// JQuery Initialization
declare let $: any;


@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.scss']
})
export class RegisterComponent implements OnInit {

  registerForm  : any;
  register_form_submitted = false;

  constructor
  (
    private dataService: DataService,
    public route: Router,
    public formBuilder: FormBuilder
  ) {}

  _userInfo : any = {};
  _userRole = !localStorage.getItem('role') ? "no role" : localStorage.getItem('role');
  _selectedFile : any;
  _imageLicenseSource : String = "";
  _imageRegistrationSource : any; 

  ngOnInit(): void 
  {

    this.registerForm = this.formBuilder.group
    ({

        _email        : ["", [Validators.required, Validators.email]],
        _password     : ["", [Validators.required, Validators.minLength]],
        _firstname    : ["", [Validators.required]],
        _middlename   : ["", [Validators.nullValidator]],
        _lastname     : ["", [Validators.required]],
        _address      : ["", [Validators.required]],
        _registration      : ["", [Validators.required]],
        _license      : ["", [Validators.required]],
        _contact      : ["", [Validators.required, Validators.minLength]]
        


    });

    
    if(this._userRole == 'no role')
    {
      this.route.navigate(['']);
      return;
    }

 

  }


  back_to_login()
  {
    this.route.navigate(['']);
  }



  get errorControl() {
    return this.registerForm.controls;
  }

  get errorControlEmail() {
    return this.registerForm.get('_email');
  }


 
  register_user()
  {
    this.register_form_submitted = true;
    if (!this.registerForm.valid) {
      console.log('Please provide all the required values!');
      return false;
    }
    this._userInfo.user_fname         = this.registerForm.value['_firstname'];
    this._userInfo.user_lname         = this.registerForm.value['_lastname'];
    this._userInfo.user_mname         = this.registerForm.value['_middlename'];
    this._userInfo.user_address       = this.registerForm.value['_address'];
    this._userInfo.user_contact       = `+639${this.registerForm.value['_contact']}`;
    this._userInfo.user_email         = this.registerForm.value['_email'];
    this._userInfo.user_password      = this.registerForm.value['_password'];
    this._userInfo.rider_license      = this.registerForm.value['_license'];
    this._userInfo.rider_registration = this.registerForm.value['_registration'];
    this._userInfo.user_type          = this._userRole;

    this.dataService.sendRequest('register_user', this._userInfo)
    .subscribe(async (response) =>
    { 
      if(response)
      {
          $('#spinnerModal').modal({backdrop: 'static', keyboard: false}).modal('show');
        
          await this.dataService.sendRequest('send_otp', this._userInfo)
            .subscribe( async (email_response) => 
            {
              console.log(email_response);
              
              $('#spinnerModal').modal('hide');
              if(email_response.code == 200)
              {
                  await this.dynamic_alert(email_response.remarks, email_response.message, !email_response.text ?  "" : email_response.text);
                  this.register_form_submitted = false;
                  this.route.navigate(['']);
                  return;
              }
              
                
              this.dynamic_alert("error", "Something Went Wrong!", "");
            
            });   
      }
      else
      {
          this.dynamic_alert("error", "Something Went Wrong!", "");
      }    
    });
    

  }
  dynamic_alert(remarks, message, text)
  { 
    Swal.fire({
      icon: remarks,
      title: message,
      text: text,
    })
  }


  imgSrc: String = "";
  onUploadHandler(e: any, type) {
    if (e.target.files) {
      var reader = new FileReader();
      reader.readAsDataURL(e.target.files[0]);
      reader.onload = (event: any) => {
        if(type == "license")
        {
          this._imageLicenseSource = event.target.result;
          return
        }
          this._imageRegistrationSource = event.target.result;
      };
    }
  }


  
}

$(document).on('keypress', '#_contact', function(e)
{
  this.orExists = false;
  var charCode = e.which ? e.which : e.keyCode;
  // Only Numbers 0-9
  if (charCode < 48 || charCode > 57 || $(this).val().length == 9) {
    e.preventDefault();
    return false;
  } 
});


$(document).on('change', '#_imageSelector', function(e)
{
  e.preventDefault();

  const reader = new FileReader();

  reader.readAsDataURL($(this).val());
  reader.onload = (event : any) => {
    $('._imageHolder').attr("src" , event.target.result);
  }

});



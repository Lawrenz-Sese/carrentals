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
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.scss']
})
export class ProfileComponent implements OnInit {

  editProfileForm  : any;
  editProfile_form_submitted: any;

  editProfilePassword : any;
  editPassword_form_submitted: any;

  _userData = JSON.parse(localStorage.getItem('sessionUser'));
  _userRole = this._userData.user_role;


  constructor(

                private dataService: DataService,
                public route: Router,
                public formBuilder: FormBuilder

             ) { }


  _userInfo: any = {};
  _selectedFile : any;
  _imageLicenseSource : String = "";
  _imageRegistrationSource : any; 




  ngOnInit(): void 
  {

      console.log(this._userData);
      

      this.editProfileForm = this.formBuilder.group
      ({

          _email        : [`${this._userData.user_email}`, [Validators.required, Validators.email]],
          _firstname    : [`${this._userData.user_fname}`, [Validators.required]],
          _middlename   : [`${this._userData.user_mname}`, [Validators.nullValidator]],
          _lastname     : [`${this._userData.user_lname}`, [Validators.required]],
          _address      : [`${this._userData.user_address}`, [Validators.required]],
          _registration      : [``, [Validators.required]],
          _license      : [``, [Validators.required]],
          _contact      : [`${this._userData.user_contact}`, [Validators.required, Validators.minLength]]
          


      });
      
      this.editProfilePassword = this.formBuilder.group
      ({

          _password     : [``, [Validators.required, Validators.minLength]],
          _newPassword     : [``, [Validators.required, Validators.minLength]],
          _confirmPassword     : [``, [Validators.required, Validators.minLength]],

      });
  }


  
  ngAfterViewInit(): void
  {

    // HIDE OR SHOW EDIT PROFILE
    $('._editProfileButton').on('click', function(e)
    {
      e.preventDefault();

      this.editPassword_form_submitted = false;
      this.editProfile_form_submitted = false;

      this.editProfilePassword.reset();

      $('._profileContents').attr("hidden", $(this).data('profilecontent'));
      $('._editProfileForm').attr("hidden", $(this).data('editprofile'));

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

  back_to_login()
  {
    this.route.navigate(['']);
  }




  get errorControl() 
  {

    return this.editProfileForm.controls;

  }



  get errorControlEmail() 
  {

    return this.editProfileForm.get('_email');
    
  }

  get errorPasswordControl()
  {
    return this.editProfilePassword.controls;
  }

  
  edit_profile()
  {
    this.editProfile_form_submitted = true;
 

    if (!this.editProfileForm.valid) {
      console.log('Please provide all the required values!');
      return false;
    }
    this._userInfo.user_fname         = this.editProfileForm.value['_firstname'];
    this._userInfo.user_lname         = this.editProfileForm.value['_lastname'];
    this._userInfo.user_mname         = this.editProfileForm.value['_middlename'];
    this._userInfo.user_address       = this.editProfileForm.value['_address'];
    this._userInfo.user_contact       = `+639${this.editProfileForm.value['_contact']}`;
    this._userInfo.user_email         = this.editProfileForm.value['_email'];
    this._userInfo.rider_license      = this.editProfileForm.value['_license'];
    this._userInfo.rider_registration = this.editProfileForm.value['_registration'];

  }

  edit_password()
  {

    this.editPassword_form_submitted = true;

    if (!this.editProfilePassword.valid) 
    {
      console.log('Please provide all the required values!');
      return false;
    }

    this._userInfo.user_password      = this.editProfileForm.value['_password'];
    // this._userInfo.user_password      = this.editProfileForm.value['_password'];
    // this._userInfo.user_password      = this.editProfileForm.value['_password'];
    
  }
          
  imgSrc: String = "";

  onUploadHandler(e: any, type) 
  {
      if (e.target.files) 
      {
          var reader = new FileReader();

          reader.readAsDataURL(e.target.files[0]);

          reader.onload = (event: any) => 
          {
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





import { Component, OnInit } from '@angular/core';
import { DataService } from 'src/app/services/data.service';

// JQuery Initialization
declare let $: any;
@Component({
  selector: 'app-add-booking',
  templateUrl: './add-booking.component.html',
  styleUrls: ['./add-booking.component.scss']
})
export class AddBookingComponent implements OnInit {

  constructor(private dataService: DataService) { }

  ngOnInit(): void {
    this.pull_booking();
  }

  driver: any = [ 
    {name: 'Lawrenz Sese Diestro', contact: '09094320987', address: 'Castillejos, Zambales', rating: '★★★★★', gas: 'Diesel', type: 'Automatic', seater: '5', price: '2000'},
    {name: 'Maria Dela Cruz', contact: '09094320987', address: 'Castillejos, Zambales', rating: '★★★★★', gas: 'Diesel', type: 'Automatic', seater: '5', price: '2000'},
    {name: 'Chris John Ramirez', contact: '09094320987', address: 'Castillejos, Zambales', rating: '★★★★★', gas: 'Diesel', type: 'Automatic', seater: '5', price: '2000'},
    {name: 'John Doe', contact: '09094320987', address: 'Castillejos, Zambales', rating: '★★★★★', gas: 'Diesel', type: 'Automatic', seater: '5', price: '2000'},
    {name: 'Vladimer Ace Laguisma', contact: '09094320987', address: 'Castillejos, Zambales', rating: '★★★★★', gas: 'Diesel', type: 'Automatic', seater: '5', price: '2000'},
    {name: 'Jose Rizal', contact: '09094320987', address: 'Castillejos, Zambales', rating: '★★★★★', gas: 'Diesel', type: 'Automatic', seater: '5', price: '2000'},
    {name: 'Bleng Blong Macros', contact: '09094320987', address: 'Castillejos, Zambales', rating: '★★★★★', gas: 'Diesel', type: 'Automatic', seater: '5', price: '2000'},
  ];

  drivers =[];
  driver_rating: any;

 pull_booking()
 {
    this.dataService.sendRequest('pull_booking', null).subscribe((response) => {
      this.drivers = response;

      if(this.drivers.length == 0)
      {
        console.log(response);
        
        return;
      }

      this.drivers.forEach(driver => 
      {
        let star_rating = "★";
        driver.rating_num = star_rating.repeat(parseInt(driver.rating_num + 0.5));   
      });

    })
 }

 open_car_detail(details)
 {
    $(".driver_name").text(`${details.user_fname} ${details.user_mname} ${details.user_lname}`);
    $(".rating_num").text(`${details.rating_num}`);
    $(".driver_address").text(details.user_address);
    $(".driver_contact").text(details.user_contact);
    $(".driver_email").text(details.user_email);
    $(".car_brand").text(details.car_brand);
    $(".car_color").text(details.car_color);
    $(".car_gas").text(details.car_gas);
    $(".car_seater").text(details.car_seater);
    $(".car_plateNum").text(details.car_plateNum);
    $(".car_type").text(details.car_type);
    $(".rate").text(details.rate);

    $(".car_image").attr("src", `${details.car_image}`)

    $("#carDetails").modal("show");
    

    

    
 }
  

}

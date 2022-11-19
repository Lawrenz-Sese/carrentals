import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-add-booking',
  templateUrl: './add-booking.component.html',
  styleUrls: ['./add-booking.component.scss']
})
export class AddBookingComponent implements OnInit {

  constructor() { }

  ngOnInit(): void {
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



}

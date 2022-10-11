import { Injectable } from '@angular/core';

import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class DataService {

  constructor
  (
    private http: HttpClient,
  ) {}

  apiUrl = "http://localhost/CarRentals/api/";

  sendRequest(method: any, data: any)
  {
    return<any>
    (
      this.http.post(this.apiUrl + method, btoa(JSON.stringify(data)))
    );

  }
}

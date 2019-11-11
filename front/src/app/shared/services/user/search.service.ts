import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { ApiService } from "../../../core/http/api.service";

@Injectable({
  providedIn: 'root'
})
export class SearchService {
  constructor(
    private http: HttpClient,
    private api: ApiService
  ) { }

  getUsers() {
    return this.api.post('user/get');
  }
}

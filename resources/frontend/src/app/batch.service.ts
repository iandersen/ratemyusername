import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class BatchService {

  batches = {};

  constructor(private httpClient: HttpClient) {
    console.log('CONSTRUCTING');
  }

  async getBatch(id){
    console.log('Getting!', id, this.batches);
    if(this.batches[id]) {
      console.log('Got: ', this.batches[id]);
      return this.batches[id];
    } else {
      const batch = await this.httpClient.get<any>(`http://localhost:8000/rest/batch/${id}`).toPromise();
      console.log('We got the batch: ', batch);
      this.batches[id] = batch.data;
      return batch.data;
    }
  }

  setBatch(id, data:object){
    console.log('Setting!', id, data);
    this.batches[id] = data;
  }
}

import {ChangeDetectorRef, Component, OnInit} from '@angular/core';
import {ActivatedRoute} from '@angular/router';
import {BatchService} from "../batch.service";
import {HttpClient} from "@angular/common/http";
import swal from "sweetalert2";


@Component({
  selector: 'app-batch',
  templateUrl: './batch.component.html',
  styleUrls: ['./batch.component.scss']
})
export class BatchComponent implements OnInit {

  id: number;
  batch: any = {
    usernames: []
  };
  emailValid:boolean = false;
  email:string = '';
  getBatch(): void{
    this.batchService.getBatch(this.id).then((result) => {
      this.batch = result;
      this.changeDetectorRef.detectChanges();
    });
  }

  constructor(private route: ActivatedRoute, private batchService: BatchService, private changeDetectorRef: ChangeDetectorRef, private httpClient: HttpClient) {
  }

  ngOnInit() {
    this.id = this.route.snapshot.params['id'];
    this.getBatch();
  }

  validateEmail(email) {
    const regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    this.emailValid = regex.test(String(email).toLowerCase());
    if(this.emailValid)
      this.email = email;
  }

  submitEmail(){
    this.httpClient.post(`http://localhost:8000/rest/batch/${this.id}/setEmail`, {
      email: this.email
    }).subscribe((response: any)=>{
      if(response.data) {
        swal.fire({
          title: 'Success!',
          text: response.data,
          type: 'success'
        });
        this.batch.email = this.email;
      } else if (response.error){
        // @ts-ignore
        swal.fire({
          title: 'Uh oh',
          text: response.error,
          type: 'error'
        });
      }
    });
  }
}

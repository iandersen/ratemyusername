import { Component, OnInit } from '@angular/core';
import {FormArray, FormControl, FormBuilder} from '@angular/forms';
import { HttpClient } from '@angular/common/http';
import {BatchService} from "../batch.service";
import {Location} from "@angular/common";
import {Router} from "@angular/router";


@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {
  usernameForm = this.formBuilder.group({
    usernames: this.formBuilder.array([ this.createItem() ])
  });
  usernames = this.usernameForm.get('usernames') as FormArray;
  canSubmit = false;
  usernamesSearched = 0;

  createItem(): FormControl {
    return this.formBuilder.control('');
  }

  getUsernamesSearched(){
    this.httpClient.get('/rest/usernamesSearched').subscribe((res: number)=>{
      this.usernamesSearched = res;
    });
  }

  constructor(private formBuilder: FormBuilder, private httpClient: HttpClient, private batchService: BatchService, private router: Router) {
    this.getUsernamesSearched();
  }

  ngOnInit() {
  }

  addUsername(){
    this.usernames = this.usernameForm.get('usernames') as FormArray;
    this.usernames.push(this.createItem());
    this.canSubmit = false;
  }

  validate(){
    this.canSubmit = true;
    this.usernames.controls.forEach((input)=>{
      input.setValue(input.value.replace(/[^a-zA-Z0-9_.]/, ''));
        if(input.value.length < 3 || input.value.length > 32) {
          this.canSubmit = false;
        }
    });
  }

  trackByFn(index: any, item: any) {
    return index;
  }

  removeLast(){
    this.usernames = this.usernameForm.get('usernames') as FormArray;
    this.usernames.removeAt(this.usernames.length-1);
    this.validate();
  }

  submit(){
    const usernames = this.usernames.controls.map((input)=>{
      return input.value;
    });
    console.log(usernames);
    this.httpClient.post('/rest/evaluateUsernames', {
      usernames
    }).subscribe((response: any)=>{
      if(response.data) {
        this.batchService.setBatch(response.data.id, response.data);
        this.router.navigate(['batch', response.data.id]);
      } else if (response.error){
        alert(response.error)
      }
    });
  }

}

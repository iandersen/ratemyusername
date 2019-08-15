import { Component } from '@angular/core';
import {BatchService} from "./batch.service";

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent {
  title = 'Rate My Username';
  constructor(
    batchService: BatchService,
  ) {}
}

import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-footer',
  templateUrl: './footer.component.html',
  styleUrls: ['./footer.component.scss']
})
export class FooterComponent implements OnInit {
  public lat: number = 18.943268;
  public lng: number = -99.242426;
  public zoom: number = 17;

  constructor() { }

  ngOnInit() { }

  subscribe(){ }

}

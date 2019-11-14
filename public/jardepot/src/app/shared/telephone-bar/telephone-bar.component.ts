import {Component, OnInit} from '@angular/core';
import {faWhatsapp} from '@fortawesome/free-brands-svg-icons';

@Component({
    selector: 'app-telephone-bar',
    templateUrl: './telephone-bar.component.html',
    styleUrls: ['./telephone-bar.component.scss']
})
export class TelephoneBarComponent implements OnInit {

    faWhatsapp = faWhatsapp;

    constructor() {
    }

    ngOnInit() {
    }

}

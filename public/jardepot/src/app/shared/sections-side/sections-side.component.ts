import {Component, Input, OnInit} from '@angular/core';

@Component({
    selector: 'app-sections-side',
    templateUrl: './sections-side.component.html',
    styleUrls: ['./sections-side.component.scss']
})
export class SectionsSideComponent implements OnInit {

    @Input('productTypes') productTypes: Array<any> = [];
    @Input('brands') brands: Array<any> = [];
    @Input('additional') additional: Array<any> = [];

    constructor() {
    }

    ngOnInit() {
    }

}

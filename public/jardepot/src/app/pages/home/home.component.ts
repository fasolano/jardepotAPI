import {Component, Input, OnInit} from '@angular/core';
import {AppService} from '../../app.service';
import {forEachComment} from 'tslint';

@Component({
    selector: 'app-home',
    templateUrl: './home.component.html',
    styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {


    public distributions = [];
    public banners = [];
    public brands = [];
    public productTypes: Array<any>;
    public additional = [];

    constructor(public appService: AppService) {
    }

    ngOnInit() {
        this.getBanners();
        this.getDistributions();
        this.getBrands();
        this.getProductTypes();
        this.getAdditional();
    }


    public getBanners() {
        this.appService.getBanners().subscribe(data => {
            this.banners = data;
        });
    }

    public getDistributions() {
        this.distributions = this.appService.getDistributions();
    }

    public getBrands() {
        this.appService.getBrands().subscribe(data => {
            this.brands = data;
        });
        this.brands.forEach(brand => {
            brand.selected = false;
        });
    }

    public getAdditional() {
        this.appService.getAdditional().subscribe(data => {
            this.additional = data;
        });
    }

    public getProductTypes() {
        this.appService.getProductTypes().subscribe(data => {
            this.productTypes = data;
        });
    }

}

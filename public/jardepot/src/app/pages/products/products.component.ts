import {Component, OnInit, ViewChild, HostListener, Input} from '@angular/core';
import {ActivatedRoute, Router} from '@angular/router';
import {MatDialog} from '@angular/material';
import {ProductDialogComponent} from '../../shared/products-carousel/product-dialog/product-dialog.component';
import {AppService} from '../../app.service';
import {Product, Category} from '../../app.models';
import {Settings, AppSettings} from 'src/app/app.settings';
import { HttpClient, HttpHeaders } from '@angular/common/http';

@Component({
    selector: 'app-products',
    templateUrl: './products.component.html',
    styleUrls: ['./products.component.scss']
})
export class ProductsComponent implements OnInit {
    @ViewChild('sidenav', {static: true}) sidenav: any;
    public sidenavOpen: boolean = true;
    private sub: any;
    public viewType: string = 'grid';
    public viewCol: number = 25;
    public counts = [12, 24, 36];
    public count: any;
    public sortings = ['Más relevantes', 'Menor precio', 'Mayor precio'];
    public sort: any;
    public products: Array<Product> = [];
    public brands = [];
    public productTypes = [];
    public additional = [];
    public priceFrom: number = 750;
    public priceTo: number = 2599;
    public page: any;
    public settings: Settings;
    public sections: Array<any> = [];
    public categoriesFilter: Array<any> = [];
    public orderByOption : string = 'relevant';

    constructor(public appSettings: AppSettings,
                private activatedRoute: ActivatedRoute,
                public appService: AppService,
                public dialog: MatDialog,
                private router: Router,
                private http: HttpClient) {
        this.settings = this.appSettings.settings;
    }

    ngOnInit() {
        this.count = this.counts[0];
        this.sort = this.sortings[0];
        this.sub = this.activatedRoute.params.subscribe(params => {
            if(params['nivel1'] && params['nivel2']){
                this.getProducts(params);
                this.getSectionsProducts(params);
            }
            return;
        });
        if (window.innerWidth < 960) {
            this.sidenavOpen = false;
        }
        ;
        if (window.innerWidth < 1280) {
            this.viewCol = 33.3;
        }
        ;

        if (this.priceFrom > this.priceTo) {
            this.priceTo = this.priceFrom + 1;
        }

        this.getBrands();
        this.getProductTypes();
        this.getAdditional();
    }

    public addCategoriteFilter($section, $event){
        if(this.categoriesFilter.length == 0 || this.categoriesFilter.length == this.sections.length){
            var buttons = document.getElementsByClassName('btn-section');
            // @ts-ignore
            for (let button of buttons){
                button.classList.add("selected");
            }
            this.categoriesFilter = [];
            this.categoriesFilter.push($section);
            $event.currentTarget.classList.remove("selected");
        }else{
            var existCategory = this.categoriesFilter.filter(section => section.name == $section.name);
            if(existCategory.length > 0){
                this.categoriesFilter = this.categoriesFilter.filter(section => section.name != $section.name);
                $event.currentTarget.classList.add("selected");
            }else{
                this.categoriesFilter.push($section);
                $event.currentTarget.classList.remove("selected");
            }
        }

    }

    public changeString($productType, $brand, $mpn){
        $brand = $brand.replace(/ /g, "_");
        $mpn = $mpn.replace(/-/g, "_");
        $productType = $productType.replace(/ /g, "_");
        return $productType + '-' + $brand + '-' + $mpn;
    }

    public changeStringBrand($brand){
        return $brand.replace(/ /g, "_");
    }

    public getBrands() {
        this.appService.getBrands().subscribe(data => {
            this.brands = data;
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

    public getProducts(params) {
        this.appService.getProducts(params).subscribe(data => {
            this.products = data;
        });
    }

    public getSectionsProducts(params) {
        this.appService.getSectionsProducts(params).subscribe(data => {
            this.sections = data;
        });
    }


    @HostListener('window:resize')
    public onWindowResize(): void {
        (window.innerWidth < 960) ? this.sidenavOpen = false : this.sidenavOpen = true;
        (window.innerWidth < 1280) ? this.viewCol = 33.3 : this.viewCol = 25;
    }

    public changeCount(count) {
        this.count = count;
        // this.getProducts();
    }

    public changeSorting(sort) {
        this.sort = sort;
    }

    public changeViewType(viewType, viewCol) {
        this.viewType = viewType;
        this.viewCol = viewCol;
    }

    public openProductDialog(product) {
        let dialogRef = this.dialog.open(ProductDialogComponent, {
            data: product,
            panelClass: 'product-dialog',
            direction: (this.settings.rtl) ? 'rtl' : 'ltr'
        });
        dialogRef.afterClosed().subscribe(product => {
            if (product) {
                this.router.navigate(['/products', product.id, product.name]);
            }
        });
    }

    public onPageChanged(event) {
        this.page = event;
        // this.getProducts();
        window.scrollTo(0, 0);
    }

    public orderBy($event){
        this.orderByOption = $event.value;
    }



}

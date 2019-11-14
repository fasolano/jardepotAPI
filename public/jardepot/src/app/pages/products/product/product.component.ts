import {Component, HostListener, OnInit, ViewChild, ChangeDetectionStrategy,
    ChangeDetectorRef} from '@angular/core';
import {ActivatedRoute} from '@angular/router';
import {FormBuilder, FormGroup, FormControl, Validators} from '@angular/forms';
import {MatDialog} from '@angular/material';
import {SwiperConfigInterface, SwiperDirective} from 'ngx-swiper-wrapper';
import {Data, AppService} from '../../../app.service';
import {Product} from '../../../app.models';
import {emailValidator} from '../../../theme/utils/app-validators';
import {ProductZoomComponent} from './product-zoom/product-zoom.component';

@Component({
    selector: 'app-product',
    templateUrl: './product.component.html',
    styleUrls: ['./product.component.scss'],
    changeDetection: ChangeDetectionStrategy.OnPush
})
export class ProductComponent implements OnInit {
    @ViewChild('sidenav', {static: true}) sidenav: any;
    public sidenavOpen: boolean = true;
    @ViewChild('zoomViewer', {static: true}) zoomViewer;
    @ViewChild(SwiperDirective, {static: true}) directiveRef: SwiperDirective;
    public config: SwiperConfigInterface = {};
    public product: Product;
    public image: any;
    public zoomImage: any;
    private sub: any;
    public form: FormGroup;
    public relatedProducts: Array<Product>;
    public brands = [];
    public productTypes = [];
    public additional = [];
    public dataSheet: string;

    constructor(public appService: AppService, private activatedRoute: ActivatedRoute, public dialog: MatDialog, public formBuilder: FormBuilder, private cd: ChangeDetectorRef) {
    }

    ngOnInit() {
        this.sub = this.activatedRoute.params.subscribe(params => {
            this.getProductByName(params['product']);
            this.getRelatedProducts(params['product']);

        });

        if (window.innerWidth < 1280) {
            this.sidenavOpen = false;
        }


        this.getBrands();
        this.getProductTypes();
        this.getAdditional();
    }

    ngAfterViewInit() {
        this.config = {
            observer: false,
            slidesPerView: 4,
            spaceBetween: 10,
            keyboard: true,
            navigation: true,
            pagination: false,
            loop: false,
            preloadImages: false,
            lazy: true,
            breakpoints: {
                480: {
                    slidesPerView: 2
                },
                600: {
                    slidesPerView: 3,
                }
            }
        };
    }


    @HostListener('window:resize')
    public onWindowResize(): void {
        (window.innerWidth < 960) ? this.sidenavOpen = false : this.sidenavOpen = true;
    }

    public getBrands() {
        this.appService.getBrands().subscribe(data => {
            this.brands = data;
        });
    }

    public getAdditional() {
        this.appService.getAdditional().subscribe(data => {
            this.additional = data
        });
    }

    public getProductTypes() {
        this.appService.getProductTypes().subscribe(data =>{
            this.productTypes = data;
        });
    }

    private getProductByName(product) {
        this.appService.getProductByName(product).subscribe(data => {
            this.product = data;
            this.dataSheet = this.product.dataSheet;
            this.image = data.images[0].medium;
            this.zoomImage = data.images[0].big;
            setTimeout(() => {
                this.config.observer = true;
            });
            this.directiveRef.setIndex(0);
            this.cd.detectChanges();
            if (this.directiveRef.swiper()) {
                setTimeout(() => {
                    this.directiveRef.swiper().lazy.load();
                }, 0);
            }
        });
    }

    public getRelatedProducts(product: any) {
        this.appService.getProductsRelated(product).subscribe(data => {
            this.relatedProducts = data;
        });
    }

    public selectImage(image) {
        this.image = image.medium;
        this.zoomImage = image.big;
    }

    public onMouseMove(e) {
        if (window.innerWidth >= 1280) {
            var image, offsetX, offsetY, x, y, zoomer;
            image = e.currentTarget;
            offsetX = e.offsetX;
            offsetY = e.offsetY;
            x = offsetX / image.offsetWidth * 100;
            y = offsetY / image.offsetHeight * 100;
            zoomer = this.zoomViewer.nativeElement.children[0];
            if (zoomer) {
                zoomer.style.backgroundImage = 'url(' + image.currentSrc + ')';
                zoomer.style.backgroundPosition = x + '% ' + y + '%';
                zoomer.style.display = 'block';
                zoomer.style.height = image.height + 'px';
                zoomer.style.width = image.width + 'px';
            }
        }
    }

    public onMouseLeave(event) {
        this.zoomViewer.nativeElement.children[0].style.display = 'none';
    }

    public openZoomViewer() {
        this.dialog.open(ProductZoomComponent, {
            data: this.zoomImage,
            panelClass: 'zoom-dialog'
        });
    }

    ngOnDestroy() {
        this.sub.unsubscribe();
    }

    public onSubmit(values: Object): void {
        if (this.form.valid) {
            //email sent
        }
    }
}

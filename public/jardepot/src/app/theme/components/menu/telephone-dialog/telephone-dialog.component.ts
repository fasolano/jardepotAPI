import {Component, ViewEncapsulation, OnInit, Inject} from '@angular/core';
import {MatDialogRef, MAT_DIALOG_DATA} from '@angular/material';
import {SwiperConfigInterface} from 'ngx-swiper-wrapper';

@Component({
  selector: 'app-telephone-dialog',
  templateUrl: './telephone-dialog.component.html',
  styleUrls: ['./telephone-dialog.component.scss'],
  encapsulation: ViewEncapsulation.None
})
export class TelephoneDialogComponent implements OnInit {

    public config: SwiperConfigInterface = {};

    constructor(public dialogRef: MatDialogRef<TelephoneDialogComponent>) {
    }

    ngOnInit() {
    }

    ngAfterViewInit() {
        this.config = {
            slidesPerView: 1,
            spaceBetween: 0,
            keyboard: true,
            navigation: true,
            pagination: false,
            grabCursor: true,
            loop: false,
            preloadImages: false,
            lazy: true,
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            }
        };
    }

    public close(): void {
        this.dialogRef.close();
    }

}
